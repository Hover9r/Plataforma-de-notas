<?php

    require 'conexion.php';
    
    if (isset($_POST['guardar'])) {
        // Recuperar datos del formulario
        $nombre_subgrado = $_POST['subgrado'];
        $grado_id = $_POST['grado_id']; // Obtener el ID del grado seleccionado
    
        try {
            // Iniciar la transacción
            $conn->beginTransaction();
    
            // Insertar en la tabla subgrados con el id del grado asociado
            $stmtSubgrados = $conn->prepare("INSERT INTO subgrados (nombre_subgrados, grado_id) VALUES (:subgrado, :grado_id)");
            $stmtSubgrados->bindParam(':subgrado', $nombre_subgrado);
            $stmtSubgrados->bindParam(':grado_id', $grado_id);
            $stmtSubgrados->execute();
    
            // Confirmar la transacción
            $conn->commit();
    
            // Redirigir con mensaje de éxito
            header("Location: registro_subgrados.php?info=success");
            exit();
    
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollBack();
    
            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            // Redirigir con mensaje de error
            header("Location: registro_subgrados.php?err=error");
            exit();
        }
    }
    

?>