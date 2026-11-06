<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<aside class="sidebar">
    <?php if (isset($_SESSION['nombre_cliente'])): ?>
        <div class="caja-login caja-bienvenida">
            <h3>¡Bienvenid@, <?php echo htmlspecialchars($_SESSION['nombre_cliente']); ?>!</h3>
            <p>Sesión activa</p>
        </div>

        <div class="caja-login">
            <h3>Tu Carrito</h3>
            <a href="#" class="btn-login" onclick="event.preventDefault(); alert('El carrito de compras no está disponible por el momento.');">Carrito</a>
        </div>
    <?php else: ?>
        <div class="caja-login">
            <h3>Iniciar Sesión</h3>
            <a href="login.php" class="btn-login">Iniciar Sesión</a>
        </div>
    <?php endif; ?>
</aside>