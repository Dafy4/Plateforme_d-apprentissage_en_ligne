@component('mail::message')
    # Vérification d'e-mail

    Cliquez sur le bouton ci-dessous pour vérifier votre adresse e-mail :

    @component('mail::button', ['url' => $verificationLink])
        Vérifier mon e-mail
    @endcomponent

    Merci,<br>
    {{ config('app.name') }}

@endcomponent
