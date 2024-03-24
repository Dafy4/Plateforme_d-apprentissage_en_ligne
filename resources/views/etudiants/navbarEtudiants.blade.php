@section('navbar')

@php
     $routeName = request()->route()->getName();
@endphp
<div class="partie1">
            <div class="navbarEtudiant">
            <span id="logo"></span>
            <div class="linkEt">
                <p id="depEt"> {{ Auth::user()->etudiants->departement->nom }} </p>
                <a href="{{ route('etudiant.accueil') }}"
                @if($routeName =='etudiant.accueil')
                    class='activeEtudiant'
                @endif
                >Accueil</a>

                {{-- Redirige vers la route du profil avec comme paramètre l'id de l'utilisateur --}}
                <a href="{{ route('etudiant.profil') }}"
                @if($routeName =='etudiant.profil')
                    class='activeEtudiant'
                @endif
                >Profil</a>

                <a href="#">Examens</a>
                <a href="{{route('etudiant.matiere')}}"
                @if($routeName =='etudiant.matiere')
                    class='activeEtudiant'
                @endif
                > Matière </a>
                <form action="{{route('auth.logout')}}" method="post">
                    @csrf
                    @method("delete")
                    <button class="btn_deconnexion_etudiant"> Déconnexion </button>
                </form>
                <form action="{{route('verify.passwordReset')}}" method="get">
                    @csrf
                    <button class="btn_deconnexion_etudiant"> Reset password </button>
                </form>
            </div>


    {{-- Ces images et formes ne sont à afficher que dans la page d'accueil --}}
    @if($routeName == 'admin.accueil')
            {{-- Contient l'image de la femme --}}
            <div class="image">

            </div>

            {{-- Décorations --}}
            <div class="rect1"></div>
            <div class="rect2"></div>
            <div class="rect3">
                    {{-- Phrases --}}
                <h1 class="ODATA"> ODATA-LEARNING </h1>
                <h2 class="Connaissance"> <span class="Connaissance">CONNAISSANCE</span> A PORTER DE MAIN</h2>
            </div>
            <div class="rect4"></div>
            <div class="rect5"></div>
            <div class="points1"></div>
            <div class="points2"></div>
    @endif
    @if($routeName != 'admin.accueil')
            <style>
                div.navbarAdmin{
                    background-color: #00143d;
                }
            </style>
    @endif
</div>

@endsection
