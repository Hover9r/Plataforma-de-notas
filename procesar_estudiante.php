<?php

    require 'conexion.php';

    if (isset($_POST['guardar'])) {
        // Recuperar datos del formulario
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $numlista = $_POST['numlista'];
        $genero = $_POST['genero'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $grado_id = $_POST['grado'];
        $subgrado_id = $_POST['subgrado'];

        try {
            // Iniciar la transacción
            $conn->beginTransaction();

            // Insertar en la tabla login
            $stmtLogin = $conn->prepare("INSERT INTO login (usuario_login, password_login, rol_login) VALUES (:usuario, :clave, 'Estudiante')");
            $stmtLogin->bindParam(':usuario', $usuario);
            //password_hash devuelve 60 caracteres, y tú lo tenías en 45 la base de datos
            //lo cambié
            $contraseña = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar la contraseña

            $stmtLogin->bindParam(':clave', $contraseña);

            /**
            * este no sirve porque password_hash devuelve un resultado
            *  y bindParam necesita una variable, por eso la de arriba funciona
            */

            //$stmtLogin->bindParam(':contraseña', password_hash($contraseña, PASSWORD_DEFAULT)); // Encriptar la contraseña
           
            $stmtLogin->execute();

            $login_id = $conn->lastInsertId(); // Obtener el ID del registro en la tabla login

            // Insertar en la tabla alumnos
            $stmtAlumno = $conn->prepare("INSERT INTO alumnos (lista_num_alumnos, nombres_alumnos, apellidos_alumnos, genero_alumnos, grados_alumnos, subgrados_alumnos, login_alumnos) VALUES (:numlista, :nombres, :apellidos, :genero, :grado_id, :subgrado_id, :login_id)");
            $stmtAlumno->bindParam(':numlista', $numlista);
            $stmtAlumno->bindParam(':nombres', $nombres);
            $stmtAlumno->bindParam(':apellidos', $apellidos);
            $stmtAlumno->bindParam(':genero', $genero);
            $stmtAlumno->bindParam(':grado_id', $grado_id);
            $stmtAlumno->bindParam(':subgrado_id', $subgrado_id);
            $stmtAlumno->bindParam(':login_id', $login_id);
            $stmtAlumno->execute();

            // Confirmar la transacción
            $conn->commit();

            // Redirigir con mensaje de éxito
            header("Location: registro_estudiantes.php?info=success");
            exit();

        } catch (Exception $e) {
            // Revertir la transacción
            $conn->rollBack();

            var_dump($e->getMessage());exit();
            // Mostrar el mensaje de error
            echo "Error: " . $e->getMessage();
            // Redirigir con mensaje de error
            header("Location: registro_estudiantes.php?err=error");
            exit();
        }
    }




    // require 'conexion.php';

    // if (isset($_POST['guardar'])) {

    //     try {
    //         $conn->beginTransaction();

    //         $stmtLogin = $conn->prepare("INSERT INTO login (usuario_login, password_login, rol_login) VALUES ('testuser', 'testpassword', 'Estudiante')");
    //         $stmtLogin->execute();
    //         $login_id = $conn->lastInsertId();

    //         $stmtAlumno = $conn->prepare("INSERT INTO alumnos (lista_num_alumnos, nombres_alumnos, apellidos_alumnos, genero_alumnos, grados_alumnos, subgrados_alumnos, login_alumnos) VALUES (1, 'Test Nombre', 'Test Apellido', 'M', 1, 1, $login_id)");
    //         $stmtAlumno->execute();

    //         $conn->commit();

    //         echo "Éxito";
    //     } catch (Exception $e) {
    //         $conn->rollBack();
    //         echo "Error: " . $e->getMessage();
    //     }
    // }


?>
