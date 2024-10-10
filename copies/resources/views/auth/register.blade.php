@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" id="registration-form">
                            @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('role') }}</label>

                            <div class="col-md-6">
                                <select id="role" type="role" class="form-control @error('role') is-invalid @enderror" name="role" value="{{ old('role') }}" required autocomplete="role">
                                    <option value="3">Student</option>
                                    <option value="2">Teacher</option>
                                    <option value="1">Admin</option>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-md-4 col-form-label text-md-end">{{ __('username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <input type="hidden" id="public-key" name="public_key">


                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button id="saveButton" type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/3.0.0/jsencrypt.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var form = document.getElementById("registration-form");
    var publicKeyField = document.getElementById("public-key");

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        var encrypt = new JSEncrypt({ default_key_size: 2048 });
        var privateKey = encrypt.getPrivateKey(); // Obtenez la clé privée

        // Générer et obtenir la clé publique
        var publicKey = encrypt.getPublicKey();

        // Stocker la clé publique dans le champ caché
        publicKeyField.value = publicKey;

        // Créer un lien de téléchargement pour la clé privée
        var privateKeyBlob = new Blob([privateKey], { type: "text/plain" });
        var privateKeyUrl = URL.createObjectURL(privateKeyBlob);
        var privateKeyLink = document.createElement("a");
        privateKeyLink.id = "keyLink"; // Ajoute l'ID à l'élément
        privateKeyLink.href = privateKeyUrl;
        privateKeyLink.download = "private_key.txt";
        privateKeyLink.textContent = "Télécharger la clé privée";
        privateKeyLink.style.display = "block"; // Mettre en ligne pour l'afficher comme un lien

        // Ajouter le lien de téléchargement au formulaire
        form.appendChild(privateKeyLink);

        document.getElementById('keyLink').click(function(){
            form.submit();
        });
        form.submit();
    });
});
</script>
