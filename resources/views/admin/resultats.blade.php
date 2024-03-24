@extends('base')

@section('titre', 'Résultats des tests')

@include('admin.navbarAdmin')

@section('contenu')
<table id="tableResultat">
    <tr>
        <th> N° </th>
        <th> Nom et prénoms </th>
        <th> Département </th>
        <th  class="dropBtn">
            <div class="dropdownMenu">
                <p> Cours   <i class="fa fa-caret-down" style="font-size:48px;color:rgb(38, 0, 255)"></i></p>

                <div class="dropdownContent">
                    @foreach ($matieres as $cours )
                        <a href="{{ route('admin.filtrerResutats',['cours' => $cours->id]) }}"> {{ $cours->matiere }}</a>
                    @endforeach
                </div>
            </div>
        </th>


        <th> Notes </th>
    </tr>
    {{-- @if($etat == 'all') --}}
        @foreach ($etudiants as $etudiant)
            <tr>
                <td>     {{ $loop->index + 1 }}  </td>
                <td>     {{ $etudiant['etudiant']->nom}}   {{$etudiant['etudiant']->prenom}}  </td>
                <td>     {{ $etudiant['etudiant']->departement->nom }}  </td>

                @foreach ($etudiant['etudiant']->contenu_du_cours as $contenu )
                    <td>     {{ $contenu->matiere[0]->matiere }}  </td>
                @endforeach

                <td
                    @if( $etudiant['note'] < 10 )
                        class="note"
                    @else
                        class="noteBien"
                    @endif
                >  {{  $etudiant['note'] }} </td>
            </tr>
        @endforeach

    {{-- @endif --}}
</table>
@endsection
