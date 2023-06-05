@component('mail::message')
hi {{$user}}
here is your motif
@component('mail::panel')
 {{$motif}}
 @endcomponent
<br>
{{ config('app.name') }}
@endcomponent
