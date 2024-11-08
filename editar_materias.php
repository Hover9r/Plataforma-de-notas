<?php

    // require 'roles.php';

    // $permisos = ['Administrador'];
    // permisos($permisos);

    // if (!isset($_GET['id'])) {
    //     echo "ID de materia no especificado.";
    //     exit;
    // }

    // $materia_id = $_GET['id'];

    // // Obtener los detalles de la materia específica
    // $consulta_materia = $conn->prepare("
    //     SELECT 
    //         m.id_materias, 
    //         m.nombre_materias, 
    //         m.cant_notas_materias,
    //         p.id_maestros,
    //         p.nombres_maestros,
    //         p.apellidos_maestros
    //     FROM 
    //         materias m
    //     LEFT JOIN 
    //         maestros p ON m.maestros_materias = p.id_maestros
    //     WHERE 
    //         m.id_materias = :id
    // ");
    // $consulta_materia->bindParam(':id', $materia_id, PDO::PARAM_INT);
    // $consulta_materia->execute();
    // $materia = $consulta_materia->fetch(PDO::FETCH_ASSOC);

    // if (!$materia) {
    //     echo "Materia no encontrada.";
    //     exit;
    // }

    // // Consultar los maestros en la BD
    // $maestros = $conn->prepare("SELECT * FROM maestros");
    // $maestros->execute();
    // $maestros = $maestros->fetchAll(PDO::FETCH_ASSOC); // Agregué el FETCH_ASSOC para mayor claridad

    // // Procesar el formulario de actualización
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $nombre_materia = $_POST['nombre_materia'];
    //     $cantidad_notas = $_POST['cant_notas_materias'];
    //     $id_maestro = $_POST['id_maestro'];

    //     // Actualizar los datos de la materia
    //     $actualizar_materia = $conn->prepare("
    //         UPDATE materias 
    //         SET nombre_materias = :nombre, cant_notas_materias = :cant_notas, maestros_materias = :id_profesor 
    //         WHERE id_materias = :id
    //     ");
    //     $actualizar_materia->bindParam(':nombre', $nombre_materia, PDO::PARAM_STR);
    //     $actualizar_materia->bindParam(':cant_notas', $cantidad_notas, PDO::PARAM_INT);
    //     $actualizar_materia->bindParam(':id_profesor', $id_maestro, PDO::PARAM_INT);
    //     $actualizar_materia->bindParam(':id', $materia_id, PDO::PARAM_INT);

    //     if ($actualizar_materia->execute()) {
    //         echo "Materia actualizada exitosamente.";
    //     } else {
    //         echo "Error al actualizar la materia.";
    //     }
    // }

    require 'roles.php';
    
    $permisos = ['Administrador'];
    permisos($permisos);
    
    if (!isset($_GET['id'])) {
        echo "ID de materia no especificado.";
        exit;
    }
    
    $materia_id = $_GET['id'];
    
    // Obtener los detalles de la materia específica
    $consulta_materia = $conn->prepare("
        SELECT 
            m.id_materias, 
            m.nombre_materias, 
            m.cant_notas_materias,
            p.id_maestros,
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
    
    // Consultar los maestros en la BD
    $maestros = $conn->prepare("SELECT * FROM maestros");
    $maestros->execute();
    $maestros = $maestros->fetchAll(PDO::FETCH_ASSOC);
    
    // Procesar el formulario de actualización solo cuando se haga clic en "Modificar"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
        // Validar y asignar valores
        $nombre_materia = $_POST['nombre_materia'] ?? '';
        $cantidad_notas = $_POST['cant_notas_materias'] ?? 0;
        $id_maestro = $_POST['id_maestro'] ?? null;
    
        // Verificar que los campos requeridos no estén vacíos
        if (!empty($nombre_materia) && !empty($cantidad_notas) && !empty($id_maestro)) {
            // Actualizar los datos de la materia
            $actualizar_materia = $conn->prepare("
                UPDATE materias 
                SET nombre_materias = :nombre, cant_notas_materias = :cant_notas, maestros_materias = :id_profesor 
                WHERE id_materias = :id
            ");
            $actualizar_materia->bindParam(':nombre', $nombre_materia, PDO::PARAM_STR);
            $actualizar_materia->bindParam(':cant_notas', $cantidad_notas, PDO::PARAM_INT);
            $actualizar_materia->bindParam(':id_profesor', $id_maestro, PDO::PARAM_INT);
            $actualizar_materia->bindParam(':id', $materia_id, PDO::PARAM_INT);
    
            if ($actualizar_materia->execute()) {
                header('Location: listado_materias.php?info=success');
                exit();
            } else {
                header('Location: listado_materias.php?err=error');
                exit();
            }
        } else {
            echo "Por favor completa todos los campos obligatorios.";
        }
    }  


?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registro.css">
    <link rel="stylesheet" href="css/paneles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/4c9a3d6a1f.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logopas-png.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Open+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <title>Editar Materia</title>
</head>
<body>
    <div class="padre">
        <header class="header">
            <div class="menu margen-interno">
                <div class="logo">
                    <img src="./img/logopas-png.png" alt="Logo">
                </div>
                <div class="nombre">
                    <a href="paneles.php">Misael Pastrana Borrero</a>
                </div>
            </div>
        </header>
        
        <div class="titulo">
            <h2>Editar Materia</h2>
        </div>

        <div class="panel">
            <form method="POST">
                <label for="nombre_materia">Nombre de la Materia:</label>
                <input type="text" name="nombre_materia" id="nombre_materia" value="<?php echo htmlspecialchars($materia['nombre_materias']); ?>" required>

                <label for="id_maestro">Profesor Asignado:</label>
                <select name="id_maestro" id="id_maestro">
                    <option value="">-- Seleccione un Profesor --</option>
                    <?php foreach ($maestros as $profesor) : ?>
                        <option value="<?php echo $profesor['id_maestros']; ?>" <?php echo $materia['id_maestros'] == $profesor['id_maestros'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($profesor['nombres_maestros'] . " " . $profesor['apellidos_maestros']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="cant_notas_materias">Cantidad de Notas:</label>
                <input type="number" name="cant_notas_materias" id="cant_notas_materias" value="<?php echo htmlspecialchars($materia['cant_notas_materias']); ?>" min="1" required>

                <input type="submit" name= "modificar" value="Modificar">
                <a href="listado_materias.php">Salir</a>
            </form>
        </div>
    </div>
</body>
</html>

