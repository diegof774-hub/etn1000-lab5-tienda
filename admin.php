<?php
session_start();

// Definimos la contraseña de acceso (puedes cambiar "12345" por lo que quieras)
$password_correcta = "12345";

// Procesar el login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password_admin'])) {
    if ($_POST['password_admin'] === $password_correcta) {
        $_SESSION['admin_logeado'] = true;
    } else {
        $error = "Contraseña incorrecta.";
    }
}

// Procesar el cierre de sesión
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin | TecnoStore</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo">TecnoStore PANEL ADMIN</div>
        <nav>
            <?php if (isset($_SESSION['admin_logeado'])): ?>
                <a href="admin.php?logout=1" style="background: red; padding: 5px 10px; border-radius:3px;">Cerrar Sesión</a>
            <?php else: ?>
                <a href="index.html">Volver al Portal</a>
            <?php endif; ?>
        </nav>
    </header>
   
    <main>
        <?php if (!isset($_SESSION['admin_logeado'])): ?>
            <section class="hero"><h1>Acceso Restringido</h1></section>
            <div class="formulario-registro" style="max-width: 300px; text-align:center;">
                <h3>Ingrese Contraseña</h3>
                <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                <form method="POST">
                    <input type="password" name="password_admin" required placeholder="Contraseña">
                    <button type="submit" class="btn-comprar" style="background-color:#2d3748;">Ingresar</button>
                </form>
            </div>
        <?php else: ?>
            <section class="hero">
                <h1>Gestión de Inventario</h1>
                <p>Bienvenido, Administrador.</p>
            </section>
            <section class="contenedor-productos">
                <div class="formulario-registro">
                    <h2>Añadir Nuevo Producto</h2>
                    <form action="procesar.php" method="POST">
                        <label>Nombre del Equipo:</label><input type="text" name="txt_nombre" required>
                        <label>Descripción:</label><textarea name="txt_desc" required></textarea>
                        <label>Precio (Bs.):</label><input type="number" step="0.01" name="num_precio" required>
                        <label>Stock:</label><input type="number" name="num_stock" required>
                        <button type="submit" class="btn-comprar" style="background-color:#2d3748;">Guardar Producto</button>
                    </form>
                </div>
            </section>
        <?php endif; ?>
    </main>
</body>
</html>