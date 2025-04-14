<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\FosterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\SignUpController;
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
Route::controller(AnimalController::class)->group(function () {
    Route::prefix('/animaux')->group(function () {
        Route::get('/', 'displayAll');
        Route::post('/', 'getSearched');
        Route::get('/{id}', 'animal_details');
        Route::post('/{id}', 'make_request');
    });
});

//* Associations Pages
Route::controller(AssociationController::class)->group(function () {
    Route::prefix('/associations')->group(function() {
        Route::get('/', 'displayAll');
        Route::post('/', 'getSearched');
        Route::get('/{id}', 'shelter_details');
    });
});

//* Login Page
Route::controller(LoginController::class)->group(function () {
    Route::get('/connexion', 'display_login');
    Route::post('/connexion', 'login');
    Route::get('/deconnexion', 'logout');
});

//* Register Pages
Route::controller(SignUpController::class)->group(function () {
    Route::view('/inscription', 'signIn/inscription');

    Route::get('/association/inscription', 'display_shelter_signup');
    Route::post('/association/inscription', 'shelter_signup');

    Route::get('/famille/inscription', 'display_foster_signup');
    Route::post('/famille/inscription', 'foster_signup');
});

//* Foster Pages
Route::controller(FosterController::class)->group(function () {
    Route::prefix('/famille/profil')->group(function () {
        Route::get('/', 'foster_profile');
        Route::post('/', 'foster_edit');
        Route::get('/delete', 'foster_destroy');
        Route::get('/demandes', 'foster_requests');
    });
});

//* Shelter Pages
Route::controller(ShelterController::class)->group(function () {
    Route::prefix('/association/profil')->group(function () {

        Route::get('/', 'shelter_dashboard');
        Route::post('/', 'shelter_edit');
        Route::get('/delete', 'shelter_destroy');
        Route::get('/logo', 'shelter_logo');
        Route::post('/logo', 'shelter_logo_upload');

        Route::prefix('/animaux')->group(function () {
            Route::get('/', 'shelter_animals_list');
            Route::get('/suivi', 'shelter_fostered_animals');
            Route::post('/nouveau-profil', 'shelter_create_animal');
            Route::get('/nouveau-profil', 'shelter_display_create_animal');
            Route::get('/{animalId}', 'shelter_animal_details');
        });

        Route::prefix('/demandes')->group(function () {
        Route::get('/', 'shelter_requests');
        Route::get('/{demandeId}', 'shelter_request_details');
        Route::post('/{demandeId}/deny', 'shelter_deny_request');
        Route::post('/{demandeId}/accept', 'shelter_accept_request');
        });
    });
});

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
