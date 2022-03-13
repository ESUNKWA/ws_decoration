<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\utilisateursController;
use App\Http\Controllers\ProfilUtilisatersController;

Route::post('profil/creation', [ProfilUtilisatersController::class, '_create']);
Route::get('profil/_get_list',[ProfilUtilisatersController::class,'_get_list'])->name('user.profil.liste');
Route::apiResources([
    'profil'    => ProfilUtilisatersController::class,
    'utilisateur'   => utilisateursController::class
]);
