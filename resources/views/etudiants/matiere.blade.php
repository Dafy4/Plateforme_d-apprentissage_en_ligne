@extends('base')

@section('titre', 'Accueil')

@include('etudiants.navbarEtudiants')

@section('contenu')
<div class="cours courrss">
    <h2 class="IntroEtAcc"> Tous vos cours  </h2>
    {{-- <h2> Département : {{ $departement }}</h2> --}}
    <div class="lecon">

        @foreach ($matieres as $matiere )
            <div>
                <h2>{{ $matiere->matiere }}</h2>
                <h3 id="CatégorieCoursEt">{{ $matiere->categorie->categorie }}</h3>
                <section>
                    <div style="background-color:green;border-bottom-left-radius: 10px;width: 100%;border-bottom-right-radius: 10px;"> <a href="{{ route('etudiant.affichageCours', ['matiere' => $matiere->id, 'contenu' =>  $matiere->contenu_du_cours[0]->id]) }}"> Voir </a></div>
                </section>

                {{-- Progression par cours de l'étudiant --}}
                @php
                    $etudiants = Auth::user()->etudiants;
                    $matieres = $etudiants->departement->matieres;
                @endphp
                    {{-- {{ $matiere->matiere }}: --}}

                    @php
                        $progression_etudiant = $matiere->progressionContenu_du_cour($etudiants);
                        $total = $matiere -> progression();
                        if($total==0)
                        {
                            $total = 1;
                        }
                        $progression_pourcentage = ($progression_etudiant / $total ) * 100;
                    @endphp
                    <p id="progessEt"> {{  $progression_pourcentage  }}% </p>
            </div>
        @endforeach
    </div>
</div>

@endsection