<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Cliente | TecnoStore</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo" style="font-weight: bold;">TecnoStore</div>
        <nav><a href="index.html">Volver al Portal</a></nav>
    </header>
   
    <main>
        <section class="hero">
            <h1>Crea tu cuenta de Cliente</h1>
            <p>Regístrate para obtener tu ID y realizar compras en nuestro catálogo.</p>
        </section>
 
        <section class="contenedor-productos">
            <div class="formulario-registro">
                <h2>Tus Datos</h2>
                <form method="POST">
                    <label>Nombre Completo:</label>
                    <input type="text" name="txt_nombre" required>
                    <label>Correo Electrónico:</label>
                    <input type="email" name="txt_email" required>
                    <label>Dirección de Envío:</label>
                    <input type="text" name="txt_direccion" required>
                    <button type="submit" class="btn-comprar" style="width: 100%;">Registrarme</button>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    require_once 'conexion.php';
                    $nombre = trim($_POST['txt_nombre']);
                    $email = trim($_POST['txt_email']);
                    $direccion = trim($_POST['txt_direccion']);

                    try {
                        $stmt = $pdo->prepare("INSERT INTO cliente (nombre, email, direccion) VALUES (:n, :e, :d)");
                        $stmt->execute([':n' => $nombre, ':e' => $email, ':d' => $direccion]);
                        $nuevo_id = $pdo->lastInsertId();
                        
                        echo "<div style='margin-top:20px; padding:15px; background:#d4edda; color:#155724; border-radius:5px; text-align:center;'>";
                        echo "<strong>¡Registro exitoso!</strong><br>Tu ID de Cliente es: <span style='font-size:1.5rem;'>$nuevo_id</span><br>";
                        echo "<p>Guarda este número para realizar tus compras.</p>";
                        echo "<a href='catalogo.php' class='btn-comprar' style='text-decoration:none; display:inline-block; margin-top:10px;'>Ir a comprar</a>";
                        echo "</div>";
                    } catch (PDOException $e) {
                        echo "<p style='color:red;'>Error: " . $e->getMessage() . "</p>";
                    }
                }
                ?>
            </div>
        </section>
    </main>
</body>
</html>