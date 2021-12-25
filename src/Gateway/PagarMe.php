<?php

namespace LojaVirtual\Gateway;
use LojaVirtual\Gateway\PagarMe\PagarMeInterface;

class PagarMe {

    private $payment_type;

    function __construct(PagarMeInterface $payment_type) {
        $this->payment_type = $payment_type;
    }

    function setPaymentType(PagarMeInterface $payment_type) {
        $this->payment_type = $payment_type;
    }

    function pay() {
        return $this->payment_type->pay();
    }
}

?>