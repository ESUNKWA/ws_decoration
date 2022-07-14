<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\Utilisateurs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class authController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validation des données
        $errors = [
            'p_login' => 'required',
            'p_mdp' => 'required',
        ];
        $erreurs = [
            'p_login.required' => 'Veuillez saisir votre identifiant',
            'p_mdp.required' => 'Veuillez saisir votre mot de passe',
        ];

        $validate = Validator::make($request->all(), $errors, $erreurs);


        if( $validate->fails() ){
            return $validate->errors();
        }
        //Récuperation des infos des utilisateurs
        $login = DB::table('t_utilisateurs')
                    ->join('t_personnels','t_personnels.r_i', '=','t_utilisateurs.r_personnel')
                    ->join('t_profils','t_profils.r_i', '=','t_utilisateurs.r_profil')
                    ->select('t_utilisateurs.r_i','t_utilisateurs.r_login','t_personnels.r_nom','t_personnels.r_prenoms','t_personnels.r_contact','t_profils.r_libelle as profil','t_profils.r_code_profil','t_utilisateurs.r_actif')
                    ->where('r_login', $request->p_login)
                    ->where('password', MD5($request->p_mdp))
                    ->get();

        if( count($login) >= 1){

            // switch( $login[0]->r_actif ){

            //     case 0:
            //         $users = Utilisateurs::find($login[0]->r_i);

            //         $users->update([
            //             'r_actif' => 1
            //         ]);

            //         $response = [
            //             '_status' => 1,
            //             '_result' => $login,
            //         ];

            //         break;

            //     case 1:
            //         $response = [
            //             '_status' => -100,
            //             '_result' => "Ce compte est déjà en cours d'utilisation",
            //         ];
            //         break;

            //     default:
            //         break;
            // }
            $response = [
                '_status' => 1,
                '_result' => $login
            ];
            return response()->json($response, 200);
        }else{
            return response()->json(['_status'=>0, '_result'=>'Login ou Mot de passe incorrecte !']);
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

    public function deconnect(Request $request){

        $users = Utilisateurs::findOrfail($request->idUtilisateur);

        $users->update([
                'r_actif' => 0
        ]);
        return ($users->r_i)? true : false;
    }
}
