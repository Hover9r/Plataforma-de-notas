<?php

    require 'conexion.php';

    if (isset($_POST['modificar'])) {
        $id = $_POST['id'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $cedula = $_POST['cedula'];
        $genero = $_POST['genero'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];

        try {
            // Iniciar transacción
            $conn->beginTransaction();

            // Actualizar la tabla maestros
            $stmtMaestro = $conn->prepare("
                UPDATE maestros
                SET 
                    nombres_maestros = :nombres,
                    apellidos_maestros = :apellidos,
                    cedula_maestros = :cedula,
                    genero_maestros = :genero
                WHERE 
                    id_maestros = :id
            ");
            $stmtMaestro->bindParam(':nombres', $nombres);
            $stmtMaestro->bindParam(':apellidos', $apellidos);
            $stmtMaestro->bindParam(':cedula', $cedula);
            $stmtMaestro->bindParam(':genero', $genero);
            $stmtMaestro->bindParam(':id', $id);

            if (!$stmtMaestro->execute()) {
                throw new Exception("Error al actualizar la tabla maestros: " . implode(" ", $stmtMaestro->errorInfo()));
            }

            // Obtener el ID de login asociado al profesor
            $stmtGetLoginId = $conn->prepare("SELECT login_maestros FROM maestros WHERE id_maestros = :id");
            $stmtGetLoginId->bindParam(':id', $id);
            $stmtGetLoginId->execute();
            $loginId = $stmtGetLoginId->fetchColumn();

            if (!$loginId) {
                throw new Exception("ID de login no encontrado para el profesor.");
            }

            // Actualizar la tabla login
            $sqlLogin = "UPDATE login SET usuario_login = :usuario";
            if (!empty($contraseña)) {
                $sqlLogin .= ", password_login = :password";
            }
            $sqlLogin .= " WHERE id_login = :id";

            $stmtLogin = $conn->prepare($sqlLogin);
            $stmtLogin->bindParam(':usuario', $usuario);

            if (!empty($contraseña)) {
                $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
                $stmtLogin->bindParam(':password', $contraseña);
            }

            $stmtLogin->bindParam(':id', $loginId);

            if (!$stmtLogin->execute()) {
                throw new Exception("Error al actualizar la tabla login: " . implode(" ", $stmtLogin->errorInfo()));
            }

            // Confirmar transacción
            $conn->commit();

            // Redireccionar con mensaje de éxito
            header('Location: listado_profesores.php?info=success');
            exit();
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $conn->rollBack();
            echo 'Error al actualizar: ' . $e->getMessage();
        }
    }


?>