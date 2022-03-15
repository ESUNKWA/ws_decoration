<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class utilisateursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listeUtilisateurs = Utilisateurs::orderBy('r_nom', 'ASC')->get();
        $datas = [
            '_status'   => 1,
            '_result'   => $listeUtilisateurs
        ];
        return response()->json($datas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'p_profil'  => 'required',
            'p_nom'  => 'required|between:2,20',
            'p_prenoms'  => 'required|between:2,30',
            'r_login'  => 'required|min:4',
            'password'  => 'required|min:4|confirmed'
        ];

        $erreurs = [
            'p_profil.required'  => 'Le profil est réquis',
            'p_nom.required'  => 'Le nom est réquis',
            'p_nom.between'  => 'La taille du nom est compris entre 2 et 20 caractères',
            'p_prenoms.required'  => 'le nom est réquis',
            'p_prenoms.between'  => 'La taille du nom est compris entre 2 et 20 caractères',
            'r_login.required'  => 'L\'identifiant est obligatoire',
            'r_login.min'       => 'L\'identifiant doit avoir au minimum 4 caractères',
            'password.required' => 'Le mot de passe est réquis',
            'password.min' => 'Le mot de passe doit être de 4 caractères minimum',
            'password_confirmation.required' => 'Confirmer le mot de passe',
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails() ){
            return $validate->errors();
        }else{

            $insertion = Utilisateurs::create([
                'r_profil' => $request->p_profil,
                'r_nom' => $request->p_nom,
                'r_prenoms'=>   $request->p_prenoms,
                'r_telephone'   => $request->r_telephone,
                'r_login' => $request->r_login,
                'password' => MD5($request->password), 
                'r_photo'   => $request->p_img_name,
                'r_status'  => 1,
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function show(rc $rc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function edit(rc $rc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rc $rc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rc  $rc
     * @return \Illuminate\Http\Response
     */
    public function destroy(rc $rc)
    {
        //
    }
}
