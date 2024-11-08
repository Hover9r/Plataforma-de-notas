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

            // Actualizar la tabla administradores
            $stmtAdmin = $conn->prepare("
                UPDATE administradores
                SET 
                    nombres_admin = :nombres,
                    apellidos_admin = :apellidos,
                    cedula_admin = :cedula,
                    genero_admin = :genero
                WHERE 
                    id_admin = :id
            ");
            $stmtAdmin->bindParam(':nombres', $nombres);
            $stmtAdmin->bindParam(':apellidos', $apellidos);
            $stmtAdmin->bindParam(':cedula', $cedula);
            $stmtAdmin->bindParam(':genero', $genero);
            $stmtAdmin->bindParam(':id', $id);

            if (!$stmtAdmin->execute()) {
                throw new Exception("Error al actualizar la tabla administradores: " . implode(" ", $stmtAdmin->errorInfo()));
            }

            // Obtener el ID de login asociado al administrador
            $stmtGetLoginId = $conn->prepare("SELECT login_admin FROM administradores WHERE id_admin = :id");
            $stmtGetLoginId->bindParam(':id', $id);
            $stmtGetLoginId->execute();
            $loginId = $stmtGetLoginId->fetchColumn();

            if (!$loginId) {
                throw new Exception("ID de login no encontrado para el administrador.");
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
            header('Location: listado_admin.php?info=success');
            exit();
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $conn->rollBack();
            echo 'Error al actualizar: ' . $e->getMessage();
        }
    }

?>
