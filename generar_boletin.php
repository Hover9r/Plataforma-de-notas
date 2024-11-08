<?php

//     require "./fpdf/fpdf186/fpdf.php";
//     require_once 'roles.php';


// // Verificar permisos de acceso
// $permisos = ['Administrador', 'Profesor', 'Padre', 'Estudiante'];
// permisos($permisos);

// // Asegurarse de que el ID del alumno está en la URL
// if (!isset($_GET['id_alumno']) || !isset($_GET['periodo'])) {
//     die('ID del alumno o período no encontrado.');
// }
    
// // Obtener ID del alumno y nombre del período de la URL
// $id_alumno = $_GET['id_alumno'];
// $nombre_periodo = $_GET['periodo'];

// // Asegurarse de que $nombre_periodo tenga un valor correcto
// if (empty($nombre_periodo)) {
//     die('El período no está definido.');
// }

// // Consultar el ID del período usando el nombre
// $periodoQuery = $conn->prepare("SELECT id_periodo FROM periodos WHERE nombre_periodo = :nombre_periodo");
// $periodoQuery->bindParam(':nombre_periodo', $nombre_periodo);
// $periodoQuery->execute();
// $id_periodo = $periodoQuery->fetchColumn();

// // Verificar si se encontró el ID del período
// if (!$id_periodo) {
//     die('Período no encontrado');
// }

// // Consulta para obtener las materias
// $materiasQuery = $conn->prepare("SELECT id_materias, nombre_materias FROM materias");
// $materiasQuery->execute();
// $materias = $materiasQuery->fetchAll(PDO::FETCH_ASSOC);

// // Construcción de la consulta para obtener promedios, observaciones y nombres de maestros por materia
// $selectFields = "
//     a.id_alumnos,
//     a.lista_num_alumnos AS num_lista, 
//     a.nombres_alumnos AS nombres, 
//     a.apellidos_alumnos AS apellidos, 
//     a.genero_alumnos AS genero, 
//     b.nombre_grados AS grado, 
//     c.nombre_subgrados AS subgrado,
//     p.nombre_periodo AS periodo
// ";

// $averageFields = [];
// $observationFields = [];
// $professorFields = [];

// foreach ($materias as $materia) {
//     // Calcular promedio
//     $averageFields[] = "ROUND(AVG(CASE WHEN m.id_materias = {$materia['id_materias']} AND n.id_periodo = :id_periodo THEN n.nota_notas END), 1) AS promedio_{$materia['id_materias']}";
    
//     // Obtener observaciones
//     $observationFields[] = "GROUP_CONCAT(DISTINCT CASE WHEN m.id_materias = {$materia['id_materias']} THEN n.observaciones_notas END SEPARATOR ', ') AS observaciones_{$materia['id_materias']}";
    
//     // Obtener nombres de los maestros por materia
//     $professorFields[] = "GROUP_CONCAT(DISTINCT CASE WHEN m.id_materias = {$materia['id_materias']} THEN CONCAT(ma.nombres_maestros, ' ', ma.apellidos_maestros) END SEPARATOR ', ') AS profesor_{$materia['id_materias']}";
// }

// $averageFieldsString = implode(", ", $averageFields);
// $observationFieldsString = implode(", ", $observationFields);
// $professorFieldsString = implode(", ", $professorFields);

// $query = "
//     SELECT 
//         $selectFields, 
//         $averageFieldsString, 
//         $observationFieldsString, 
//         $professorFieldsString
//     FROM alumnos AS a
//     INNER JOIN grados AS b ON a.grados_alumnos = b.id_grados
//     INNER JOIN subgrados AS c ON a.subgrados_alumnos = c.id_subgrados
//     LEFT JOIN notas AS n ON a.id_alumnos = n.alumnos_notas
//     LEFT JOIN materias AS m ON n.materias_notas = m.id_materias
//     LEFT JOIN maestros AS ma ON m.maestros_materias = ma.id_maestros
//     LEFT JOIN periodos AS p ON n.id_periodo = p.id_periodo
//     WHERE a.id_alumnos = :id_alumno AND n.id_periodo = :id_periodo
//     GROUP BY 
//         a.id_alumnos, a.lista_num_alumnos, a.nombres_alumnos, a.apellidos_alumnos, 
//         a.genero_alumnos, b.nombre_grados, c.nombre_subgrados, p.nombre_periodo
//     ORDER BY 
//         a.apellidos_alumnos
// ";

// // Preparar y ejecutar la consulta
// $reporte = $conn->prepare($query);
// $reporte->bindParam(':id_alumno', $id_alumno);
// $reporte->bindParam(':id_periodo', $id_periodo);
// $reporte->execute();
// $reporte = $reporte->fetch(PDO::FETCH_ASSOC);

// // Comprobar si se obtuvo algún dato
// if (!$reporte) {
//     header('Location: boletin.php?err=error');
//     exit();
// }

// // Generar boletín
// $pdf = new FPDF(); 
// $pdf->AddPage();
// $pdf->SetFont('Arial', 'B', 16);
// $pdf->Cell(0, 10, utf8_decode('Boletín de Notas'), 0, 1, 'C');

// $pdf->SetFont('Arial', 'B', 12);
// $pdf->Cell(40, 10, 'Nombre Completo:', 1);
// $pdf->Cell(150, 10, $reporte['nombres'] . ' ' . $reporte['apellidos'], 1);
// $pdf->Ln();
// $pdf->Cell(40, 10, utf8_decode('Código:'), 1);
// $pdf->Cell(30, 10, $reporte['num_lista'], 1);
// $pdf->Cell(30, 10, 'Grado:', 1);
// $pdf->Cell(40, 10, $reporte['grado'], 1);
// $pdf->Cell(30, 10, 'Subgrado:', 1);
// $pdf->Cell(20, 10, $reporte['subgrado'], 1);
// $pdf->Ln(10);
// $pdf->Cell(40, 10, 'Periodo:', 1);
// $pdf->Cell(150, 10, $reporte['periodo'], 1);
// $pdf->Ln(10);

// // Tabla de materias
// $pdf->SetFont('Arial', 'B', 12);
// $pdf->Cell(80, 10, 'Materia', 1);
// $pdf->Cell(40, 10, 'Profesor', 1);
// $pdf->Cell(30, 10, 'Promedio', 1);
// $pdf->Cell(40, 10, 'Rendimiento', 1);
// $pdf->Ln();

// $pdf->SetFont('Arial', '', 12);
// foreach ($materias as $materia) {
//     $materia_id = $materia['id_materias'];
//     $promedio = isset($reporte["promedio_$materia_id"]) ? $reporte["promedio_$materia_id"] : 'No hay';
//     $observacion_materia = isset($reporte["observaciones_$materia_id"]) ? $reporte["observaciones_$materia_id"] : '';
//     $profesor_materia = isset($reporte["profesor_$materia_id"]) ? $reporte["profesor_$materia_id"] : 'No hay';

//     // Calcular rendimiento basado en el promedio
//     if ($promedio !== 'N/A') {
//         $rendimiento_materia = '';
//         if ($promedio >= 4.5 && $promedio <= 5.0) {
//             $rendimiento_materia = 'Superior';
//         } elseif ($promedio >= 4.0 && $promedio < 4.5) {
//             $rendimiento_materia = 'Alto';
//         } elseif ($promedio >= 3.5 && $promedio < 4.0) {
//             $rendimiento_materia = 'Básico';
//         } elseif ($promedio >= 0.0 && $promedio < 3.5) {
//             $rendimiento_materia = 'Bajo';
//         }
//     } else {
//         $rendimiento_materia = 'No hay';
//     }

//     // Mostrar datos en una fila
//     $pdf->Cell(80, 10, utf8_decode($materia['nombre_materias']), 1);
//     $pdf->Cell(40, 10, utf8_decode($profesor_materia), 1);
//     $pdf->Cell(30, 10, $promedio, 1);
//     $pdf->Cell(40, 10, utf8_decode($rendimiento_materia), 1);
//     $pdf->Ln();

//     // Concatenar el título con el contenido
//     $texto_completo = 'Observaciones: ' . utf8_decode($observacion_materia);

//     // Usar MultiCell para permitir múltiples líneas
//     $pdf->MultiCell(190, 10, $texto_completo, 1);
// }

// // Salida del PDF
// $pdf->Output('I', 'boletin_' . $reporte['nombres'] . '_' . $reporte['apellidos'] . '.pdf');

require "./fpdf/fpdf186/fpdf.php";
require_once 'roles.php';

// Verificar permisos de acceso
$permisos = ['Administrador', 'Profesor', 'Padre', 'Estudiante'];
permisos($permisos);

// Asegurarse de que el ID del alumno está en la URL
if (!isset($_GET['id_alumno']) || !isset($_GET['periodo'])) {
    die('ID del alumno o período no encontrado.');
}
    
// Obtener ID del alumno y nombre del período de la URL
$id_alumno = $_GET['id_alumno'];
$nombre_periodo = $_GET['periodo'];

// Asegurarse de que $nombre_periodo tenga un valor correcto
if (empty($nombre_periodo)) {
    die('El período no está definido.');
}

// Consultar el ID del período usando el nombre
$periodoQuery = $conn->prepare("SELECT id_periodo FROM periodos WHERE nombre_periodo = :nombre_periodo");
$periodoQuery->bindParam(':nombre_periodo', $nombre_periodo);
$periodoQuery->execute();
$id_periodo = $periodoQuery->fetchColumn();

if (!$id_periodo) {
    die('Período no encontrado');
}

// Consulta para obtener las materias
$materiasQuery = $conn->prepare("SELECT id_materias, nombre_materias FROM materias");
$materiasQuery->execute();
$materias = $materiasQuery->fetchAll(PDO::FETCH_ASSOC);

// Construcción de la consulta para obtener promedios, observaciones y nombres de maestros por materia
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
$professorFields = [];

foreach ($materias as $materia) {
    $averageFields[] = "ROUND(AVG(CASE WHEN m.id_materias = {$materia['id_materias']} AND n.id_periodo = :id_periodo THEN n.nota_notas END), 1) AS promedio_{$materia['id_materias']}";
    $observationFields[] = "GROUP_CONCAT(DISTINCT CASE WHEN m.id_materias = {$materia['id_materias']} THEN n.observaciones_notas END SEPARATOR ', ') AS observaciones_{$materia['id_materias']}";
    $professorFields[] = "GROUP_CONCAT(DISTINCT CASE WHEN m.id_materias = {$materia['id_materias']} THEN CONCAT(ma.nombres_maestros, ' ', ma.apellidos_maestros) END SEPARATOR ', ') AS profesor_{$materia['id_materias']}";
}

$averageFieldsString = implode(", ", $averageFields);
$observationFieldsString = implode(", ", $observationFields);
$professorFieldsString = implode(", ", $professorFields);

$query = "
    SELECT 
        $selectFields, 
        $averageFieldsString, 
        $observationFieldsString, 
        $professorFieldsString
    FROM alumnos AS a
    INNER JOIN grados AS b ON a.grados_alumnos = b.id_grados
    INNER JOIN subgrados AS c ON a.subgrados_alumnos = c.id_subgrados
    LEFT JOIN notas AS n ON a.id_alumnos = n.alumnos_notas
    LEFT JOIN materias AS m ON n.materias_notas = m.id_materias
    LEFT JOIN maestros AS ma ON m.maestros_materias = ma.id_maestros
    LEFT JOIN periodos AS p ON n.id_periodo = p.id_periodo
    WHERE a.id_alumnos = :id_alumno AND n.id_periodo = :id_periodo
    GROUP BY 
        a.id_alumnos, a.lista_num_alumnos, a.nombres_alumnos, a.apellidos_alumnos, 
        a.genero_alumnos, b.nombre_grados, c.nombre_subgrados, p.nombre_periodo
    ORDER BY 
        a.apellidos_alumnos
";

$reporte = $conn->prepare($query);
$reporte->bindParam(':id_alumno', $id_alumno);
$reporte->bindParam(':id_periodo', $id_periodo);
$reporte->execute();
$reporte = $reporte->fetch(PDO::FETCH_ASSOC);

if (!$reporte) {
    header('Location: boletin.php?err=error');
    exit();
}

// Generar boletín
$pdf = new FPDF(); 
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, utf8_decode('Boletín de Notas'), 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nombre Completo:', 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, $reporte['nombres'] . ' ' . $reporte['apellidos'], 1);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, utf8_decode('Código:'), 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, $reporte['num_lista'], 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Grado:', 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(40, 10, $reporte['grado'], 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Subgrado:', 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(20, 10, $reporte['subgrado'], 1);
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Periodo:', 1);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(150, 10, $reporte['periodo'], 1);
$pdf->Ln(10);

// Tabla de materias
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Materia', 1);
$pdf->Cell(75, 10, 'Profesor', 1);
$pdf->Cell(25, 10, 'Promedio', 1);
$pdf->Cell(30, 10, 'Rendimiento', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);
foreach ($materias as $materia) {
    $materia_id = $materia['id_materias'];
    $promedio = isset($reporte["promedio_$materia_id"]) ? $reporte["promedio_$materia_id"] : 'No hay';
    $observacion_materia = isset($reporte["observaciones_$materia_id"]) ? $reporte["observaciones_$materia_id"] : '';
    $profesor_materia = isset($reporte["profesor_$materia_id"]) ? $reporte["profesor_$materia_id"] : 'No hay';

    if ($promedio !== 'N/A') {
        $rendimiento_materia = '';
        if ($promedio >= 4.5 && $promedio <= 5.0) {
            $rendimiento_materia = 'Superior';
        } elseif ($promedio >= 4.0 && $promedio < 4.5) {
            $rendimiento_materia = 'Alto';
        } elseif ($promedio >= 3.5 && $promedio < 4.0) {
            $rendimiento_materia = 'Básico';
        } elseif ($promedio >= 0.0 && $promedio < 3.5) {
            $rendimiento_materia = 'Bajo';
        }
    } else {
        $rendimiento_materia = 'No hay';
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(60, 10, utf8_decode($materia['nombre_materias']), 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(75, 10, utf8_decode($profesor_materia), 1);
    $pdf->Cell(25, 10, $promedio, 1);
    $pdf->Cell(30, 10, utf8_decode($rendimiento_materia), 1);
    $pdf->Ln();

    $texto_completo = 'Observaciones: ' . utf8_decode($observacion_materia);
    $pdf->MultiCell(190, 10, $texto_completo, 1);
}

$pdf->Output('I', 'boletin_' . $reporte['nombres'] . '_' . $reporte['apellidos'] . '.pdf');



    
?>