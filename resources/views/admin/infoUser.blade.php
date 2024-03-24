@extends('base')

@section('title', 'Accueil')

@include('admin.navbarAdmin')

@section('contenu')

<form action="" method="post">
    @csrf

    @method('PATCH')

    @if($type_user == 'etudiants' || $type_user =='professeur')
        <div>
            <label for="nom"> Nom : </label>
            <input type="text" readonly value="{{$user->type($type_user)->nom}}">
        </div>
        <div>
            <label for="prenom"> Prénoms : </label>
            <input type="text" readonly value="{{$user->type($type_user)->prenom}}">
        </div>
        <div>
            <label for="tel"> Téléphone : </label>
            <input type="text" readonly value="{{$user->type($type_user)->telephone}}">
        </div>
        <div>
            <label for="email"> Email : </label>
            <input type="text" readonly value="{{$user->type($type_user)->email}}">
        </div>
        @if($type_user == 'etudiants')
            <div>
                <label for="departement"> Département : </label>
                <input type="text" readonly value="{{$user->type($type_user)->departement->nom}}">
            </div>
        @elseif ($type_user == 'admin')
            <div>
                <label for="email"> Email : </label>
                <input type="text" readonly value="{{$user->type($type_user)->email}}">
            </div>
            <div>
                <label for="post"> post </label>
                <input type="text" readonly value="{{$user->type($type_user)->post}}">
            </div>
        @endif
    @endif
    <button> Confirmer </button>
</form>

@endsection
