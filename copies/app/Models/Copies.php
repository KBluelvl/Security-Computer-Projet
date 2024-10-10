<?php
namespace App\Models;

use \Illuminate\Support\Facades\DB;

class Copies {
    public static function find($course) {
        $pdo = DB::getPdo();
        $result = $pdo->prepare("SELECT * FROM copies where course = :course");
        $result->execute(['course' => $course]);
        $copies = [];

        foreach ($result as $copie) {
            $copies[] = $copie;
        }
        return $copies;
    }

    public static function findAll($studentId,$course) {
        $pdo = DB::getPdo();
        $result = $pdo->prepare("SELECT * FROM copies where student = :student and course = :course");
        $result->execute(['student' => $studentId, 'course' => $course]);
        $copies = [];
        foreach ($result as $copie) {
            $copies[] = $copie;
        }
        return $copies;
    }

    public static function getCourses($studentId) {
        $pdo = DB::getPdo();
        $result = $pdo->prepare("SELECT DISTINCT course FROM copies where student = :student;");
        $result->execute(['student' => $studentId]);
        $copies = [];
        foreach ($result as $copie) {
            $copies[] = $copie;
        }
        return $copies;
    }

    public static function insertCopie($studentId,$mark,$course,$path,$KeyStudent,$KeyTeacher) {
        $pdo = DB::getPDO();
        $graded = 1;
        if($mark == NULL){
            $graded = 0;
        }
        $statement = $pdo->prepare("INSERT INTO `copies`(`student`, `course`, `graded`, `mark`,`name_file`,`teacher_session_key`,`student_session_key`) 
            VALUES (:student, :course, :graded, :mark, :nameFile, :keyTeacher, :keyStudent)");
        $statement->execute(['student' => $studentId, 'course' => $course, 'graded' => $graded, 
        'mark' => $mark, 'nameFile' => $path,'keyStudent' => $KeyStudent,'keyTeacher' => $KeyTeacher]);
    }

    public static function getTeacherKey($copieId) {
        $result = DB::select("select teacher_session_key,mark from copies WHERE id = ".$copieId);
        return $result;
    }

    public static function getStudentKey($copieId) {
        $result = DB::select("select student_session_key,mark from copies WHERE id = ".$copieId);
        return $result;
    }

    public static function deleteCopie($copieId) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("delete from copies where id = :id");
        $statement->execute(['id' => $copieId]);
    }
}
