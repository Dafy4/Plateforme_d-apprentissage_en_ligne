@extends('base')

@section('title', 'Personalisé les cours')

{{-- NAVBAR --}}
@include('professeur.navbarProf')

@section('contenu')
    <div class="containerProfilProf">
        <div class="PhotoProfilProf">
            <img src="{{ asset('images/'. Auth::user()->profilImage) }}" id="imageProfil" alt="Photo de profil">
            <a href="{{ route('changeProfilPictureRedirect') }}"><button id="btnChangePicture"> Changer la photo de profil </button></a>
            {{-- <a href="{{route('professeur.resetPassword', ['professeur' => $professeur->user->id])}} " > <button id="btnChangePicture"> Changer de mot de passe </button> </a> --}}
        </div>
        <div class="ProfilProf">
            <p> <span> Nom : </span>  {{ $professeur->nom }} </p>
            <p> <span> Prénom : </span>  {{ $professeur->prenom }} </p>
            <p> <span> Téléphone : </span>  {{ $professeur->telephone }}</p>
            <p> <span> Email : </span>  {{ $professeur->email }}</p>
        </div>
    </div>
    @endsection
