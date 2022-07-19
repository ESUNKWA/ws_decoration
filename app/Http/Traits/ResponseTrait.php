<?php
namespace App\Http\Traits;
/**
 * Renvoie le retour d'une requête http
 */
trait ResponseTrait
{
    /**
     * $message
     * $dataRequest
     */
    public function responseSuccess(String $message, $dataRequest){
        $response = [
            '_status' => 1,
            '_message' => $message,
            '_result' => $dataRequest
        ];
        return response()->json($response)  ;
    }

    public function responseCatchError(String $message){
        $response = [
            '_status' => 1,
            '_error' => $message
        ];
        return response()->json($response)  ;
    }
} 