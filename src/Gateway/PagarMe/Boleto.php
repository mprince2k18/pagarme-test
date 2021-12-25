<?php

namespace LojaVirtual\Gateway\PagarMe;
use LojaVirtual\Resources\HandleError;
use LojaVirtual\Resources\Messages;
use LojaVirtual\Gateway\PagarMe;

class Boleto implements PagarMeInterface
{
    private $json = NULL;
    private $token = NULL;

    private $Data_Model = array(
        "items" => array ("code"      => NULL,
                        "amount"      => NULL,          
                        "description" => NULL,
                        "quantity"    => NULL,
        ),
        "customer" => array (
            "name"     => NULL,
            "email"    => NULL,
            "document" => NULL,
            "type"     => NULL,
            "address"  => array (
                "address"  => NULL,
                "zip_code" => NULL,
                "city"     => NULL,
                "state"    => NULL,
                "country"  => NULL,
            ),
            "phones" => array ("mobile_phone" => array (
                "country_code" => NULL,
                "area_code"    => NULL,
                "number"       => NULL,
            ))
            ),
        "payments" => array (
            "payment_method" => "boleto",
            "boleto" => array (
                "instructions"    => NULL,
				"due_at"          => NULL,
				"document_number" => NULL,
				"type"            => NULL,                  
            )
        ),
    );

    public function __construct($token = NULL, $json = NULL) 
    {
        $this->token = $token;
        $this->json = $json;
        
        if ($token === NULL)
            throw new HandleError("token is invalid, please check and try again");

        if ($json === NULL)
            throw new HandleError("json is invalid, please check and try again");

        $this->validate();

        $this->json["items"][0]["amount"] = "Deu Certo";
    }

    public function pay()
    {
        return json_encode($this->json);
    }

    private function validate()
    {
        $data = $this->json;
        $data_model = $this->Data_Model;

        // Verifica se o JSON enviado possui uma estrutura correta
        if (json_last_error() !== 0)
            throw new HandleError("json is invalid, please check and try again");

        // Verifica se o JSON enviado é igual ao JSON Modelo
        $diff = array_diff_key($data_model, $data);
        if (count($diff) > 0)
            throw new HandleError("fill in the fields correctly [" . json_encode($diff) . "]");

        return $data;
    }

}