<?php

    require 'conexion.php';

    // if (isset($_POST['guardar'])) {
    //     // Recuperar datos del formulario
    //     $nombres = $_POST['nombres'];
    //     $apellidos = $_POST['apellidos'];
    //     $usuario = $_POST['usuario'];
    //     $contraseña = $_POST['contraseña'];
    //     $alumno_id = $_POST['estudiante'];

    //     try {
    //         // Iniciar la transacción
    //         $conn->beginTransaction();

    //         // Insertar en la tabla login
    //         $stmtLogin = $conn->prepare("INSERT INTO login (usuario_login, password_login, rol_login) VALUES (:usuario, :clave, 'Padre')");
    //         $stmtLogin->bindParam(':usuario', $usuario);
    //         //password_hash devuelve 60 caracteres, y tú lo tenías en 45 la base de datos
    //         //lo cambié
    //         $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar la contraseña

    //         $stmtLogin->bindParam(':clave', $contraseña);

    //         /**
    //         * este no sirve porque password_hash devuelve un resultado
    //         *  y bindParam necesita una variable, por eso la de arriba funciona
    //         */

    //         //$stmtLogin->bindParam(':contraseña', password_hash($contraseña, PASSWORD_DEFAULT)); // Encriptar la contraseña
        
    //         $stmtLogin->execute();

    //         $login_id = $conn->lastInsertId(); // Obtener el ID del registro en la tabla login

    //         // Insertar en la tabla alumnos
    //         $stmtPadres = $conn->prepare("INSERT INTO padres (nombres_padres, apellidos_padres, login_padres) VALUES (:nomnbres, :apellidos, :login_id)");
    //         $stmtPadres->bindParam(':nombres', $nombres);
    //         $stmtPadres->bindParam(':apellidos', $apellidos);
    //         $stmtPadres->bindParam(':login_id', $login_id);
    //         $stmtPadres->execute();

    //         $padre_id = $conn->lastInsertId();

    //         $stmtAlumnos = $conn->prepare("UPDATE alumnos SET padres_alumnos= ':idpadre' Where id_alumnos="); //terminar -> obtener el id del alummno

    //         // Confirmar la transacción
    //         $conn->commit();

    //         // Redirigir con mensaje de éxito
    //         header("Location: registro_estudiantes.php?info=success");
    //         exit();

    //     } catch (Exception $e) {
    //         // Revertir la transacción
    //         $conn->rollBack();

    //         var_dump($e->getMessage());exit();
    //         // Mostrar el mensaje de error
    //         echo "Error: " . $e->getMessage();
    //         // Redirigir con mensaje de error
    //         header("Location: registro_estudiantes.php?err=error");
    //         exit();
    //     }
    // }

    if (isset($_POST['guardar'])) {
        // Recuperar datos del formulario
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $alumno_id = $_POST['estudiante'];

        try {
            // Iniciar la transacción
            $conn->beginTransaction();

            // Insertar en la tabla login
            $stmtLogin = $conn->prepare("INSERT INTO login (usuario_login, password_login, rol_login) VALUES (:usuario, :clave, 'Padre')");
            $stmtLogin->bindParam(':usuario', $usuario);
            $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar la contraseña
            $stmtLogin->bindParam(':clave', $contraseña);
            $stmtLogin->execute();
            
            $login_id = $conn->lastInsertId(); // Obtener el ID del registro en la tabla login

            // Insertar en la tabla padres
            $stmtPadres = $conn->prepare("INSERT INTO padres (nombres_padres, apellidos_padres, login_padres) VALUES (:nombres, :apellidos, :login_id)");
            $stmtPadres->bindParam(':nombres', $nombres);
            $stmtPadres->bindParam(':apellidos', $apellidos);
            $stmtPadres->bindParam(':login_id', $login_id);
            $stmtPadres->execute();

            $padre_id = $conn->lastInsertId(); // Obtener el ID del padre

            // Actualizar el registro del estudiante para asignarle el ID del padre
            $stmtAlumnos = $conn->prepare("UPDATE alumnos SET padres_alumnos = :idpadre WHERE id_alumnos = :id_alumno");
            $stmtAlumnos->bindParam(':idpadre', $padre_id);
            $stmtAlumnos->bindParam(':id_alumno', $alumno_id);
            $stmtAlumnos->execute();

            // Confirmar la transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: registro_estudiantes.php?info=success");
            exit();

        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
            // Redirigir con mensaje de error
            header("Location: registro_estudiantes.php?err=error");
            exit();
        }
    }


?>