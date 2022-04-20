<?php

namespace App\Http\Controllers\location;

use App\Models\cr;
use Illuminate\Http\Request;
use App\Models\location\client;
use App\Models\metier\Produits;
use App\Models\location\Location;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\location\Detailslocacation;
use App\Models\metier\Paiementechellonner;

class locationController extends Controller
{
    private $listeLocation;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inputs = $request->all();


        $errors = [
            'p_status'=> 'required',
        ];
        $erreurs = [
            'p_status.required' => 'Veuillez selectionner le type'
        ];


        switch ($inputs['p_mode']) {

            case 1:
                $this->listeLocation = DB::table('t_clients')
                ->join('t_locations', 't_clients.r_i', '=', 't_locations.r_client')
                ->join('t_communes', 't_communes.r_i', '=', 't_locations.r_destination')
                ->select('t_clients.*','t_locations.*','t_communes.r_libelle')
                ->where('t_locations.r_status', DB::raw('COALESCE('.$inputs['p_status'].',t_locations.r_status)'))
                ->whereDate('t_locations.r_date_envoie', '=', $inputs['p_date'])
                ->get();
                break;

            case 2:
                $this->listeLocation = DB::table('t_clients')
                ->join('t_locations', 't_clients.r_i', '=', 't_locations.r_client')
                ->join('t_communes', 't_communes.r_i', '=', 't_locations.r_destination')
                ->select('t_clients.*','t_locations.*','t_communes.r_libelle')
                ->where('t_locations.r_status',DB::raw('COALESCE('.$inputs['p_status'].',t_locations.r_status)'))
                ->whereDate('t_locations.r_date_retour', '=', $inputs['p_date'])
                ->get();
                break;

            default:
            $this->listeLocation = DB::table('t_clients')
                ->join('t_locations', 't_clients.r_i', '=', 't_locations.r_client')
                ->join('t_communes', 't_communes.r_i', '=', 't_locations.r_destination')
                ->select('t_clients.*','t_locations.*','t_communes.r_libelle')
                ->where('t_locations.r_status',DB::raw('COALESCE('.$inputs['p_status'].',t_locations.r_status)'))
                ->whereDate('t_locations.r_date_envoie', '>=', $inputs['p_date'])
                ->whereDate('t_locations.r_date_retour', '<=', $inputs['p_date_retour'])
                ->get();
            break;

        }

        $response = [
            '_status' => 1,
            '_result' => $this->listeLocation
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
    public function store(Request $request, $mode)
    {
        $inputs = $request->all();

        $errors = [
            'p_details'  => 'required',
            'p_nom'  => 'required',
            'p_prenoms'  => 'required',
            'p_telephone'  => 'required|size:10',
            //'p_email'  => 'required',
            //'p_description'  => 'required',
            'p_date_envoie'  => 'required',
            'p_date_retour'  => 'required',
            'p_commune_depart'  => 'required',
            'p_commune_arrive'  => 'required',
            //'p_vehicule'  => 'required',
            //'p_frais'  => 'required',
            'p_mnt_total'  => 'required',
            'p_utilisateur'  => 'required',
        ];

        $erreurs = [
            'p_details.required' => 'Veuillez saisir les détails de la location',
            'p_nom.required' => 'Veuillez saisir le nom du client',
            'p_prenoms.required' => 'Veuillez saisir le prenoms du client',
            'p_telephone.required' => 'Veuillez saisir le numéro de téléphone du client',
            'p_telephone.size' => 'Le format du numéro de téléphone est incorrect',
            'p_date_envoie.required' => 'Veuillez saisir la date d\'envoie',
            'p_date_retour.required' => 'Veuillez saisir la date de retour',
            'p_commune_depart.required' => 'La commune de départ est inconnue',
            'p_commune_arrive.required' => 'La destination est inconnue',
            'p_mnt_total.required' => 'Le montant du total de la location est inconnu',
            'p_utilisateur.required' => 'L\'utilisateur est inconnue'
        ];

        $validator = Validator::make($inputs, $errors, $erreurs);

        if( $validator->fails()){
            return $validator->errors();
        }else{
            $date = date('ym');

            //Insertion des données du client
            try {
                //DB::beginTransaction();

                $insertion = client::create([
                    'r_nom' => $request->p_nom,
                    'r_prenoms' => $request->p_prenoms,
                    'r_telephone' => '225'.$request->p_telephone,
                    'r_email' => $request->p_email,
                    'r_description' => $request->p_description,
                    'r_utilisateur' => $request->p_utilisateur,
                ]);

                //Insertion des données de locations
                try {
                    $insertion_location = Location::create([
                        'r_client' => $insertion->r_i,
                        'r_num' => ($insertion->r_i < 9 )? $date.'0'.$insertion->r_i : $date.$insertion->r_i ,
                        'r_mnt_total' => $request->p_mnt_total,
                        'r_status' => 0,
                        'r_frais_transport' => $request->p_frais,
                        'r_destination' => $request->p_commune_arrive,
                        'r_remise' => $request->p_remise,
                        'r_mnt_total_remise' =>  $request->p_mnt_total_remise,
                        'r_logistik' => $request->p_vehicule,
                        'r_date_envoie' => $request->p_date_envoie,
                        'r_date_retour' => $request->p_date_retour,
                        'r_duree' => $request->p_duree,
                        'r_utilisateur' => $request->p_utilisateur
                    ]);

                    try {
                        //dd($request->p_details);

                        for ($i=0; $i < count($request->p_details); $i++) {

                            $insertion_details = Detailslocacation::create([
                                'r_quantite' => $request->p_details[$i]["qte"],
                                'r_produit' => $request->p_details[$i]["idproduit"],
                                'r_location' => $insertion_location->r_i,
                                'r_sous_total' => $request->p_details[$i]["total"],
                                'r_utilisateur' => $request->p_utilisateur
                                //'r_prix_unitaire' => 1000
                            ]);
                         }

                          $res = $this->majstockProduit($request);

                          

                         $response = [
                            '_status' => 1,
                            '_result' => 'Enregistrement effectuée avec succès'
                        ];
                        return response()->json($response, 200);

                         //return response()->json($response, 200);

                    } catch (\Throwable $e) {

                        return $e->getMessage();
                    }



                } catch (\Throwable $e) {

                    return $e->getMessage();
                }

                //DB::commit();
            } catch (\Throwable $e) {
                //DB::rollBack();
                return $e->getMessage();
            }
        }
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
    public function update(Request $request, cr $cr)
    {
        //
    }


    public function updateStat(Request $request){

        $location = Location::find($request->p_idlocation);

        if( !empty($location) ){
            try{

                $location->update([
                    'r_status' => $request->p_status
                ]);

                switch ($location->r_status) {
                    case 0:
                       $p = 'Location en attente de validation';
                        break;

                    case 1:
                        $p = 'Location valider avec succès';
                        break;

                    case 2:
                        $t = $this->majstockProduit($request);
                        $p = 'Location terminée';
                        break;

                    default:
                        $p = 'Demande de location annulée';
                        break;
                }

                //$res = $this->majstockProduit($request);
                //return $res;

                $response = [
                    '_status' =>1,
                    '_result' => $p
                ];

            } catch(\Throwable $e){
                return $e->getMessage();
            }

        }else{
            $response = [
                '_status' =>1,
                '_result' => 'Valeur non retrouvée'
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

    public function majstockProduit(Request $request){

        $tabs = $request->p_details;
        $signe = $request->p_signe;

        try{

            foreach( $tabs as $val ){

                $produit = Produits::find($val['idproduit']);

                $tt = intval($produit['r_stock']) . $signe . intval($val['qte']); // Former une équation de chaîne

                $p = eval('return '.$tt.';'); // Évaluation de l'équation

                $produit->update([
                   'r_stock' => $p
                ]);

            }
            return true;
            // $response = [
            //     '_status' =>1,
            //     '_result' => 'Enregistrement effectué avec succès'
            // ];

            // return response()->json($response, 200);

        }catch(\Throwable $e){
            return $e->getMessage();
        }




    }

    public function add_payment_partiel(Request $request){

        $insert = Paiementechellonner::create([
            'r_location' => $request->p_location,
            'r_mnt' => $request->p_mnt,
            'r_utilisateur' => $request->p_utilisateur,
            'r_description' => $request->p_description,
        ]);

        return $insert;
    }
}
