<?php
    // require 'conexion.php';

    // if (isset($_POST['modificar'])) {
    //     $id = $_POST['id'];
    //     $nombres = $_POST['nombres'];
    //     $apellidos = $_POST['apellidos'];
    //     $numlista = $_POST['numlista'];
    //     $genero = $_POST['genero'];
    //     $grado_id = $_POST['grado'];
    //     $subgrado_id = $_POST['subgrado'];
    //     $usuario = $_POST['usuario'];
    //     $contraseña = $_POST['contraseña'];

    //     try {
    //         $conn->beginTransaction();

    //         // Actualizar la tabla alumnos
    //         $stmtAlumno = $conn->prepare("
    //             UPDATE alumnos
    //             SET lista_num_alumnos = :numlista, nombres_alumnos = :nombres, apellidos_alumnos = :apellidos, genero_alumnos = :genero, grados_alumnos = :grado, subgrados_alumnos = :subgrado
    //             WHERE id_alumnos = :id
    //         ");
    //         $stmtAlumno->bindParam(':numlista', $numlista);
    //         $stmtAlumno->bindParam(':nombres', $nombres);
    //         $stmtAlumno->bindParam(':apellidos', $apellidos);
    //         $stmtAlumno->bindParam(':genero', $genero);
    //         $stmtAlumno->bindParam(':grado', $grado_id);
    //         $stmtAlumno->bindParam(':subgrado', $subgrado_id);
    //         $stmtAlumno->bindParam(':id', $id);

    //         if (!$stmtAlumno->execute()) {
    //             throw new Exception("Error al actualizar la tabla alumnos: " . implode(" ", $stmtAlumno->errorInfo()));
    //         }

    //         // Obtener el usuario actual para la tabla login
    //         $stmtGetUser = $conn->prepare("
    //             SELECT usuario_login FROM login
    //             WHERE id_login = (SELECT login_alumnos FROM alumnos WHERE id_alumnos = :id)
    //         ");
    //         $stmtGetUser->bindParam(':id', $id);
    //         $stmtGetUser->execute();
    //         $currentUser = $stmtGetUser->fetchColumn();

    //         // Actualizar la tabla login
    //         $stmtLogin = $conn->prepare("
    //             UPDATE login
    //             SET usuario_login = :usuario, password_login = :password
    //             WHERE id_login = (SELECT login_alumnos FROM alumnos WHERE id_alumnos = :id)
    //         ");
    //         $stmtLogin->bindParam(':usuario', $usuario);

    //         if (!empty($contraseña)) {
    //             $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
    //             $stmtLogin->bindParam(':password', $contraseña);
    //         } else {
    //             // Obtener la contraseña actual si no se proporciona una nueva
    //             $stmtGetPassword = $conn->prepare("SELECT password_login FROM login WHERE id_login = (SELECT login_alumnos FROM alumnos WHERE id_alumnos = :id)");
    //             $stmtGetPassword->bindParam(':id', $id);
    //             $stmtGetPassword->execute();
    //             $currentPassword = $stmtGetPassword->fetchColumn();
    //             $stmtLogin->bindValue(':password', $currentPassword);
    //         }

    //         if (!$stmtLogin->execute()) {
    //             throw new Exception("Error al actualizar la tabla login: " . implode(" ", $stmtLogin->errorInfo()));
    //         }

    //         $conn->commit();
    //         header('Location: listado_alumno.php?info=actualizado');
    //         exit();
    //     } catch (Exception $e) {
    //         $conn->rollBack();
    //         echo 'Error al actualizar: ' . $e->getMessage();
    //     }
    // }

    require 'conexion.php';
    
    // if (isset($_POST['modificar'])) {
    //     $id = $_POST['id'];
    //     $nombres = $_POST['nombres'];
    //     $apellidos = $_POST['apellidos'];
    //     $numlista = $_POST['numlista'];
    //     $genero = $_POST['genero'];
    //     $grado_id = $_POST['grado'];
    //     $subgrado_id = $_POST['subgrado'];
    //     $usuario = $_POST['usuario'];
    //     $contraseña = $_POST['contraseña'];

    
    //     try {
    //         $conn->beginTransaction();
    
    //         // Actualizar la tabla alumnos
    //         $stmtAlumno = $conn->prepare("
    //             UPDATE alumnos
    //             SET lista_num_alumnos = :numlista, nombres_alumnos = :nombres, apellidos_alumnos = :apellidos, genero_alumnos = :genero, grados_alumnos = :grado, subgrados_alumnos = :subgrado
    //             WHERE id_alumnos = :id
    //         ");
    //         $stmtAlumno->bindParam(':numlista', $numlista);
    //         $stmtAlumno->bindParam(':nombres', $nombres);
    //         $stmtAlumno->bindParam(':apellidos', $apellidos);
    //         $stmtAlumno->bindParam(':genero', $genero);
    //         $stmtAlumno->bindParam(':grado', $grado_id);
    //         $stmtAlumno->bindParam(':subgrado', $subgrado_id);
    //         $stmtAlumno->bindParam(':id', $id);
    
    //         if (!$stmtAlumno->execute()) {
    //             throw new Exception("Error al actualizar la tabla alumnos: " . implode(" ", $stmtAlumno->errorInfo()));
    //         }
    
    //         // Obtener el ID de login asociado al alumno
    //         $stmtGetLoginId = $conn->prepare("SELECT login_alumnos FROM alumnos WHERE id_alumnos = :id");
    //         $stmtGetLoginId->bindParam(':id', $id);
    //         $stmtGetLoginId->execute();
    //         $loginId = $stmtGetLoginId->fetchColumn();
    
    //         if (!$loginId) {
    //             throw new Exception("ID de login no encontrado para el alumno.");
    //         }
    
    //         // Actualizar la tabla login
    //         $sqlLogin = "UPDATE login SET usuario_login = :usuario";
    //         if (!empty($contraseña)) {
    //             $sqlLogin .= ", password_login = :password";
    //         }
    //         $sqlLogin .= " WHERE id_login = :id";
    
    //         $stmtLogin = $conn->prepare($sqlLogin);
    //         $stmtLogin->bindParam(':usuario', $usuario);
    
    //         if (!empty($contraseña)) {
    //             $contraseña = password_hash($contraseña, PASSWORD_DEFAULT);
    //             $stmtLogin->bindParam(':password', $contraseña);
    //         }
    
    //         $stmtLogin->bindParam(':id', $loginId);
    
    //         if (!$stmtLogin->execute()) {
    //             throw new Exception("Error al actualizar la tabla login: " . implode(" ", $stmtLogin->errorInfo()));
    //         }
    
    //         $conn->commit();
    //         header('Location: listado_alumno.php?info=success');
    //         exit();
    //     } catch (Exception $e) {
    //         $conn->rollBack();
    //         echo 'Error al actualizar: ' . $e->getMessage();
    //     }
    // }

    if (isset($_POST['modificar'])) {
        $id = $_POST['id'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $numlista = $_POST['numlista'];
        $genero = $_POST['genero'];
        $grado_id = $_POST['grado'];
        $subgrado_id = $_POST['subgrado'];
        $usuario = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $padre_id = $_POST['padre']; // Nuevo: ID del padre
        
        try {
            $conn->beginTransaction();
    
            // Actualizar la tabla alumnos, incluyendo el campo padres_alumnos
            $stmtAlumno = $conn->prepare("
                UPDATE alumnos
                SET 
                    lista_num_alumnos = :numlista,
                    nombres_alumnos = :nombres,
                    apellidos_alumnos = :apellidos,
                    genero_alumnos = :genero,
                    grados_alumnos = :grado,
                    subgrados_alumnos = :subgrado,
                    padres_alumnos = :padre_id
                WHERE 
                    id_alumnos = :id
            ");
            $stmtAlumno->bindParam(':numlista', $numlista);
            $stmtAlumno->bindParam(':nombres', $nombres);
            $stmtAlumno->bindParam(':apellidos', $apellidos);
            $stmtAlumno->bindParam(':genero', $genero);
            $stmtAlumno->bindParam(':grado', $grado_id);
            $stmtAlumno->bindParam(':subgrado', $subgrado_id);
            $stmtAlumno->bindParam(':padre_id', $padre_id);
            $stmtAlumno->bindParam(':id', $id);
    
            if (!$stmtAlumno->execute()) {
                throw new Exception("Error al actualizar la tabla alumnos: " . implode(" ", $stmtAlumno->errorInfo()));
            }
    
            // Obtener el ID de login asociado al alumno
            $stmtGetLoginId = $conn->prepare("SELECT login_alumnos FROM alumnos WHERE id_alumnos = :id");
            $stmtGetLoginId->bindParam(':id', $id);
            $stmtGetLoginId->execute();
            $loginId = $stmtGetLoginId->fetchColumn();
    
            if (!$loginId) {
                throw new Exception("ID de login no encontrado para el alumno.");
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
    
            $conn->commit();
            header('Location: listado_alumno.php?info=success');
            exit();
        } catch (Exception $e) {
            $conn->rollBack();
            echo 'Error al actualizar: ' . $e->getMessage();
        }
    }
    
    
?>




