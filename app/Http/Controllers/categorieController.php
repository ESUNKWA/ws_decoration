<?php

namespace App\Http\Controllers;

use App\Models\rc;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class categorieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liste_categories = Categories::OrderBy('r_libelle', 'ASC')->get();

        $response = [
            '_status' => 1,
            '_result' => $liste_categories,
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
        $inputs = $request->all();

        // Validation des champs
        $errors = [
            'r_libelle'  => 'required|unique:t_categories',
            'p_utilisateur' => 'required'
        ];
        $erreurs = [
            'r_libelle.required' =>'Le libellé est obligatoire',
            'r_libelle.unique' =>'Catégories déjà existant',
            'p_utilisateur.required'  => 'Veuillez préciser l\'utilisateur'
        ];

        $validate = Validator::make($inputs, $errors, $erreurs);

        if( $validate->fails()){
            return $validate->errors();
        }else{
            $insertion = Categories::create([
                'r_libelle' => $request->r_libelle,
                'p_description' => $request->p_description,
                'r_utilisateur' => $request->p_utilisateur,
                'r_status' => 1,
            ]);

            $response = [
                '_status' => 1,
                '_result' => 'La catégorie [ '.$insertion->r_libelle.' ] à bien été enregistrée'
            ];
            return response()->json($response, 200);
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
