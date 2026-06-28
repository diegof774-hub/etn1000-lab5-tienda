<?php
require_once 'conexion.php'; // Asegúrate de tener tu archivo conexion.php apuntando a tecnostoredb

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre      = trim($_POST['txt_nombre']);
    $descripcion = trim($_POST['txt_desc']);
    $precio      = floatval($_POST['num_precio']);
    $stock       = intval($_POST['num_stock']);

    try {
        $sql = "INSERT INTO producto (nombre, descripcion, precio, stock) VALUES (:nombre, :descripcion, :precio, :stock);";
        $stmt = $pdo->prepare($sql);
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $stock);
        
        if ($stmt->execute()) {
            // Te devuelve al catálogo automáticamente después de guardar
            header("Location: admin.php");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error SQL: " . $e->getMessage();
    }
}
?>