<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PartenaireController;
use App\Mail\InfoClient;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', [UserController::class, 'Login'])->name('login');
Route::get('/inscrire', [UserController::class, 'Inscrire'])->name('inscrire');
Route::post('/ajouter-user', [UserController::class, 'ajouterUser'])->name('ajouter-user');
Route::post('/acceuil', [UserController::class, 'loginUser'])->name('acceuil');
// Route::post('/acceuil', [UserController::class, 'loginUser2'])->name('acceuil2');

// Route::get('/acceuil', [UserController::class, 'loginUser'])->name('acceuil');

Route::post('/lochere', [UserController::class, 'lochere'])->name('lochere');
Route::post('/plusDeProduits', [UserController::class, 'plusDeProduits'])->name('plusDeProduits');
Route::post('/annonce', [UserController::class, 'annonce'])->name('annonce');
Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/pdp', [UserController::class, 'pdp'])->name('pdp');
Route::post('/Notes', [UserController::class, 'Notes'])->name('Notes');
Route::get('/MesLocClient', [UserController::class, 'MesLocClient'])->name('MesLocClient');
Route::post('/Reclamation', [UserController::class, 'Reclamation'])->name('Reclamation');
Route::post('/publier', [UserController::class, 'publier'])->name('publier');
Route::post('/add', [UserController::class, 'add'])->name('add');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::post('/devenirPartenaire', [UserController::class, 'devenirPartenaire'])->name('devenirPartenaire');
Route::post('/location', [UserController::class, 'location'])->name('location');
// Route::get('/email', [InfoClient::class, 'build'])->name('verif');



// Route::get('/email', function () {

    // Mail::to('tbestt4@gmail.com')->send(new InfoClient());
//      return new InfoClient();
// })->name('email');


// I can use the mail to function wherever I want which is fun
// Route::get('/test', function () {

//     echo "yes";
// })->name('test');