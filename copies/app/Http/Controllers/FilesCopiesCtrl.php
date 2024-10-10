<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Models\Copies;

use Illuminate\Support\Facades\Crypt;

use Illuminate\Support\Facades\Response;

class FilesCopiesCtrl extends Controller {
    public function upload(Request $request){
        if ($request->hasFile('file')) {
            // recupère le fichier
            $uploadedFile = $request->file('file');
            //  enregistre dans local storage
            $path = Storage::disk('local')->putFile('copies_files', $uploadedFile);

            $content  = $request->input('content');
            // modifie le message
            $myfile = fopen(storage_path("app\\".$path), "w") or die("Unable to open file!");
            fwrite($myfile, $content);
            fclose($myfile);

            $student = $request->input('student');
            $mark = $request->input('mark');
            $course = $request->input('course');
            $KeyStudent = $request->input('encryptedSessionKeyStudent');
            $KeyTeacher = $request->input('encryptedSessionKeyTeacher');
            //$nameFile = $uploadedFile->getClientOriginalName();
            $path = basename($path);
            Copies::insertCopie($student,$mark,$course,$path,$KeyStudent,$KeyTeacher);
            
            return redirect('/courses/2')->with('success', 'Fichier téléversé avec succès !');
        }
        return redirect('/courses/2')->with('error', 'Aucun fichier n\'a été téléversé.');
    }

    public function download(Request $request) {
        $nameFile = $request->input('nameFile');
        $filePath = storage_path('app\copies_files\\' . $nameFile); // Chemin complet vers le fichier
        $fileContents = file_get_contents($filePath);
        $user = auth()->user();
        $userRole = $user->role;
        if($userRole == 3){
            $sessionKey = Copies::getStudentKey( $request->input('id'));
        } else if($userRole == 2){
            $sessionKey = Copies::getTeacherKey( $request->input('id'));
        }
        
        return view('file', ['file' => $fileContents, 'sessionKey' => $sessionKey, 'role' => $userRole]);
    }
    
    public function delete(Request $request) {
        $course = $_POST['course'];
        $copies = Copies::find($course);
        return view('teacherCopiesDelete', ['copies' => $copies]);
    }

    public function deleteCopie(Request $request) {
        Copies::deleteCopie($request->input('id'));
        $course = $_POST['course'];
        $copies = Copies::find($course);
        return view('teacherCopiesDelete', ['copies' => $copies]);
    }
}