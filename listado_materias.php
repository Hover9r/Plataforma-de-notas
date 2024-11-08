<?php 

    require 'roles.php';

    $permisos = ['Administrador'];
    permisos($permisos);

    // Consulta para obtener las materias y sus profesores asociados
    $materias = $conn->prepare("
        SELECT 
            m.id_materias, 
            m.nombre_materias,
            p.id_maestros,
            p.nombres_maestros,
            p.apellidos_maestros,
            m.cant_notas_materias
        FROM 
            materias m
        LEFT JOIN 
            maestros p ON m.maestros_materias = p.id_maestros
        ORDER BY 
            m.nombre_materias, p.apellidos_maestros
    ");
    $materias->execute();
    $materias = $materias->fetchAll();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paneles.css">
    <title>Proyecto Final - Listado de Materias</title>
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
                    <a href="gestion_materias.php"><img src="./img/undo-regular-48.png" alt="" class="desplegable"></a>
                </div>
            </div>
        </div>
    </header> 
    <div class="titulo">
        <h2>Usuario: <?php echo $_SESSION["username"] ?></h2>
    </div>

    <div class="panel">
        <div class="contenido-panel">
            <h4>Listado de Materias</h4>
            <table class="table" cellspacing="0" cellpadding="0">
                <tr>
                    <th>Nombre de la Materia</th>
                    <th>Profesor Asignado</th>
                    <th>Cantidad de Notas</th>
                    <th class="vacio"></th>
                    <th class="vacio"></th>
                </tr>

                <?php foreach ($materias as $materia) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($materia['nombre_materias']); ?></td>
                        <td>
                            <?php
                            // Muestra el nombre del profesor si existe, de lo contrario muestra "Sin profesor asignado"
                            if ($materia['id_maestros']) {
                                echo htmlspecialchars($materia['nombres_maestros'] . " " . $materia['apellidos_maestros']);
                            } else {
                                echo "Sin profesor asignado";
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($materia['cant_notas_materias']); ?></td>
                        
                        <td class="vacio">
                            <form method="post" action="editar_materias.php?id=<?php echo $materia['id_materias'] ?>">
                                <input type="hidden" name="id" value="<?php echo$materia['id_materias'] ?>">
                                <input type="submit" value="Editar">
                            </form>
                        </td>
                        <td class="vacio">
                            <form method="post" action="borrar_materia.php" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta materia y sus profesores asociados?');">
                                <input type="hidden" name="id" value="<?php echo $materia['id_materias']; ?>">
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

