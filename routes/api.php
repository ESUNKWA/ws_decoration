<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\utilisateursController;
use App\Http\Controllers\ProfilUtilisatersController;

Route::put('profil/edit/{idprofil}', [ProfilUtilisatersController::class, 'modif']);
//Route::get('profil/_get_list',[ProfilUtilisatersController::class,'_get_list'])->name('user.profil.liste');
Route::resources([
    'profil'    => ProfilUtilisatersController::class,
    'utilisateur'   => utilisateursController::class
]);
