<!DOCTYPE html>
<?php
    require 'conexion.php';
    require 'roles.php';
    // permisos -> roles de quienes pueden entrar
    $permisos = ['Administrador'];
    permisos($permisos);

    //consultar los grados en la BD
    $grados = $conn->prepare("select * from grados");
    $grados->execute();
    $grados = $grados->fetchAll();

    //consultar las materias en la BD
    $materias = $conn->prepare("select * from materias");
    $materias->execute();
    $materias = $materias->fetchAll();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de profesores</title>
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
        <h2>Registro de profesores</h2>
    </div>
    <div class="container">
        <form action="procesar_profesores.php" method="POST">
            <label>Nombres:</label>
            <input type="text" name="nombres" required maxlength="50">
            <br>

            <label>Apellidos:</label>
            <input type="text" name="apellidos" required maxlength="50">
            <br>

            <label>Cedula:</label>
            <input type="number" name="cedula" required>
            <br>

            <label>Genero</label><br>
            <input type="radio" name="genero" value="M"> Masculino
            <input type="radio" name="genero" value="F"> Femenino
            <br>

            <br>
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario">
            <br>

            <label for="contraseña">Contraseña:</label>
            <input type="password" name="contraseña">
            <br>

            <!-- <label>Grados que enseña:</label><br>
            <select name="grado" required>
                <?php foreach ($grados as $grado): ?>
                    <option name="grados[]" value="<?php echo $grado['id_grados']; ?>"> <?php echo $grado['nombre_grados']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label>Materias que enseña:</label><br>
            <select name="materias" required>
                <?php foreach ($materias as $materia): ?>
                    <option name="materias[]" value="<?php echo $materia['id_materias']; ?>"> <?php echo $materia['nombre_materias']; ?></option>
                <?php endforeach; ?>
            </select> -->

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
                if (isset($_GET['cedula']))
                echo '<span class="error">La cédula no puede tener más de 10 dígitos.</span>';
            ?>
        </form>
    </div>
</body>
</html>