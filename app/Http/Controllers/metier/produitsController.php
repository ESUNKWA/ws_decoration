<?php

namespace App\Http\Controllers\metier;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\metier\Produits;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class produitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_produits = Produits::orderBy('r_libelle','ASC')->get();
        $response = [
            '_status' =>1,
            '_result' => $liste_produits
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
            'p_libelle' => 'required',
            'p_categories' => 'required',
            'p_stock' => 'required',
            'p_utilisateur' => 'required',
        ];
        $erreurs = [
            'p_libelle.required' =>'Le libellé est obligatoire',
            'p_categories.required' => 'Le libellé est obligatoire',
            'p_stock.required'  => 'Le stock est obligatoire',
            'p_utilisateur.required' => 'Utilisateur inconnu',
        ];

        $validator = Validator::make($inputs,$errors, $erreurs);

        if( $validator->fails() ){
            return $validator->errors();
        }else{
            $insertion = Produits::create([
                'r_categorie' => $request->p_categories,
                'r_libelle' => $request->p_libelle,
                'r_description' => $request->p_description,
                'r_stock' => $request->p_stock,
                'r_image' => $request->p_image,
                'p_utilisateur' => $request->p_utilisateur
            ]);
        }
        if( $insertion->r_i ){
            $response = [
                '_status' =>1,
                '_result' => 'Produits enregistré avec succès'
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
    public function show(cr $cr)
    {
        //
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
    public function update(Request $request, $id)
    {
        $inputs = $request->all();
        //validate des champs
        $errors = [
            'p_categories'  => 'required',
            'p_libelle' => 'required',
            'p_utilisateur' => 'required',
        ];
        $erreurs = [
            'p_libelle.required' =>'Le libellé est obligatoire',
            'p_categories.required' => 'Le libellé est obligatoire',
            'p_utilisateur.required' => 'Utilisateur inconnu',
        ];
        $update = Produits::find($id);

        $update->update([
            'r_categorie' => $request->p_categories,
            'r_libelle' => $request->p_libelle,
            'r_description' => $request->p_description,
            'r_image' => $request->p_image,
            'p_utilisateur' => $request->p_utilisateur
        ]);
        if( $update->r_i ){
            $response = [
                '_status' =>1,
                '_result' => 'Produits Modifié avec succès'
            ];
        }else{
            $response = [
                '_status' =>0,
                '_result' => 'Une erreur est survenue lors de la modification'
            ];
        }

        return response()->json($response, 200);
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
