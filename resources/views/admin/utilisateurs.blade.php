@extends('base')

@section('titre', 'Utilisateurs')

@include('admin.navbarAdmin')

@section('contenu')

{{-- <div class="navigation">
    <button onclick="filtrerUtilisateurs('Tous')"> Tous </button>
    <button onclick="filtrerUtilisateurs('professeur')"> Professeurs </button>
    <button onclick="filtrerUtilisateurs('etudiants')"> Etudiants </button>
</div> --}}
<div class="infoUsers">
    @if ($etat = 'Tous')

    <div class="titre">
        <h2> Informations sur tous les étudiants </h2>
        <h2> Informations sur tous les étudiants </h2>
    </div>

    <div class="infoEtudiants filtre">
        @foreach ($info_etudiants as $etudiants )
            <div class="infoEtudiantsContenus">
                <!-- <div class="containerr" onclick="this.classList.toggle('change')"> -->
                <div class="containerr" onclick="option(this)">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>

                <div class="option affOption">
                    <div>
                        <div style="background-color: black;color:white">Changer le type d'utilisateur</div>
                        <div class="modifType">
                            {{-- @php
                                dd($etudiants->user->id)
                            @endphp --}}
                            <a class="direc" href="{{route('admin.changeTypeUser',['user'  => $etudiants->user->id,'type'=>'professeur','idDepart'=> 0])}}">changer en professeur</a>
                            <a class="direc" href="{{route('admin.changeTypeUser',['user'  => $etudiants->user->id,'type'=>'admin','idDepart'=> 0])}}">changer en administrateur</a>
                            <div class="etudientDep">
                                <p style="color: white;margin-bottom: 0;">changer en etudiant</p>
                                <div>
                                    <h4 style="margin-top: 0;margin-bottom: 0;">choisir le departement</h4>
                                    <div class="depp">
                                        @foreach ($departement as $dep)
                                            <a class="direc" href="{{route('admin.changeTypeUser',['user'  => $etudiants->user->id,'type'=>'etudiants','idDepart'=> $dep->id])}}">{{$dep->nom}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="background-color: brown;"><a href="{{route('admin.suppreUser',['user'  => $etudiants->user->id])}}">Supprimer cette utilisateur</a></div>
                </div>

                <div class="">
                    <span class="infoUserSpan"> Etudiant </span>
                    <img src="{{ asset('images/'. $etudiants->user->profilImage) }}" alt="photo_profil" class="profilePicture">
                    
                    {{-- <div class="profilePicture"></div> --}}
                    <p> Nom : {{ $etudiants -> nom }}</p>
                    <p> Prénom : {{ $etudiants -> prenom }}</p>
                    <p> Téléphone : {{ $etudiants -> telephone  }}</p>
                    <p> Email : {{ $etudiants -> email }} </p>
                    <p> Département : {{ $etudiants -> departement -> nom}}</p>
                    <p> APPRENTISSAGE </p>
                    <p>

                        @php
                            $matieres = $etudiants -> departement -> matieres;
                        @endphp
                        @if ($matieres->isEmpty())
                            Aucune matière à apprendre
                        @else
                            @foreach ($matieres as $matiere)
                                {{ $matiere->matiere }}:

                                @php
                                    $progression_etudiant = $matiere->progressionContenu_du_cour($etudiants);
                                    $total = $matiere -> progression();
                                    if($total==0)
                                    {
                                        $total = 1;
                                    }
                                    $progression_pourcentage = ($progression_etudiant / $total ) * 100;
                                @endphp
                                <div class="progress">
                                    <div class="progress-bar" data-pourcentage="{{ $progression_pourcentage }}" id="" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                {{ $progression_pourcentage }}%
                                <br>
                            @endforeach
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    </div>
    <div class="titre">
        <h2> Informations sur tous les professeurs </h2>
        <h2> Informations sur tous les professeurs </h2>
    </div>
    <div class="infoProfeseurs filtre">
        @foreach ($info_professeurs as $professeur)
            <div class="infoEtudiantsContenus">
                <div class="containerr" onclick="option(this)">
                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3"></div>
                </div>

                <div class="option affOption">
                    <div>
                        <div style="background-color: black;color:white">Changer le type d'utilisateur</div>
                        <div class="modifType">
                            <a class="direc" href="{{route('admin.changeTypeUser',['user'=> $professeur->user->id,'type'=>'professeur','idDepart'=> 0])}}">changer en professeur</a>
                            <a class="direc" href="{{route('admin.changeTypeUser',['user'=> $professeur->user->id,'type'=>'admin','idDepart'=> 0])}}">changer en administrateur</a>
                            <div class="etudientDep">
                                <p style="color: white;margin-bottom: 0;">changer en etudiant</p>
                                <div >
                                    <h4 style="margin-top: 0;margin-bottom: 0;">choisir le departement</h4>
                                    <div class="depp">
                                        @foreach ($departement as $dep)
                                            <a class="direc" href="{{route('admin.changeTypeUser',['user'  => $professeur->user->id,'type'=>'etudiants','idDepart'=> $dep->id])}}">{{$dep->nom}}</a>
                                        @endforeach
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <div style="background-color: brown;"><a href="{{route('admin.suppreUser',['user'  => $professeur->user->id])}}">Supprimer cette utilisateur</a></div>
                </div>

                <div class="">
                    <span class="infoUserSpan"> Professeur </span>
                    <img src="{{ asset('images/'.$professeur->user->profilImage) }}" alt="photo_profil" class="profilePicture">
                    <p> Nom : {{ $professeur->nom }} </p>
                    <p> Prénoms : {{ $professeur->prenom }}</p>
                    <p> Téléphone : {{ $professeur->telephone }}</p>
                    <p> Email : {{ $professeur->email }}</p>
                    <p> COURS CREER </p>
                    <p>
                        @php
                            $matieres =  $professeur->matieres
                        @endphp
                        @if ($matieres->isEmpty())
                            <p> Aucune contribution </p>
                        @else
                            @foreach ($matieres as $matiere)
                                <p>
                                    {{ $matiere->matiere }}
                                    @php
                                        $contenus = $matiere->contenu_du_cours
                                    @endphp
                                    @foreach ( $contenus as  $contenu )
                                    <span> {{  $contenu->etudiant->count()  }} apprenants </span>
                                    @endforeach
                                </p>
                            @endforeach
                        @endif
                    </p>
                </div>
            </div>
        @endforeach

    </div>
    @endif
</div>
<div class="test">  </div>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        var progressBars = document.querySelectorAll('.progress-bar');
        console.log(progressBars.length);
        for(var i = 0; i != progressBars.length; i++)
        {
            var balise = progressBars[i];
            console.log(balise.dataset);
            var percentage = balise.dataset.pourcentage;
            balise.style.width = percentage + '%';
            balise.setAttribute('aria-valuenow', percentage);
        }
    });

    //  Fonction qui permet de filtrer les utilisateurs
    function filtrerUtilisateurs(utilisateur)
    {
        //Utiliser la reqêtte AJAX pour récupérer les informations filtrées
        fetch(`users/filtre/type_user/${utilisateur}`)
            .then(response => response.json())
            .then(data => {
                //Mise à jour de la liste de utilisateurs affichés
                console.log(data);
                // document.getElementById('test').innerHTML = data;
            })
            .catch(error => console.error('Erreur lors du filtrage de données : ', error));
    }
    function option(balise){
        balise.classList.toggle('change')
        const element=balise.parentElement.children
        element[1].classList.toggle('affOption')
        element[2].classList.toggle('afflist')
    }
    var lien = document.querySelectorAll('.direc')
    for(var i=0; i < lien.length ;i++){
        lien[i].addEventListener('click',function(event){
            const verif=confirm("vous voulez vraiment changer le type d'utilisateur de cette utilisateur?")
            if(verif==false){
                event.preventDefault()
            }
        })
    }
</script>
@endsection

