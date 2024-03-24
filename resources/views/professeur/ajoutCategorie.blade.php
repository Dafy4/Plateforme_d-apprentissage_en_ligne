@extends('base')

@section('titre', 'Categorie')

{{-- NAVBAR --}}
@include('professeur.navbarProf')

@section('contenu')
    <h4 style="text-align: center;color:#001a4b;"> Ajouter une nouvelle catégorie pour les cours : </h4>

    <form class="creationM" action="" method="post" style="display:flex;align-items: baseline;padding-bottom: 2px;">

        @csrf
        <label for="categorie"> Nom de la catégorie : </label>
        <input type="text" name="categorie" id="categorie">
        <button style="margin-left: 14px;width: 94px;"> CONFIRMER </button>
    </form>

    <h4 style="text-align: center;color:#001a4b;"> Liste des catégories existantes </h4>
    <table class="listUser categorie">
        <tr class="tete">
            <th> Nom </th>
            <th> Date de création  </th>
        </tr>
        <tbody class="list">
            @foreach ( $category as $categorie )
                <tr>
                    <td><p> {{ $categorie->categorie}} </p></td>
                    <td><p> {{ $categorie->created_at}} </p></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
