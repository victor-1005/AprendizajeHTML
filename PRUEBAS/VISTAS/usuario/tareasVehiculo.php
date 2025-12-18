<!--PHP-->
<?php
    //iniciamos la sesión
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: ../login.php?error=sesion");
        exit;
    }
    // Evitar volver atrás después del logout
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    
    //Incluimos la conexion a la bd
    include("../../conexion.php");

    //Traemos los datos del usuario
    $idUsuario=$_SESSION["idUsuario"];
    
    
    //Preparamos una consulta para traer los servicios registrados en la bd
    $queryListarServicios=$conexion->prepare("SELECT * FROM prestaciones");
    $queryListarServicios->execute();
    $resultadoListarServicios=$queryListarServicios->get_result();
    //Guardamos los resultados en un array para poder tener dos consultas
    $servicios=[];
    while($fila=$resultadoListarServicios->fetch_assoc()){
        $servicios[]=$fila;
    }

    //Creamos una consulta para los vehiculos registrados con servicios 
    $queryListarVehiculos=$conexion->prepare("SELECT tarea.idServicio,
    vehiculo.marca,
    vehiculo.matricula,
    tarea.nombre,
    tarea.fecha,
    tarea.precio,
    tarea.estado
    FROM tarea INNER JOIN vehiculo ON vehiculo.idVehiculo=tarea.idVehiculo 
    INNER JOIN usuarios ON usuarios.id=vehiculo.idUsuario WHERE  usuarios.id=?");
    $queryListarVehiculos->bind_param("i",$idUsuario);
    $queryListarVehiculos->execute();
    $resultadoVehiculoTarea=$queryListarVehiculos->get_result();
    $DatosVehiculoTarea=[];//Guardamos los valores en un array por si necesitamos listar los valores
    while($f=$resultadoVehiculoTarea->fetch_assoc()){
        $DatosVehiculoTarea[]=$f;
    }

    //NOS PREPARAMOS PARA AGREGAR UN SERVICIO
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["accion"])){
        //Para saber si se registro manualmente
        if($_POST["accion"]=="ServicioManual"){
            //Obtenemos los datos del form
            $placa=$_POST['matricula'];
            $idPrestaciones=$_POST['servicios'];
            $fecha=$_POST['fecha'];

            //Creamos una validación para buscar la placa solicitada
            $queryBuscarPlaca=$conexion->prepare("SELECT idVehiculo FROM vehiculo WHERE matricula =? LIMIT 1");
            $queryBuscarPlaca->bind_param("s",$placa);
            $queryBuscarPlaca->execute();
            $resultadoBuscarPlaca=$queryBuscarPlaca->get_result();
            if($resultadoBuscarPlaca->num_rows==0){
                header("Location: tareasVehiculo.php?msg=vehiculoNoSeEncontro");
                exit;
            }else{
                //Ahora que si se  encontro el vehiculo obtenemos los datos por el id
                $reultadoIdPlaca=$resultadoBuscarPlaca->fetch_assoc();
                $idPlaca=$reultadoIdPlaca['idVehiculo'];
                //Ahora nos preparamos para recuperar los datos de la tabla Prestaciones
                $queryPrestaciones=$conexion->prepare("SELECT * FROM prestaciones WHERE idPrestaciones=?");
                $queryPrestaciones->bind_param("i",$idPrestaciones);
                $queryPrestaciones->execute();
                $ResultadoPrestaciones=$queryPrestaciones->get_result();
                if($ResultadoPrestaciones->num_rows==0){
                    header("Location: tareasVehiculo.php?msg=errorPrestacion");
                    exit;
                }else{
                    //Ahora validamos que el id del vehiculo sea del usuario
                    $queryBuscarIdUsuarioPlaca=$conexion->prepare("SELECT * FROM vehiculo WHERE idVehiculo=? AND idUsuario=? ");
                    $queryBuscarIdUsuarioPlaca->bind_param("ii",$idPlaca,$idUsuario);
                    $queryBuscarIdUsuarioPlaca->execute();
                    $resultadoidUsuarioPlaca=$queryBuscarIdUsuarioPlaca->get_result();
                    if($resultadoidUsuarioPlaca->num_rows==0){
                        header("Location: tareasVehiculo.php?msg=PermisoVehiculoNegado");
                        exit();
                    }else{
                        //Recuperamos los datos de la prestacion
                        $DatosPrestacion=$ResultadoPrestaciones->fetch_assoc();
                        $nombre=$DatosPrestacion['nombrePrestacion'];
                        $descripcion=$DatosPrestacion['descripcion'];
                        $costo=$DatosPrestacion['costo'];
                        $estado="pendiente";

                        //Ahora con ese id registrmos en la tabla tarea
                        $queryInsertarTarea=$conexion->prepare("INSERT INTO tarea (nombre, precio, fecha, estado, idPrestaciones, idVehiculo)
                        VALUES (?,?,?,?,?,?)");
                        $queryInsertarTarea->bind_param("sdssii",$nombre,$costo,$fecha,$estado,$idPrestaciones,$idPlaca);
                        if($queryInsertarTarea->execute()){
                            header("Location: tareasVehiculo.php?msg=TareaRegistrada");
                            exit;
                        }else{
                            header("Location: tareasVehiculo.php?msg=TareaError");
                            exit;
                        }
                    }
                }
            }
        }
    }

?>
<!--HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios</title>
    <link rel="stylesheet" href="../../css/stilos.css">
</head>
<body>
    <header>
    <h1>Agrega un servicio</h1>    
    <header>
    <div class="Contenedor">
        <a href="./indexUsuario.php"><button type="button">Regresar al index usuario</button></a>
        <a href="./vehiculo.php"><button type="button">Ver Mis Vehiculos</button></a>
        <a href="../../logout.php"><button type="button">Cerrar sesión</button></a>
        <section>
            <h2>Servicios disponibles</h2>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($servicios)>0):?>
                        <?php foreach($servicios as $fila2): ?>
                           <tr>
                            <td><?=$fila2['idPrestaciones'] ?></td>
                            <td><?=$fila2['nombrePrestacion']?></td>
                            <td><?=$fila2['descripcion']?></td>
                            <td>$<?=$fila2['costo']?></td>
                           </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr>
                            <td colspan="4">No hay Servicios Disponibles</td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </section>
        <section>
            <h2>Agrega un Servicio de manera Manual</h2>
            <form action="tareasVehiculo.php" method="POST" class="Formulario">
                <input type="hidden" name="accion" value="ServicioManual">

                <label for="matricula">Ingrese la placa del vehiculo</label>
                <input type="text" name="matricula" id="matricula" placeholder="Ejemplo: P388058" required>

                <label for="servicios">Seleccione un servicio</label>
                <select name="servicios" id="servicios" required><!--COMBOBOX-->
                    <option value="">-- Selecciona --</option>
                    <!--Creamos un foreach para recorrer el array. $servicios, y guardar los datos en $prestaciones-->
                    <?php foreach ($servicios as $prestaciones):?>
                        <option value="<?= $prestaciones['idPrestaciones'] ?>">
                            <?=$prestaciones['nombrePrestacion']?> Precio: $<?=$prestaciones['costo']?>
                        </option>
                    <?php endforeach?>
                </select>
                <label for="fecha">Seleccione una fecha</label>
                <input type="date" name="fecha"required>
                <button type="submit">Registrar</button>
            </form>
        </section>
        <section>
            <h2>Vehiculos con servicios programados</h2>
            <table>
                <thead>
                    <tr>
                        <th>idServicio</th>
                        <th>Vehiculo</th>
                        <th>Matricula</th>
                        <th>Nombre del Servicio</th>
                        <th>Fecha programada</th>
                        <th>Costo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($DatosVehiculoTarea)>0):?>
                        <?php foreach($DatosVehiculoTarea as $fila3):?>
                            <tr>
                                <td><?= $fila3['idServicio']?></td>
                                <td><?= $fila3['marca']?></td>
                                <td><?= $fila3['matricula']?></td>
                                <td><?= $fila3['nombre']?></td>
                                <td><?= $fila3['fecha']?></td>
                                <td>$<?= $fila3['precio']?></td>
                                <td><?= $fila3['estado']?></td>
                                <td>
                                    <button type="button" class="Cancelar" id="Cancelar"
                                    onclick="confirmarCancelarServicio(<?= $fila3['idServicio']?>)">Cancelar</button>
                                    <!--EL FLUJO ES 1: ENVIAR EL ID AL JS (usuarioEventos.js) EL CUAL RECIBE LA INFO
                                    2: REDIRRECCIONA AL EdicionTarea DONDE ESTA PROGRAMADA LA FUNCION
                                    3:CANCELA EL SERVICIO Y REDIRECCIONA A tareasVehiculo.php ya que es donde se genero la funcion-->
                                </td>
                            </tr>
                        <?php endforeach?>
                    <?php else:?>
                        <tr>
                            <td colspan="7"> No hay vehiculos con servicios registrados</td>
                        </tr>
                    <?php endif?>
                </tbody>
            </table>
        </section>
    </div>
     <!--PARA ALERTAS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--PARA LOS EVENTOS-->
    <script src="../../js/eventos.js"></script>
    <script src="../../js/usuarioEventos.js"></script>
</body>
</html>