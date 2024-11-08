<!DOCTYPE html>
<?php
    require 'roles.php';
    $permisos = ['Administrador','Profesor','Padre','Estudiante']; 
    permisos($permisos);

    // Consultar los subgrados en la BD
    $subgrados = $conn->prepare("select * from subgrados");
    $subgrados->execute();
    $subgrados = $subgrados->fetchAll();

    // Consultar los grados en la BD
    $grados = $conn->prepare("select * from grados");
    $grados->execute();
    $grados = $grados->fetchAll();

    // Consultar las materias en la BD
    $materias = $conn->prepare("select * from materias");
    $materias->execute();
    $materias = $materias->fetchAll();

    // Consultar los periodos en la BD
    $periodos = $conn->prepare("SELECT * FROM periodos");
    $periodos->execute();
    $periodos = $periodos->fetchAll();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paneles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://kit.fontawesome.com/4c9a3d6a1f.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="./img/logopas-png.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&family=Open+Sans:ital,wght@1,600&display=swap" rel="stylesheet">
    <title>Proyecto Final</title>
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
                <h4>Consultar notas</h4>

                <?php if(!isset($_GET['consultar'])): ?>
                    <p>Seleccione el grado, la materia, la sección y el periodo</p>
                    <form method="get" class="form" action="listado_notas2.php">
                        <label>Seleccione el Grado</label><br>
                        <select name="grado" required>
                            <?php foreach ($grados as $grado): ?>
                                <option value="<?php echo $grado['id_grados'] ?>"><?php echo $grado['nombre_grados'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
                        <label>Seleccione la Materia</label><br>
                        <select name="materia" required>
                            <?php foreach ($materias as $materia): ?>
                                <option value="<?php echo $materia['id_materias'] ?>"><?php echo $materia['nombre_materias'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
                        <label>Seleccione el subgrado</label><br><br>
                        <?php foreach ($subgrados as $subgrado): ?>
                            <input type="radio" name="subgrado" required value="<?php echo $subgrado['id_subgrados'] ?>"> Subgrado <?php echo $subgrado['nombre_subgrados'] ?><br>
                        <?php endforeach; ?>
                        <br>
                        <label>Seleccione el Periodo</label><br>
                        <select name="periodo" required>
                            <?php foreach ($periodos as $periodo): ?>
                                <option value="<?php echo $periodo['id_periodo'] ?>"><?php echo $periodo['nombre_periodo'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br>
                        <button type="submit" name="consultar" value="1">Consultar Notas</button>
                        <br><br>
                    </form>
                <?php endif; ?>
                <hr>

                <?php if(isset($_GET['consultar'])): ?>
                    <?php
                    $id_materia = $_GET['materia'];
                    $id_grado = $_GET['grado'];
                    $id_subgrado = $_GET['subgrado'];
                    $id_periodo = $_GET['periodo'];

                    // Extraer el número de evaluaciones para la materia seleccionada
                    $num_notas = $conn->prepare("SELECT cant_notas_materias FROM materias WHERE id_materias = ?");
                    $num_notas->execute([$id_materia]);
                    $num_notas = $num_notas->fetch()['cant_notas_materias'];

                    // Obtener los alumnos del grado y subgrado seleccionados
                    $sqlalumnos = $conn->prepare("
                        SELECT 
                            a.id_alumnos, 
                            a.lista_num_alumnos, 
                            a.apellidos_alumnos, 
                            a.nombres_alumnos, 
                            b.observaciones_notas,
                            AVG(b.nota_notas) as promedio
                        FROM 
                            alumnos AS a 
                        LEFT JOIN 
                            notas AS b ON a.id_alumnos = b.alumnos_notas 
                            AND b.materias_notas = ? 
                            AND b.id_periodo = ?
                        WHERE 
                            grados_alumnos = ? 
                            AND subgrados_alumnos = ?
                        GROUP BY 
                            a.id_alumnos, 
                            a.lista_num_alumnos, 
                            a.apellidos_alumnos, 
                            a.nombres_alumnos, 
                            b.observaciones_notas
                    ");
                    $sqlalumnos->execute([$id_materia, $id_periodo, $id_grado, $id_subgrado]);
                    $alumnos = $sqlalumnos->fetchAll();
                    $num_alumnos = $sqlalumnos->rowCount();
                    $promediototal = 0.0;
                    ?>
                    <br>
                    <a href="listado_notas2.php"><strong><< Volver</strong></a>
                    <br><br>

                    <table class="table" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>No de lista</th><th>Apellidos</th><th>Nombres</th>
                            <?php for($i = 1; $i <= $num_notas; $i++): ?>
                                <th>Nota <?php echo $i ?></th>
                            <?php endfor; ?>
                            <th>Promedio</th>
                            <th>Observaciones</th>
                        </tr>
                        <?php foreach ($alumnos as $alumno): ?>
                        <tr>
                            <td align="center"><?php echo $alumno['lista_num_alumnos'] ?></td>
                            <td><?php echo $alumno['apellidos_alumnos'] ?></td>
                            <td><?php echo $alumno['nombres_alumnos'] ?></td>
                            <?php
                                // Obtener las notas del alumno para la materia y el periodo seleccionados
                                $notas = $conn->prepare("SELECT nota_notas FROM notas WHERE alumnos_notas = ? AND materias_notas = ? AND id_periodo = ?");
                                $notas->execute([$alumno['id_alumnos'], $id_materia, $id_periodo]);
                                $notasArray = $notas->fetchAll(PDO::FETCH_COLUMN);

                                // Mostrar las notas o 0 si no existen
                                for ($i = 0; $i < $num_notas; $i++) {
                                    echo '<td align="center">' . ($notasArray[$i] ?? 0) . '</td>';
                                }
                                echo '<td align="center">' . number_format($alumno['promedio'], 2) . '</td>';
                                $promediototal += $alumno['promedio'];
                                echo '<td>' . $alumno['observaciones_notas'] . '</td>';
                            ?>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3">Promedio General:</td>
                            <?php for($i = 0; $i < $num_notas; $i++): ?>
                                <td></td>
                            <?php endfor; ?>
                            <td align="center">
                                <?php echo $num_alumnos > 0 ? number_format($promediototal / $num_alumnos, 2) : 'N/A'; ?>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    <br>

                <?php endif; ?>
            </div>
        </div>
    </div>        
</body>    
</html>
