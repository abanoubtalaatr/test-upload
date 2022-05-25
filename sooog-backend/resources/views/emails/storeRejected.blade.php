@component('mail::message')
# Hello,

The requested {{$store_name}} has been rejected and the reason is: <br>
{{$reason}}

{{-- @component('mail::button', ['url' => ''])

@endcomponent --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
