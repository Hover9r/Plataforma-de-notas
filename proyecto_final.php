<?php
//mensajes
$messages = [
    "1" => "Usuario o contraseña incorrectas",
    "2" => "No ha iniciado sesión"
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="./img/logopas-png.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Open+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <title>proyecto Final</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="padre">
        <header class="header">
            <div class="menu margen-interno">
                <div class="logo">
                    <img src="./img/logopas-png.png">
                </div>
                <div class="nombre">
                    <a href="proyecto_final.php">Misael Pastrana Borrero</a>
                </div>
                <div class="social">
                    <div class="social-icon">
                        <a href="https://www.facebook.com/profile.php?id=100057667800225&sk=photos_albums"><i class="fa-brands fa-facebook fa-xl"></i></a>
                        <a href="https://twitter.com/?lang=es"><i class="fa-brands fa-twitter fa-xl"></i></a>
                        <a href="x"><i class="fa-brands fa-Kwai fa-xl"></i></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="recuadro">
            <div class="secciones">
                <div class="log">
                    <!-- inicio de sesion -->
                    <form method="post" class="form" action="login_post.php">
                        <label>Usuario</label><br>
                        <input type="text" name="usuario" placeholder="Nombre de usuario">
                        <br>
                        <label>Contraseña</label><br>
                        <input type="password" name="contraseña" placeholder="Contraseña">
                        <br><br>
                        <button type="submit">Ingresar</button>
                    </form>
                <?php
                    // mensaje de error
                    if(isset($_GET['err']) && is_numeric($_GET['err']) && $_GET['err'] > 0 && $_GET['err'] < 3 )
                        echo '<span class="error">'.$messages[$_GET['err']].'</span>';
                ?>
                </div>
            </div>
        </div>
    </div>
</body>    
</html>