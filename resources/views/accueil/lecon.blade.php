@extends('base')

@section('titre', 'A propos de tous les cours')

@include('admin.navbarAdmin')

@section('contenuOffline')

<style>
    .matiere{
        color:black;
    }
    <style>
    .cours{
        text-align: center;
        background-color: white;
        margin-top: 20px;
        margin-bottom: 20px;
    }
    .cours h2,h3{
        color: #06b3e3;
        text-align:center;
    }
    .lecon{
    display: table;
    }
    .lecon > div{
        width: 275px;
        height: 143px;
        margin: 23px;
        box-shadow: inset 1px 3px 6px 5px rgb(225 222 222);
        border-radius: 10px;
        float: left;
    }
    .lecon > div >section{
        width:100%;
        color:white;
        position:relative;
        bottom:10px;
        box-shadow: inset 1px 3px 6px 5px rgb(225 222 222);
        display:none;
        animation: apparition 0.5s;
        font-size: 12px;
    }
    @keyframes apparition {
        from {transform: translateY(30px);opacity:0;}
        to {transform: translateY(0);opacity:1;}
    }
    .lecon > div:hover section{
        display:block;
    }
    .lecon > div >section >div {
        float:left;
        width:50%;
        height:30px;
    }
    .lecon > div >section >a {
        float:left;
        width:50%;
        height:30px;
    }
</style>

<div class="coursOffline">
    <h3
        style="font-family: 'Philosopher';
        color: #00143d;"
    >
        Voici toutes les matières existantes
    </h3>
    <div class="lecon">

        @foreach ($matieres as $matiere )
            <div>
                <h2 class="titreCours">{{ $matiere->matiere }}</h2>
                <p class="categoryCours">Catégorie : {{ $matiere->categorie->categorie }} </p>
                <p class="profTitulaireCours"> {{ $matiere->proffesseur->prenom}} </p>
                {{-- <section>
                    <div style="background-color:green;border-bottom-left-radius: 10px;cursor:pointer;"> <a style="color:#fff" href="{{ route('admin.affichageCoursAdmin', ['matiere' => $matiere->id, 'contenu' =>  $matiere->contenu_du_cours[0]->id]) }}" class="matiere"> Voir </a> </div>
                    <div style="background-color:red;border-bottom-right-radius: 10px;"> <a style="color:#fff" href="{{ route('admin.visibiliteCours', ['cours'  => $matiere->id ]) }}" class="matiere"> Visibilité par département</a></div>
                </section> --}}
            </div>
        @endforeach
        {{-- <div style="text-align: center;padding-top: -7%;">
            <p style="margin-top: 17%;">ajouter <br> une matiere </p>
        </div> --}}
    </div>
</div>
@endsection
