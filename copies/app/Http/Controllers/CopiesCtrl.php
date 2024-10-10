<?php
namespace App\Http\Controllers;

use App\Models\Copies; 
use App\Models\Courses;

class CopiesCtrl extends Controller {
    

    public function teacherView() {
        $course = $_POST['course'];
        $copies = Copies::find($course);
        return view('teacherCopies', ['copies' => $copies]);
    }

    public function studentView() {
        $user = auth()->user();
        $userId = $user->id;
        $courses = Copies::getCourses($userId);
        return view('studentCourses',['courses' => $courses]);
    }

    public function studentCopies() {
        $user = auth()->user();
        $userId = $user->id;
        $course = $_POST['course'];
        $copies = Copies::findAll($userId,$course);
        return view('studentCopies', ['copies' => $copies]);
    }

    public function uploadView() {
        $course = $_POST['course'];
        $students = Courses::getStudent();
        return view('uploadCopies', ['course' => $course,'students'=>$students]);
    }
}

