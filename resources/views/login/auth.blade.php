@extends('base')

@section('titre', 'Authentification')

@section('home')
<div class="login">
    <div class="gauche"> </div>
    <form class="formulaire" action="{{ route("auth.login") }}" method="post">

        @csrf

        <h3>AUTHENTIFICATION</h3>
        <div>
            <label for="nom"> Nom ou Email: </label>
            <input type="text" name="email_or_name" id="nom" value="{{old('email_or_name')}}">
        </div>
        <div>
            @error('email_or_name')
            {{ $message }}
            @enderror
        </div>

        <div>
            <label for="mdp"> Mot de passe: </label>
            <input type="password" name="password" id="mdp" value="{{ old('password') }}">
            <input type="checkbox"id="box">
        </div>
        <div>
            @error('password')
            {{ $message }}
            @enderror
        </div>

        <div class="boutton">
            <button class="btn" type="submit">Se connecter</button>
            <a href="{{route('create.account')}}"> Créer un compte </a>
        </div>
        <div class="forgotPassword">
            <a href="{{ route('password.request')}}"> Mot de passe oublié </a>
        </div>
    </form>
</div>
<script>
    const input=document.getElementById('mdp')
    const box=document.getElementById('box')
    var temps;
    box.addEventListener("click",()=>{
        clearTimeout(temps);
        if(box.checked){
            input.setAttribute('type','text');
        }else{
            input.setAttribute('type','password');
        }
        temps=setTimeout(function(){
            input.setAttribute('type','password');
            box.checked=false;
        }, 1000);
    })
</script>

@endsection
