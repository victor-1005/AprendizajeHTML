<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php?error=sesion");
    exit;
}

// Evitar volver atrás después del logout
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");

//Incluimos la conexion a la bd
include("../../conexion.php");
//Preparamos una consulta para obtener los datos personales del usuario.
$idUsuario=$_SESSION["idUsuario"];
//   ASI SE PREPARA UNA QUERY CON UN PREPARE, SE EJECUTA Y SE DA EL RESULT
$DatosUsuario=$conexion->prepare("SELECT * FROM usuarios WHERE id=? LIMIT 1");
$DatosUsuario->bind_param("i",$idUsuario);
$DatosUsuario->execute();
$resultado=$DatosUsuario->get_result();

//    DE ESTA MANERA SE OBTIENE LOS VALORES EN FORMA DE ARRAY
$datos=$resultado->fetch_assoc();
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
    <div class="Contenedor">
        <a href="../../logout.php"><button type="button">Cerrar sesión</button></a>
        <section>
            <h2>
                Bienvenido <?= $_SESSION["usuario"]; ?> 
                su id es: <?= $idUsuario?>
            </h2>
            <p>
                <!--$datos=variable["Nombre de la columna de la BD"]-->
                Su nombre es: <?= $datos["nombre"]?><br>
                Su Edad es: <?= $datos["edad"] ?? "no registrada" ?><br>
                Su correo es: <?= $datos["email"]?>
            </p>
        </section>
    </div>
    <!--Para las alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Para los scripts-->
    <script src="../../js/eventos.js"></script>
    <footer>
        <p>
            &copy;LEPIOLA.inc. 
            <a href="../../index.html">Regresar a pagina principal</a>
        </p>
    </footer>
</body>
</html>