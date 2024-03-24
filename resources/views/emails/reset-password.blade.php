@component('mail::message')
    # Réinitialisation de mot de passe

    Cliquez sur le bouton ci-dessous pour accéder au formulaire de réinitialisation de mot de passe :

    @component('mail::button', ['url' =>  $resetPasswordLink])
        Changer mon mot de passe
    @endcomponent

    Merci,<br>
    {{ config('app.name') }}
@endcomponent
