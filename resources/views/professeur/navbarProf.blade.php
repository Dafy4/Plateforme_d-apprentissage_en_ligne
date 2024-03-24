@section('navbar')

@php
     $routeName = request()->route()->getName();
@endphp
        <div class="navbar">
            {{-- <h1>logo</h1> --}}
            <span id="logo"></span>
            <div class="link">
                <a href="{{route('professeur.accueil')}}"
                    @if($routeName =='professeur.accueil')
                    class='activeEtudiant'
                    @endif
                >Accueil</a>

                {{-- Redirige vers la route du profil avec comme paramètre l'id de l'utilisateur --}}
                <a href="{{ route('professeur.profil', ['professeur' => Auth::user()->professeur->id]) }}"
                    @if($routeName =='professeur.profil')
                        class='activeEtudiant'
                    @endif
                >Profil</a>
                {{-- <a href="#">Examens</a> --}}
                <a href="{{ route('professeur.creationMatiere')}}"
                    @if($routeName =='professeur.creationMatiere')
                        class='activeEtudiant'
                    @endif
                > Créer une matière </a>
                {{-- <form action="{{route('auth.logout')}}" method="post">
                    @csrf
                    @method("delete")
                    <button> Déconnexion </button>
                </form> --}}
                <form action="{{route('auth.logout')}}" method="post">
                    @csrf
                    @method("delete")
                    <button class="btn_deconnexion_professeur"> Déconnexion </button>
                </form>
                <form action="{{route('verify.passwordReset')}}" method="get">
                    @csrf
                    <button class="btn_deconnexion_professeur"> Reset password </button>
                </form>
        </div>
@endsection
