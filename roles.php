<?php

    //inicio de sesion
    session_start();
    //validar si el usuario ha iniciado sesion antes
    if (isset($_COOKIE["activo"]) && isset($_SESSION['username'])) {
        setcookie("activo", 1, time() + 3600);

    } else {
        http_response_code(403);
        header('location:proyecto_final.php?err=2');
        exit(); // después de una redirección
    }
    
    
    // // Validar si el usuario ha iniciado sesión antes
    // if (isset($_COOKIE["activo"]) && isset($_SESSION['username'])) {
    //     setcookie("activo", 1, time() + 3600);
    
    //     // Conectar a la base de datos
    //     require 'conexion.php';
    
    //     // Obtener el nombre de usuario de la sesión
    //     $username = $_SESSION['username'];
    
    //     // Consulta para obtener el idlogin de la tabla login
    //     $stmt = $conn->prepare("SELECT id_login FROM login WHERE usuario_login = :username");
    //     $stmt->bindParam(':username', $username);
    //     $stmt->execute();
    //     $idlogin = $stmt->fetchColumn();
    
    //     // Verificar si se encontró el idlogin
    //     if (!$idlogin) {
    //         die('Usuario no encontrado');
    //     }
    
    //     // Ahora, usando el idlogin, obtener el id_alumnos de la tabla alumnos
    //     $stmt_alumno = $conn->prepare("SELECT id_alumnos FROM alumnos WHERE login_alumnos = :idlogin");
    //     $stmt_alumno->bindParam(':idlogin', $idlogin);
    //     $stmt_alumno->execute();
    //     $id_alumno = $stmt_alumno->fetchColumn();
    
    //     // Verificar si se encontró el id_alumno
    //     if (!$id_alumno) {
    //         die('Alumno no encontrado');
    //     }
    
    //     // Almacenar el id_alumno en la sesión para uso posterior
    //     $_SESSION['id_alumno'] = $id_alumno;
    
    // } else {
    //     http_response_code(403);
    //     header('location:proyecto_final.php?err=2');
    //     exit(); // Después de una redirección
    // }
    


    // conexion a la base de datos
    require 'conexion.php';

    //para verificar que tiene acceso a un archivo
    function permisos($permisos){
        if (!in_array($_SESSION['rol'], $permisos)) {
            http_response_code(403);
            header('location:paneles.php?err=1');
            exit(); // no redirrecionarlo mucho
        }
    }


    // function existeNota($id_alumno, $id_materia, $id_periodo, $conn) {
    //     $stmt = $conn->prepare("SELECT COUNT(*) FROM notas WHERE alumnos_notas = ? AND materias_notas = ? AND id_periodo = ?");
    //     $stmt->execute([$id_alumno, $id_materia, $id_periodo]);
    //     return $stmt->fetchColumn();
    // }
    
    function existeNota($alumnoId, $materiaId, $periodoId, $conn) {
        $query = $conn->prepare("SELECT COUNT(*) FROM notas WHERE alumnos_notas = ? AND materias_notas = ? AND id_periodo = ?");
        $query->execute([$alumnoId, $materiaId, $periodoId]);
        return $query->fetchColumn();
    }
    


    // function existeNota($id_alumno, $id_materia, $conn) {
    //     // Consulta para verificar si existen notas para el alumno y la materia especificada
    //     $stmt = $conn->prepare("SELECT COUNT(*) FROM notas WHERE alumnos_notas = ? AND materias_notas = ?");
    //     $stmt->execute([$id_alumno, $id_materia]);
    //     $count = $stmt->fetchColumn();
    
    //     // Si el resultado es mayor que 0, significa que hay notas registradas
    //     return $count > 0;
    // }
    


?>