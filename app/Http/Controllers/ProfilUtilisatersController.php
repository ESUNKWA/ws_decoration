<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilUtilisatersController extends Controller
{
    public function _get_list(){
        return [
            'result' => true
        ];
    }

    public function _create(Request $request){
        die($request);
    }
}
