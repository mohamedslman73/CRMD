@component('mail::message')
    # News Application

    Your activation code to reset password : {{$code}}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent