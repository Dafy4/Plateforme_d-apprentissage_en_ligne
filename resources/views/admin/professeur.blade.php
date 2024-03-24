@extends('base')

@section('titre', 'Engager un professeur')

@include('admin.navbarAdmin')

@section('contenu')
<style>
input {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #e3e3e3;
}

input:focus {
  background-color: #999999;
  outline: none;
}

hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}

button {
  background-color: #001a4b;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}


.signupbtn {
  margin-left: 25%;
  width: 50%;
}

.container {
  padding: 16px;
}

.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

@media screen and (max-width: 300px) {
  .signupbtn {
    width: 100%;
  }
}

{{-- <a href="{{route('admin.professeur')}}"> <button type="button" class="btn btn-primary btn-lg"> Engager un professeur </button></a>
 --}}

</style>
    <form action="" method="post" style="border:1px solid #ccc">
        @csrf
        <div class="container">
            <h1> Engagez le meilleur pour former votre équipe </h1>
            <hr>

            <label for="nom"><b>Nom</b></label>
            <input type="text" placeholder="Entrer votre nom" name="nom" required>
            @error('nom')
                {{ $message }}
            @enderror
            <label for="prenom"><b>Prénom</b></label>
            <input type="text" placeholder="Entrer votre prenom" name="prenom" required>
            @error('prenom')
                {{ $message }}
            @enderror
            <label for="telephone"><b>Telephone</b></label>
            <input type="tel" placeholder="Entrer votre numero telephone" name="telephone" required>
            @error('telephone')
                {{ $message }}
            @enderror
            <label for="email"><b>Email </b></label>
            <input type="email" placeholder="Entrer votre adress Email" name="email" required>
            @error('email')
                {{ $message }}
            @enderror
            <div class="clearfix">
                <button class="signupbtn">Ajouter</button>
            </div>
        </div>
    </form>
@endsection


