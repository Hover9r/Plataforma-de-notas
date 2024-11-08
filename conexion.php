<?php

    //conexion a la base de datos

    try{
    $conn = new PDO('mysql:host=localhost; dbname=prueba; charset=utf8mb4', 'root', 'Hola:123');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
    echo "Error: ". $e->getMessage();
    die();
    }


    // try {
    //     // Configuración de la conexión y la codificación a UTF-8
    //     $conn = new PDO('mysql:host=localhost;dbname=prueba;charset=utf8', 'root', 'Hola:123', [
    //         PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    //     ]);
        
    //     // Establece el modo de error de PDO a excepción
    //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    // } catch(PDOException $e) {
    //     echo "Error: " . $e->getMessage();
    //     die();
    // }
    

?>