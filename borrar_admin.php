<?php

    require 'conexion.php';

    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        try {
            // Iniciar transacción
            $conn->beginTransaction();

            // Obtener el ID de login asociado al administrador
            $stmt = $conn->prepare("
                SELECT login_admin FROM administradores WHERE id_admin = :id
            ");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $login_id = $stmt->fetchColumn();

            if (!$login_id) {
                throw new Exception("ID de login no encontrado para el administrador.");
            }

            // Eliminar el administrador
            $stmt = $conn->prepare("DELETE FROM administradores WHERE id_admin = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Eliminar el usuario
            $stmt = $conn->prepare("DELETE FROM login WHERE id_login = :login_id");
            $stmt->bindParam(':login_id', $login_id);
            $stmt->execute();

            // Confirmar transacción
            $conn->commit();

            // Redireccionar con mensaje de éxito
            header('Location: listado_admin.php?info=borrado');
            exit();
        } catch (Exception $e) {
            // Revertir transacción en caso de error
            $conn->rollBack();
            echo 'Error al eliminar: ' . $e->getMessage();
        }
    } else {
        echo 'ID de administrador no proporcionado';
    }

?>
