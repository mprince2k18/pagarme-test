<?php

namespace LojaVirtual\Resources;

abstract class Curl
{

    const URL = 'https://api.pagar.me/core/v5/orders';
    static public function send($token, $data) {
        $ch = curl_init(self::URL); 
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode("$token:") // <--- Token aqui
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new HandleError(curl_errno($ch) . ' : ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }

}

?>