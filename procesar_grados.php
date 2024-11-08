<?php

    require 'conexion.php';

    if (isset($_POST['guardar'])) {
        // Recuperar datos del formulario
        $nombre_grado = $_POST['nombre'];

        try {
            // Iniciar la transacción
            $conn->beginTransaction();

            // Insertar en la tabla grados
            $stmtGrados = $conn->prepare("INSERT INTO grados (nombre_grados) VALUES (:nombre)");
            $stmtGrados->bindParam(':nombre', $nombre_grado);
            $stmtGrados->execute();

            // Confirmar la transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: registro_grados.php?info=success");
            exit();

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollBack();

            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            // Redirigir con mensaje de error
            header("Location: registro_grados.php?err=error");
            exit();
        }
    }

?>