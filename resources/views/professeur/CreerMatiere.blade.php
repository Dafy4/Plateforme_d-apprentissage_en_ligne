@extends('base')

@section('titre', 'Créer une nouvelle matière')

{{-- NAVBAR --}}
@include('professeur.navbarProf')

@section('contenu')
    <h1 style="text-align: center;color:#001a4b;"> INTRODUISEZ UNE NOUVELLE MATIERE </h1>

    <form class="creationM" action="" method="post">

        @csrf
        <div>
            <label for="matiere"> Entrer le nom de votre module : </label>
            <input type="text" name="matiere" id="matiere"
                    @if( old('matiere') !== null )
                        value="{{old('matiere')}}
                    @else
                        placeholder="Nom de la matière"
                    @endif
            >
        </div>
        @error('matiere')
                {{ $message }}
        @enderror
        <p></p>
        <div>
            <label for="categorie"> Choisissez une catégorie : </label>
            <select name="categorie_id" id="categorie">
                @foreach ($category as $categorie)
                   <option value="{{ $categorie->id }}"> {{$categorie->categorie}} </option>
                @endforeach
            </select><br>
            <a href="{{ route('professeur.ajoutCategorie') }}">Ajouter une nouvelle catégorie</a>
        </div>
            @error('categorie_id')
                    {{ $message }}
            @enderror
            <p></p>
        <div class="description">
            <div>
                <label for="description"> Ajouter une description de la matière : </label><br>
                <textarea name="description" id="description" cols="30" rows="10" value="{{ old('description', 'Nom_matiere a pour finalité d\'enseigner les bases du.... et de maîtriser le... ') }}"></textarea>
            </div>
                @error('description')
                        {{ $message }}
                @enderror
            <p></p>
        </div>
        <button> VALIDER </button>
    </form>




@endsection
