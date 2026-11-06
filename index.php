<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NYX Cosmetics - Inicio</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="responsive.css">
</head>
<body>

    <header>
        <div class="top-bar">NYX COSMETICS</div>
        <nav>
            <ul>
                <li><a href="index.php" class="activo">Inicio</a></li>
                <?php if (isset($_SESSION['nombre_cliente'])): ?>
                    <li><a href="logout.php" class="btn-cerrar-header">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="auth-btn">Cuenta</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="encabezado-seccion">
        <h1>Bienvenido a NYX Cosmetics</h1>
        <p>Descubre lo último en belleza y tendencias de cosméticos profesionales.</p>
    </div>

    <div class="contenedor-principal">
        <div class="catalogo-container">
            <h2 class="titulo-inicio">Resalta tu belleza con NYX</h2>
            <p class="descripcion-inicio">
                Explora nuestras categorías exclusivas de labiales, productos para ojos y rostro. Ofrecemos fórmulas altamente pigmentadas, libres de crueldad animal y diseñadas para adaptarse a tu propio estilo.
            </p>

            <div class="grid-categorias-inicio">
                <div class="tarjeta-categoria-inicio">
                    <div class="img-categoria-container">
                        <img src="img/categoria_rostro.webp" alt="Categoría Rostro" onerror="this.onerror=null; this.style.display='none';">
                    </div>
                    <a href="rostro.php" class="btn-comprar">Rostro</a>
                </div>
                <div class="tarjeta-categoria-inicio">
                    <div class="img-categoria-container">
                        <img src="img/categoria_labiales.webp" alt="Categoría Labiales" onerror="this.onerror=null; this.style.display='none';">
                    </div>
                    <a href="labiales.php" class="btn-comprar">Labiales</a>
                </div>
                <div class="tarjeta-categoria-inicio">
                    <div class="img-categoria-container">
                        <img src="img/categoria_ojos.avif" alt="Categoría Ojos" onerror="this.onerror=null; this.style.display='none';">
                    </div>
                    <a href="ojos.php" class="btn-comprar">Ojos</a>
                </div>
            </div>
        </div>

        <?php include("sidebar.php"); ?>
    </div>

    <footer>
        GONZALEZ MARES SOFIA YAMILETH 5-J | P2-PRACTICA 1 FORMULARIO 1027
    </footer>

</body>
</html>