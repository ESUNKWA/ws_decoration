<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\dashController;
use App\Http\Controllers\categorieController;
use App\Http\Controllers\utilisateursController;
use App\Http\Controllers\metier\communesController;
use App\Http\Controllers\metier\logistikController;
use App\Http\Controllers\metier\produitsController;
use App\Http\Controllers\location\locationController;
use App\Http\Controllers\ProfilUtilisatersController;
use App\Http\Controllers\personnel\fonctionController;
use App\Http\Controllers\metier\achatproduitController;
use App\Http\Controllers\metier\tarificationController;
use App\Http\Controllers\location\detailsLocationController;
use App\Http\Controllers\personnel\PersonnelController;

Route::put('profil/edit/{idprofil}', [ProfilUtilisatersController::class, 'modif']);
Route::post('location/{proforma}', [locationController::class, 'store']);
Route::get('detailslocation/{idlocation}', [detailsLocationController::class, 'show']);
Route::post('location', [locationController::class, 'index']);
Route::post('updatestatlocation', [locationController::class, 'updateStat']);
Route::post('majstockProduit', [locationController::class, 'majstockProduit']);
Route::post('majstock', [produitsController::class, 'addStock']);
Route::get('personneltNotUser', [PersonnelController::class, 'listNotUser']);
Route::post('tarifapply', [tarificationController::class, 'tarifapply']);
Route::post('paymentpartiel', [locationController::class, 'add_payment_partiel']);
Route::resources([
    'profils'    => ProfilUtilisatersController::class,
    'auth'    => authController::class,
    'utilisateurs'   => utilisateursController::class,
    //Metier
    'categories'   => categorieController::class,
    'produits' => produitsController::class,
    'tarifications' => tarificationController::class,
    'achatproduits' => achatproduitController::class,
    'commune' => communesController::class,
    'logistik' => logistikController::class,
    //Dashbord
    'dash' => dashController::class,
    //Personnel
    'fonction' => fonctionController::class,
    'personnel' => PersonnelController::class,
]);
