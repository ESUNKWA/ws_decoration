<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\utilisateursController;
use App\Http\Controllers\ProfilUtilisatersController;
use App\Http\Controllers\categorieController;

Route::put('profil/edit/{idprofil}', [ProfilUtilisatersController::class, 'modif']);
Route::resources([
    'profils'    => ProfilUtilisatersController::class,
    'auth'    => authController::class,
    'utilisateurs'   => utilisateursController::class,
    //Metier
    'categories'   => categorieController::class
]);
