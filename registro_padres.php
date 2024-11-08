<!DOCTYPE html>
<?php
    require 'conexion.php';
    require 'roles.php';
    // permisos -> roles de quienes pueden entrar
    $permisos = ['Administrador'];
    permisos($permisos);

    //consultar los maestros en la BD
    $alumnos = $conn->prepare("select * from alumnos");
    $alumnos->execute();
    $alumnos = $alumnos->fetchAll();

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de materias</title>
    <link rel="stylesheet" href="css/paneles.css">
    <link rel="stylesheet" href="css/registro.css">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Open+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="menu margen-interno">
            <div class="logo">
                <img src="./img/logopas-png.png" alt="Logo">
            </div>
            <div class="nombre">
                <a class="aa" href="paneles.php">Misael Pastrana Borrero</a>
            </div>
            <div class="social">
                <div class="social-icon">
                    <a href="registros.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                </div>
            </div>
        </div>
    </header>
    <div class="titulo">
        <h2>Registro de padres de familia</h2>
    </div>
    <div class="container">
        <form action="procesar_padres.php" method="POST">

            <label>Nombres:</label>
            <input type="text" name="nombres" required maxlength="50">
            <br>

            <label>Apellidos:</label>
            <input type="text" name="apellidos" required maxlength="50">
            <br>

            <br>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario">
            <br>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña">
            <br>

            <label>Estudiante:</label><br>
            <select name="estudiante" required>
                <?php foreach ($alumnos as $alumno): ?>
                    <option value="<?php echo $alumno['id_alumnos']; ?>"><?php echo $alumno['nombres_alumnos'] . ' ' . $alumno['apellidos_alumnos']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <button type="submit" name="guardar">Guardar</button> 
            <br>
            <button type="reset">Limpiar</button> 
            <br>
            <a href="paneles.php">Salir</a>

            <!--mensajes-->
            <?php
            if (isset($_GET['err']))
                echo '<span class="error">Error al guardar</span>';
            if (isset($_GET['info']))
                echo '<span class="success">¡Ha sido registrado correctamente!</span>';
            ?>
        </form>

    </div>
</body>
</html>