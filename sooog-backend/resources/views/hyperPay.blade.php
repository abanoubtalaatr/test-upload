<html>
<head>
    <style>
        body {
            background-color: #f6f6f5;
        }
        /*.wpwl-form-card{*/
        /*max-width: 100% !important;*/
        /*}*/
        /*.wpwl-form-virtualAccount{*/
        /*max-width: 40em !important;*/
        /*}*/
        /*.wpwl-wrapper-registration-cvv{*/
        /*width: 22% !important;*/
        /*}*/
        /*.wpwl-wrapper-cardNumber{*/
        /*direction: ltr !important;*/
        /*}*/
        /*.wpwl-wrapper input[type="radio"]{*/
        /*display: unset !important;*/
        /*}*/
        /*.wpwl-wrapper input[type="checkbox"]{*/
        /*display: unset !important;*/
        /*}*/
        /*.wpwl-label{*/
        /*color: #0c0c0c !important;*/
        /*}*/
        /*.customLabel{*/
        /*color: #0c0c0c !important;*/
        /*}*/
        /*.wpwl-group-paymentMode{*/
        /*color: #0c0c0c !important;*/
        /*}*/
    </style>
</head>
<body>
{{--@dd(session('checkout_id'))--}}
<div>
    <form action="{{route('check-payment')}}" class="paymentWidgets"
          data-brands="{{$payment_method}}"
        {{--data-brands="VISA MASTER MADA"--}}
    ></form>
</div>
<script>
    var wpwlOptions = {style: "card"}
</script>
<script src="{{env('APP_ENV')=='local'?env('Test_Payment_link'):env('Live_Payment_link')}}v1/paymentWidgets.js?checkoutId={{$checkout}}"></script>
<script src="https://code.jquery.com/jquery.js" type="text/javascript"></script>
<script>
    var wpwlOptions = {
        onChangeBrand: function(data) {
            var url=$('input[name="shopperResultUrl"]').val();
            var str = url.substr(url.lastIndexOf('/') + 1) + '$';
            var oldurl= url.replace( new RegExp(str), '' );
            var newurl=oldurl+data;
            $('input[name="shopperResultUrl"]').attr('value',newurl);
        }
    };

    var wpwlOptions = {
        locale: "{{app()->getLocale()}}", //check if the store is in Arabic or English

        onReady: function(){
            if (wpwlOptions.locale == "ar") {
                $(".wpwl-group").css('direction', 'ltr');
                $(".wpwl-control-cardNumber").css({'direction': 'ltr' , "text-align":"right"});
                $(".wpwl-brand-card").css('right', '200px');
            }
        }}
    // var wpwlOptions = {
    //     onReady: function() {
    //         var createRegistrationHtml = '<div class="customLabel">Store payment details?</div><div class="customInput"><input type="checkbox" name="createRegistration" value="true" /></div>';
    //         $('form.wpwl-form-card').find('.wpwl-button').before(createRegistrationHtml);
    //     }
    // }
</script>
<script type="text/javascript">
    var wpwlOptions = {
        paymentTarget:"_top",
        locale: "{{app()->getLocale()}}",
    }
</script>
</body>
</html>
