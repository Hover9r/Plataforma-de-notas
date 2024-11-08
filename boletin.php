<?php
require 'roles.php';

$permisos = ['Administrador', 'Profesor', 'Padre', 'Estudiante'];
permisos($permisos);

// // Inicializar la variable de mensaje de error
// $error_message = 'Boletin no disponible';

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['username'];

// Consulta para obtener el id_login de la tabla login
$stmt = $conn->prepare("SELECT id_login FROM login WHERE usuario_login = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$idlogin = $stmt->fetchColumn();

// Verificar si se encontró el id_login
if (!$idlogin) {
    $error_message = 'Usuario no encontrado';
}

// Obtener el rol del usuario desde la base de datos
$stmt_rol = $conn->prepare("SELECT rol_login FROM login WHERE id_login = :idlogin");
$stmt_rol->bindParam(':idlogin', $idlogin);
$stmt_rol->execute();
$rol_usuario = $stmt_rol->fetchColumn();

// Almacenar el ID del alumno solo si el usuario es un estudiante
if ($rol_usuario === 'Estudiante') {
    $stmt_alumno = $conn->prepare("SELECT id_alumnos FROM alumnos WHERE login_alumnos = :idlogin");
    $stmt_alumno->bindParam(':idlogin', $idlogin);
    $stmt_alumno->execute();
    $id_alumno = $stmt_alumno->fetchColumn();

    // Verificar si se encontró el id_alumno
    if (!$id_alumno) {
        $error_message = 'Alumno no encontrado';
    } else {
        // Almacenar el id_alumno en la sesión para uso posterior
        $_SESSION['id_alumno'] = $id_alumno;
    }
} elseif ($rol_usuario === 'Padre') {
    // Obtener el ID del hijo asociado al padre
    $stmt_hijo = $conn->prepare("SELECT id_alumnos FROM alumnos WHERE padres_alumnos = :idlogin");
    $stmt_hijo->bindParam(':idlogin', $idlogin);
    $stmt_hijo->execute();
    $id_hijo = $stmt_hijo->fetchColumn();

    // Verificar si se encontró el id_hijo
    if ($id_hijo) {
        // Redirigir al boletín del hijo
        header("Location: generar_boletin.php?id_alumno=" . $id_hijo);
        exit;
    } else {
        $error_message = 'No se encontró el hijo asociado a este padre.';
    }
} else {
    // Si el usuario es un administrador o profesor, mostrar un selector de estudiantes
    $stmt_estudiantes = $conn->prepare("SELECT id_alumnos, nombres_alumnos, apellidos_alumnos FROM alumnos");
    $stmt_estudiantes->execute();
    $estudiantes = $stmt_estudiantes->fetchAll(PDO::FETCH_ASSOC);
}

// Consultar los periodos en la BD
$periodos = $conn->prepare("SELECT * FROM periodos");
$periodos->execute();
$periodos = $periodos->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
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
    <title>Listado de Maestros</title>
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
        <h2>Usuario: <?php echo htmlspecialchars($_SESSION["username"]); ?></h2>
    </div>
    <div class="panel">
        <div class="contenido-panel">
            <!-- Mostrar mensaje de error si existe -->
            <!-- <?php if ($error_message): ?>
                <div class="">
                    <p><?php echo htmlspecialchars($error_message); ?></p>
                </div>
            <?php endif; ?> -->
            <?php  if (isset($_GET['err'])) {
                    echo '<span class="error">Boletin no disponible</span>';
                }
            ?>
            

            <div class="row">
                <div class="col2">
                    <a class="aa" href="reporte.php">
                        <div class="boton">
                            <img class="icono" src="./img/ver.png" alt="">
                            <p class="separador">Reporte de estudiantes</p>
                        </div>
                    </a>
                </div>
                <div class="col2">
                <div class="sinboton">
                        <img src="" alt="" class="icono">
                        <p class="separador"></p>
                    </div>
                </div>
                <div class="col2">
                    <div class="sinboton">
                        <img src="" alt="" class="icono">
                        <p class="separador"></p>
                    </div>
                </div>
                <div class="col2">
                    <div class="sinboton">
                        <img src="" alt="" class="icono">
                        <p class="separador"></p>
                    </div>
                </div>
            </div>
            <?php if ($rol_usuario !== 'Estudiante' && $rol_usuario !== 'Padre'): ?>
                <form method="GET" action="">
                    <label for="estudiante">Seleccionar Estudiante:</label>
                    <select name="estudiante" id="estudiante">
                        <?php foreach ($estudiantes as $estudiante): ?>
                            <option value="<?php echo $estudiante['id_alumnos']; ?>">
                                <?php echo htmlspecialchars($estudiante['nombres_alumnos'] . ' ' . $estudiante['apellidos_alumnos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Seleccionar</button>
                </form>

                <?php if (isset($_GET['estudiante'])): ?>
                    <?php $_SESSION['id_alumno'] = $_GET['estudiante']; ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['id_alumno'])): ?>
                <div class="row">
                    <?php foreach ($periodos as $periodo): ?>
                        <div class="col2">
                            <?php $url = "generar_boletin.php?id_alumno=" . $_SESSION['id_alumno'] . "&periodo=" . urlencode($periodo['nombre_periodo']); ?>
                            <a class="aa" href="<?php echo $url; ?>">
                                <div class="boton">
                                    <img class="icono" src="./img/prin.png" alt="">
                                    <p class="separador">Generar Boletín <?php echo htmlspecialchars($periodo['nombre_periodo']); ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        
        </div>
    </div>
</div>
</body>
</html>






