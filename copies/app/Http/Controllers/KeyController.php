<?php
namespace  App\Http\Controllers;
 
use  App\Models\Key;
use App\Models\User;

class KeyController{
public function getPublicKey($studentId) {
    $publicKey = Key::getPublicKey($studentId);
    return response()->json(['publicKey' => $publicKey]);
}
public function storeEncryptedSessionKey(Request $request) {
    $encryptedSessionKey = $request->input('encryptedSessionKey');
    $keyStudent = $request->input('sessionKeyStudent');

    $idStudent = $request->input('studentId');

    $keyTeacher = $request->input('sessionKeyTeacher');

    $idTeacher = $request->input('teacherId');
    Key::storeSessionKey($idStudent, $keyStudent);
    Key::storeSessionKey($idTeacher, $keyTeacher);



}
}