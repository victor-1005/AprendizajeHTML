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

    /*PARA RECUPERAR LOS DATOS DEL VEHICULO A EDITAR, ESTE SE OBTIENE CON EL ID MANDADO EN EL FORM ATERIOR
    CON ESE ID COLOCAMOS LOS DATOS EN EL FORM Y DESPUES VEMOS COMO LOS ACTUALIZAMOS*/
    if(!isset($_GET['id'])){//por si pasa un error, que no se bugee
        header("Location: vehiculo.php?msg=idInvalido");
        exit;
    }
    $idvehiculo = $_GET['id'];
    


    //Obtenemos los datos de ese vehiculo
    $queryBuscarPorID=$conexion->prepare("SELECT * FROM vehiculo WHERE idVehiculo=? LIMIT 1");
    $queryBuscarPorID->bind_param("i",$idvehiculo);
    $queryBuscarPorID->execute();
    $resultadoBuscarId=$queryBuscarPorID->get_result();
    $datosVehiculo=$resultadoBuscarId->fetch_assoc();

    //AHORA NOS PREPARAMOS PARA ACTUALIZAR LA INFORMACIÓN MEDIANTE LOS FORMS
    if($_SERVER["REQUEST_METHOD"]=="POST"){

        $idVehiculo = $_POST['idVehiculo']; // YA LO TIENES AQUÍ ✔✔✔
        //Obtenemos lo datos del form
        $marca=$_POST['marca'];
        $modelo=$_POST['modelo'];
        $tipo=$_POST['tipo'];
        $año=$_POST['año'];
        $matricula=$_POST['matricula'];

        //Verificamos is marco la casilla de reurtilizar la placa
        $mantenerPlaca=isset($_POST['radVehiculo'])? $_POST['radVehiculo']:'';
        //        ^                            ^                 ^           ^
        //  Variable destino              Condición          Si TRUE     Si FALSE

        //La logica es que si la placa concide con  la bd entonces esta marcado
        //Ya que el radButton devuelve lo del value, y se compara con el registrado

        if($mantenerPlaca==$datosVehiculo["matricula"]){//preparamos para solo actualizar los datos menos la placa
            //Una vez que la placa no este duplicada actualizamos los datos
            $queryActualizarVehiculo=$conexion->prepare("UPDATE vehiculo SET marca=?, modelo=?, tipo=?, anio=?  WHERE idVehiculo=?");
            $queryActualizarVehiculo->bind_param("sssii",$marca,$modelo,$tipo,$año,$idVehiculo);
            if($queryActualizarVehiculo->execute()){
                //Aca colocamos id=$idVehiculo& para que se envie el idVehiculo para que funcione ya que asi viene trabajando por el METODO GET
                header("Location: editarVehiculo.php?id=$idVehiculo&msg=Actualizado");
                exit;
            }else{
                header("Location: editarVehiculo.php?id=$idVehiculo&msg=errorVehiculo");
                exit;
            }
        }else{
            //Ahora preparamos una query para buscar placas duplicadas
            $queryBuscarPlaca=$conexion->prepare("SELECT * FROM vehiculo WHERE matricula =? ");
            $queryBuscarPlaca->bind_param("s",$matricula);
            $queryBuscarPlaca->execute();
            $resultadoBuscarPlaca=$queryBuscarPlaca->get_result();
            if($resultadoBuscarPlaca->num_rows>0){//Validamos que la placa no este duplicada
                header("Location: editarVehiculo.php?id=$idVehiculo&msg=placaDuplicada");
                exit;
            }else{
                //Una vez que la placa no este duplicada actualizamos los datos
                $queryActualizarVehiculo=$conexion->prepare("UPDATE vehiculo SET marca=?, modelo=?, tipo=?, anio=?, matricula=? WHERE idVehiculo=?");
                $queryActualizarVehiculo->bind_param("sssisi",$marca,$modelo,$tipo,$año,$matricula,$idvehiculo);
                if($queryActualizarVehiculo->execute()){
                    header("Location: editarVehiculo.php?id=$idVehiculo&msg=Actualizado");
                    exit;
                }else{
                    header("Location: editarVehiculo.php?id=$idVehiculo&msg=errorVehiculo");
                    exit;
                }
            }
        }
    }

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
            <label>
                DATOS DEL VEHICULO <br>
                ID: <?= $datosVehiculo['idVehiculo'] ?><br>
                <!--METODO PARA REUTILIZAR LA PLACA EN EL JS-->
                Placa: <label id="Placa_Vehiculo_P"><?= $datosVehiculo["matricula"] ?><br></label>
                Marca: <?= $datosVehiculo['marca'] ?><br>
                Modelo: <?= $datosVehiculo['modelo'] ?> <br>
                Tipo: <?= $datosVehiculo['tipo'] ?><br>
                Año: <?= $datosVehiculo['anio'] ?> <br>
            </label>
        </section>
        <section>
            <h2>Edición</h2>
                <!--AL COLOCARLE EL ID REENVIAMOS LA INFORMACIÓN DEL ID PARA QUE CARGUE LA INFORMACIÓN....-->
            <form action="editarVehiculo.php?id=<?= $datosVehiculo['idVehiculo'] ?>" class="Formulario" method="POST">

            <!--PARA REENVIAR EL EL ID DEL VEHICULO-->
            <input type="hidden" name="idVehiculo" value="<?= $datosVehiculo['idVehiculo'] ?>">

                <label for="marca">Marca del Vehiculo</label>
                <input type="text" name="marca" value="<?= $datosVehiculo['marca'] ?>" id="marca"  placeholder="Ejemplo: Nissan" required>

                <label for="modelo">Modelo del Vehiculo</label>
                <input type="text" name="modelo" value="<?= $datosVehiculo['modelo'] ?>" id="modelo" placeholder="Ejemplo: Sentra" requided>

                <label for="tipo">Tipó del vehiculo</label>
                <input type="text" name="tipo" value="<?= $datosVehiculo['tipo'] ?>" id="tipo" placeholder="Ejemplo: Sedan" required>

                <label for="año">Año del Vehiculo</label>
                <input type="text" name="año" value="<?= $datosVehiculo['anio'] ?>" id="año" placeholder="Ejemplo: 1987" required>
                
                <fieldset>
                    <legend>¿Desea usar la misma Placa?</legend>
                    <label for="si">Si</label>
                    <input type="radio" id="si_Vehiculo" name="radVehiculo" value="<?= $datosVehiculo['matricula'] ?>">
                    <label for="no">No</label>
                    <input type="radio" id="no_Vehiculo" name="radVehiculo" value="" checked>
                </fieldset>
                <label for="matricula">Matricula del Vehiculo</label>
                <input type="text" name="matricula"  id="matricula" placeholder="Ejemplo: P388058" required>

                <button type="submit">Actualizar Vehiculo</button>
            </form>
        </section>
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
                                    <a href="./editarVehiculo.php?id=<?= $fila["idVehiculo"] ?>"><button type="button" class="Editar" id="Editar">Editar</button></a>
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
    <script src="../../js/usuarioEventos.js"></script>
</body>
</html>