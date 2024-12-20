<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdmissionController;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/datatable', [HomeController::class, 'datatable'])->name('datatable');

Route::middleware(['auth'])->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('class', ClassController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('payments', PaymentController::class);
    Route::post('course/fee', [CourseController::class,'course_fee'])->name('course.cus.fee');
    Route::resource('admissions', AdmissionController::class);
    Route::get('report/summary', [ReportController::class,'report_summary'])->name('report.summary');
});

