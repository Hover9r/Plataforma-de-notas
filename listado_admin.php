<?php

    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

    // Consulta los maestros y las materias que dictan
    $admins = $conn->prepare("
        SELECT 
            ad.id_admin,
            ad.nombres_admin, 
            ad.apellidos_admin, 
            ad.cedula_admin, 
            ad.genero_admin,
            l.usuario_login
        FROM 
            administradores AS ad
        INNER JOIN 
            login AS l ON ad.login_admin = l.id_login
        GROUP BY 
           ad.id_admin
        ORDER BY 
           ad.apellidos_admin
    ");

    $admins->execute();
    $admins = $admins->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paneles.css">
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
                <img src="./img/logopas-png.png"></a>
            </div>
            <div class="nombre">
                <a class="aa" href="paneles.php">Misael Pastrana Borrero</a>
            </div>
            <div class="social">
                <div class="social-icon">
                    <a href="listados.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                </div>
            </div>
        </div>
    </header>
    <div class="titulo">
        <h2>Usuario: <?php echo htmlspecialchars($_SESSION["username"]) ?></h2>
    </div>
    <div class="panel">
        <div class="contenido-panel">
            <div>
                <h4>Listado de administradores</h4>
                <table class="table" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Cédula</th>
                        <th>Género</th>
                        <th>Usuario</th>
                        <th class="vacio"></th>
                        <th class="vacio"></th>
                    </tr>
                    <?php foreach ($admins as $admin) : ?>
                    <tr>
                    <td><?php echo htmlspecialchars($admin['apellidos_admin']) ?></td> 
                    <td><?php echo htmlspecialchars($admin['nombres_admin']) ?></td>
                    <td><?php echo htmlspecialchars($admin['cedula_admin']) ?></td>
                    <td align="center"><?php echo htmlspecialchars($admin['genero_admin']) ?></td>
                    <td><?php echo htmlspecialchars($admin['usuario_login']) ?></td>

                        <td class="vacio">
                            <form method="post" action="editar_admin.php?id=<?php echo $admin['id_admin'] ?>">
                                <input type="hidden" name="id" value="<?php echo $admin['id_admin'] ?>">
                                <input type="submit" value="Editar">
                            </form>
                        </td>
                        <td class="vacio">
                            <form method="post" action="borrar_admin.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este administrador?');">
                                <input type="hidden" name="id" value="<?php echo $admin['id_admin']; ?>">
                                <input type="submit" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <br><br>

                <a class="btn-link" href="registro_admin.php">Agregar administradores</a>
                <br><br>
                <!-- mostrando los mensajes que recibe a través de los parámetros en la URL -->
                <?php
                if (isset($_GET['err'])) {
                    echo '<span class="error">Error al almacenar el registro</span>';
                }
                if (isset($_GET['info'])) {
                    echo '<span class="success">Registro almacenado correctamente!</span>';
                }
                ?>
            </div>
        </div>
    </div> 

</body>
</html>