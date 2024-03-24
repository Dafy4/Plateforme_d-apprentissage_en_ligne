@extends('base')

@section('titre', 'Personalisé les cours')

{{-- NAVBAR --}}
@include('professeur.navbarProf')

@section('contenu')
    <h3> Module : {{$matiere->matiere}} </h3>
    <div class="niveau">
        @foreach ($matiere->contenu_du_cours as $contenu)
            {{-- <p> {{ $contenu->id }} </p> --}}
            <div
            @if( $contenu->id == $content)
                class='active'
            @endif
            >
                <a href="{{ route('professeur.creationExamen' , ['matiere' => $matiere->id, 'contenu' =>  $contenu->id ]) }}"> Examen </a>
                <a style="text-decoration: underline" href="{{ route('professeur.creationCours' , ['matiere' => $matiere->id, 'contenu' =>  $contenu->id ]) }}"> Niveau {{ $contenu->niveau }} </a>
            </div>
        @endforeach
    </div>
    <div id="cours" data-id="{{$content}}"></div>
    @vite('resources/js/Cours/corrigerExamen.js')
@endsection