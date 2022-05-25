<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Mail;

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PartenaireController;
use App\Mail\InfoClient;

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');
Route::get('/', [UserController::class, 'FirstPage'])->name('FirstPage');
Route::get('/plusDeProduitsOff', [UserController::class, 'plusDeProduitsOff'])->name('plusDeProduitsOff');
Route::post('/annonceOff', [UserController::class, 'annonceOff'])->name('annonceOff');

Route::get('/login', [UserController::class, 'Login'])->name('login');
Route::get('/inscrire', [UserController::class, 'Inscrire'])->name('inscrire');
Route::post('/ajouter-user', [UserController::class, 'ajouterUser'])->name('ajouter-user');
Route::post('/acceuil', [UserController::class, 'loginUser'])->name('acceuil');

Route::post('/lochere', [UserController::class, 'lochere'])->name('lochere');
Route::post('/plusDeProduits', [UserController::class, 'plusDeProduits'])->name('plusDeProduits');
Route::post('/annonce', [UserController::class, 'annonce'])->name('annonce');
Route::post('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/pdp', [UserController::class, 'pdp'])->name('pdp');
Route::post('/Notes', [UserController::class, 'Notes'])->name('Notes');
Route::get('/MesLocClient', [UserController::class, 'MesLocClient'])->name('MesLocClient');
Route::post('/Reclamation', [UserController::class, 'Reclamation'])->name('Reclamation');
Route::post('/publier', [UserController::class, 'publier'])->name('publier');
Route::post('/add', [UserController::class, 'add'])->name('add');
Route::post('/dashboard', [UserController::class, 'getDataDashboard'])->name('getDataDashboard');
Route::post('/devenirPartenaire', [UserController::class, 'devenirPartenaire'])->name('devenirPartenaire');
Route::post('/location', [UserController::class, 'location'])->name('location');
Route::post('/archive', [UserController::class, 'archive'])->name('archive');


Route::post('/customers', [UserController::class, 'customers'])->name('customers');
Route::post('/partners', [UserController::class, 'partners'])->name('partners');
Route::get('/customerbloquer/{id}', [UserController::class, 'bloquercustomer'])->name('post.bloquercustomer');
Route::get('/bloquerpartner/{id}', [UserController::class, 'bloquerpartner'])->name('post.bloquerpartner');
Route::get('/annoncebloquer/{IdAnnonce}', [UserController::class, 'bloquer'])->name('post.bloquer');
Route::post('/view_AnnoncesAdmin', [UserController::class, 'announcement'])->name('view_AnnoncesAdmin');
Route::get('/view_Annonces_blackliste', [UserController::class, 'announcementblack'])->name('view_Annonces_blackliste');
// reclamations
Route::post('/complaints', [AdminController::class, 'Complaints'])->name('complaints');
Route::post('/complaints/repondre1', [AdminController::class, 'ComplaintsRepondre'])->name('ComplaintsRepondre');
Route::post('/complaints/repondre2', [AdminController::class, 'storeReponse'])->name('storeReponse');
Route::post('/complaints/vu1', [AdminController::class, 'ComplaintsVu'])->name('ComplaintsVu');
Route::post('/complaints/vu2', [AdminController::class, 'storeVu'])->name('storeVu');