<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "nyx_cosmetics";

mysqli_report(MYSQLI_REPORT_OFF);
$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    error_log("Error de conexión: " . $conexion->connect_error);
    die("No se pudo conectar con la base de datos.");
}

$conexion->set_charset("utf8mb4");