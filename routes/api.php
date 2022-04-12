<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\categorieController;
use App\Http\Controllers\utilisateursController;
use App\Http\Controllers\metier\communesController;
use App\Http\Controllers\metier\logistikController;
use App\Http\Controllers\metier\produitsController;
use App\Http\Controllers\location\LocationController;
use App\Http\Controllers\ProfilUtilisatersController;
use App\Http\Controllers\metier\achatproduitController;
use App\Http\Controllers\metier\tarificationController;
use App\Http\Controllers\location\detailsLocationController;

Route::put('profil/edit/{idprofil}', [ProfilUtilisatersController::class, 'modif']);


Route::post('location/{proforma}', [LocationController::class, 'store']);

Route::get('detailslocation/{idlocation}', [detailsLocationController::class, 'show']);

Route::post('location', [LocationController::class, 'index']);

Route::post('updatestatlocation', [LocationController::class, 'updateStat']);
Route::post('majstockProduit', [LocationController::class, 'majstockProduit']);

Route::post('majstock', [produitsController::class, 'addStock']);
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
]);
