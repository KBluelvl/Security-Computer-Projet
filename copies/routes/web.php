<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CopiesCtrl;
use App\Http\Controllers\CoursesCtrl;
use App\Http\Controllers\RolesCtrl;
use App\Http\Controllers\FilesCopiesCtrl;
use App\Http\Controllers\KeyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');



// route admin
Route::middleware(['auth','role:1'])->group(function() {
    Route::get('/roles/edit',[RolesCtrl::class,'index'])->name('editRole');
    Route::post('roles/accept',[RolesCtrl::class,'accept'])->name('acceptRole');
    Route::post('roles/decline',[RolesCtrl::class,'decline'])->name('declineRole');
    Route::get('/courses/edit',[CoursesCtrl::class,'index'])->name('editCourse');
    Route::post('/courses/delete',[CoursesCtrl::class,'delete'])->name('deleteCourse');
    Route::post('/courses/add',[CoursesCtrl::class,'insert'])->name('addingCourse');
});

// route teacher
Route::middleware(['auth','role:2'])->group(function() {
    Route::get('/courses/2',[CoursesCtrl::class,'view'])->name('courses.teacher');
    Route::post('/courses/2/action',[CoursesCtrl::class, 'action'])->name('courses.teacher.action');
    Route::post('/copies/2/upload',[CopiesCtrl::class, 'uploadView'])->name('copies.teacher.upload');
    Route::post('/copies/2/view',[CopiesCtrl::class, 'teacherView'])->name('copies.teacher.view');
    Route::post('/copies/upload',[FilesCopiesCtrl::class, 'upload'])->name('copies.upload');
    Route::post('/copies/2/download',[FilesCopiesCtrl::class, 'download'])->name('copies.d');
    Route::post('/copies/2/deleteCopie',[FilesCopiesCtrl::class, 'deleteCopie'])->name('copies.delete'); // supprimer une copie
    Route::post('/copies/2/delete',[FilesCopiesCtrl::class, 'delete'])->name('copies.teacher.delete');
});

// route student
Route::middleware(['auth','role:3'])->group(function() {
    Route::get('/courses/3',[CopiesCtrl::class,'studentView'])->name('courses.student');
    Route::post('/copies/3',[CopiesCtrl::class,'studentCopies'])->name('copies.student');
    Route::post('/copies/3/download',[FilesCopiesCtrl::class, 'download'])->name('copies.download');
});

Route::post('/store-encrypted-session-key', [KeyController::class,'storeEncryptedSessionKey']);
Route::get('/get-public-key/{studentId}', [KeyController::class,'getPublicKey']);