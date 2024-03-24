@extends('base')

@section('titre', 'Examen')

@section('contenu')
    <div id="cours" data-id="{{$content}}" allowfullscreen></div>
    @vite('resources/js/Cours/affichageExam.js')
    {{-- @vite('resources/js/Cours/appProf.js') --}}
@endsection
