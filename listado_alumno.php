<?php
    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

    // Consulta los alumnos para el listado de alumnos
    $alumnos = $conn->prepare("
        SELECT 
            a.id_alumnos,
            a.lista_num_alumnos AS num_lista, 
            a.nombres_alumnos AS nombres, 
            a.apellidos_alumnos AS apellidos, 
            a.genero_alumnos AS genero, 
            b.nombre_grados AS grado, 
            c.nombre_subgrados AS subgrado,
            l.usuario_login AS usuario,
            p.nombres_padres AS nombres_padre, 
            p.apellidos_padres AS apellidos_padre
        FROM 
            alumnos AS a
        INNER JOIN 
            grados AS b ON a.grados_alumnos = b.id_grados
        INNER JOIN 
            subgrados AS c ON a.subgrados_alumnos = c.id_subgrados
        INNER JOIN 
            login AS l ON a.login_alumnos = l.id_login
        LEFT JOIN 
            padres AS p ON a.padres_alumnos = p.id_padres
        ORDER BY 
            a.apellidos_alumnos
    ");

    $alumnos->execute();
    $alumnos = $alumnos->fetchAll();
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
                        <a href="listados.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                    </div>
                </div>
            </div>
        </header>
        <div class="titulo">
            <h2>Usuario:  <?php echo $_SESSION["username"] ?></h2>
        </div>
        <div class="panel">
            <div class="contenido-panel">
                <h4>Listado de Alumnos</h4>
                <table class="table" cellspacing="0" cellpadding="0">
                    <tr>
                        <th>codigo del<br>estudiante</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Género</th>
                        <th>Grado</th>
                        <th>Subgrado</th>
                        <th>Usuario</th>
                        <th>Nombre del padre</th>
                        <th class="vacio"></th>
                        <th class="vacio"></thcl>
                    </tr>
                    <?php foreach ($alumnos as $alumno) : ?>
                        <tr>
                            <td align="center"><?php echo htmlspecialchars($alumno['num_lista']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['apellidos']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['nombres']); ?></td>
                            <td align="center"><?php echo htmlspecialchars($alumno['genero']); ?></td>
                            <td align="center"><?php echo htmlspecialchars($alumno['grado']); ?></td>
                            <td align="center"><?php echo htmlspecialchars($alumno['subgrado']); ?></td>
                            <td><?php echo htmlspecialchars($alumno['usuario']); ?></td>
                            <td align="center"><?php echo htmlspecialchars($alumno['nombres_padre']?: 'No asignado' . ' ' . $alumno['apellidos_padre']?: 'No asignado'); ?></td>

                            <td class="vacio">
                                <form method="post" action="editar_alumno.php?id=<?php echo $alumno['id_alumnos']; ?>">
                                    <input type="hidden" name="id" value="<?php echo $alumno['id_alumnos']; ?>">
                                    <input type="submit" value="Editar">
                                </form>
                            </td>
                            <td class="vacio">
                                <form method="post" action="borrar_alumno.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este alumno?');">
                                    <input type="hidden" name="id" value="<?php echo $alumno['id_alumnos']; ?>">
                                    <input type="submit" value="Eliminar">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <br><br>

                <a class="btn-link" href="registro_estudiantes.php">Agregar Alumno</a>
                <br><br>
                <!-- mostrando los mensajes que recibe a través de los parámetros en la URL -->
                <?php
                if (isset($_GET['err'])) {
                    echo '<span class="error">Error al almacenar el registro</span>';
                }
                if (isset($_GET['info'])) {
                    echo '<span class="success">Registro almacenado correctamente!</span>';
                }
                if (isset($_GET['borrado'])) {
                    echo '<span class="success">Registro borrado correctamente!</span>';
                }
                ?>

            </div>
        </div>

    </div> 

</body>

</html>