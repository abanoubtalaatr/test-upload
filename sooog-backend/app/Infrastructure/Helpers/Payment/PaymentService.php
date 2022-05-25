<?php
/**
 * Created by PhpStorm.
 * User: Ahmed
 * Date: 2/6/2022
 * Time: 01:21 PM
 */

namespace App\Infrastructure\Helpers\Payment;


interface PaymentService
{

    public function getMethods();

    public function doPayment($data,$paymentMethodId,$type=null);

    public function paymentLink($data);

    public function checkPayment($id,$paymentMethod=null);
}
