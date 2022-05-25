@component('mail::message')
# Replying To Your Message ( {{$contact->parent->title??substr($contact->parent->body,0,50)}} )

{!! $contact->body !!}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
