<?php

    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

    // Consulta para obtener los grados y sus subgrados asociados
    $grados = $conn->prepare("
        SELECT 
            g.id_grados, 
            g.nombre_grados,
            s.id_subgrados,
            s.nombre_subgrados
        FROM 
            grados g
        LEFT JOIN 
            subgrados s ON g.id_grados = s.grado_id
        ORDER BY 
            g.nombre_grados, s.nombre_subgrados
    ");
    $grados->execute();
    $grados = $grados->fetchAll();
    
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
    <title>Proyecto Final - Listado de Grados y Subgrados</title>
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
                <a href="gestion_grados.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                </div>
            </div>
        </div>
    </header>
    <div class="titulo">
        <h2>Usuario: <?php echo $_SESSION["username"] ?></h2>
    </div>

    <div class="panel">
        <div class="contenido-panel">
            <h4>Listado de Grados y Subgrados</h4>
            <table class="table" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Nombre del Grado</th>
                    <th>Subgrados</th>
                    <th class="vacio"></th>
                    <th class="vacio"></th>
                </tr>

                <?php foreach ($grados as $fila) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($fila['nombre_grados']); ?></td>
                        <td>
                            <?php
                            if ($fila['id_subgrados']) {
                                echo htmlspecialchars($fila['nombre_subgrados']) . " 
                                <a href='editar_subgrado.php?id=" . $fila['id_subgrados'] . "'>Editar</a>
                                <form method='post' action='borrar_subgrado.php' style='display:inline;' onsubmit='return confirm(\"¿Estás seguro de que deseas eliminar este subgrado?\");'>
                                    <input type='hidden' name='id' value='" . $fila['id_subgrados'] . "'>
                                    <input type='submit' value='Eliminar'>
                                </form><br>";
                            } else {
                                echo "Sin subgrados"; // Mensaje claro cuando no hay subgrados
                            }
                            ?>
                        </td>
                        <td class="vacio">
                            <form method="post" action="editar_grado.php?id=<?php echo $fila['id_grados']; ?>">
                                <input type="hidden" name="id" value="<?php echo $fila['id_grados']; ?>">
                                <input type="submit" value="Editar">
                            </form>
                        </td>
                        <td class="vacio">
                            <form method="post" action="borrar_grados.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este grado y sus subgrados asociados?');">
                                <input type="hidden" name="id" value="<?php echo $fila['id_grados']; ?>">
                                <input type="submit" value="Eliminar">
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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




