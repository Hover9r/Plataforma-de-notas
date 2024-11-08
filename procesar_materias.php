<?php

    require 'conexion.php';

    if (isset($_POST['guardar'])) {
        // Recuperar datos del formulario
        $nombre_materia = $_POST['nombre'];
        $cant_materias = $_POST['cantidad'];
        $id_maestro = $_POST['maestro'];

        try {
            // Iniciar la transacción
            $conn->beginTransaction();

            // Verificar si el ID del maestro es válido
            $stmtMaestro = $conn->prepare("SELECT id_maestros FROM maestros WHERE id_maestros = :id_maestro");
            $stmtMaestro->bindParam(':id_maestro', $id_maestro);
            $stmtMaestro->execute();
            $maestro = $stmtMaestro->fetch();

            if (!$maestro) {
                // Si el ID del maestro no es válido, revertir la transacción y redirigir con un mensaje de error
                $conn->rollBack();
                header("Location: formulario_materias.php?err=maestro_invalido");
                exit();
            }

            // Insertar en la tabla materias
            $stmtMateria = $conn->prepare("INSERT INTO materias (nombre_materias, cant_notas_materias, maestros_materias) VALUES (:nombre, :cantidad, :maestro)");
            $stmtMateria->bindParam(':nombre', $nombre_materia);
            $stmtMateria->bindParam(':cantidad', $cant_materias);
            $stmtMateria->bindParam(':maestro', $id_maestro);
            $stmtMateria->execute();

            // Obtener el ID de la materia recién insertada
            $id_materia = $conn->lastInsertId();

            // Insertar en la tabla maestros_materias
            $stmtMaestrosMaterias = $conn->prepare("INSERT INTO maestros_materias (id_materias, id_maestros) VALUES (:id_materia, :id_maestro)");
            $stmtMaestrosMaterias->bindParam(':id_materia', $id_materia);
            $stmtMaestrosMaterias->bindParam(':id_maestro', $id_maestro);
            $stmtMaestrosMaterias->execute();

            // Confirmar la transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: registro_materias.php?info=success");
            exit();

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollBack();

            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            // Redirigir con mensaje de error
            header("Location: registro_materias.php?err=error");
            exit();
        }
    }


?>
