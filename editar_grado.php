<?php
    // require 'roles.php';
    // $permisos = ['Administrador'];
    // permisos($permisos);

    // // Obtener el ID del grado desde la URL
    // $id_grado = $_GET['id'];

    // // Consulta para obtener los datos del grado
    // $grado_stmt = $conn->prepare("SELECT * FROM grados WHERE id_grados = :id");
    // $grado_stmt->bindParam(':id', $id_grado);
    // $grado_stmt->execute();
    // $grado = $grado_stmt->fetch(PDO::FETCH_ASSOC);

    // // Verificar si se encontró el grado
    // if (!$grado) {
    //     die('Grado no encontrado.');
    // }

    // // Procesar el formulario al enviarlo
    // if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //     $nuevo_nombre = $_POST['nombre_grado'];

    //     // Actualizar el grado
    //     $update_stmt = $conn->prepare("UPDATE grados SET nombre_grados = :nombre WHERE id_grados = :id");
    //     $update_stmt->bindParam(':nombre', $nuevo_nombre);
    //     $update_stmt->bindParam(':id', $id_grado);
    //     $update_stmt->execute();

    //     // Redireccionar después de la actualización
    //     header("Location: listado_grados_sub.php");
    //     exit;
    // }

    require 'roles.php';
    $permisos = ['Administrador'];
    permisos($permisos);

    // Obtener el ID del grado desde la URL
    $id_grado = $_GET['id'];

    // Consulta para obtener los datos del grado
    $grado_stmt = $conn->prepare("SELECT * FROM grados WHERE id_grados = :id");
    $grado_stmt->bindParam(':id', $id_grado);
    $grado_stmt->execute();
    $grado = $grado_stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el grado
    if (!$grado) {
        die('Grado no encontrado.');
    }

    // Procesar el formulario solo cuando se haga clic en "Modificar"
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modificar'])) {
        // Validar y asignar el valor
        $nuevo_nombre = $_POST['nombre_grado'] ?? '';

        // Verificar que el campo 'nombre_grado' no esté vacío
        if (!empty($nuevo_nombre)) {
            // Actualizar el grado
            $update_stmt = $conn->prepare("UPDATE grados SET nombre_grados = :nombre WHERE id_grados = :id");
            $update_stmt->bindParam(':nombre', $nuevo_nombre, PDO::PARAM_STR);
            $update_stmt->bindParam(':id', $id_grado, PDO::PARAM_INT);

            // Ejecutar la actualización
            if ($update_stmt->execute()) {
                header("Location: listado_grados_sub.php?info=success");
                exit;
            } else {
                echo "Error al actualizar el grado.";
            }
        } else {
            echo "<p style='color:red;'>Por favor, ingrese un nombre para el grado.</p>";
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
    <title>Editar Grado</title>
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
            <h2>Editar Grado</h2>
        </div>
        <div class="panel">
            <form method="post">
                <label for="nombre_grado">Nombre del Grado:</label>
                <input type="text" id="nombre_grado" name="nombre_grado" value="<?php echo htmlspecialchars($grado['nombre_grados']); ?>" required>
                <input type="submit" name="modificar"  value="Modificar">
                <a href="listado_grados_sub.php">Salir</a>
            </form>
        </div>
    </div>
</body>
</html>
