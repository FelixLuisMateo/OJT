<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\CourseController as AdminCourse;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartment;
use App\Http\Controllers\Admin\SchoolYearController as AdminSchoolYear;
use App\Http\Controllers\Admin\UserManagementController as AdminUsers;
use App\Http\Controllers\Admin\FilterController as AdminFilters;
use App\Http\Controllers\Coordinator\DashboardController as CoordDashboard;
use App\Http\Controllers\Coordinator\StudentController as CoordStudent;
use App\Http\Controllers\Coordinator\InternshipController as CoordInternship;
use App\Http\Controllers\Coordinator\AssignmentController as CoordAssignment;
use App\Http\Controllers\Coordinator\DocumentController as CoordDocument;
use App\Http\Controllers\Coordinator\MessageController as CoordMessage;

/*
|--------------------------------------------------------------------------
| Public / Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('login', [LoginController::class,'showLogin'])->name('login');
Route::post('login', [LoginController::class,'login']);
Route::get('register', [RegisterController::class,'showRegister'])->name('register');
Route::post('register', [RegisterController::class,'register']);
Route::post('logout', [LoginController::class,'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Dashboard Redirect
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) return redirect()->route('admin.dashboard');
    if ($user->isCoordinator()) return redirect()->route('coordinator.dashboard');
    if ($user->isSupervisor()) return redirect('/supervisor/dashboard'); // later
    if ($user->isStudent()) return redirect('/student/dashboard'); // later
    return abort(403);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    Route::get('dashboard', [AdminDashboard::class,'index'])->name('admin.dashboard');

    Route::resource('courses', AdminCourse::class, ['as'=>'admin']);
    Route::resource('departments', AdminDepartment::class, ['as'=>'admin'])->except(['show']);
    Route::get('school-years', [AdminSchoolYear::class,'index'])->name('admin.school-years.index');
    Route::post('school-years', [AdminSchoolYear::class,'store'])->name('admin.school-years.store');
    Route::post('school-years/{schoolYear}/activate', [AdminSchoolYear::class,'toggleActive'])->name('admin.school-years.activate');

    Route::resource('users', AdminUsers::class, ['as'=>'admin']);
    Route::get('filters', [AdminFilters::class,'filters'])->name('admin.filters');
});

/*
|--------------------------------------------------------------------------
| Coordinator Routes
|--------------------------------------------------------------------------
*/
Route::prefix('coordinator')->middleware(['auth','coordinator'])->group(function () {
    Route::get('dashboard', [CoordDashboard::class,'index'])->name('coordinator.dashboard');

    Route::get('students', [CoordStudent::class,'index'])->name('coordinator.students.index');
    Route::get('students/{student}', [CoordStudent::class,'show'])->name('coordinator.students.show');
    Route::delete('students/{student}', [CoordStudent::class,'destroy'])->name('coordinator.students.destroy');

    Route::resource('internships', CoordInternship::class, ['as' => 'coordinator']);
    Route::post('internships/{internship}/assign-supervisor', [CoordAssignment::class,'assignSupervisor'])->name('coordinator.internships.assign-supervisor');
    Route::post('internships/{internship}/set-department', [CoordAssignment::class,'setDepartment'])->name('coordinator.internships.set-department');

    Route::post('internships/{internship}/generate-doc', [CoordDocument::class,'generate'])->name('coordinator.internships.generate-doc');

    Route::get('messages', [CoordMessage::class,'index'])->name('coordinator.messages.index');
    Route::get('messages/create', [CoordMessage::class,'create'])->name('coordinator.messages.create');
    Route::post('messages', [CoordMessage::class,'store'])->name('coordinator.messages.store');
});
<?php
// Supervisor Routes
use App\Http\Controllers\Supervisor\DashboardController as SupDashboard;
use App\Http\Controllers\Supervisor\DTRController as SupDtr;
use App\Http\Controllers\Supervisor\EvaluationController as SupEval;
use App\Http\Controllers\Supervisor\ReportController as SupReport;

Route::prefix('supervisor')->middleware(['auth','supervisor'])->group(function () {
    Route::get('dashboard', [SupDashboard::class,'index'])->name('supervisor.dashboard');

    Route::get('dtr', [SupDtr::class,'index'])->name('supervisor.dtr.index');
    Route::get('dtr/{internship}', [SupDtr::class,'showInternshipDtrs'])->name('supervisor.dtr.show');
    Route::post('dtr/{dtr}/approve', [SupDtr::class,'approveDtr'])->name('supervisor.dtr.approve');
    Route::post('dtr/{dtr}/reject', [SupDtr::class,'rejectDtr'])->name('supervisor.dtr.reject');

    Route::get('evaluations/{internship}/create', [SupEval::class,'create'])->name('supervisor.evaluations.create');
    Route::post('evaluations/{internship}', [SupEval::class,'store'])->name('supervisor.evaluations.store');

    Route::post('reports/send', [SupReport::class,'sendReport'])->name('supervisor.reports.send');
});

// Student Routes
use App\Http\Controllers\Student\DashboardController as StuDashboard;
use App\Http\Controllers\Student\DTRController as StuDtr;
use App\Http\Controllers\Student\BiometricController as StuBio;
use App\Http\Controllers\Student\EvaluationController as StuEval;
use App\Http\Controllers\Student\CertificateController as StuCert;

Route::prefix('student')->middleware(['auth','student'])->group(function () {
    Route::get('dashboard', [StuDashboard::class,'index'])->name('student.dashboard');

    Route::get('dtr', [StuDtr::class,'index'])->name('student.dtr.index');
    Route::get('dtr/create', [StuDtr::class,'create'])->name('student.dtr.create');
    Route::post('dtr', [StuDtr::class,'store'])->name('student.dtr.store');

    Route::get('biometric/register', [StuBio::class,'showRegister'])->name('student.biometric.register');
    Route::post('biometric/register', [StuBio::class,'register'])->name('student.biometric.register.store');

    Route::get('evaluation', [StuEval::class,'index'])->name('student.evaluation.index');

    Route::post('certificate/generate', [StuCert::class,'generate'])->name('student.certificate.generate');
});