<?php
    // session_start();
    // session_destroy();

    // header('location:proyecto_final.php');

    session_start();
    session_destroy();
    setcookie("activo", "", time() - 3600);
    
    header('location:proyecto_final.php');

?>