@component('mail::message')

{{$message}}

{{-- @component('mail::button', ['url' => setting('store_url')])
{{setting('store_name')}}
@endcomponent --}}

Thanks,<br>
{{ $store_name }}
@endcomponent
