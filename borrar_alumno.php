<?php

    require 'conexion.php';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        try {
            $conn->beginTransaction();

            // Obtener el usuario asociado
            $stmt = $conn->prepare("
                SELECT login_alumnos FROM alumnos WHERE id_alumnos = :id
            ");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $login_id = $stmt->fetchColumn();

            // Eliminar el alumno
            $stmt = $conn->prepare("DELETE FROM alumnos WHERE id_alumnos = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Eliminar el usuario
            $stmt = $conn->prepare("DELETE FROM login WHERE id_login = :login_id");
            $stmt->bindParam(':login_id', $login_id);
            $stmt->execute();

            $conn->commit();
            header('Location: listado_alumno.php?borrado=borrado');
            exit();
        } catch (Exception $e) {
            $conn->rollBack();
            echo 'Error al eliminar: ' . $e->getMessage();
        }
    } else {
        echo 'ID de alumno no proporcionado';
    }

?>

