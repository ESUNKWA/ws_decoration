<?php

namespace App\Http\Controllers\ventes;

use App\Models\c;
use Illuminate\Http\Request;
use App\Http\Traits\cryptTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\location\client;
use App\Models\VenteProduits\DetailVentes;
use App\Models\VenteProduits\ProduitsVente;
use Illuminate\Support\Facades\Validator;
use App\Models\VenteProduits\VenteProduits;

class VenteProduitController extends Controller
{
    use cryptTrait, ResponseTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listProduits = ProduitsVente::orderBy('r_nom_produit', 'asc')->get();

        $donnees = $this->responseSuccess('Liste des produits en ventes', json_decode($listProduits));

        //Cryptage des données avant à envoyer au client
        $donneesCryptees = $this->crypt($donnees);
        return $donneesCryptees;
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
           'p_ventes'  => 'required',
           'r_details' => 'required'
       ];
       $erreurs = [
           'p_ventes.required' =>'Le montant total est obligatoire',
           'r_details.required' =>'Veuillez selectionner les produits de l\'achat'
       ];

       $validate = Validator::make($inputs, $errors, $erreurs);

       if( $validate->fails()){
           return $this->responseCatchError($validate->errors());
       }else{

           try {
            $date = date('ym');

               //Début de la transaction
               DB::beginTransaction();

               //Insertion des données du client
                $insertionClient = client::create($inputs['p_client']);

                //Insertion des données dans t_ventes
                $inputs['p_ventes']['r_reference'] = ($insertionClient->r_i < 9 )? $date.'0'.$insertionClient->r_i : $date.$insertionClient->r_i;
               $insertion = VenteProduits::create($inputs['p_ventes']);

               if( $insertion ){

                foreach ($inputs['r_details'] as $value) {
                    //Insertion des données dans t_details_ventes
                    $value['r_vente'] = $insertion->id;
                    DetailVentes::create($value);
                }

                DB::commit();

                $response = 'Le Enregistrement effectué avec succès';
                return $this->responseSuccess($response);

               }




               //$response = $this->crypt('Le fournisseur [ '.$insertion->r_nom_fournisseur.' ] à bien été enregistrée');

               //return $this->responseSuccess($response);

           } catch (\Throwable $e) {
               DB::rollback();
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
    public function update(Request $request, c $c)
    {
        //
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

    public function vente_produits(Request $request){



    }
}
