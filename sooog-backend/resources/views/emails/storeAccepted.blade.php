@component('mail::message')
Hello 

the requested {{$store_name}} has been accepted
login data is : <br>
email: {{$email}}
password:  {{$password}}


{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
