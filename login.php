<?php
session_start();
include("conexion.php");

$mensaje = "";
$usuario_no_existe = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario  = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usuario !== '' && $password !== '') {
        $stmt = $conexion->prepare("SELECT id, nombre, usuario, password FROM usuarios WHERE usuario = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            $datos = $resultado->fetch_assoc();
            if (password_verify($password, $datos['password'])) {
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $datos['id'];
                $_SESSION['nombre_cliente'] = $datos['nombre'];
                header("Location: index.php");
                exit();
            } else {
                $mensaje = "Contraseña incorrecta. Inténtalo de nuevo.";
            }
        } else {
            $mensaje = "El usuario ingresado no existe.";
            $usuario_no_existe = true;
        }
        $stmt->close();
    } else {
        $mensaje = "Por favor, llena todos los campos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - NYX Cosmetics</title>
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
            <h3 style="font-size: 20px; color: #7c3aed;">Iniciar Sesión</h3>

            <?php if (!empty($mensaje)): ?>
                <div style="background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 6px; font-size: 14px; margin-bottom: 15px;">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST" style="display: flex; flex-direction: column; gap: 15px;">
                <input type="text" name="usuario" placeholder="Usuario" required value="<?php echo htmlspecialchars($_POST['usuario'] ?? ''); ?>" style="padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                <input type="password" name="password" placeholder="Contraseña" required style="padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                <button type="submit" class="btn-login">Ingresar</button>
            </form>
            <p style="margin-top: 15px; font-size: 13px;">
                <?php echo $usuario_no_existe ? '¿No tienes una cuenta aún?' : '¿No tienes cuenta?'; ?>
                <a href="registro.php" style="color: #7c3aed; font-weight: bold;">Regístrate aquí</a>
            </p>
        </div>
    </div>

    <footer>
        GONZALEZ MARES SOFIA YAMILETH 5-J | P2-PRACTICA 1 FORMULARIO 1027
    </footer>

</body>
</html>