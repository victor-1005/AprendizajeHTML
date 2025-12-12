<!--PHP-->
<?php
    //Recuperamos los datos de la sesion
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: ../login.php?error=sesion");
        exit;
    }
    // Evitar volver atrás después del logout
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");

    //Inlcuimos la conexion a la bd
    include("../../conexion.php");
    //preparamos una consulta para obtener los datos del usuario
    $idUsuario=$_SESSION["idUsuario"];
    $DatosUsuario=$conexion->prepare("SELECT * FROM usuarios WHERE id=? LIMIT 1");
    $DatosUsuario->bind_param("i",$idUsuario);
    $DatosUsuario->execute();
    $resultado=$DatosUsuario->get_result();
    $datos=$resultado->fetch_assoc();//De esta manera recuperamos los valores en forma de array

    //preparamos una consulta para obtener los vehiculos registrados del usuario
    $queryBuscarVehiculos=$conexion->prepare("SELECT * FROM vehiculo WHERE idusuario=?");
    $queryBuscarVehiculos->bind_param("i",$idUsuario);
    $queryBuscarVehiculos->execute();
    $resultadoVehiculos=$queryBuscarVehiculos->get_result();
    // Inicializar variable para evitar errores
    $ResultadoBuscarVehiculo2 = null;

    //PREPARAMOS PARA LOS FORMS 
    if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["accion"])){

        //PARA REGISTRAR UN VEHICULO
        if($_POST["accion"]=="registrarVehiculo"){
            //Obtenemos los datos del form
            $marca=$_POST['marca'];
            $modelo=$_POST['modelo'];
            $tipo=$_POST['tipo'];
            $año=$_POST['año'];
            $matricula=$_POST['matricula'];
            
            //Creamos una validacion para que la placa no este registrada
            $querybuscarPlacaVehiculo=$conexion->prepare("SELECT * FROM vehiculo WHERE matricula=? LIMIT 1");
            $querybuscarPlacaVehiculo->bind_param("s",$matricula);
            $querybuscarPlacaVehiculo->execute();
            $resultadoplaca=$querybuscarPlacaVehiculo->get_result();
            if($resultadoplaca->num_rows !=0){//Si devuelve un resultado esta duplicado
                header("Location: vehiculo.php?msg=placaDuplicada");
                exit;
            }else{
                //Preparamos la query para insertar el vehiculo
                $queryAgregarVehiculo=$conexion->prepare("INSERT INTO vehiculo (marca, modelo, tipo, anio, matricula, idUsuario)
                VALUES (?,?,?,?,?,?)");
                $queryAgregarVehiculo->bind_param("sssisi",$marca,$modelo,$tipo, $año,$matricula,$idUsuario);
                //Ejecutamos la query
                if($queryAgregarVehiculo->execute()){
                    header("Location: vehiculo.php?msg=VehiculoRegistado");
                    exit;
                }else{
                    header("Location: vehiculo.php?msg=errorVehiculo");
                    exit;
                }
            }
        }//Fin Registrar Vehiculo

        //PARA BUSCAR UN VEHICULO
        if($_POST["accion"]=="buscarVehiculo"){
            //Tenemos los datos del form
            $placa=$_POST['placaVehiculo'];


            //preparamos la query para buscar el vehiculo
            $querybuscarPlacaVehiculo=$conexion->prepare("SELECT * FROM vehiculo WHERE matricula=? LIMIT 1");
            $querybuscarPlacaVehiculo->bind_param("s",$placa);
            $querybuscarPlacaVehiculo->execute();
            $resultadoPlaca=$querybuscarPlacaVehiculo->get_result();
            if($resultadoPlaca->num_rows==0){
                header("Location: vehiculo.php?msg=vehiculoNoEncontrado");
                exit;
            }else{
                $queryBuscarVehiculos2=$conexion->prepare("SELECT * FROM vehiculo WHERE matricula=? LIMIT 1");
                $queryBuscarVehiculos2->bind_param("s",$placa);
                $queryBuscarVehiculos2->execute();
                $ResultadoBuscarVehiculo2=$queryBuscarVehiculos2->get_result();
                

                
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
    <title>Mis Vehiculos</title>
    <link href="../../CSS/stilos.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Bienvenido a mis vehiculos</h1>
    </header>
    <div class="Contenedor">
        <a href="./indexUsuario.php"><button type="button">Regresar al index usuario</button></a>
        <a href="../../logout.php"><button type="button">Cerrar sesión</button></a>
        <section>
            <h2>QUIERE REGISTRAR UN VEHICULO?</h2>
            <form action="vehiculo.php" class="Formulario" method="POST">
                <!--Para diferenciar de forms-->
                <input type="hidden" name="accion" value="registrarVehiculo">

                <label for="marca">Marca del Vehiculo</label>
                <input type="text" name="marca" id="marca"  placeholder="Ejemplo: Nissan" required>

                <label for="modelo">Modelo del Vehiculo</label>
                <input type="text" name="modelo" id="modelo" placeholder="Ejemplo: Sentra" requided>

                <label for="tipo">Tipó del vehiculo</label>
                <input type="text" name="tipo" id="tipo" placeholder="Ejemplo: Sedan" required>

                <label for="año">Año del Vehiculo</label>
                <input type="text" name="año" id="año" placeholder="Ejemplo: 1987" required>

                <label for="matricula">Matricula del Vehiculo</label>
                <input type="text" name="matricula" id="matricula" placeholder="Ejemplo: P388058" required>

                <button type="submit">Registrar Vehiculo</button>
            </form>
        </section>
        <section>
            <h2>VEHICULOS REGISTRADOS</h2>
            <table>
                <thead>
                    <tr>
                        <th>idVehiculo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Tipo</th>
                        <th>año</th>
                        <th>Matricula</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($resultadoVehiculos->num_rows>0):?>
                        <?php while($fila=$resultadoVehiculos->fetch_assoc()): ?>
                            <tr>
                                <td><?=$fila['idVehiculo']?></td>
                                <td><?=$fila['marca']?></td>
                                <td><?=$fila['modelo']?></td>
                                <td><?=$fila['tipo']?></td>
                                <td><?=$fila['anio']?></td>
                                <td><?=$fila['matricula']?></td>
                                <td>
                                            <!--AL COLOCAR ?id<=$fila['idVehiculo']?> se envia el id del vehiculo.
                                            Si espacio para no tener problema-->
                                    <a href="./editarVehiculo.php?id=<?=$fila['idVehiculo']?> "><button type="button" class="Editar" id="Editar">Editar</button></a>
                                    <button type="button" class="Eliminar" id="Eliminar"
                                    onclick="confirmarEliminacionVehiculo(<?= $fila['idVehiculo'] ?>)">Eliminar</button>
                                    <!--EL FLUJO ES 1: ENVIAR EL ID AL JS (usuarioEventos.js) EL CUAL RECIBE LA INFO
                                    2: REDIRRECCIONA AL editarVehiculo DONDE ESTA PROGRAMADA LA FUNCION
                                    3: VALIDA LOS DATOS Y DESPUES DE ELIMIAR DEVUELVE AL vehiculo.php PORQUE NO EXISTE UN ID-->
                                </td>
                            </tr>
                        <?php endwhile;?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No hay Vehiculos Registrados</td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </section>
        <section class="div-aside">
            <div class="main">
                <h2>Desea cambiar infomación de algun vehiculo registrado?</h2>
                <form action="vehiculo.php" method="POST" class="Formulario">

                    <!--PARA DIFERENCIAR EL FORM-->
                    <input type="hidden" name="accion" value="buscarVehiculo">
                    <label for="placaVehiculo">ingrese la placa del vehiculo a cambiar</label>
                    <input type="text" name="placaVehiculo" id="placaVehiculo" placeholder="Ejemplo: P3880588" required>

                    <button type="submit">Buscar</button>
                    <a href="./editarVehiculo.php"><button type="button">Editar Vehiculos</button></a>
                </form>
            </div>
            <aside id="RESULTADO_Vehiculo">
                    <!--Aca mostrara información de la placa-->
                    <article>
                        <?php if($ResultadoBuscarVehiculo2 !== null && $ResultadoBuscarVehiculo2->num_rows > 0): ?>
                          <?php while($txtVehiculo=$ResultadoBuscarVehiculo2->fetch_assoc()):?>  
                                Placa: <?=$txtVehiculo['matricula']?><br>
                                Marca: <?=$txtVehiculo['marca']?><br>
                                Modelo: <?=$txtVehiculo['modelo']?><br>
                                Tipo: <?=$txtVehiculo['tipo']?><br>
                                Año: <?=$txtVehiculo['anio']?><br>
                          <?php endwhile; ?>
                        <?php else: ?>
                            Introdusca el numero de placa en el buscador.
                        <?php endif;?>
                    </article>
                    
            </aside>
        </section>
    </div>
    <footer>
        <p>&copy;LEPIOLA.inc</p>
        <p><a href="./indexUsuario.php">Volver a mi index</a></p>
        <p><a href="../../logout.php">Cerrar sesión</a></p>
    </footer>
    <!--PARA ALERTAS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--PARA LOS SCRIPTS-->
    <script src="../../js/eventos.js"></script>
    <script src="../../js/usuarioEventos.js"></script>
</body>
</html>