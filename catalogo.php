<?php require_once 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo | TecnoStore</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar">
        <div class="logo" style="font-weight: bold; font-size: 1.2rem;">TecnoStore CLIENTES</div>
        <nav>
            <a href="index.html">Volver al Portal</a>
        </nav>
    </header>
   
    <main>
        <section class="hero">
            <h1>Nuevos Ingresos 2026</h1>
            <p>Explora nuestra tecnología e infórmate sobre el tipo de cambio.</p>
        </section>

        <div class="api-banner">
            Cotización del Dólar en Vivo (API): <span id="tasa-cambio">Conectando...</span>
        </div>
 
        <section class="contenedor-productos">
            <h2>Catálogo Oficial de Productos</h2>
            
            <div style="background: var(--gris-claro); padding: 15px; margin-bottom: 2rem; border-radius: 8px; text-align: center;">
                <label style="font-weight: bold;">🔑 Introduce tu ID de Cliente para comprar: </label>
                <input type="number" id="cliente_id_input" value="1" style="width: 60px; padding: 5px; text-align: center;">
                <p style="font-size: 0.8rem; color: #4a5568; margin: 5px 0 0 0;">(Usa ID 1 o 2 que fueron creados en el Lab 7)</p>
            </div>

            <div class="grid-productos">
                <?php
                try {
                    $stmt = $pdo->query("SELECT * FROM producto WHERE stock > 0 ORDER BY id_producto DESC");
                    
                    while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<article class="tarjeta-producto">';
                        echo '<div class="imagen-placeholder"></div>';
                        echo '<h3>' . htmlspecialchars($fila['nombre']) . '</h3>';
                        echo '<p>' . htmlspecialchars($fila['descripcion']) . '</p>';
                        echo '<span class="precio">' . number_format($fila['precio'], 2) . ' Bs.</span>';
                        echo '<p style="font-size: 0.85rem; color: #718096; margin-bottom:15px;">Disponibles: ' . htmlspecialchars($fila['stock']) . ' u.</p>';
                        
                        // Formulario individual para enviar la compra mediante POST de manera oculta
                        echo '<form action="procesar_compra.php" method="POST" onsubmit="añadirClienteId(this)">';
                        echo '<input type="hidden" name="id_producto" value="' . $fila['id_producto'] . '">';
                        echo '<input type="hidden" name="id_cliente" class="cliente_id_oculto" value="1">';
                        echo '<button type="submit" class="btn-comprar">Comprar Ahora</button>';
                        echo '</form>';
                        
                        echo '</article>';
                    }
                } catch (PDOException $e) {
                    echo "<p>Error al cargar el inventario: " . $e->getMessage() . "</p>";
                }
                ?>
            </div>
        </section>
    </main>
 
    <footer>
        <p style="text-align: center; padding: 20px; background: var(--gris-claro); margin:0;">&copy; 2026 Sistema Integrado - Bases de Datos</p>
    </footer>

    <script>
        // JS para inyectar dinámicamente el ID de cliente del input de arriba en el formulario que se envíe
        function añadirClienteId(form) {
            var idClienteActivo = document.getElementById('cliente_id_input').value;
            form.querySelector('.cliente_id_oculto').value = idClienteActivo;
        }

        // API de Divisas
        async function obtenerTipoCambio() {
            try {
                const res = await fetch('https://api.exchangerate-api.com/v4/latest/USD');
                const datos = await res.json();
                document.getElementById('tasa-cambio').innerHTML = `1 USD = ${datos.rates.BOB} BOB`;
            } catch (e) {
                document.getElementById('tasa-cambio').innerHTML = "Error de red";
            }
        }
        window.onload = obtenerTipoCambio;
    </script>
</body>
</html>