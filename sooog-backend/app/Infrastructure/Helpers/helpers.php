<?php

use App\Infrastructure\Exceptions\NotFoundException;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

if (!function_exists('handleDateFormat')) {
    function handleDateFormat($date)
    {
        return Carbon::parse($date)->translatedFormat('d M Y');
    }
}
if (!function_exists('qrCode')) {
    function qrCode()
    {
        $uniqueString = time() . '_' . Str::random(4);
        // https://www.simplesoftware.io/#/docs/simple-qrcode
        if (\Illuminate\Support\Facades\Storage::disk('public')->missing('barcodes')) {
            \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('barcodes');
        }
        QrCode::format('svg')->size(200)->generate($uniqueString,
            storage_path("app/public/barcodes/$uniqueString" . '.svg'));

        return $uniqueString . '.svg';
    }
}

if (!function_exists('findModel')) {
    function findModel($id, $model, $relations = [], $selects = '*')
    {
        try {
            //** eager loading of relations in one query */
            return $model->whereId($id)->with($relations)
                ->select($selects)->firstOrFail();

        } catch (ModelNotFoundException $e) {

            throw new NotFoundException();
        }
    }
}

function setting($key = null)
{
    if (is_null($key)) {
        return optional(\App\AppContent\Domain\Models\Setting::where('key', 'added_tax')->first())->body ?? null;
    }
    return optional(\App\AppContent\Domain\Models\Setting::where('key', $key)->first())->body ?? null;
}

function price_including_tax($unit)
{
    $tax = optional(\App\AppContent\Domain\Models\Setting::where('key', 'added_tax')->first())->body ?? null;
    return $unit->price + ($unit->price * $tax / 100);
}

function status($type, $key)
{
    return optional(\App\Order\Domain\Models\Status::where('type', $type)->where('key', $key)->first())->id ?? null;
}

function send_fcm_notification($user, $notification_data, $is_admin = false, $tokens = [])
{
    $firebaseTokens = [];
    if ($is_admin) {
        if (!empty($tokens)) {
            $firebaseTokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\Store\Domain\Models\StoreAdmin')->whereIn('tokenable_id', $tokens)->pluck('device_token')->all();
        } else {
            $firebaseTokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\Admin\Domain\Models\Admin')->pluck('device_token')->all();
        }
    } else {
        if ($user) {
            $firebaseTokens = $user->tokens->pluck('device_token')->all();
        } else {
            $firebaseTokens = \App\User\Domain\Models\DeviceToken::where('tokenable_type', 'App\User\Domain\Models\User')->pluck('device_token')->all();
        }
    }


//    dd($firebaseTokens);

    // var_dump($firebaseTokens);
    // echo "<br>";
    //dd($firebaseTokens);
    // $notification_data = [
    //     "title" => $title,
    //     "body" => $body,
    //     "type" => $type,
    //     "id" : "' . $id . '",
    //     "message" : "' . $message . '",
    //     "icon" : "new",
    //     "sound" : "default"
    // ];
    $notif_arr = [];
    $data_arr = [];
    $notif_arr['content'] = array(
        'model_id' => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound' => 'default',
        'timestamp' => date('Y-m-d G:i:s'),
        'data' => $notification_data,
        'title' => $notification_data['title'],
        'body' => $notification_data['body'],
        'type' => $notification_data['type'] ?? null
    );
    $notif_arr['notification'] = array(
        'model_id' => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound' => 'default',
        'timestamp' => date('Y-m-d G:i:s'),
        'data' => $notification_data,
        'title' => $notification_data['title'],
        'body' => $notification_data['body'],
        'type' => $notification_data['type'] ?? null
    );

    $data_arr['content'] = array(
        'model_id' => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound' => 'default',
        'timestamp' => date('Y-m-d G:i:s'),
        'data' => $notification_data,
        'title' => $notification_data['title'],
        'body' => $notification_data['body'],
        'type' => $notification_data['type'] ?? null
    );
    $data_arr['notification'] = array(
        'model_id' => $notification_data['model_id'] ?? null,
        'channelKey' => 'basic_channel',
        'sound' => 'default',
        'timestamp' => date('Y-m-d G:i:s'),
        'data' => $notification_data,
        'title' => $notification_data['title'],
        'body' => $notification_data['body'],
        'type' => $notification_data['type'] ?? null
    );

    // $data = [
    //     "registration_ids" => $firebaseTokens,
    //     "notification" => array_merge(\Illuminate\Support\Arr::only($notification_data, ['title', 'body']), ['channelKey' => 'basic_channel']),
    //     "data" => \Illuminate\Support\Arr::only($notification_data, ['model_id', 'type'])
    // ];

    $data = [
        "registration_ids" => $firebaseTokens,
        "mutable_content" => true,
        "content_available" => true,
        "priority" => "high",
        "data" => $data_arr,
        //"data" => array('content' => $data_arr),
        "notification" => $notif_arr
    ];

    $dataString = json_encode($data);
    //dd(config('app.FCM_KEY'));
    $headers = [
        'Authorization: key=' . config('app.fcm_server_key'),
        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);
//    dd($response);
    curl_close($ch);
    if ($response === false) {
        // throw new Exception('Curl error: ' . curl_error($crl));
        //print_r('Curl error: ' . curl_error($crl));
        $result = 0;
    } else {
        $result = 1;
    }
    return $result;
}

//HI SMS
function send_hisms_sms($mobile, $msg)
{
    $sender_mobile = setting('hisms_phone');
    $sender_name = str_replace(' ', '%20', setting('site_name'));
    $password = setting('hisms_password');
    $numbers = $mobile;
    $msg = str_replace(' ', '%20', $msg);
    $date = date('Y-m-d');
    $time = date("H:i");
    $url = "http://hisms.ws/api.php?send_sms&username=" . $sender_mobile . "&password=" . $password . "&numbers=" . $numbers . "&sender=" . $sender_name . "&message=" . $msg . "&date=" . $date . "&time=" . $time;
    $msg = [];
    $response = (int)file_get_contents($url);
    $result = validate_response($response);
    return $msg = ['response' => $response, 'result' => $result];
}

function validate_response($response)
{
    $result = '';
    switch ($response) {
        case 1:
            $result = 'اسم المستخدم غير صحيح';
            break;
        case 2:
            $result = 'كلمة المرور غير صحيحة';
            break;
        case 3:
            $result = 'تم الارسال';
            break;
        case 4:
            $result = 'لايوجد ارقام';
            break;
        case 5:
            $result = 'لايوجد رسالة';
            break;
        case 6:
            $result = 'خطاء في السندر';
            break;
        case 7:
            $result = 'سندر غير مفعل';
            break;
        case 8:
            $result = 'الرسالة تحتوى على كلمة ممنوعة';
            break;
        case 9:
            $result = 'لايوجد رصيد';
            break;
        case 10:
            $result = 'صيغة التاريخ غير صحيحة';
            break;
        case 11:
            $result = 'صيغة الوقت غير صحيحة';
            break;
        case 404:
            $result = 'لم يتم ادخال جميع البرمترات المطلوبة';
            break;
        case 403:
            $result = 'تم تجاوز عدد المحاولات المسموحة';
            break;
        case 504:
            $result = 'الحساب معطل';
            break;
    }
    return $result;
}

function sendSMS($phone, $message)
{

    $number = $phone;
    $sender = env('sms_username');
//    $sender='ARAS for AC';
    $url = "https://www.hisms.ws/api.php?send_sms&username=" . env('sms_user') .
        "&password=" . env('sms_password') . "&numbers=" . $number . "&sender=" . $sender . "&message=" . urlencode($message);
//    dd($url);
//    $options = array(
//        CURLOPT_RETURNTRANSFER => true,     // return web page
//        CURLOPT_HEADER => false,    // don't return headers
//        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
//        CURLOPT_ENCODING => "",       // handle all encodings
//        CURLOPT_USERAGENT => "spider", // who am i
//        CURLOPT_AUTOREFERER => true,     // set referer on redirect
//        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
//        CURLOPT_TIMEOUT => 120,      // timeout on response
//        CURLOPT_MAXREDIRS => 10,       // stop after 10 redirects
//        CURLOPT_SSL_VERIFYPEER => false     // Disabled SSL Cert checks
//    );
//    $ch = curl_init($url);
//    curl_setopt_array($ch, $options);
//    $content = curl_exec($ch);
//    $err = curl_errno($ch);
//    $errmsg = curl_error($ch);
//    $header = curl_getinfo($ch);
//    curl_close($ch);
    $content = (int)file_get_contents($url);
    $result = validate_response($content);
    $msg = ['response' => $content, 'result' => $result];
//    \Illuminate\Support\Facades\Log::info('sms',$msg);
    return $msg;

}

function send_msegat_sms($mobile_number, $msg)
{
    $data = [
        "userName" => 'googan',
        "password" => 'dcfa',
        "userSender" => 'pin-code',
        "numbers" => $mobile_number,
        "apiKey" => '7fe0f68d4a193a3a802870f71c98e72a',
        "msg" => $msg,
        "msgEncoding" => "UTF8"
    ];
    $client = new \GuzzleHttp\Client();
    $res = $client->request('POST', 'https://www.msegat.com/gw/sendsms.php', [
        'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Accept-Language' => app()->getLocale() == 'ar' ? 'ar-Sa' : 'en-Uk'
        ],
        'body' => json_encode($data),
    ]);
    if ($res) {
        $data = json_decode($res->getBody()->getContents());
        if ($data->code) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
