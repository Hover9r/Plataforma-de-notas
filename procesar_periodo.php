<?php
    require 'conexion.php';

    if (isset($_POST['guardar'])) {

        $periodo = $_POST['nombre_periodo'];


        $stmt_periodo = $conn->prepare("INSERT INTO periodos (nombre_periodo) VALUES (:nombre_periodo)");
        $stmt_periodo->bindParam(':nombre_periodo', $periodo);
        

        if ($stmt_periodo->execute()) {

            header("Location: registro_periodo.php?info=success");
            exit();
        } else {

            header("Location: registro_periodo.php?err=error");
            exit();
        }
    }
?>

