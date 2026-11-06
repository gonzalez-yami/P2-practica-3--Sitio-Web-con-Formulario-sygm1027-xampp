<?php
session_start();
include("conexion.php");

$mensaje = "";
$exito = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = trim($_POST['nombre'] ?? '');
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre === '' || $usuario === '' || $password === '') {
        $mensaje = "Por favor, completa todos los campos.";
    } elseif (strlen($password) < 8) {
        $mensaje = "La contraseña debe tener al menos 8 caracteres.";
    } else {
        $stmt_check = $conexion->prepare("SELECT id FROM usuarios WHERE usuario = ?");
        $stmt_check->bind_param("s", $usuario);
        $stmt_check->execute();
        $resultado = $stmt_check->get_result();

        if ($resultado->num_rows > 0) {
            $mensaje = "El usuario ya está registrado. Intenta con otro.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, usuario, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $usuario, $password_hash);

            if ($stmt->execute()) {
                $exito = true;
                $mensaje = "¡Registro exitoso! Ya puedes iniciar sesión.";
            } elseif ($conexion->errno === 1062) {
                $mensaje = "El usuario ya está registrado. Intenta con otro.";
            } else {
                $mensaje = "Error al registrar el usuario.";
            }
            $stmt->close();
        }
        $stmt_check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Cliente - NYX Cosmetics</title>
    <link rel="stylesheet" href="estilos.css">
    <link rel="stylesheet" href="responsive.css">
</head>
<body>

    <header>
        <div class="top-bar">NYX COSMETICS</div>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
                <li><a href="labiales.php">Labiales</a></li>
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

    <div class="contenedor-principal" style="justify-content: center; align-items: center;">
        <div class="caja-login" style="max-width: 400px; width: 100%; margin-top: 40px;">
            <h3 style="font-size: 20px; color: #7c3aed;">Registro de Cliente</h3>

            <?php if (!empty($mensaje)): ?>
                <div style="background-color: <?php echo $exito ? '#dcfce7' : '#fee2e2'; ?>; color: <?php echo $exito ? '#15803d' : '#dc2626'; ?>; padding: 10px; border-radius: 6px; font-size: 14px; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <?php if ($exito): ?>
                <a href="login.php" class="btn-login">Ir a Iniciar Sesión</a>
            <?php else: ?>
                <form action="registro.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                    <input type="text" name="nombre" placeholder="Nombre Completo" required maxlength="100" value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>" style="padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <input type="text" name="usuario" placeholder="Nombre de Usuario" required maxlength="50" value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>" style="padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <input type="password" name="password" placeholder="Contraseña (mínimo 8 caracteres)" required minlength="8" style="padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                    <button type="submit" class="btn-login">Registrarse</button>
                </form>
                <p style="margin-top: 15px; font-size: 13px;">¿Ya tienes cuenta? <a href="login.php" style="color: #7c3aed; font-weight: bold;">Inicia sesión aquí</a></p>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        GONZALEZ MARES SOFIA YAMILETH 5-J | P2-PRACTICA 1 FORMULARIO 1027
    </footer>

</body>
</html>