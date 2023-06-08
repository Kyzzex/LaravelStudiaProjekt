<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::redirect('/', '/dashboard');

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('/users', UserController::class);
    Route::patch('/groups/students', [GroupController::class, 'addStudent'])->name('students.group.add')->middleware('role:admin');
    Route::delete('/groups/students/{student}', [GroupController::class, 'removeStudent'])->name('students.group.remove')->middleware('role:admin');
    Route::patch('/groups/subjects', [GroupController::class, 'addSubject'])->name('subjects.group.add')->middleware('role:admin');
    Route::delete('/groups/subjects', [GroupController::class, 'removeSubject'])->name('subjects.group.remove')->middleware('role:admin');
    Route::resource('/groups', GroupController::class);
    Route::resource('/subjects', SubjectController::class);
    Route::resource('/grades', GradeController::class);
});

require __DIR__.'/auth.php';
