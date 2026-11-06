<?php
session_start();
include("conexion.php");

$categoria_id = 3;
$stmt = $conexion->prepare("SELECT nombre, descripcion, precio, imagen FROM productos WHERE categoria_id = ?");
$stmt->bind_param("i", $categoria_id);
$stmt->execute();
$resultado = $stmt->get_result();
if (!$resultado) {
    die("Error al cargar los productos.");
}
$sin_imagen = "data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='150'><rect width='100%' height='100%' fill='%23f3e8ff'/><text x='50%' y='50%' fill='%237c3aed' font-size='14' text-anchor='middle' dominant-baseline='middle'>Sin imagen</text></svg>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Labiales - NYX Cosmetics</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="responsive.css">
</head>
<body>

    <header>
        <div class="top-bar">NYX COSMETICS</div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="labiales.php" class="activo">Labiales</a></li>
                <li><a href="ojos.php">Ojos</a></li>
                <li><a href="rostro.php">Rostro</a></li>
                <?php if (isset($_SESSION['nombre_cliente'])): ?>
                    <li><a href="logout.php" class="btn-cerrar-header">Cerrar Sesión</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="auth-btn">Cuenta</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="encabezado-seccion">
        <h1>Productos para Labios</h1>
        <p>Encuentra tus tonos y acabados favoritos.</p>
    </div>

    <div class="contenedor-principal">
        <div class="catalogo-container">
            <h2 class="subtitulo-catalogo">Catálogo de Labiales</h2>
            <div class="productos-grid">
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <div class="tarjeta-producto">
                        <div class="img-container">
                            <img src="img/<?php echo htmlspecialchars($row['imagen']); ?>" alt="<?php echo htmlspecialchars($row['nombre']); ?>" onerror="this.onerror=null; this.src='<?php echo $sin_imagen; ?>';">
                        </div>
                        <h3><?php echo htmlspecialchars($row['nombre']); ?></h3>
                        <div class="descripcion"><?php echo htmlspecialchars($row['descripcion']); ?></div>
                        <div class="precio">$<?php echo number_format($row['precio'], 2); ?> USD</div>
                        <a href="#" class="btn-comprar">Añadir al Carrito</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <?php include("sidebar.php"); ?>
    </div>

    <footer>
        GONZALEZ MARES SOFIA YAMILETH 5-J | P2-PRACTICA 1 FORMULARIO 1027
    </footer>

</body>
</html>