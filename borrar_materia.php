<?php

    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

    if (!isset($_POST['id'])) {
        echo "ID de materia no especificado.";
        exit;
    }

    $materia_id = $_POST['id'];

    // Conectar a la base de datos y verificar que la materia existe antes de borrar
    $consulta_materia = $conn->prepare("
        SELECT 
            m.id_materias, 
            m.nombre_materias, 
            p.nombres_maestros, 
            p.apellidos_maestros
        FROM 
            materias m
        LEFT JOIN 
            maestros p ON m.maestros_materias = p.id_maestros
        WHERE 
            m.id_materias = :id
    ");
    $consulta_materia->bindParam(':id', $materia_id, PDO::PARAM_INT);
    $consulta_materia->execute();
    $materia = $consulta_materia->fetch(PDO::FETCH_ASSOC);

    if (!$materia) {
        echo "Materia no encontrada.";
        exit;
    }

    // Borrar la materia de la base de datos
    $borrar_materia = $conn->prepare("DELETE FROM materias WHERE id_materias = :id");
    $borrar_materia->bindParam(':id', $materia_id, PDO::PARAM_INT);

    if ($borrar_materia->execute()) {
        header('Location: listado_materias.php?borrado=deleted');
        exit();
    } else {
        echo "Error al intentar borrar la materia.";
    }

?>