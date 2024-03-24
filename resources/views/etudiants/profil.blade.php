@extends('base')

@section('titre', 'Votre profil')

@include('etudiants.navbarEtudiants')

@section('contenu')
    <div class="ProfilEt1">
        <div class="CollectET">
            <div class="PhotoProfil">
                <img src="{{ asset('images/'. Auth::user()->profilImage) }}" id="imageProfil" alt="Photo de profil">
                <a href="{{ route('changeProfilPictureRedirect') }}"><button id="btnChangePicture"> Changer la photo de profil </button></a>
            </div>
           
            <div class="Noms">
                <p> <span>  Nom : </span> {{ $etudiant->nom }} </p>
                <p> <span> Prénom : </span>  {{ $etudiant->prenom }}</p>
            </div>
        </div>
        <div class="apprentissageEnCours">
            <div class="cours courrss">
                <h2 class="IntroEtAcc" id="EtCours"> Apprentissage en cours</h2>
                <div class="lecon" id="cardLecon">
    
                    @foreach ($matiereEnCours as $matiere )
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
                                    $total = $matiere->progression();
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
            
            @foreach ($matiereEnCours as $matiere )
                @php
                    $note = $matiere->resultatExamen();
                    $exist = 0;
                    if($note==-1)
                    {
                        $exist++;
                    }
                @endphp
            @endforeach
    
    
            <div class="coursTermine">
                <h2 class="IntroEtAcc" id="EtCours"> Cours terminé </h2>
                @if ($exist==0)
                    <p id="AucunCoursTermine"> Vous n'avez encore terminé aucune matière </p>
                @else
                    <div class="cours courrss">
                        <div class="lecon" id="cardLecon">
                            <div>
                                @foreach ($matiereEnCours as $matiere )
                                <div>
                                    <h2>{{ $matiere->matiere }}</h2>
                                    <h3 id="CatégorieCoursEt">{{ $matiere->categorie->categorie }}</h3>
                                    <span> Note : </span> <p id="progessEt"> {{ $matiere->resultatExamen() }}</p>
                                @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    

@endsection
