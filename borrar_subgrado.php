<?php

require 'conexion.php';

if (isset($_POST['id'])) {
    $subgrado_id = $_POST['id'];

    try {
        // Iniciar la transacción
        $conn->beginTransaction();

        // Obtener cualquier dato relacionado si es necesario (por ejemplo, un grado asociado)
        $stmt = $conn->prepare("
            SELECT grado_id FROM subgrados WHERE id_subgrados = :id
        ");
        $stmt->bindParam(':id', $subgrado_id, PDO::PARAM_INT);
        $stmt->execute();
        $grado_id = $stmt->fetchColumn();

        // Eliminar el subgrado
        $stmt = $conn->prepare("DELETE FROM subgrados WHERE id_subgrados = :id");
        $stmt->bindParam(':id', $subgrado_id, PDO::PARAM_INT);
        $stmt->execute();

        // Si hay más tablas relacionadas, agrega sus eliminaciones aquí

        // Confirmar los cambios
        $conn->commit();

        // Redirigir al listado de subgrados con un mensaje de éxito
        header('Location: listado_grados_sub.php?borrado=err');
        exit();
    } catch (Exception $e) {
        // Revertir los cambios en caso de error
        $conn->rollBack();
        echo 'Error al eliminar el subgrado: ' . $e->getMessage();
    }
} else {
    echo 'ID de subgrado no proporcionado';
}
?>
