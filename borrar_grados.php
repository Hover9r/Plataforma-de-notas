<?php


require 'conexion.php';

if (isset($_POST['id'])) {
    $grado_id = $_POST['id'];

    try {
        // Iniciar la transacción
        $conn->beginTransaction();

        // Establecer `grado_id` en NULL en los subgrados asociados
        $stmt = $conn->prepare("UPDATE subgrados SET grado_id = NULL WHERE grado_id = :grado_id");
        $stmt->bindParam(':grado_id', $grado_id, PDO::PARAM_INT);
        $stmt->execute();

        // Eliminar el grado
        $stmt = $conn->prepare("DELETE FROM grados WHERE id_grados = :id");
        $stmt->bindParam(':id', $grado_id, PDO::PARAM_INT);
        $stmt->execute();

        // Confirmar los cambios
        $conn->commit();

        // Redirigir al listado de grados con un mensaje de éxito
        header('Location: listado_grados.php?borrado=grado_eliminado');
        exit();
    } catch (Exception $e) {
        // Revertir los cambios en caso de error
        $conn->rollBack();
        echo 'Error al eliminar el grado: ' . $e->getMessage();
    }
} else {
    echo 'ID de grado no proporcionado';
}


?>