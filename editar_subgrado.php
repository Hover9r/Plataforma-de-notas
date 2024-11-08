<?php
    require 'roles.php';
    $permisos = ['Administrador'];
    permisos($permisos);

    // Obtener el ID del subgrado desde la URL
    $id_subgrado = $_GET['id'];

    // Consulta para obtener los datos del subgrado y el grado asociado
    $subgrado_stmt = $conn->prepare("
        SELECT s.*, g.id_grados 
        FROM subgrados s
        JOIN grados g ON s.grado_id = g.id_grados
        WHERE s.id_subgrados = :id
    ");
    $subgrado_stmt->bindParam(':id', $id_subgrado);
    $subgrado_stmt->execute();
    $subgrado = $subgrado_stmt->fetch(PDO::FETCH_ASSOC);

    // Verificar si se encontró el subgrado
    if (!$subgrado) {
        die('Subgrado no encontrado.');
    }

    // Procesar el formulario al enviarlo
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nuevo_nombre = $_POST['nombre_subgrado'];
        $grado_id = $_POST['grado_id']; // Obtener el ID del grado

        // Actualizar el subgrado
        $update_stmt = $conn->prepare("UPDATE subgrados SET nombre_subgrados = :nombre, grado_id = :grado_id WHERE id_subgrados = :id");
        $update_stmt->bindParam(':nombre', $nuevo_nombre);
        $update_stmt->bindParam(':grado_id', $grado_id);
        $update_stmt->bindParam(':id', $id_subgrado);
        $update_stmt->execute();

        // Redireccionar después de la actualización
        header("Location: listado_grados_sub.php");
        exit;
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
    <title>Editar Subgrado</title>
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
            <h2>Editar Subgrado</h2>
        </div>
        <div class="panel">
            <form method="post">
                <label for="nombre_subgrado">Nombre del Subgrado:</label>
                <input type="text" id="nombre_subgrado" name="nombre_subgrado" value="<?php echo htmlspecialchars($subgrado['nombre_subgrados']); ?>" required>
                
                <!-- Campo oculto para el ID del grado -->
                <input type="hidden" name="grado_id" value="<?php echo htmlspecialchars($subgrado['grado_id']); ?>">

                <input type="submit" value="Modificar">
                <a href="listado_grados_sub.php">Salir</a>
            </form>
        </div>
    </div>
</body>
</html>

