<?php
    require 'roles.php';
    $permisos = ['Administrador'];
    permisos($permisos);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Obtener los datos del profesor
        $stmt = $conn->prepare("
            SELECT m.*, l.usuario_login AS usuario
            FROM maestros AS m
            INNER JOIN login AS l ON m.login_maestros = l.id_login
            WHERE m.id_maestros = :id
        ");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $profesor = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$profesor) {
            die('Profesor no encontrado');
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paneles.css">
    <link rel="stylesheet" href="css/registro.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/4c9a3d6a1f.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logopas-png.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Open+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <title>Editar Profesor</title>
</head>
<body>
    <div class="padre">
        <header class="header">
            <div class="menu margen-interno">
                <div class="logo">
                    <img src="./img/logopas-png.png"></a>
                </div>
                <div class="nombre">
                    <a class="aa" href="paneles.php">Misael Pastrana Borrero</a>
                </div>
                <div class="social">
                    <div class="social-icon">
                        <a href="listado_profesores.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="titulo">
            <h2>Editar Profesor</h2>
        </div>
        <div class="container">
            <form method="post" action="procesar_editar_profesores.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($profesor['id_maestros']); ?>">

                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($profesor['usuario']); ?>" required><br>

                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" id="contraseña"><br>
                <small>Deja en blanco si no deseas cambiar la contraseña.</small><br>

                <label for="nombres">Nombres:</label>
                <input type="text" name="nombres" id="nombres" value="<?php echo htmlspecialchars($profesor['nombres_maestros']); ?>" required><br>

                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($profesor['apellidos_maestros']); ?>" required><br>

                <label for="cedula">Cédula:</label>
                <input type="text" name="cedula" id="cedula" value="<?php echo htmlspecialchars($profesor['cedula_maestros']); ?>" required><br>

                <label for="genero">Género:</label>
                <input type="text" name="genero" id="genero" value="<?php echo htmlspecialchars($profesor['genero_maestros']); ?>" required><br>

                <button type="submit" name="modificar">Modificar</button>
                <br>
                <a href="listado_profesores.php">Salir</a>
            </form>
        </div>
    </div>
</body>
</html>
