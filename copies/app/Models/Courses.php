<?php
namespace App\Models;

use \Illuminate\Support\Facades\DB;

Class Courses{
    public static function getTeacher() {
        $result = DB::select("select id,name from users where role = 2");
        $teachers = collect($result)->map(function($item){
            return [
                'id' => (int) $item->id,
                'name' => $item->name,
            ];
        });
        return $teachers;
    }
    public static function getStudent() {
        $result = DB::select("select id,name from users where role = 3");
        $students = collect($result)->map(function($item){
            return [
                'id' => (int) $item->id,
                'name' => $item->name,
            ];
        });
        return $students;
    }

    
    public static function getCourses() {
        $result = DB::select("select name from course");
        $courses = collect($result)->pluck('name')->toArray();
        return $courses;
    }

    public static function deleteCourse($name) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("delete from course where name = :name");
        $statement->execute(['name' => $name]);
    }

    public static function insertCourse($name,$responsable) {
        $pdo = DB::getPDO();
        $statement = $pdo->prepare("insert into course values(:name, :responsable)");
        $statement->execute(['name' => $name, 'responsable' => $responsable]);
    }

    public static function getCoursesByResp($teacherId) {
        $pdo = DB::getPDO();
        $result = $pdo->prepare("select name from course where responsable = :id");
        $result->execute(['id' => $teacherId]);
        $courses = collect($result)->pluck('name')->toArray();
        return $courses;
    }
}