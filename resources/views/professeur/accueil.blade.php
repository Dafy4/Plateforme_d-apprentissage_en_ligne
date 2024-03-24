@extends('base')

@section('title', 'Bienvenue professeur')

@include('professeur.navbarProf')

@section('contenu')
    <style>

    </style>
    <div class="cours courrss">
        <h3> Voici toutes les matières que vous avez créer </h3>
        <div class="lecon">

            @foreach ($matieres as $matiere )
                <div>
                    <h2>{{ $matiere->matiere }}</h2>
                    <h3>Catégorie : {{ $matiere->categorie->categorie }}</h3>
                    <section>
                        <div style="background-color:green;border-bottom-left-radius: 10px;"> <a href="{{ route('professeur.affichageCours', ['matiere' => $matiere->id, 'contenu' =>  $matiere->contenu_du_cours[0]->id]) }}"> Voir </a></div>
                        <div style="background-color:red;border-bottom-right-radius: 10px;"><a href="{{route('professeur.creationCours', ['matiere' => $matiere->id, 'contenu' =>  $matiere->contenu_du_cours[0]->id])}}" class="matiere">Ameliorer</a></div>
                    </section>
                </div>
            @endforeach
            <div style="text-align: center;padding-top: -7%;">
               <a href="{{route('professeur.creationMatiere')}}" class="AjoutMatiere"> <p style="margin-top: 17%;">ajouter <br> une matiere </p> </a>
            </div>
        </div>
    </div>

@endsection
