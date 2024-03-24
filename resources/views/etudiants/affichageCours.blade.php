@extends('base')

@section('titre', 'Consultation des cours')

{{-- NAVBAR --}}
@include('etudiants.navbarEtudiants')

@section('contenu')
    <div class="niveau">
        @foreach ($matiere->contenu_du_cours as $contenu )
            {{-- <p> {{ $contenu->id }} </p> --}}
            <div
            @if( $contenu->id == $content)
                class='active'
            @endif
            ><a href="{{ route('etudiant.affichageCours' , ['matiere' => $matiere->id, 'contenu' =>  $contenu->id ]) }}"> Niveau {{ $contenu->niveau }} </a></div>
        @endforeach
    </div>
    <div id="cours" data-id="{{$content}}"></div>
    @vite('resources/js/Cours/afiichageCours.js')
    {{-- @vite('resources/js/Cours/appProf.js') --}}
@endsection
