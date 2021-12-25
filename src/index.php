<?php

require_once '../vendor/autoload.php';

use LojaVirtual\Gateway;

$token = "sk_test_qv8VREmI80tW8BL9";

$data = json_decode(file_get_contents('credit_card.json'), true);


$creditCard = new LojaVirtual\Gateway\PagarMe\CreditCard($token, $data);

$PagarMe = new LojaVirtual\Gateway\PagarMe($creditCard);
$res1 = $PagarMe->pay();

//$PagarMe->setPaymentType($boleto);
//$res2 = $PagarMe->pay();

echo json_encode(array("credit_card"=>json_decode($res1)));
?>