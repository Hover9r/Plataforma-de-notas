<?php

    // if(!$_POST){
    //     header('location: registro_estudiantes.php');
    // }
    // else {
    //     //incluimos el archivo para hacer la conexion
    //     require 'roles.php';
    //     //Recuperamos los valores que vamos a llenar en la BD
    //     $id_materia = htmlentities($_POST ['id_materia']);
    //     $id_grado = htmlentities($_POST ['id_grado']);
    //     $id_subgrado = htmlentities($_POST ['id_subgrado']);
    //     $num_notas = htmlentities($_POST ['num_notas']);
    //     $num_alumnos = htmlentities($_POST['num_alumnos']);

    //     //guardar es el nombre del boton guardar que esta en el archivo registro_notas.php
    //     if (isset($_POST['guardar'])){

    //         /*Recorro el numero de estudiantes*/
    //         for($i = 0; $i < $num_alumnos; $i++){
    //             $id_alumno = htmlentities($_POST['id_alumno' . $i]);
    //             //por cada estudiante se recorre el numero de evaluaciones para extraer la nota de cada una
    //                 //funcion existeNota en roles.php valida que la nota no exista segun el alumno y la materia
    //                 if(existeNota($id_alumno,$id_materia,$conn) == 0){
    //                     for($j = 0; $j < $num_notas; $j++) {
    //                         $nota = htmlentities($_POST['evaluacion' . $j . 'alumno' . $i]);
    //                         $observaciones = htmlentities($_POST['observaciones' . $i]);
    //                         $sql_insert = "insert into notas (alumnos_notas, materias_notas, nota_notas, observaciones_notas) values ('$id_alumno', '$id_materia', '$nota','$observaciones' )";
    //                         $result = $conn->query($sql_insert);
    //                     }
    //                 }elseif(existeNota($id_alumno,$id_materia,$conn) > 0){
    //                     //hace una actualizacion o update
    //                     for($j = 0; $j < $num_notas; $j++) {
    //                         $id_nota = htmlentities($_POST['idnota' . $j . 'alumno' . $i]);
    //                         $nota = htmlentities($_POST['evaluacion' . $j . 'alumno' . $i]);
    //                         $observaciones = htmlentities($_POST['observaciones' . $i]);
    //                         $sql_query = "update notas set nota_notas = '$nota', observaciones_notas = '$observaciones' where id_notas = ".$id_nota;
    //                         $result = $conn->query($sql_query);
    //                     }
    //                 }

    //         }
    //         if (isset($result)) {
    //             header('location:registro_notas.php?grado='.$id_grado.'&materia='.$id_materia.'&subgrado='.$id_subgrado.'&revisar=1&info=1');
    //         } else {
    //             header('location:registro_notas.php?grado='.$id_grado.'&materia='.$id_materia.'&subgrado='.$id_subgrado.'&revisar=1&err=1');
    //         }// validación de registro*/

    //     //sino boton modificar que esta en el archivo registro_estudiantes.php
    //     }else if (isset($_POST['modificar'])) {
    //         //capturamos el id alumnos a modificar
    //             $id_alumno = htmlentities($_POST['id']);
    //             $result = $conn->query("update alumnos set lista_num_alumnos = '$numlista', nombres_alumnos = '$nombres', apellidos_alumnos = '$apellidos', genero_alumnos = '$genero',grados_alumnos = '$idgrado', subgrados_alumnos = '$idseccion' where id_alumnos = " . $id_alumno);
    //             if (isset($result)) {
    //                 header('location:registro_estudiantes.php?id=' . $id_alumno . '&info=1');
    //             } else {
    //                 header('location:registro_estudiantes.php?id=' . $id_alumno . '&err=1');
    //             }// validación de registro

    //     }

    // }



if (!$_POST) {
    header('location: registro_notas2.php');
} else {
    require 'roles.php';
    $permisos = ['Administrador','Profesor']; 
    permisos($permisos);

    // Recuperamos los valores que vamos a llenar en la BD
    $id_materia = htmlentities($_POST['id_materia']);
    $id_grado = htmlentities($_POST['id_grado']);
    $id_subgrado = htmlentities($_POST['id_subgrado']);
    $num_notas = htmlentities($_POST['num_notas']);
    $num_alumnos = htmlentities($_POST['num_alumnos']);
    $id_periodo = htmlentities($_POST['id_periodo']);
    
    // guardar es el nombre del botón guardar que está en el archivo registro_notas2.php
    if (isset($_POST['guardar'])) {
        /* Recorro el número de estudiantes */
        for ($i = 0; $i < $num_alumnos; $i++) {
            $id_alumno = htmlentities($_POST['id_alumno' . $i]);
            // Por cada estudiante, se recorre el número de evaluaciones para extraer la nota de cada una
            // Función existeNota valida que la nota no exista según el alumno, la materia y el periodo
            if (existeNota($id_alumno, $id_materia, $id_periodo, $conn) == 0) {
                for ($j = 0; $j < $num_notas; $j++) {
                    $nota = htmlentities($_POST['nota' . $j . 'alumno' . $i]);
                    $observaciones = htmlentities($_POST['observaciones' . $i]);
                    $sql_insert = "INSERT INTO notas (alumnos_notas, materias_notas, nota_notas, observaciones_notas, id_periodo) VALUES ('$id_alumno', '$id_materia', '$nota', '$observaciones', '$id_periodo')";
                    $result = $conn->query($sql_insert);
                }
            } elseif (existeNota($id_alumno, $id_materia, $id_periodo, $conn) > 0) {
                // Hace una actualización o update
                for ($j = 0; $j < $num_notas; $j++) {
                    $id_nota = htmlentities($_POST['id_nota' . $j . 'alumno' . $i]);
                    $nota = htmlentities($_POST['nota' . $j . 'alumno' . $i]);
                    $observaciones = htmlentities($_POST['observaciones' . $i]);
                    $sql_query = "UPDATE notas SET nota_notas = '$nota', observaciones_notas = '$observaciones' WHERE id_notas = " . $id_nota;
                    $result = $conn->query($sql_query);
                }
            }
        }

        if (isset($result)) {
            header('location: registro_notas2.php?grado=' . $id_grado . '&materia=' . $id_materia . '&subgrado=' . $id_subgrado . '&periodo=' . $id_periodo . '&revisar=1&info=1');
        } else {
            header('location: registro_notas2.php?grado=' . $id_grado . '&materia=' . $id_materia . '&subgrado=' . $id_subgrado . '&periodo=' . $id_periodo . '&revisar=1&err=1');
        } // validación de registro
    }
}



?>