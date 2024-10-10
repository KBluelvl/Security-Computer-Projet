<?php
namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Copies;

    class CoursesCtrl extends Controller {
    public function index() {
        $teachers = Courses::getTeacher();
        $courses = Courses::getCourses();
        return view('editCourses', ['teachers' => $teachers,'courses' => $courses]);
    }

    public function delete() {
        $cours = $_POST['course'];
        Courses::deleteCourse($cours);
        return redirect('courses/edit');
    }

    public function insert() {
        $name = $_POST['name'];
        $responsable = $_POST['teacher'];
        Courses::insertCourse($name,$responsable);
        return redirect('courses/edit');
    }

    public function view() {
        $user = auth()->user();
        $userId = $user->id;
        $courses = Courses::getCoursesByResp($userId);
        return view('courses',['courses' => $courses]);
    }

    public function action() {
        $course = $_POST['course'];
        return view('action', ['course' => $course]);
    }
}

