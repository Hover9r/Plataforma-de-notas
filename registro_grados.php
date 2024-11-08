<!DOCTYPE html>
<?php
    require 'conexion.php';
    require 'roles.php';
    // permisos -> roles de quienes pueden entrar
    $permisos = ['Administrador'];
    permisos($permisos);

?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de grados</title>
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
                    <a href="gestion_grados.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                </div>
            </div>
        </div>
    </header>
    <div class="titulo">
        <h2>Registro de grados</h2>
    </div>
    <div class="container">
        <form action="procesar_grados.php" method="POST">

            <label>Nombre del grado:</label>
            <input type="text" name="nombre" required maxlength="50">
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