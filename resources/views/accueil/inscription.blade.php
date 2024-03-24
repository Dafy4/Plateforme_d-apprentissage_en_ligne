@extends('base')

@section('title', 'Créer un compte')

{{-- @include('admin.navbarAdmin') --}}

@section('contenuOffline')
  <div id="formInscri" class=formInscri></div>
  @vite('resources/js/accueil/formInscri.js')
@endsection


