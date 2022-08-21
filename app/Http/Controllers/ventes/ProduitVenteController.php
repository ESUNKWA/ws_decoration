<?php

namespace App\Http\Controllers\ventes;

use App\Models\c;
use Illuminate\Http\Request;
use App\Http\Traits\cryptTrait;
use App\Http\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\VenteProduits\ProduitsVente as Produits;

class ProduitVenteController extends Controller
{
    use cryptTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_produits = Produits::OrderBy('r_nom_produit', 'ASC')->get();

        $donnees = $this->responseSuccess('Liste des produits en ventes', json_decode($liste_produits));

        //Cryptage des données avant à envoyer au client
        //$donneesCryptees = $this->crypt($donnees);

        return $donnees;
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
        //Décryptage des données récues
       //$inputs = $this->decryptData($request->p_data);
       $inputs = $request->p_data;

       // Validation des champs
       $errors = [
           'r_nom_produit'  => 'required|unique:t_produitventes',
           'r_creer_par' => 'required',
           'r_modifier_par' => 'required',
       ];
       $erreurs = [
           'r_nom_produit.required' =>'Le nom du produit est obligatoire',
           'r_nom_produit.unique' =>'Le nom du produit existe dejà',
           'r_creer_par.required'  => 'Utilisateur obligatoire',
           'r_modifier_par.required'  => 'Utilisateur obligatoire'
       ];

       $validate = Validator::make($inputs, $errors, $erreurs);

       if( $validate->fails()){
           return $this->responseCatchError($validate->errors());
       }else{

           try {

               $insertion = Produits::create($inputs);

               $response = $this->crypt('Le produit [ '.$insertion->r_nom_produit.' ] à bien été enregistrée');

               return $this->responseSuccess($response);

           } catch (\Throwable $e) {
               return $this->responseCatchError($e->getMessage());
           }

       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function show(c $c)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function edit(c $c)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //$inputs = $this->decryptData($request->p_data);
       $inputs = $request->p_data;

       // Validation des champs
       $errors = [
        'r_nom_produit'  => 'required',
        'r_creer_par' => 'required',
        'r_modifier_par' => 'required',
        ];
        $erreurs = [
            'r_nom_produit.required' =>'Le nom du produit est obligatoire',
            'r_creer_par.required'  => 'Utilisateur obligatoire',
            'r_modifier_par.required'  => 'Utilisateur obligatoire'
        ];

       $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            $response = [
                '_status' =>0,
                '_result' => $validate->errors()
            ];
            return $response;
        }else{

            $update = Produits::find($id);

            $update->update($inputs);

            $response = [
                '_status' => 1,
                '_result' => 'Le produit [ '.$update->r_nom_produit.' ] à bien été modifiée'
            ];
            return response()->json($response, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function destroy(c $c)
    {
        //
    }
}
