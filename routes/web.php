<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampusController;


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

Route::get('/campuses',[CampusController::class,'create']);
Route::post('/campuses',[CampusController::class,'store'])->name('campuses.store');
