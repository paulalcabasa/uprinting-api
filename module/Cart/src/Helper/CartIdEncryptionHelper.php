<?php

namespace Cart\Helper;

use Zend\Http\Request;

class CartIdEncryptionHelper
{
    
    private $encryptMethod;
    private $secret_key;
    private $secretIv;

    public function __construct()
    {
        $this->encryptMethod = "AES-256-CBC";
        $this->secretKey = "AA74CDCC2BBRT935136HH7B63C27";
        $this->secretIv = "5fgf5HJ5g27";
    }

    public function encrypt($cartId)
    {
        $key = hash('sha256', $this->secretKey);
        $iv = substr(hash('sha256', $this->secretIv), 0, 16); // sha256 is hash_hmac_algo
        $output = openssl_encrypt($cartId, $this->encryptMethod, $key, 0, $iv);
        $output = base64_encode($output);
        
        return $output;
    }


    public function decrypt($encryptedId)
    {
        $key = hash('sha256', $this->secretKey);
        $iv = substr(hash('sha256', $this->secretIv), 0, 16); // sha256 is hash_hmac_algo   
        $output = openssl_decrypt(base64_decode($encryptedId), $this->encryptMethod, $key, 0, $iv);
       
        return $output;
    }
}
