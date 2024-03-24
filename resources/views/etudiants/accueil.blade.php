@extends('base')

@section('titre', 'Accueil')

@include('etudiants.navbarEtudiants')

@section('contenu')
<div class="teteEt">
    <h1> ODATA-LEARNING </h1>
    <div class="croix">
        @for ($i = 0;$i <= 15; $i++)
                <svg class="svg"  xmlns="http://www.w3.org/2000/svg" width="30" height="60.679" viewBox="0 0 61.4 70.679">
                    <g id="Croix2" transform="translate(-1686.47 -562.661)">
                    <line id="Ligne_9" data-name="Ligne 9" x2="59" y2="7" transform="translate(1687 598)" fill="none" stroke="#fff" stroke-width="9"/>
                    <line id="Ligne_10" data-name="Ligne 10" y1="67" x2="52" transform="translate(1693.5 564.5)" fill="none" stroke="#fff" stroke-width="6"/>
                    </g>
                </svg>
        @endfor
    </div>
    <script>
        const svg=document.querySelectorAll(".svg")
        for(var i=0; i < svg.length ;i++){
            (function(i){
                svg[i].style.transition="10s";
                svg[i].style.position="absolute";
                setTimeout(function(){
                    svg[i].style.top=((Math.random() * 100) + 1)+"%";
                    svg[i].style.left=((Math.random() * 80) + 1)+"%";
                    svg[i].style.transform="rotate("+(((Math.random() * 360)))+"deg)";
                }, 500);
                var duree=parseInt((Math.random() * 10000)+10000)
                setInterval(function(){
                    svg[i].style.top=((Math.random() * 100) + 1)+"vh";
                    svg[i].style.left=((Math.random() * 80) + 20)+"vw";
                    svg[i].style.transform="rotate("+(((Math.random() * 360)))+"deg)";
                }, duree);
            })(i)
        }

    </script>

</div>
<div class="cours courrss">
    <h2 class="IntroEtAcc"> Cours ajoutés récemment </h2>
    {{-- <h2> Département : {{ $departement }}</h2> --}}
    <div class="lecon">

        @foreach ($matieresRecents as $matiere )
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
