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

    //Recuperamos los datos por el metodo get
    if(!isset($_GET['id'])){
        header("Location: A_editarVehiculo.php?msg=errorID");
        exit();
    }
    $idVehiculo=$_GET['id'];
 ?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vehiculo</title>
    <link rel="stylesheet" href="../../css/stilos.css">
</head>
<body>
    <header> 
        <h1>Edicion de vehiculos</h1>
    </header>
    <div class="Contenedor">
        <section>
            <h2>Editar Información</h2>
            <form action="A_editarVehiculo.php" class="Formulario" method="POST">
                <input type="hidden" name="accion" value="modVehiculo">
                <label for="idVehiculo">ID del vehiculo</label>
                <input type="text" name="idVehiculo" id="idVehiculo" required readonly placeholder="Ejemplo: 1">

                <label for="marca">Marca</label>
                <input type="text" name="marca"  id="marca" required readonly placeholder="Ejemplo: Nissan">

                <label for="modelo">Modelo</label>
                <input type="text" name="modelo"  id="modelo" required readonly placeholder="Ejemplo: Sentra">

                <label for="tipo">Tipo</label>
                <input type="text" name="tipo"  id="tipo" required readonly placeholder="Ejemplo: Sedan">

                <label for="anio">Año</label>
                <input type="text" name="anio"  id="anio" required readonly placeholder="Ejemplo: 1977">

                <label for="matricula">Matricula</label>
                <input type="text" name="matricula"  id="matricula" required readonly placeholder="Ejemplo: P388058">

                <button type="submit">Actualizar</button>
            </form>
        </section>
    </div>
    <!--PARA ALERTAS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--PARA LOS EVENTOS-->
    <script src="../../js/eventos.js"></script>
    <script src="../../js/adminEventos.js"></script>
</body>
</html>