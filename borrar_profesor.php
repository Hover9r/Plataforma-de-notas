<?php

    require 'conexion.php';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
    
        try {
            // Iniciar transacción
            $conn->beginTransaction();
    
            // Obtener el ID de login asociado al profesor
            $stmt = $conn->prepare("
                SELECT login_maestros FROM maestros WHERE id_maestros = :id
            ");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $login_id = $stmt->fetchColumn();
    
            if (!$login_id) {
                throw new Exception("ID de login no encontrado para el profesor.");
            }
    
            // Eliminar la relación del profesor con las materias
            $stmt = $conn->prepare("DELETE FROM maestros_materias WHERE id_maestros = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            // Eliminar el profesor
            $stmt = $conn->prepare("DELETE FROM maestros WHERE id_maestros = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
    
            // Eliminar el usuario
            $stmt = $conn->prepare("DELETE FROM login WHERE id_login = :login_id");
            $stmt->bindParam(':login_id', $login_id);
            $stmt->execute();
    
            // Confirmar transacción
            $conn->commit();
    
            // Redireccionar con mensaje de éxito
            header('Location: listado_profesores.php?info=borrado');
            exit();
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $conn->rollBack();
            echo 'Error al eliminar: ' . $e->getMessage();
        }
    } else {
        echo 'ID de profesor no proporcionado';
    }
    
?>
