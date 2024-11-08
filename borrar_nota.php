<?php

    require 'roles.php';

    if($_SESSION['rol'] =='Administrador') {
        if (isset($_GET['idalumno']) && isset($_GET['idmateria']) && is_numeric($_GET['idalumno'])) {
            try {
                // $id_alumno = $_GET['idalumno'];
                // $id_materia = $_GET['idmateria'];
                // $alumno = $conn->prepare("delete from notas where alumnos_notas = " . $id_alumno . " and materias_notas = " . $id_materia);
                // $alumno->execute();
                $id_alumno = $_GET['idalumno'];
                $id_materia = $_GET['idmateria'];
                $id_periodo = $_GET['idperiodo'];

                $stmt = $conn->prepare("DELETE FROM notas WHERE alumnos_notas = ? AND materias_notas = ? AND id_periodo = ?");
                $stmt->execute([$id_alumno, $id_materia, $id_periodo]);

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            die('Ha ocurrido un error');
        }
    }else{
        header('paneles.php?err=1');
    }
    
?>