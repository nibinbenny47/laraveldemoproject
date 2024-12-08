<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\CourseController;


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
Route::get('/campuslist',[CampusController::class,'index'])->name('campuses.index');
Route::get('/campuses',[CampusController::class,'create'])->name('campuses.create');
Route::post('/campuses',[CampusController::class,'store'])->name('campuses.store');
// Route::get('/campuses/{id}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
// Route::put('/campuses/{id}', [CampusController::class, 'update'])->name('campuses.update');
Route::get('/campuses/{campus}/edit', [CampusController::class, 'edit'])->name('campuses.edit');
Route::put('/campuses/{campus}', [CampusController::class, 'update'])->name('campuses.update');
Route::delete('/campuses/{campus}', [CampusController::class, 'destroy'])->name('campuses.destroy');

Route::get('/courses',[CourseController::class,'create'])->name('courses.create');
Route::post('/courses',[CourseController::class,'store'])->name('courses.store');