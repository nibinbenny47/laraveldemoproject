<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/campuslist',[CampusController::class,'index'])->name('campuses.index');
// Route::get('/campuses',[CampusController::class,'create'])->name('campuses.create');
// Route::post('/campuses',[CampusController::class,'store'])->name('campuses.store');
// // Route::get('/campuses/{id}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
// // Route::put('/campuses/{id}', [CampusController::class, 'update'])->name('campuses.update');
// Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
// Route::put('/campuses/{campus}', [CampusController::class, 'update'])->name('campuses.update');
// Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('campuses.destroy');


Route::middleware('auth')->group(function () {
    Route::get('/campuslist', [CampusController::class, 'index'])->name('campuses.index');
    Route::get('/campuses', [CampusController::class, 'create'])->name('campuses.create');
    Route::post('/campuses', [CampusController::class, 'store'])->name('campuses.store');
    Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
    Route::put('/campuses/{campus}', [CampusController::class, 'update'])->name('campuses.update');
    Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('campuses.destroy');
});

Route::resource('teachers', TeacherController::class);

Route::resource('courses', CourseController::class);


Route::prefix('course')->name('courses.')->group(function () {
    Route::get('/fetchcampus', [CourseController::class, 'fetchcampus'])->name('fetchcampus');
});

// Login Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Registration Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (Protected Route)
Route::get('/dashboard', function () {
    return view('dashboard'); // Make sure you have a `dashboard.blade.php` in the `resources/views` folder.
})->middleware('auth')->name('dashboard');