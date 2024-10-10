@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('upload - ') }}{{$_POST['course']}}</div>
                <div class="card-body">
                    <p>Create new copies:</p>
                    <form action="{{ route('copies.upload') }}" method="post" enctype="multipart/form-data" id="uploadForm">
                        @csrf
                            <input type="file" name="file" id="file">
                            <br>
                            <select id="student" name="student">
                                    @foreach ($students as $student)
                                    <option value="{{$student['id']}}">{{$student['name']}}</option>
                                    @endforeach 
                            </select>
                            <br>
                            <label for="mark">Mark :&ensp;</label>
                            <input type="number" id="mark" name="mark" max=20 min=0 step="any">
                            <br>
                            <button type="submit" class="btn btn-primary">send</button>
                            <input type="hidden" name="course" value="{{$_POST['course']}}">
                            <input type="hidden" name="content">
                        </form>
                        <div id="user-id" data-id="{{ auth()->user()->id }}"></div>
                </div>  
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/forge/0.10.0/forge.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/3.0.0/jsencrypt.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

<script>
     document.addEventListener("DOMContentLoaded", function() {
    // Fonction pour effectuer une requête AJAX et récupérer la clé publique
    async function fetchPublicKey(userId) {
        const response = await fetch('/get-public-key/' + userId);
        const data = await response.json();
        return data.publicKey;
    }

    // Fonction pour crypter une clé de session avec une clé publique (ne fonctionne pas encore !)
    function encryptWithPublicKey(publicKey, data) {
        // Utilisez la bibliothèque JsEncrypt pour le chiffrement
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(publicKey[0]);
        return encrypt.encrypt(data);
    }

    // Générer une clé de session en combinant les IDs et des données aléatoires
    function generateSessionKey() {
        var randomData = Math.random().toString(36).substring(2);
        return randomData;
    }

    // Chiffrement d'un fichier avec la clé de session
    function encryptFile(sessionKey, file, mark) {
    const reader = new FileReader();
    reader.onload = async function(event) {
        // crypter la copie
        const data = event.target.result;
        const trimmedData = data.substring(data.indexOf(',') + 1);
        const encryptedData = CryptoJS.AES.encrypt(trimmedData, sessionKey).toString();

        // crypter la note
        const encryptedMark = CryptoJS.AES.encrypt(mark, sessionKey).toString();
        document.getElementById('mark').type = "text";
        document.getElementById('mark').value = encryptedMark;

        // Créer un champ caché dans le formulaire pour stocker les données chiffrées
        const encryptedDataInput = document.createElement('input');
        encryptedDataInput.type = 'hidden';
        encryptedDataInput.name = 'content';
        encryptedDataInput.value = encryptedData;

        // Ajouter le champ caché au formulaire
        document.getElementById('uploadForm').appendChild(encryptedDataInput);

        // Envoyer le formulaire
        document.getElementById('uploadForm').submit();
    };
    reader.readAsDataURL(file);
}

    // Lorsque le formulaire est soumis
    document.getElementById('uploadForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        // Récupérer les IDs des professeurs et étudiants et les points
        const teacherId = {{ auth()->user()->id }};
        const studentId = document.getElementById('student').value;
        const mark = document.getElementById('mark').value;

        // Récupérer les clés publiques des professeurs et étudiants
        const publicKeyTeacher = await fetchPublicKey(teacherId);
        const publicKeyStudent = await fetchPublicKey(studentId);

        // Générer la clé de session
        const sessionKey = generateSessionKey();

        // Crypter la clé de session avec les clés publiques
        const encryptedSessionKeyTeacher = encryptWithPublicKey(publicKeyTeacher, sessionKey);
        const encryptedSessionKeyStudent = encryptWithPublicKey(publicKeyStudent, sessionKey);

        // Créer un champ caché dans le formulaire pour stocker les données cryptées
        const encryptedSessionKeyTeacherInput = document.createElement('input');
        encryptedSessionKeyTeacherInput.type = 'hidden';
        encryptedSessionKeyTeacherInput.name = 'encryptedSessionKeyTeacher';
        encryptedSessionKeyTeacherInput.value = encryptedSessionKeyTeacher;

        const encryptedSessionKeyStudentInput = document.createElement('input');
        encryptedSessionKeyStudentInput.type = 'hidden';
        encryptedSessionKeyStudentInput.name = 'encryptedSessionKeyStudent';
        encryptedSessionKeyStudentInput.value = encryptedSessionKeyStudent;

        // Ajouter les champs cachés au formulaire
        this.appendChild(encryptedSessionKeyTeacherInput);
        this.appendChild(encryptedSessionKeyStudentInput);

        const inputFile = document.querySelector('input[type="file"]').files[0];
        encryptFile(sessionKey, inputFile, mark);
    });
});
</script>