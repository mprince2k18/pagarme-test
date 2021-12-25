<?php

namespace LojaVirtual\Gateway\PagarMe;
use LojaVirtual\Resources\HandleError;
use LojaVirtual\Resources\Messages;
use LojaVirtual\Resources\Curl;
use LojaVirtual\Gateway\PagarMe;

class CreditCard implements PagarMeInterface
{
    private $json = NULL;
    private $token = NULL;
    private $data = NULL;

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
            "payment_method" => "credit_card",
            "credit_card" => array (
                "recurrence" => NULL,
                "installments" => NULL,
                "statement_descriptor" => NULL,
                "card" => array (
                    "number"      => NULL,
                    "holder_name" => NULL,
                    "exp_month"   => NULL,
                    "exp_year"    => NULL,
                    "cvv"         => NULL,
                    "billing_address" => array (
                        "address"  => NULL,
                        "zip_code" => NULL,
                        "city"     => NULL,
                        "state"    => NULL,
                        "country"  => NULL,                
                    )
                )
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

        $this->json["items"][0]["amount"] = rand(10000, 100000);
    }

    public function pay()
    {
        // Validar retornos
        $response =  Curl::send($this->token, $this->data);
        $status = $response["status"]??NULL;
        return $response;
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

        $this->data = $data;
    }

}