<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class dashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dash = DB::select("SELECT SUM(loc.r_mnt_total_remise) as r_mnt_total_mois, 
        (SELECT COUNT(loc.r_i) from t_locations loc WHERE MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois,
        (SELECT COALESCE(SUM(ach.r_prix_achat),0) from t_achats_produits ach WHERE MONTH(ach.created_at) = MONTH(NOW())) as total_achat_mois,
        (SELECT COALESCE(SUM(loc.r_mnt_total_remise),0) from t_locations loc WHERE DATE(loc.created_at) = DATE(NOW())) as total_location_jours,
        (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 1 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_val,
        (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 3 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_rej,
        (SELECT COUNT(loc.r_i) from t_locations loc WHERE loc.r_status = 0 AND MONTH(loc.created_at) = MONTH(NOW())) as total_location_mois_att,
        /*(SELECT JSON_ARRAYAGG(JSON_OBJECT('produit', r_libelle, 'stock', r_stock)) from t_produits) as produits,*/
        (SELECT COUNT(r_i) FROM t_locations WHERE t_locations.r_status = 0 AND DATE(t_locations.r_date_envoie) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY))) as nbreLivraisonDemain,
        (SELECT COUNT(r_i) FROM t_locations WHERE t_locations.r_status = 0 AND DATE(t_locations.r_date_envoie) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 0 DAY))) as nbreLivraisonJour,
        (SELECT COUNT(r_i) FROM t_locations WHERE t_locations.r_status = 0 AND DATE(t_locations.r_date_retour) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY))) as nbreRetourDemain,
        (SELECT COUNT(r_i) FROM t_locations WHERE t_locations.r_status = 0 AND DATE(t_locations.r_date_retour) = DATE(DATE_ADD(CURRENT_DATE, INTERVAL 0 DAY))) as nbreRetourJour
        FROM t_locations loc WHERE loc.r_status NOT IN(0,3) AND MONTH(loc.created_at) = MONTH(NOW()) ");

    //$LocationStatus = DB::select("SELECT COUNT(r_i), SUM(r_mnt_total_remise) FROM `t_locations` GROUP BY r_status");
    $LocationStatus = DB::select("SELECT COUNT(loc.r_i) as nbre, SUM(r_mnt_total_remise) as total from t_locations loc WHERE MONTH(loc.created_at) = MONTH(NOW()) GROUP BY r_status");
    
    $produitStat = DB::select("SELECT prd.r_libelle as produit, SUM(det.r_sous_total) as total FROM t_produits prd
    INNER JOIN t_details_locations det ON prd.r_i = det.r_produit
    INNER JOIN t_locations loc ON loc.r_i = det.r_location
    WHERE loc.r_status NOT IN(0,3)
    GROUP BY prd.r_libelle ORDER BY total DESC");

        return array_merge([$dash, $LocationStatus, $produitStat]);;
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
        //
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
