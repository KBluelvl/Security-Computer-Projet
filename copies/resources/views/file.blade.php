@extends('layouts.app')
@section('content')
<h2>Decrypt the file</h2>
<form method="POST" action="" enctype="multipart/form-data" id="uploadForm">
    <label for="">Private Key</label>
        <input type="file" id="privateKey">  
        <br>
        <button id="btn">Decrypt</button>
        <input type="hidden" name="encryptedData" id="encryptedData" value="{{$file}}">
        @if($role == 3)
            <input type="hidden" name="sessionKey" id="sessionKey" value="{{$sessionKey[0]->student_session_key}}">
        @elseif($role == 2)
            <input type="hidden" name="sessionKey" id="sessionKey" value="{{$sessionKey[0]->teacher_session_key}}">
        @endif
        <input type="hidden" name="mark" id="mark" value="{{$sessionKey[0]->mark}}">
</form>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jsencrypt/3.0.0/jsencrypt.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function decryptWithPrivateKey(privateKey, encryptedData) {
            var decrypt = new JSEncrypt();
            decrypt.setPrivateKey(privateKey); // privateKey contient la clé privée, sans [1]
        
            try {
                return decrypt.decrypt(encryptedData);
            } catch (error) {
                console.error("Erreur de déchiffrement : ", error);
                return null;
            }
        }

        document.getElementById('uploadForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            const privateKeyFile = document.getElementById('privateKey').files[0];
            const encryptedData = document.getElementById('encryptedData').value;
            const encryptedSessionKey = document.getElementById('sessionKey').value;
            const mark = document.getElementById('mark').value;
            
            // Lire le contenu du fichier de clé privée
            const reader = new FileReader();
            reader.onload = async function(event) {
                const privateKey = event.target.result;
                const sessionKey = decryptWithPrivateKey(privateKey, encryptedSessionKey);

                // decrypt  data
                const decryptedWordArray = CryptoJS.AES.decrypt(encryptedData, sessionKey);
                const decryptedData = decryptedWordArray.toString(CryptoJS.enc.Utf8);
                const trimmedDecrypted = decryptedData.substring(decryptedData.indexOf(',') + 1);
                
                // decrypt mark
                const decryptedMarkArray = CryptoJS.AES.decrypt(mark, sessionKey);
                const decryptedMark = decryptedMarkArray.toString(CryptoJS.enc.Utf8);
                const trimmedmark = decryptedMark.substring(decryptedMark.indexOf(',') + 1);

                let p1 = document.createElement('p');
                p1.textContent = "mark = " + decryptedMark;
                document.body.appendChild(p1);
                let p2 = document.createElement('p');
                p2.textContent =  atob(trimmedDecrypted);
                document.body.appendChild(p2);
                console.log('Decrypted Data:', atob(trimmedDecrypted));
            };
            reader.readAsText(privateKeyFile);
        });
    });
</script>