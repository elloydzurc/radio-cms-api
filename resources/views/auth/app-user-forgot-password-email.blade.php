@component('mail::message')
    # Hello {{$appUser->first_name}},

    Here's your temporary password:

    {{$password}}

    Thanks,
    {{ config('app.name') }}
@endcomponent
