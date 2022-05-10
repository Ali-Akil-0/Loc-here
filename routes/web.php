<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PartenaireController;



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
Route::get('/login', [UserController::class, 'Login']);
Route::get('/inscrire', [UserController::class, 'Inscrire']);
// name means name of the function inside the controller
Route::post('/ajouter-user', [UserController::class, 'ajouterUser'])->name('ajouter-user');
Route::post('/login-user', [UserController::class, 'loginUser'])->name('login-user');