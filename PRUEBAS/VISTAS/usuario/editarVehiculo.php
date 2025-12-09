<!--PHP-->
<?php
    //Iniciamos sesion y recuperamos los datos de la sesion
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: ../login.php?error=sesion");
        exit;
    }
    // Evitar volver atrás después del logout
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
    //obtenemos la conexion a la bd
    include("../../conexion.php");
    //obtenemos el idDel usuario
    $idUsuario=$_SESSION["idUsuario"];

    //Recuperamos todos los vehiculos registrados a nombre del usuario
    $queryBuscarVehiculo=$conexion->prepare("SELECT * FROM vehiculo WHERE idUsuario=?");
    $queryBuscarVehiculo->bind_param("i",$idUsuario);
    $queryBuscarVehiculo->execute();
    $resultadoVehiculo=$queryBuscarVehiculo->get_result();

?>
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EditarVehiculo</title>
    <link rel="stylesheet" href="../../css/stilos.css">
</head>
<body>
    <header>
        <h1>Edita tu vehiculo registrado</h1>
    </hedaer>
    <div class="Contenedor">
        <a href="./indexUsuario.php"><button type="button">Regresar al mi index</button></a>
        <a href="./vehiculo.php"><button type="button">Registrar un  vehiculo</button></a>
        <section>
            <h2>MIS VEHICULOS</h2>
            <table>
                <thead>
                    <tr>
                       <th>Id Vehiculo</th> 
                       <th>Marca</th>
                       <th>Modelo</th>
                       <th>Tipo</th>
                       <th>Año</th>
                       <th>Matricula</th>
                       <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultadoVehiculo->num_rows>0):?>
                        <?php while($fila=$resultadoVehiculo->fetch_assoc()):?>
                            <tr>
                                <td><?=$fila['idVehiculo']?></td>
                                <td><?=$fila['marca']?></td>
                                <td><?=$fila['modelo']?></td>
                                <td><?=$fila['tipo']?></td>
                                <td><?=$fila['anio']?></td>
                                <td><?=$fila['matricula']?></td>
                                <td>
                                    <button type="button" class="Editar" id="Editar">Editar</button>
                                    <button type="button" class="Eliminar" id="Eliminar">Eliminar</button>
                                </td>
                            </tr>
                        <?php endwhile;?>
                    <?php else:?>
                        <tr colspan ="7">
                           NO HAY VEHICULOS REGISTRADOS 
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </section>
    </div>
    <!--PARA ALERTAS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--PARA LOS EVENTOS-->
    <script src="../../js/eventos.js"></script>
</body>
</html>