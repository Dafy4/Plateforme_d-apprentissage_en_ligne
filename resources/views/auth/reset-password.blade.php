@extends('base')
@section('title', 'Réinitialisation de mot de passe')

@section('contenuOffline')

{{-- lien bootstrap en ligne --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Réinitialisation du mot de passe') }}</div>

                    <div class="card-body">
                        <form method="POST"  action="{{ route('password.update') }}">
                            @csrf

                            
                            <input type="hidden" name="token" value="{{ $token }}">
                            @error('token')
                                {{ $message }}
                            @enderror

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Adresse email') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                </div>
                                @error('email')
                                        {{ $message }}
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Nouveau mot de passe') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" name="password" required autocomplete="new-password">
                                </div>
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmation du nouveau mot de passe') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                @error('password_confirmation')
                                    {{ $message }}
                                @enderror
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Réinitialiser le mot de passe') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Vérifier les erreurs --}}
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
