<?php
    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paneles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/4c9a3d6a1f.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logopas-png.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Open+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <title>Listado de Maestros</title>
</head>
<body>
<div class="padre">
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
                    <a href="paneles.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                </div>
            </div>
        </div>
    </header>   
    <div class="titulo">
        <h2>Usuario: <?php echo htmlspecialchars($_SESSION["username"]) ?></h2>
    </div>
    <div class="panel">
        <div class="contenido-panel">
            <div class="row">
                <div class="col2">
                    <a class="aa" href="registro_materias.php">
                        <div class="boton">
                            <img class="icono" src="./img/aña.png" alt="">
                            <p class="separador">registro de materias</p>
                        </div>
                    </a>
                </div>
                <div class="col2">
                    <a class="aa" href="listado_materias.php">
                        <div class="boton">
                            <img class="icono" src="./img/file.png" alt="">
                            <p class="separador">Listado de materias</p>
                        </div>
                    </a>
                </div>
                <div class="col2">

                </div>
                <div class="col2">
                    
                </div>
            </div>
        </div>
    </div> 
</body>
</html>