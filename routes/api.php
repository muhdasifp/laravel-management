<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('admin/register', [AdminController::class, 'reisterAdmin']);
Route::post('admin/login', [AdminController::class, 'login']);

Route::post('student/register', [StudentController::class, 'registerStudent']);
Route::post('student/login', [StudentController::class, 'loginStudent']);

Route::post('teacher/register', [TeacherController::class, 'registerTeacher']);
Route::post('teacher/login', [TeacherController::class, 'loginTeacher']);

Route::group(['middleware' => ['jwt.auth', 'role:admin'], 'prefix' => 'admin'], function () {
    Route::get('/users', [AdminController::class, 'getAllUser']);
});

Route::group(['middleware' => ['jwt.auth', 'role:student'], 'prefix' => 'student'], function () {
    Route::get('/profile', [StudentController::class, 'studentProfile']);
    Route::delete('/delete_profile', [StudentController::class, 'deleteStudentProfile']);
});


Route::group(['middleware' => ['jwt.auth', 'role:teacher'], 'prefix' => 'teacher'], function () {
    Route::get('/profile', [TeacherController::class, 'teacherProfile']);
    Route::delete('/delete_profile', [TeacherController::class, 'deleteTeacherProfile']);
});
