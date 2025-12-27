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

    //Preparamos una query para poder listar todos los vehiculos
    $ListaVehiculos=[];
    $queryListarVehiculo=$conexion->prepare("SELECT * FROM vehiculo");
    $queryListarVehiculo->execute();
    $resultadoListarVehiculo=$queryListarVehiculo->get_result();
    while($datosListarVehiculo=$resultadoListarVehiculo->fetch_assoc()){
        $ListaVehiculos[]=$datosListarVehiculo;
    }
 ?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehiculos Registrados</title>
    <link rel="stylesheet" href="../../css/stilos.css">
</head>
<body>
    <header>
        <h1>Vehiculos en el sistema</h1>
    </header>
    <div class="Contenedor">
        <section>
            <h1>Listado de vehiculos</h1>
            <table>
                <thead>
                    <tr>
                        <th>IdVehiculo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>Año</th>
                        <th>Placa</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($ListaVehiculos)>0):?>
                        <?php foreach( $ListaVehiculos as $fila ):?>
                            <tr>
                                <td><?= $fila['idVehiculo']?></td>
                                <td><?= $fila['marca']?></td>
                                <td><?= $fila['modelo']?></td>
                                <td><?= $fila['tipo']?></td>
                                <td><?= $fila['anio']?></td>
                                <td><?= $fila['matricula']?></td>
                                <td>
                                    <a href="./A_editarVehiculo.php?id=<?= $fila['idVehiculo'] ?>">
                                        <button tipe="button" class="Editar">Editar</button>
                                    </a>
                                    <button class="Eliminar" id="Eliminar"
                                    >Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="7">No hay Vehiculos Registrados</td>
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
    <script src="../../js/adminEventos.js"></script>
</body>
</html>