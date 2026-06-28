<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = intval($_POST['id_producto']);
    $id_cliente  = intval($_POST['id_cliente']);

    if ($id_producto <= 0 || $id_cliente <= 0) {
        die("Datos de solicitud inválidos.");
    }

    try {
        // Iniciar una transacción para asegurar la integridad referencial
        $pdo->beginTransaction();

        // 1. Verificar si el cliente existe en la BD
        $stmtCheck = $pdo->prepare("SELECT id_cliente FROM cliente WHERE id_cliente = :id_cliente");
        $stmtCheck->execute([':id_cliente' => $id_cliente]);
        if (!$stmtCheck->fetch()) {
            throw new Exception("El ID de cliente ($id_cliente) no existe en la base de datos. Registre el cliente primero o use ID 1 o 2.");
        }

        // 2. Obtener el precio actual y stock del producto
        $stmtProd = $pdo->prepare("SELECT precio, stock FROM producto WHERE id_producto = :id_producto");
        $stmtProd->execute([':id_producto' => $id_producto]);
        $producto = $stmtProd->fetch(PDO::FETCH_ASSOC);

        if (!$producto || $producto['stock'] <= 0) {
            throw new Exception("El producto seleccionado no cuenta con stock disponible.");
        }

        $precio_unitario = $producto['precio'];

        // 3. Insertar el registro principal en la tabla 'pedido'
        $sqlPedido = "INSERT INTO pedido (fecha_pedido, id_cliente) VALUES (NOW(), :id_cliente);";
        $stmtPed = $pdo->prepare($sqlPedido);
        $stmtPed->execute([':id_cliente' => $id_cliente]);
        
        // Capturar el ID correlativo autogenerado del pedido
        $id_pedido = $pdo->lastInsertId();

        // 4. Insertar el registro en la tabla dependiente 'detalle_pedido' (Lab 6)
        $sqlDetalle = "INSERT INTO detalle_pedido (id_pedido, id_producto, cantidad, precio_unitario) 
                       VALUES (:id_pedido, :id_producto, 1, :precio_unitario);";
        $stmtDet = $pdo->prepare($sqlDetalle);
        $stmtDet->execute([
            ':id_pedido' => $id_pedido,
            ':id_producto' => $id_producto,
            ':precio_unitario' => $precio_unitario
        ]);

        // 5. Actualizar el stock en la tabla 'producto' (Efecto colateral del negocio)
        $sqlStock = "UPDATE producto SET stock = stock - 1 WHERE id_producto = :id_producto;";
        $stmtStk = $pdo->prepare($sqlStock);
        $stmtStk->execute([':id_producto' => $id_producto]);

        // Si todo anduvo bien, consolidamos los cambios en la base de datos
        $pdo->commit();

        // Mensaje de éxito estructurado con el diseño corporativo
        echo "<div style='padding:40px; text-align:center; font-family:sans-serif;'>";
        echo "<h2 style='color:#1a365d;'>🎉 ¡Compra procesada exitosamente!</h2>";
        echo "<p>Se ha generado el <strong>Pedido N° $id_pedido</strong> para el Cliente ID: $id_cliente.</p>";
        echo "<p>Los datos han sido distribuidos relacionalmente en las tablas <em>pedido</em> y <em>detalle_pedido</em>.</p>";
        echo "<br><a href='catalogo.php' style='padding:10px 20px; background:#3182ce; color:white; text-decoration:none; border-radius:5px;'>Regresar al Catálogo</a>";
        echo "</div>";

    } catch (Exception $e) {
        // En caso de fallar algo, deshacemos todas las inserciones para no dejar datos huérfanos
        $pdo->rollBack();
        echo "<div style='padding:40px; text-align:center; font-family:sans-serif; color:red;'>";
        echo "<h2>❌ Error Transaccional</h2>";
        echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
        echo "<br><a href='catalogo.php' style='padding:10px 20px; background:#cbd5e0; color:black; text-decoration:none; border-radius:5px;'>Regresar</a>";
        echo "</div>";
    }
}
?>