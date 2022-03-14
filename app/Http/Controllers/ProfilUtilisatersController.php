<?php

namespace App\Http\Controllers;

use App\Models\t_profils;
use Illuminate\Http\Request;

class ProfilUtilisatersController extends Controller
{
    public function _get_list(){
        $liste_profil = t_profils::all();
        $datas = [
            '_status' => 1,
            'result' => $liste_profil
        ];
        return $datas;
    }

    public function _create(Request $request){



        die($request);
    }
}
