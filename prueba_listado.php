<?php
require 'roles.php';

$permisos = ['Administrador'];
permisos($permisos);

// Consulta para obtener las materias
$materiasQuery = $conn->prepare("SELECT id_materias, nombre_materias FROM materias");
$materiasQuery->execute();
$materias = $materiasQuery->fetchAll(PDO::FETCH_ASSOC);

// Consulta para obtener los periodos
$periodosQuery = $conn->prepare("SELECT id_periodo, nombre_periodo FROM periodos");
$periodosQuery->execute();
$periodos = $periodosQuery->fetchAll(PDO::FETCH_ASSOC);

// Construcción de la consulta para obtener promedios y observaciones por periodo
$selectFields = "
    a.id_alumnos,
    a.lista_num_alumnos AS num_lista, 
    a.nombres_alumnos AS nombres, 
    a.apellidos_alumnos AS apellidos, 
    a.genero_alumnos AS genero, 
    b.nombre_grados AS grado, 
    c.nombre_subgrados AS subgrado,
    p.nombre_periodo AS periodo
";

$averageFields = [];
$observationFields = [];
foreach ($materias as $materia) {
    // Calcular promedio
    $averageFields[] = "AVG(CASE WHEN m.id_materias = {$materia['id_materias']} THEN n.nota_notas END) AS promedio_{$materia['id_materias']}";
    // Obtener observaciones
    $observationFields[] = "GROUP_CONCAT(CASE WHEN m.id_materias = {$materia['id_materias']} THEN n.observaciones_notas END SEPARATOR ', ') AS observaciones_{$materia['id_materias']}";
}

$averageFieldsString = implode(", ", $averageFields);
$observationFieldsString = implode(", ", $observationFields);
$query = "
    SELECT $selectFields, $averageFieldsString, $observationFieldsString
    FROM alumnos AS a
    INNER JOIN grados AS b ON a.grados_alumnos = b.id_grados
    INNER JOIN subgrados AS c ON a.subgrados_alumnos = c.id_subgrados
    LEFT JOIN notas AS n ON a.id_alumnos = n.alumnos_notas
    LEFT JOIN materias AS m ON n.materias_notas = m.id_materias
    LEFT JOIN periodos AS p ON n.id_periodo = p.id_periodo
    GROUP BY 
        a.id_alumnos, a.lista_num_alumnos, a.nombres_alumnos, a.apellidos_alumnos, 
        a.genero_alumnos, b.nombre_grados, c.nombre_subgrados, p.nombre_periodo
    ORDER BY 
        a.apellidos_alumnos
";

$reporte = $conn->prepare($query);
$reporte->execute();
$alumnos = $reporte->fetchAll(PDO::FETCH_ASSOC);
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
                <a href="paneles.php">Misael Pastrana Borrero</a>
            </div>
            <div class="social">
                <div class="social-icon">
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
                    <th>No de<br>lista</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Género</th>
                    <th>Grado</th>
                    <th>Subgrado</th>
                    <th>Periodo</th>
                    <?php foreach ($materias as $materia) : ?>
                        <th><?php echo htmlspecialchars($materia['nombre_materias']); ?></th>
                        <th>Observaciones <?php echo htmlspecialchars($materia['nombre_materias']); ?></th> <!-- Nueva columna para observaciones -->
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($alumnos as $alumno) : ?>
                    <tr>
                        <td align="center"><?php echo htmlspecialchars($alumno['num_lista']); ?></td>
                        <td><?php echo htmlspecialchars($alumno['apellidos']); ?></td>
                        <td><?php echo htmlspecialchars($alumno['nombres']); ?></td>
                        <td align="center"><?php echo htmlspecialchars($alumno['genero']); ?></td>
                        <td align="center"><?php echo htmlspecialchars($alumno['grado']); ?></td>
                        <td align="center"><?php echo htmlspecialchars($alumno['subgrado']); ?></td>
                        <td align="center"><?php echo htmlspecialchars($alumno['periodo']); ?></td>
                        <?php foreach ($materias as $materia) : ?>
                            <td align="center">
                                <?php echo ($alumno["promedio_{$materia['id_materias']}"] !== null) ? number_format($alumno["promedio_{$materia['id_materias']}"], 2) : 'N/A'; ?>
                            </td>
                            <td align="center">
                                <?php echo htmlspecialchars($alumno["observaciones_{$materia['id_materias']}"]) ?: 'Sin observaciones'; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
</body>
</html>

