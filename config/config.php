<?php

    define("CLIENT_ID", "ARAKrdtlv7RaXHQYRdtASNfO971zpdxdwznH0Q6X9w25EIO2xAIrmYqu5cft0LnV-PrMedtIC4iJ8sUm");    
    define("CURRENCY", "USD");
    define("KEY_TOKEN", "APR.wqc-354*");
    define("KEY_TOKEN2", "APR.wqc-356*");
    define("MONEDA", "$");

    //Config del sistema
    define("SITE_URL", "http://localhost/Pagina2");

    session_start();

    // Numero del carrito
    $num_cart = 0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart = count($_SESSION['carrito']['productos']);
    }

?>