<?php

use App\Http\Controllers\ProfileController;
use App\Models\Animal;
use Illuminate\Support\Facades\Route;

//* Static Pages

Route::get('/', function () {
    return view('staticPages/accueil', ['animals' => Animal::all()]);
});
Route::view('/a-propos', 'staticPages/aPropos');
Route::view('/contact', 'staticPages/contact');
Route::view('/devenir-famille-d-accueil', 'staticPages/devenirFamille');
Route::view('/faq', 'staticPages/faq');
Route::view('/infos-legales', 'staticPages/infosLegales');
Route::view('/plan', 'staticPages/plan');
Route::view('/rgpd', 'staticPages/rgpd');

//* Animal Pages

//* Associations Pages

//* Register Pages
Route::view('/connexion', 'signIn/connexion');
Route::view('/inscription', 'signIn/inscription');
Route::view('/association/inscription', 'signIn/inscriptionAsso');
Route::view('/famille/inscription', 'signIn/inscriptionFam');

//* Foster Pages

//* Shelter Pages

/* Route::get('/', function () {
    return view('welcome');
}); */

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
