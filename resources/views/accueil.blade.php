<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <title> @yield('title') </title>
    <style>
        .accueil2{
            position:fixed;
            top:0%;
            left:0%;
            z-index: -1;
        }

        .accueil{
            display: flex;
            margin-top: 40px;
            padding-left: 15%;
        }
        .ac{
            transform: translateX(1px);
            position: fixed;
            top: 0%;
            left: 0%;
            z-index: -1;
        }
        a{
            text-decoration: none;
            color: white;
            margin-left: 6%;
        }
        input.recherche{
            margin-left: 6%;
            background-color: #008ecf;
            text-align: right;
            padding-right: 16px;
            height: 31px;
            border-radius: 16px;
            border: none;
            outline: none;
        }
        input::placeholder {
            color: white;
        }
        .recherche input:not(:placeholder-shown) {
            color: white;
        }

        /* Navbar interface administrateur */
        .navbar{
            display: flex;
            width: 100%;
            height: 70px;
            background-color: #001a4b;
        }
        .navbar *{
            margin:8px
        }
        .link{
            position: absolute;
            right: 0%;
        }
        .link *{
            color: white;
        }
        .navbar h1{
            color: white;
        }
        .navbar input{
            margin-left: 40px;
            height: 35px;
            border-radius: 17px;
            border: none;
        }
    </style>

</head>
<body>
    @guest
    <div style="overflow-y: hidden;">

        <div class="accueil2">
            <div id="accueil"></div>
            @vite('resources/js/accueil/app.js')
        </div>

            <div class="accueil">
                <h1 style="color: white; margin-top: 0px;">logo</h1>
                <a href="#">Home</a>
                <a href=" {{route('auth.login')}}">Se connecter</a>
                <a href="{{ route('create.account') }}"> S'inscrire </a>
                <a href="#">Leçons</a>
                <input class="recherche" type="text" placeholder="recherche">

            </div>
        @yield('content')

    @endguest

        {{-- Si l'utilisateur est connecté  --}}
        @auth
        <div class="navbar">
            <h1>logo</h1>
            <div class="link">
                <a href="#">Accueil</a>
                <a href="#">Profil</a>
                <a href="#">Examens</a>
                <a href="">Parametre</a>
                <form action="{{route('auth.logout')}}" method="post">
                    @csrf
                    @method("delete")
                    <button> Déconnexion</button>
                </form>

                <input type="search" name="" id="">
            </div>

        </div>
            <h1> Vous êtes connecté </h1>
            @yield('professeurContent')
        @endauth

    </div>

{{-- fa fa-file-o --}}
{{-- fa fa-font (titre) --}}
</body>
</html>
