<?php

    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

    // Consulta los maestros y las materias que dictan
    $maestros = $conn->prepare("
        SELECT 
            m.id_maestros,
            m.nombres_maestros, 
            m.apellidos_maestros, 
            m.cedula_maestros, 
            m.genero_maestros,
            l.usuario_login,
            GROUP_CONCAT(mat.nombre_materias SEPARATOR ', ') AS materias
        FROM 
            maestros AS m
        INNER JOIN 
            login AS l ON m.login_maestros = l.id_login
        LEFT JOIN 
            maestros_materias AS mm ON m.id_maestros = mm.id_maestros
        LEFT JOIN 
            materias AS mat ON mm.id_materias = mat.id_materias
        GROUP BY 
            m.id_maestros
        ORDER BY 
            m.apellidos_maestros
    ");

    $maestros->execute();
    $maestros = $maestros->fetchAll();

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
                <h4>Listado de Maestros</h4>
                <table class="table" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Cédula</th>
                        <th>Género</th>
                        <th>Usuario</th>
                        <th>Materias</th>
                        <th class="vacio"></th>
                        <th class="vacio"></th>
                    </tr>
                    <?php foreach ($maestros as $maestro) : ?>
                    <tr>
                    <td><?php echo htmlspecialchars($maestro['apellidos_maestros']) ?></td> 
                    <td><?php echo htmlspecialchars($maestro['nombres_maestros']) ?></td>
                    <td><?php echo htmlspecialchars($maestro['cedula_maestros']) ?></td>
                    <td align="center"><?php echo htmlspecialchars($maestro['genero_maestros']) ?></td>
                    <td><?php echo htmlspecialchars($maestro['usuario_login']) ?></td>
                    <td><?php echo htmlspecialchars($maestro['materias'] ?: 'No asignado'); ?></td>

                    <td class="vacio">
                        <form method="post" action="editar_profesores.php?id=<?php echo $maestro['id_maestros'] ?>">
                            <input type="hidden" name="id" value="<?php echo $maestro['id_maestros'] ?>">
                            <input type="submit" value="Editar">
                        </form>
                    </td>
                    <td class="vacio">
                        <form method="post" action="borrar_profesor.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este profesor?');">
                            <input type="hidden" name="id" value="<?php echo $maestro['id_maestros']; ?>">
                            <input type="submit" value="Eliminar">
                        </form>
                    </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <br><br>

                <a class="btn-link" href="registro_profesores.php">Agregar Maestro</a>
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
