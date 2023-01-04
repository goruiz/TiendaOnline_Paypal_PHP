<?php
    define ("CLIENT_ID","Aquí va el ID del usuario");
    define ("CURRENCY","USD");
    define ("KEY_TOKEN","aquí va el KEY_TOKEN del usuario");
    define ("MONEDA","$");
    session_start();
    $num_cart=0;
    if(isset($_SESSION['carrito']['productos'])){
        $num_cart=count($_SESSION['carrito']['productos']);
    }

?>