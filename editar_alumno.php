<?php
    require 'roles.php';
    $permisos = ['Administrador'];
    permisos($permisos);

    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Obtener los datos del alumno junto con los datos del padre
        $stmt = $conn->prepare("
            SELECT 
                a.*, 
                l.usuario_login AS usuario, 
                l.password_login AS password,
                p.nombres_padres AS nombres_padre, 
                p.apellidos_padres AS apellidos_padre
            FROM 
                alumnos AS a
            INNER JOIN 
                login AS l ON a.login_alumnos = l.id_login
            LEFT JOIN 
                padres AS p ON a.padres_alumnos = p.id_padres
            WHERE 
                a.id_alumnos = :id
        ");

        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $alumno = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$alumno) {
            die('Alumno no encontrado');
        }

        //consulta los subgrados
        $subgrados = $conn->prepare("select * from subgrados");
        $subgrados->execute();
        $subgrados = $subgrados->fetchAll();

        //consulta de grados
        $grados = $conn->prepare("select * from grados");
        $grados->execute();
        $grados = $grados->fetchAll();

        //consulta de padres
        $padres = $conn->prepare("select * from padres");
        $padres->execute();
        $padres = $padres->fetchAll();

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
    <title>Editar Alumno</title>
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
                        <a href="listado_alumno.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="titulo">
            <h2>Editar Alumno</h2>
        </div>
        <div class="container">
            <form method="post" action="procesar_editar_alum.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($alumno['id_alumnos']); ?>">
                
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($alumno['usuario']); ?>" required><br>

                <label for="contraseña">Contraseña:</label>
                <input type="password" name="contraseña" id="contraseña"><br>
                <small>Deja en blanco si no deseas cambiar la contraseña.</small><br>

                <label for="numlista">Número de Lista:</label>
                <input type="text" name="numlista" id="numlista" value="<?php echo htmlspecialchars($alumno['lista_num_alumnos']); ?>" required><br>

                <label for="nombres">Nombres:</label>
                <input type="text" name="nombres" id="nombres" value="<?php echo htmlspecialchars($alumno['nombres_alumnos']); ?>" required><br>

                <label for="apellidos">Apellidos:</label>
                <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($alumno['apellidos_alumnos']); ?>" required><br>

                <label for="genero">Género:</label>
                <input type="text" name="genero" id="genero" value="<?php echo htmlspecialchars($alumno['genero_alumnos']); ?>" required><br>

                <select name="grado" id="grado" required>
                    <?php foreach ($grados as $grado): ?>
                        <option value="<?php echo $grado['id_grados']; ?>" <?php if ($alumno['grados_alumnos'] == $grado['id_grados']) { echo "selected"; } ?>>
                            <?php echo htmlspecialchars($grado['nombre_grados']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label for="subgrado">Subgrado:</label>
                <select name="subgrado" id="subgrado" required>
                    <?php foreach ($subgrados as $subgrado): ?>
                        <option value="<?php echo $subgrado['id_subgrados']; ?>" <?php if ($alumno['subgrados_alumnos'] == $subgrado['id_subgrados']) { echo "selected"; } ?>>
                            Subgrado <?php echo htmlspecialchars($subgrado['nombre_subgrados']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label for="padre">Padre:</label>
                <select name="padre" id="padre" required>
                    <?php foreach ($padres as $padre): ?>
                        <option value="<?php echo $padre['id_padres']; ?>" <?php if ($alumno['padres_alumnos'] == $padre['id_padres']) { echo "selected"; } ?>>
                            <?php echo htmlspecialchars($padre['nombres_padres'] . ' ' . $padre['apellidos_padres']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <button type="submit" name="modificar">Modificar</button>
                <br>
                <a href="listado_alumno.php">Salir</a>

            </form>
        </div>
    </div>
</body>
</html>
