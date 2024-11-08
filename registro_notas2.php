<!DOCTYPE html>
<?php
    require 'roles.php';
    $permisos = ['Administrador','Profesor']; 
    permisos($permisos);

    // Consultar los subgrados en la BD
    $subgrados = $conn->prepare("SELECT * FROM subgrados");
    $subgrados->execute();
    $subgrados = $subgrados->fetchAll();

    // Consultar los grados en la BD
    $grados = $conn->prepare("SELECT * FROM grados");
    $grados->execute();
    $grados = $grados->fetchAll();

    // Consultar las materias en la BD
    $materias = $conn->prepare("SELECT * FROM materias");
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
                <h4>Registro y modificación de notas</h4>
                
                <?php if(!isset($_GET['ingresar'])){ ?>
                <form method="get" class="form" action="registro_notas2.php">
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
                    <label>Seleccione el Subgrado</label><br>
                    
                    <?php foreach ($subgrados as $subgrado): ?>
                        <input type="radio" name="subgrado" required value="<?php echo $subgrado['id_subgrados'] ?>">Subgrado <?php echo $subgrado['nombre_subgrados'] ?><br>
                    <?php endforeach; ?>
                    
                    <br><br>
                    <label>Seleccione el Periodo</label><br>
                    <select name="periodo" required>
                        <?php foreach ($periodos as $periodo): ?>
                            <option value="<?php echo $periodo['id_periodo'] ?>"><?php echo $periodo['nombre_periodo'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <br><br>

                    <button type="submit" name="ingresar" value="1">Ingresar Notas</button> 
                    <a class="btn-link" href="listado_notas2.php">Consultar Notas</a>
                    <br><br>
                </form>
                <?php
                    }
                ?>

                <?php
                if(isset($_GET['ingresar'])){
                    $id_materia = $_GET['materia'];
                    $id_grado = $_GET['grado'];
                    $id_subgrado = $_GET['subgrado'];
                    $id_periodo = $_GET['periodo'];

                    // Extrayendo el número de evaluaciones para esa materia seleccionada
                    $num_notas = $conn->prepare("SELECT cant_notas_materias FROM materias WHERE id_materias = ?");
                    $num_notas->execute([$id_materia]);
                    $num_notas = $num_notas->fetch()['cant_notas_materias'];

                    // Consultar los alumnos del grado, subgrado y materia seleccionados
                    $sqlalumnos = $conn->prepare("
                    SELECT 
                        a.id_alumnos, 
                        a.lista_num_alumnos, 
                        a.apellidos_alumnos, 
                        a.nombres_alumnos, 
                        AVG(b.nota_notas) AS promedio, 
                        MAX(b.observaciones_notas) AS observaciones
                    FROM 
                        alumnos AS a 
                    LEFT JOIN
                        notas AS b ON a.id_alumnos = b.alumnos_notas AND b.id_periodo = ? AND b.materias_notas = ?
                    WHERE 
                        a.grados_alumnos = ? 
                        AND a.subgrados_alumnos = ?
                    GROUP BY 
                        a.id_alumnos, 
                        a.lista_num_alumnos, 
                        a.apellidos_alumnos, 
                        a.nombres_alumnos
                    ");
                    $sqlalumnos->execute([$id_periodo, $id_materia, $id_grado, $id_subgrado]);
                    $alumnos = $sqlalumnos->fetchAll();
                    $num_alumnos = $sqlalumnos->rowCount();
                ?>
                <br>
                <a href="registro_notas2.php"><strong><< Volver</strong></a>
                <br><br>

                <?php if ($num_alumnos > 0): ?>
                <form action="procesar_notas.php" method="post">
                    <table class="table" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>No de lista</th><th>Apellidos</th><th>Nombres</th>
                            <?php for($i = 1; $i <= $num_notas; $i++): ?>
                                <th>Nota <?php echo $i; ?></th>
                            <?php endfor; ?>
                            <th>Promedio</th>
                            <th>Observaciones</th>
                            <th>Eliminar</th>
                        </tr>
                        <?php foreach ($alumnos as $index => $alumno): ?>
                            <input type="hidden" value="<?php echo $num_alumnos ?>" name="num_alumnos">
                            <input type="hidden" value="<?php echo $alumno['id_alumnos'] ?>" name="id_alumno<?php echo $index ?>">
                            <input type="hidden" value="<?php echo $num_notas ?>" name="num_notas">
                            <input type="hidden" value="<?php echo $id_materia ?>" name="id_materia">
                            <input type="hidden" value="<?php echo $id_grado ?>" name="id_grado">
                            <input type="hidden" value="<?php echo $id_subgrado ?>" name="id_subgrado">
                            <input type="hidden" value="<?php echo $id_periodo ?>" name="id_periodo">
                            
                            <tr> 
                            <td align="center"><?php echo $alumno['lista_num_alumnos'] ?></td>
                            <td><?php echo $alumno['apellidos_alumnos'] ?></td>
                            <td><?php echo $alumno['nombres_alumnos'] ?></td>
                            <?php
                            // Verificamos si el alumno tiene notas registradas
                            if (existeNota($alumno['id_alumnos'], $id_materia, $id_periodo, $conn) > 0) {
                                // Ya tiene notas registradas, obtenemos las notas existentes
                                $notas = $conn->prepare("SELECT id_notas, nota_notas FROM notas WHERE alumnos_notas = ? AND materias_notas = ? AND id_periodo = ?");
                                $notas->execute([$alumno['id_alumnos'], $id_materia, $id_periodo]);
                                $registrosnotas = $notas->fetchAll();
                                $cant_notas = $notas->rowCount(); // Contamos cuántas notas existen

                                // Iteramos sobre las notas ya registradas y las mostramos en los campos de texto
                                foreach ($registrosnotas as $eval => $nota) {
                                    echo '<input type="hidden" value="'.$nota['id_notas'].'" name="id_nota'.$eval.'alumno'.$index.'">';
                                    echo '<td><input type="number" step="any" name="nota'.$eval.'alumno'.$index.'" min="0" max="5" value="'.$nota['nota_notas'].'" required></td>';
                                }
                                // Completamos con campos vacíos si no tiene el número completo de notas
                                for($eval = $cant_notas; $eval < $num_notas; $eval++) {
                                    echo '<td><input type="number" step="any" name="nota'.$eval.'alumno'.$index.'" min="0" max="5" required></td>';
                                }
                            } else {
                                // No tiene notas registradas, generamos los campos de texto vacíos
                                for($eval = 0; $eval < $num_notas; $eval++) {
                                    echo '<td><input type="number" step="any" name="nota'.$eval.'alumno'.$index.'" min="0" max="5" required></td>';
                                }
                            }
                            ?>
                            <td><?php echo round($alumno['promedio'], 2); ?></td>
                            <td><input type="text" name="observaciones<?php echo $index ?>" value="<?php echo $alumno['observaciones'] ?>"></td>
                            <td><a href="borrar_nota.php?id_alumno=<?php echo $alumno['id_alumnos']; ?>&id_periodo=<?php echo $id_periodo; ?>&id_materia=<?php echo $id_materia; ?>">Eliminar</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                    <br>
                    
                    <button type="submit" name="guardar">Guardar</button>
                    <button type="reset">Limpiar</button> 
                    <a class="btn-link" href="listado_notas2.php">Consultar Notas</a>
                </form>
                <?php else: ?>
                    <p>No hay ningún estudiante registrado.</p>
                <?php endif; ?>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>

