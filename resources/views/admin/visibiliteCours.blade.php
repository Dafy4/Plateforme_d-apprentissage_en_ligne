@extends('base')

@section('titre', 'Distribution des modules')

@include('admin.navbarAdmin')

@section('contenu')

{{-- Bootstrap en ligne --}}

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <h4> Module : {{ $cours -> matiere}}</h4>

    <h4> Choisissez les département qui auront accès à ce cours </h4>
    <form method="post">
        @csrf

        <div class="form-group">
            {{-- <select name="departement[]" id="departement" class="form-control" multiple>
                <option value=""> Séléctionner un ou plusieurs département </option>
                @foreach ($departements as $departement)
                    <option value="{{ $departement -> id }}">{{ $departement -> nom }}</option>
                @endforeach
            </select> --}}
            {{-- <option value=""> Séléctionner un ou plusieurs département </option> --}}
            <label for="departement"> Séléctionner un ou plusieurs département </label> <p></p>
            @foreach ($departements as $departement)
                {{-- Index: {{ $loop->index }} : Index de la boucle Foreach --}}
                <label for="departement{{$loop->index}}">
                    <input type="checkbox" name="departement[]" id="departement{{$loop->index}}" value="{{ $departement -> id }}">
                    {{ $departement -> nom }}
                </label> <br>

            @endforeach

            <button class="btn btn-warning"> VALIDER </button>
        </div>
    </form>


@endsection
