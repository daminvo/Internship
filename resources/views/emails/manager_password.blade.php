@component('mail::message')
{{-- hi {{$user}} --}}
here is your account password
@component('mail::button', ['url' => ''])
phive
@endcomponent
@component('mail::panel')
 {{$password}}
 @endcomponent
<br>
{{ config('app.name') }}
@endcomponent
