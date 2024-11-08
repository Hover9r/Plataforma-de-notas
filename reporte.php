<?php

    // fuentes -> https://www.youtube.com/watch?v=Nda2VRmy-n8
    // reportes -> https://www.youtube.com/watch?v=SlA7IbkwXoU

    // require "conexion.php";
    // require "./fpdf/fpdf186/fpdf.php";

    // // Consulta para obtener las materias
    // $materiasQuery = $conn->prepare("SELECT id_materias, nombre_materias FROM materias");
    // $materiasQuery->execute();
    // $materias = $materiasQuery->fetchAll(PDO::FETCH_ASSOC);

    // // Consulta para obtener los periodos
    // $periodosQuery = $conn->prepare("SELECT id_periodo, nombre_periodo FROM periodos");
    // $periodosQuery->execute();
    // $periodos = $periodosQuery->fetchAll(PDO::FETCH_ASSOC);

    // // Construcción de la consulta para obtener promedios por periodo y observaciones
    // $selectFields = "
    //     a.id_alumnos,
    //     a.lista_num_alumnos AS num_lista, 
    //     a.nombres_alumnos AS nombres, 
    //     a.apellidos_alumnos AS apellidos, 
    //     a.genero_alumnos AS genero, 
    //     b.nombre_grados AS grado, 
    //     c.nombre_subgrados AS subgrado,
    //     p.nombre_periodo AS periodo,
    //     GROUP_CONCAT(n.observaciones_notas SEPARATOR '; ') AS observaciones
    // ";

    // $averageFields = [];
    // foreach ($materias as $materia) {
    //     $averageFields[] = "AVG(CASE WHEN m.id_materias = {$materia['id_materias']} THEN n.nota_notas END) AS promedio_{$materia['id_materias']}";
    // }

    // $averageFieldsString = implode(", ", $averageFields);
    // $query = "
    //     SELECT $selectFields, $averageFieldsString
    //     FROM alumnos AS a
    //     INNER JOIN grados AS b ON a.grados_alumnos = b.id_grados
    //     INNER JOIN subgrados AS c ON a.subgrados_alumnos = c.id_subgrados
    //     LEFT JOIN notas AS n ON a.id_alumnos = n.alumnos_notas
    //     LEFT JOIN materias AS m ON n.materias_notas = m.id_materias
    //     LEFT JOIN periodos AS p ON n.id_periodo = p.id_periodo
    //     GROUP BY 
    //         a.id_alumnos, a.lista_num_alumnos, a.nombres_alumnos, a.apellidos_alumnos, 
    //         a.genero_alumnos, b.nombre_grados, c.nombre_subgrados, p.nombre_periodo
    //     ORDER BY 
    //         a.apellidos_alumnos
    // ";

    // $reporte = $conn->prepare($query);
    // $reporte->execute();
    // $reporte = $reporte->fetchAll(PDO::FETCH_ASSOC); 

    // $pdf = new FPDF("P", "mm", "letter");
    // $pdf->AddPage();
    // $pdf->SetMargins(10, 10, 10);
    // $pdf->SetFont("Arial", "B", 12);
    // $pdf->Cell(0, 10, "Reporte de estudiantes del colegio Misael Pastrana Borrero", 0, 1, "C");
    // $pdf->Ln(5); // Salto de línea

    // $pdf->SetFont('Arial', 'B', 9);
    // $pdf->Cell(20, 10, "No de lista", 1, 0, 'C');

    // $pdf->Cell(35, 10, "Apellidos", 1);
    // $pdf->Cell(35, 10, "Nombres", 1);
    // $pdf->Cell(15, 10, utf8_decode("Género"), 1);
    // $pdf->Cell(20, 10, "Grado", 1);
    // $pdf->Cell(20, 10, "Subgrado", 1);
    // $pdf->Cell(25, 10, "Periodo", 1);
    // $pdf->Cell(50, 10, "Observaciones", 1);

    // // Obtener las materias y agregar los encabezados de promedio
    // foreach ($materias as $materia) {
    //     $pdf->Cell(20, 10, $materia['nombre_materias'], 1);
    // }

    // $pdf->Ln();

    // // Establecer la fuente para los datos
    // $pdf->SetFont('Arial', '', 9);

    // // Agregar los datos de los alumnos
    // foreach ($reporte as $alumno) {
    //     $pdf->Cell(20, 10, htmlspecialchars($alumno['num_lista']), 1);
    //     $pdf->Cell(35, 10, htmlspecialchars($alumno['apellidos']), 1);
    //     $pdf->Cell(35, 10, htmlspecialchars($alumno['nombres']), 1);
    //     $pdf->Cell(15, 10, htmlspecialchars($alumno['genero']), 1);
    //     $pdf->Cell(20, 10, htmlspecialchars($alumno['grado']), 1);
    //     $pdf->Cell(20, 10, htmlspecialchars($alumno['subgrado']), 1);
    //     $pdf->Cell(25, 10, htmlspecialchars($alumno['periodo']), 1);
    //     $pdf->Cell(50, 10, htmlspecialchars($alumno['observaciones']), 1);

    //     // Mostrar los promedios de cada materia
    //     foreach ($materias as $materia) {
    //         $promedio = $alumno["promedio_{$materia['id_materias']}"];
    //         $pdf->Cell(20, 10, ($promedio !== null) ? number_format($promedio, 2) : 'N/A', 1);
    //     }
        
    //     $pdf->Ln();
    // }

    // // Salida del PDF
    // $pdf->Output('I', 'reporte_estudiantes.pdf'); // 'D' -> pdf 'I' -> mostrar en el navegador


    // fuentes -> https://www.youtube.com/watch?v=Nda2VRmy-n8
    // reportes -> https://www.youtube.com/watch?v=SlA7IbkwXoU

    require "./fpdf/fpdf186/fpdf.php";
    require "roles.php";

    permisos(['Administrador']);

    // Consulta para obtener los periodos
    $periodosQuery = $conn->prepare("SELECT id_periodo, nombre_periodo FROM periodos");
    $periodosQuery->execute();
    $periodos = $periodosQuery->fetchAll(PDO::FETCH_ASSOC);

    // Construcción de la consulta para obtener promedios totales por alumno
    $selectFields = "
        a.id_alumnos,
        a.lista_num_alumnos AS num_lista, 
        a.nombres_alumnos AS nombres, 
        a.apellidos_alumnos AS apellidos, 
        a.genero_alumnos AS genero, 
        b.nombre_grados AS grado, 
        c.nombre_subgrados AS subgrado,
        p.nombre_periodo AS periodo,
        AVG(n.nota_notas) AS promedio_total
    ";

    $query = "
        SELECT $selectFields
        FROM alumnos AS a
        INNER JOIN grados AS b ON a.grados_alumnos = b.id_grados
        INNER JOIN subgrados AS c ON a.subgrados_alumnos = c.id_subgrados
        LEFT JOIN notas AS n ON a.id_alumnos = n.alumnos_notas
        LEFT JOIN periodos AS p ON n.id_periodo = p.id_periodo
        GROUP BY 
            a.id_alumnos, a.lista_num_alumnos, a.nombres_alumnos, a.apellidos_alumnos, 
            a.genero_alumnos, b.nombre_grados, c.nombre_subgrados, p.nombre_periodo
        ORDER BY 
            a.apellidos_alumnos
    ";

    $reporte = $conn->prepare($query);
    $reporte->execute();
    $reporte = $reporte->fetchAll(PDO::FETCH_ASSOC); 

    $pdf = new FPDF("P", "mm", "letter");
    $pdf->SetMargins(10, 10, 10); // Establecer márgenes en todo el PDF
    $pdf->AddPage();
    $pdf->SetFont("Arial", "B", 12);
    $pdf->MultiCell(0, 10, "Reporte de Estudiantes - Colegio Misael Pastrana Borrero", 0, "C");
    $pdf->Ln(5); // Salto de línea

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 10, utf8_decode("código"), 1, 0, 'C');
    $pdf->Cell(35, 10, "Apellidos", 1, 0, 'C');
    $pdf->Cell(35, 10, "Nombres", 1, 0, 'C');
    $pdf->Cell(15, 10, utf8_decode("Género"), 1, 0, 'C');
    $pdf->Cell(20, 10, "Grado", 1, 0, 'C');
    $pdf->Cell(20, 10, "Subgrado", 1, 0, 'C');
    $pdf->Cell(25, 10, "Periodo", 1, 0, 'C');
    $pdf->Cell(25, 10, "Promedio Total", 1, 0, 'C');

    $pdf->Ln(); // Salto de línea para los datos

    // Establecer la fuente para los datos
    $pdf->SetFont('Arial', '', 9);

    // Agregar los datos de los alumnos
    foreach ($reporte as $alumno) {
        
        $pdf->Cell(20, 10, htmlspecialchars($alumno['num_lista']), 1);
        $pdf->Cell(35, 10, htmlspecialchars($alumno['apellidos']), 1);
        $pdf->Cell(35, 10, htmlspecialchars($alumno['nombres']), 1);
        $pdf->Cell(15, 10, htmlspecialchars($alumno['genero']), 1);
        $pdf->Cell(20, 10, htmlspecialchars($alumno['grado']), 1);
        $pdf->Cell(20, 10, htmlspecialchars($alumno['subgrado']), 1);
        $pdf->Cell(25, 10, htmlspecialchars($alumno['periodo']), 1);

        // Mostrar el promedio total
        $promedioTotal = $alumno['promedio_total'];
        $pdf->Cell(25, 10, ($promedioTotal !== null) ? number_format($promedioTotal, 2) : 'No Hay', 1);

        $pdf->Ln(); // Salto de línea después de cada fila
    }

    // Salida del PDF
    $pdf->Output('I', 'reporte_estudiantes.pdf'); // 'D' -> descarga, 'I' -> mostrar en el navegador

?>
