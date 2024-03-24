@section('navbar')

@php
     $routeName = request()->route()->getName();
@endphp
<div class="partie1">
    <div class="navbarAdmin">
        <div class="fondNavbar">
            <div class="linkAdmin">
                <a href="{{route('admin.accueil')}}"
                    @if($routeName == 'admin.accueil')
                        class="active"
                    @else
                        class="inactive"
                    @endif>
                Accueil</a>
                <a href="{{ route('admin.cours') }}"
                    @if($routeName == 'admin.cours' || $routeName == 'admin.visibiliteCours')
                        class="active"
                    @else
                        class="inactive"
                    @endif
                >Cours</a>
                <a href="{{route('admin.gestionCompte')}}"
                    @if($routeName == 'admin.gestionCompte')
                        class="active"
                    @else
                        class="inactive"
                    @endif
                >Gestion compte utilisateur</a>
                <a href="{{route('admin.departement')}}"
                    @if($routeName == 'admin.departement')
                        class="active"
                    @else
                        class="inactive"
                    @endif
                >Départements</a>
                <a href="{{route('admin.utilisateurs')}}"
                    @if($routeName == 'admin.utilisateurs')
                        class="active"
                    @else
                        class="inactive"
                    @endif
                >Informations utilisateurs</a>
                <a href="{{route('admin.resultats')}}"
                    @if($routeName == 'admin.resultats')
                        class="active"
                    @else
                        class="inactive"
                    @endif
                >Résultat des tests</a>
                <input type="search" name="" id="" placeholder="RECHERCHE" class="recherche_admin">
                <form action="{{route('auth.logout')}}" method="post">
                    @csrf
                    @method("delete")
                    <button class="btn_deconnexion_admin"> Déconnexion </button>
                </form>
                <form action="{{route('verify.passwordReset')}}" method="get">
                    @csrf
                    <button class="btn_deconnexion_admin"> Reset password </button>
                </form>
            </div>
        </div>
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
