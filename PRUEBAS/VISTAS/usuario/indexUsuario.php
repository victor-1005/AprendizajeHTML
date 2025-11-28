<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php?error=sesion");
    exit;
}

// Evitar volver atrás después del logout
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../CSS/stilos.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Bienvenido a tu inicio de sesión</h1>
    </header>
<!--Para las alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Para los scripts-->
    <script src="../../js/eventos.js"></script>
<footer>
    <div class="Contenedor">
    <a href="../../logout.php"><button type="button">Cerrar sesión</button></a>
    </div>
    <p>
        &copy;LEPIOLA.inc. 
        <a href="../../index.html">Regresar a pagina principal</a>
    </p>
</footer>
</body>
</html>