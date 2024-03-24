<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div>
        <label for="email">Adresse e-mail</label>
        <input id="email" type="email" name="email" required />
    </div>

    <div>
        <button type="submit">Envoyer le lien de réinitialisation</button>
    </div>
</form>
