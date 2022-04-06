<?php

namespace App\Http\Controllers\metier;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\metier\Tarification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class tarificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_tarification = DB::table('t_produits')
                                ->join('t_tarifications', 't_produits.r_i', '=', 't_tarifications.r_produit')
                                ->select('t_produits.r_i as idproduit','t_produits.r_libelle','t_produits.r_stock','t_tarifications.r_prix_location','t_tarifications.r_duree',)
                                ->get();
        $response = [
            '_status' =>1,
            '_result' => $liste_tarification
        ];
        return response()->json($response, 200);
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
         //Récupération des champs
         $inputs = $request->all();

         //Validation des formualires
         $errors = [
             'p_produit' => 'required',
             'p_quantite' => 'required',
             'p_prix_location' => 'required',
             'p_duree' => 'required',
             'p_utilisateur' => 'required',
         ];
         $erreurs = [
             'p_produit.required' =>'Le libellé est obligatoire',
             'p_quantite.required' => 'La quantité est obligatoire',
             'p_prix_location.required'  => 'Le prix de location est obligatoire',
             'p_duree.required'  => 'La durée est obligatoire',
             'p_utilisateur.required' => 'Utilisateur inconnu',
         ];
 
         $validator = Validator::make($inputs,$errors, $erreurs);
 
         if( $validator->fails() ){
             $response = [
                 '_status' =>-100,
                 '_result' => $validator->errors()
             ];
             return $response;
         }else{
             $insertion = Tarification::create([
                 'r_produit' => $request->p_produit,
                 'r_quantite' => $request->p_quantite,
                 'r_description' => $request->p_description,
                 'r_prix_location' => $request->p_prix_location,
                 'r_duree' => $request->p_duree,
                 'r_utilisateur' => $request->p_utilisateur
             ]);
         }
         if( $insertion->r_i ){
             $response = [
                 '_status' =>1,
                 '_result' => 'Tarification enregistré avec succès'
             ];
         }else{
             $response = [
                 '_status' =>0,
                 '_result' => 'Une erreur est survenue lors de l\'enregistrement'
             ];
         }
 
         return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function show($idproduit)
    {
        $tarification = Tarification::where('r_produit',$idproduit)->get();
        $response = [
            '_status' =>1,
            '_result' => $tarification
        ];
        return response()->json($response, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function edit(cr $cr)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, cr $cr)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\cr  $cr
     * @return \Illuminate\Http\Response
     */
    public function destroy(cr $cr)
    {
        //
    }
}
