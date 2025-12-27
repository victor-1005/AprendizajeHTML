<!-- PHP -->
 <?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: ../../login.php?error=sesion");
        exit;
    }
    //Evitar volver atrás después del logout
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    
    //Incluimos la conexion a la BD
    include("../../conexion.php");
    //Preparamos una query para obtener el id Del Admin, por defecto viene como idUsuario
    $idAdmin=$_SESSION["idUsuario"];
    //Preparamos una Consulta para obtener los datos del Admin
    $queryDatosAdmin=$conexion->prepare("SELECT * FROM rol WHERE idUsuario=?");
    $queryDatosAdmin->bind_param("i",$idAdmin);
    $queryDatosAdmin->execute();
    $ResultadoDatosAdmin=$queryDatosAdmin->get_result();
    $DatosAdmin=$ResultadoDatosAdmin->fetch_assoc()
 ?>
<!--HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index Administrador</title>
    <link rel="stylesheet" href="../../css/stilos.css">
</head>
<body>
    <header>
        <h1>Bienvenido <?=$DatosAdmin['usuario']?>
            Al index de Administrador
        </h1>
    </header>
    <div class="Contenedor">
        <a href="./A_verUsuarios.php"><button type="button">Ver Usuarios Registrados</button></a>
        <a href="../../logout.php"><button type="button">Cerrar sesión</button></a>
        <a href="./verVehiculos.php"> <button type="button">Ver Vehiculos Registrados</button></a>
        <section>
            <article>
                Hola <?= $DatosAdmin['usuario']?>
            </article>
        </section>
    </div>
    <!--PARA LOS EVENTOS-->
    <script src="../../js/eventos.js"></script>
</body>
</html>