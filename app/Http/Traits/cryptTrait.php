<?php
namespace App\Http\Traits;
use Nullix\CryptoJsAes\CryptoJsAes;
/**
 * Cryptage et décryptage des données
 */
trait cryptTrait
{
    /**
     * cryptage des données
     */
    public function crypt($data): string{
        try {
            return CryptoJSAES::encrypt($data, "123456789");
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

    }

    /**
     * Décryptage des données
     */
    public function decrypt($data): string{
        return CryptoJSAES::decrypt($data,"123456789");
    }
}
