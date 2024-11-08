<!DOCTYPE html>
<?php
    require 'roles.php';
    $permisos = ['Administrador','Profesor','Padre','Estudiante']; 
    
    permisos($permisos);
?>

<html lang="en">
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
    <title>proyecto Final</title>
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
                        <a href="login_out.php"><img src="./img/exit-regular-48.png" alt="" class="desplegable"></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="titulo">
            <h2>Usuario:  <?php echo $_SESSION["username"] ?></h2>
        </div>
        <div class="panel">
            <div class="contenido-panel">
                <!-- mejorar el mensaje de error -> diseño -->
                <?php
                    if(isset($_GET['err'])){
                        echo '<h3 class="error text-center">ERROR: Usuario no autorizado</h3>';
                    
                    }
                ?>
                <div class="row">
                    <div class="col2">
                        <a class="aa" href="registros.php">
                            <div class="boton">
                                <img class="icono" src="./img/edit.png" alt="">
                                <p class="separador">registros</p>
                            </div>
                        </a>
                    </div>
                    <div class="col2">
                        <a class="aa" href="listados.php">
                            <div class="boton">
                                <img class="icono" src="./img/registro.png" alt="">
                                <p class="separador">Listados</p>
                            </div>
                        </a>
                    </div>
                    <div class="col2">
                        <a class="aa" href="gestion_materias.php">
                            <div class="boton">
                                <img class="icono" src="./img/materia.png" alt="">
                                <p class="separador">gestión de materias</p>
                            </div>
                        </a>
                    </div>
                    <div class="col2">
                        <a class="aa" href="gestion_grados.php">
                            <div class="boton">
                                <img class="icono" src="./img/curso.png" alt="">
                                <p class="separador">gestión de grados</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col2">
                        <a class="aa" href="registro_periodo.php">
                            <div class="boton">
                                <img class="icono" src="./img/aña.png" alt="">
                                <p class="separador">registro de periodos</p>                            
                            </div>
                        </a>
                    </div>
                    <div class="col2">
                        <a class="aa" href="registro_notas2.php">
                            <div class="boton">
                                <img class="icono" src="./img/edit.png" alt="">
                                <p class="separador">registro de notas</p>
                            </div>
                        </a>
                    </div>
                    <div class="col2">
                        <a class="aa" href="listado_notas2.php">
                            <div class="boton">
                                <img class="icono" src="./img/registro.png" alt="">
                                <p class="separador">Consulta de notas</p>
                            </div>
                        </a>
                    </div>
                    <div class="col2">
                        <a class="aa" href="boletin.php">
                            <div class="boton">
                                <img class="icono" src="./img/registro.png" alt="">
                                <p class="separador">Generar boletin</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>           
</body>    
</html>