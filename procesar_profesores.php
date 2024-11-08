<?php

    require 'conexion.php';

    if (isset($_POST['guardar'])) {

        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $genero = $_POST['genero'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $cedula = $_POST['cedula'];

        if (strlen($cedula) > 10) {
            // Redirigir con un mensaje de error si la cédula tiene más de 10 dígitos
            header("Location: registro_admin.php?cedula=success");
            exit();
        }

        try {
            // Iniciar la transacción
            $conn->beginTransaction();

            // Insertar en la tabla login
            $stmtLogin = $conn->prepare("INSERT INTO login (usuario_login, password_login, rol_login) VALUES (:usuario, :clave, 'Profesor')");
            $stmtLogin->bindParam(':usuario', $usuario);

            //password_hash devuelve 60 caracteres, y tú lo tenías en 45 la base de datos
            $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar la contraseña

            $stmtLogin->bindParam(':clave', $contraseña);
           
            $stmtLogin->execute();

            $login_id = $conn->lastInsertId(); // Obtener el ID del registro en la tabla login

            // Insertar en la tabla maestros
            $stmtMaestro = $conn->prepare("INSERT INTO maestros (nombres_maestros, apellidos_maestros, cedula_maestros, genero_maestros, login_maestros) VALUES (:nombres, :apellidos, :cedula, :genero, :login_id)");
            $stmtMaestro->bindParam(':nombres', $nombres);
            $stmtMaestro->bindParam(':apellidos', $apellidos);
            $stmtMaestro->bindParam(':genero', $genero);
            $stmtMaestro->bindParam(':cedula', $cedula);
            $stmtMaestro->bindParam(':login_id', $login_id);
            $stmtMaestro->execute();
    

            // Confirmar la transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: registro_profesores.php?info=success");
            exit();

        } catch (Exception $e) {
            // Revertir la transacción
            $conn->rollBack();

            var_dump($e->getMessage());exit();
            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            // Redirigir con mensaje de error
            header("Location: registro_profesores.php?err=error");
            exit();
        }


    }


?>