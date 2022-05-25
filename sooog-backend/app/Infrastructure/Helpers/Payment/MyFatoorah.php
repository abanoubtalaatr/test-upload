<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 11/4/2021
 * Time: 03:42 PM
 */

namespace App\Infrastructure\Helpers\Payment;


use Illuminate\Support\Facades\Log;

class MyFatoorah implements PaymentService
{
    protected $apiURL;
    protected $apiKey;

    public function __construct()
    {
        if (env('APP_ENV') == 'local') {
            $this->apiURL = env('Payment_Test_Url');
            $this->apiKey = env('Payment_Test_Token');
        } else {
//Live
            $this->apiURL = env('Payment_Live_Url');
            $this->apiKey = env('Payment_Live_Token');
        }
    }

    public function getMethods()
    {
        /* ------------------------ Call InitiatePayment Endpoint ------------------- */
//Fill POST fields array
        $ipPostFields = ['InvoiceAmount' => 100, 'CurrencyIso' => 'KWD'];
//        $ipPostFields = [];
        $apiKey = env('Payment_Live_Token');
        $apiURL = env('Payment_Live_Url');
//Call endpoint
        $paymentMethods = $this->initiatePayment($apiURL, $apiKey, $ipPostFields);

        return $paymentMethods;
    }

    public function doPayment($data, $paymentMethodId,$type=null,$for='order')
    {
        if($for=='order'){
        $total = $data->remain == 0.00 ? $data->total : $data->remain;
        }else{
            $total=$data->price;
        }
        $additional['type']=$type;
        $additional['for']=$for;
        /* ------------------------ Call ExecutePayment Endpoint -------------------- */
//Fill customer address array
        /* $customerAddress = array(
          'Block'               => 'Blk #', //optional
          'Street'              => 'Str', //optional
          'HouseBuildingNo'     => 'Bldng #', //optional
          'Address'             => 'Addr', //optional
          'AddressInstructions' => 'More Address Instructions', //optional
          ); */

//Fill invoice item array
        /* $invoiceItems[] = [
          'ItemName'  => 'Item Name', //ISBAN, or SKU
          'Quantity'  => '2', //Item's quantity
          'UnitPrice' => '25', //Price per item
          ]; */

//Fill POST fields array
        $postFields = [
            //Fill required data
            'PaymentMethodId' => $paymentMethodId,
            'InvoiceValue' => $total,
            'CallBackUrl' => route('check-payment'),
            'ErrorUrl' => route('check-payment'), //or 'https://example.com/error.php'
//            'CallBackUrl' => 'http://makefy.fudex-tech.net/mokayiefy-backend/public/api/page/terms',
//            'ErrorUrl' => 'http://makefy.fudex-tech.net/mokayiefy-backend/public/api/page/terms',
            //Fill optional data
//            'CustomerName'       => 'fname lname',
            'DisplayCurrencyIso' => 'SAR',
            'MobileCountryCode' => '+966',
//            'CustomerMobile'     => '1234567890',
//            'CustomerEmail'      => 'email@example.com',
            'Language' => app()->getLocale(), //or 'ar'
            'CustomerReference' => $data->id,
            //'CustomerCivilId'    => 'CivilId',
            'UserDefinedField' => $additional  //'This could be string, number, or array',
            //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
            //'SourceInfo'         => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
            //'CustomerAddress'    => $customerAddress,
            //'InvoiceItems'       => $invoiceItems,
        ];

//Call endpoint
        $data = $this->executePayment($this->apiURL, $this->apiKey, $postFields);
        return $data;

////You can save payment data in database as per your needs
//        $invoiceId = $data->InvoiceId;
//        $paymentLink = $data->PaymentURL;
//
////Redirect your customer to the payment page to complete the payment process
////Display the payment link to your customer
//        echo "Click on <a href='$paymentLink' target='_blank'>$paymentLink</a> to pay with invoiceID $invoiceId.";
//        die;
    }

    public function paymentLink($data)
    {
        return $data->PaymentURL;
    }

    public function checkPayment($id,$paymentMethodId=null)
    {
        $data = array(
            'KeyType' => 'paymentId',
            'Key' => "$id" //the callback paymentID
        );
        $json = $this->callAPI("$this->apiURL/v2/getPaymentStatus", $this->apiKey, $data);
        if($json->Data->InvoiceStatus != 'Paid'){
            return [
                'status' => 400,
                'paid' => false,
                'msg' => $json->Data->InvoiceTransactions[0]->Error,
//                'route' => 'http://localhost:3000',
                    'route' => 'https://soog.fudex-tech.net',
                'brand' => $json->Data->InvoiceTransactions[0]->PaymentGateway,
                'order_id' => $json->Data->CustomerReference,
                'additional_info' => $json->Data->UserDefinedField['type'],
                'for' => $json->Data->UserDefinedField['for'],
            ];
        }else{
            return [
                'status' => 200,
                'paid' => true,
                'msg' => '',
//                'route' => 'http://localhost:3000',
                    'route' => 'https://soog.fudex-tech.net',
                'brand' => $json->Data->InvoiceTransactions[0]->PaymentGateway,
                'order_id' => $json->Data->CustomerReference,
                'additional_info' => $json->Data->UserDefinedField['type'],
                'for' => $json->Data->UserDefinedField['for'],
            ];
        }
    }
    /* ------------------------ Functions --------------------------------------- */
    /*
     * Initiate Payment Endpoint Function
     */

    function initiatePayment($apiURL, $apiKey, $postFields)
    {

        $json = $this->callAPI("$apiURL/v2/InitiatePayment", $apiKey, $postFields);
        return $json->Data->PaymentMethods;
    }

//------------------------------------------------------------------------------
    /*
     * Execute Payment Endpoint Function
     */

    function executePayment($apiURL, $apiKey, $postFields)
    {
        Log::info('data payment: ');
        Log::info($postFields);
        $json = $this->callAPI("$apiURL/v2/ExecutePayment", $apiKey, $postFields);
        return $json->Data;
    }

//------------------------------------------------------------------------------
    /*
     * Call API Endpoint Function
     */

    function callAPI($endpointURL, $apiKey, $postFields = [], $requestType = 'POST')
    {
        $curl = curl_init($endpointURL);
        curl_setopt_array($curl, array(
            CURLOPT_CUSTOMREQUEST => $requestType,
            CURLOPT_POSTFIELDS => json_encode($postFields),
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $apiKey", 'Content-Type: application/json'),
            CURLOPT_RETURNTRANSFER => true,
        ));

//        $req=Http::withHeaders($header)->post($endpointURL,$postFields);
//        dd($req->body());

        $response = curl_exec($curl);
        $curlErr = curl_error($curl);

        curl_close($curl);

        if ($curlErr) {
            //Curl is not working in your server
            throw new \Exception($curlErr);
//            die("Curl Error: $curlErr");
        }
        $error = $this->handleError($response);
        Log::error('response payment');
        Log::error($error);

        if ($error) {
//            die("Error: $error");
            throw new \Exception($error);
        }

        return json_decode($response);
    }

//------------------------------------------------------------------------------
    /*
     * Handle Endpoint Errors Function
     */

    function handleError($response)
    {

        $json = json_decode($response);
        if (isset($json->IsSuccess) && $json->IsSuccess == true) {
            return null;
        }

        //Check for the errors
        if (isset($json->ValidationErrors) || isset($json->FieldsErrors)) {
            $errorsObj = isset($json->ValidationErrors) ? $json->ValidationErrors : $json->FieldsErrors;
            $blogDatas = array_column($errorsObj, 'Error', 'Name');

            $error = implode(', ', array_map(function ($k, $v) {
                return "$k: $v";
            }, array_keys($blogDatas), array_values($blogDatas)));
        } else if (isset($json->Data->ErrorMessage)) {
            $error = $json->Data->ErrorMessage;
        }

        if (empty($error)) {
            $error = (isset($json->Message)) ? $json->Message : (!empty($response) ? $response : 'API key or API URL is not correct');
        }

        return $error;
    }

    /* -------------------------------------------------------------------------- */
}
