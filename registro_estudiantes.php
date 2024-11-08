<!DOCTYPE html>
<?php
    require 'conexion.php';
    require 'roles.php';
    // permisos -> roles de quienes pueden entrar
    $permisos = ['Administrador'];
    permisos($permisos);

    //consultar los subgrados en la BD
    $subgrados = $conn->prepare("select * from subgrados");
    $subgrados->execute();
    $subgrados = $subgrados->fetchAll();

    //consultar los grados en la BD
    $grados = $conn->prepare("select * from grados");
    $grados->execute();
    $grados = $grados->fetchAll();
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de estudaintes</title>
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
        <h2>Registro de estudiantes</h2>
    </div>
    <div class="container">
        <form action="procesar_estudiante.php" method="POST">
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

            <label>codigo del estudiante</label><br>
            <input type="number" min="1" class="number" name="numlista">
            <br>

            <label>Genero</label><br>
            <input type="radio" name="genero" value="M"> Masculino
            <input type="radio" name="genero" value="F"> Femenino
            <br>

            <br>
            <label>Grado</label><br>
            <select name="grado" required>
                <?php foreach ($grados as $grado): ?>
                    <option value="<?php echo $grado['id_grados']; ?>"><?php echo $grado['nombre_grados']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>

            <label>Subgrado</label><br>
            <select name="subgrado" require>
                <?php foreach ($subgrados as $subgrado): ?>
                    <option  value="<?php echo $subgrado['id_subgrados']; ?>"> Subgrado <?php echo $subgrado['nombre_subgrados']; ?></option>
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
