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

//Obtenemos datos de la tabla rol
$queryBuscarRol=$conexion->prepare("SELECT * FROM rol WHERE idUsuario=? LIMIT 1");
$queryBuscarRol->bind_param("i",$idUsuario);
$queryBuscarRol->execute();
$resultadoRol=$queryBuscarRol->get_result();
$datosRol=$resultadoRol->fetch_assoc();//Obtenemos los valores del usurio de la tabla rol

if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_POST["accion"])){//Con && isset($_POST["accion"]) avisamos que podria haver acciones
    //Y por ya que si no incluimos eso dara error porque aun no se envia el form, ya que este es modificado PORQUE HAY 2 FORMS

    //ACTUALIZAR DATOS PERSONALES
    if($_POST["accion"]=="personal"){
        //Obtenemos los datos del form
        $nombre=$_POST['Nombre'];
        $edad=$_POST['Edad'];
        $email=$_POST['Email'];
        $telefono=$_POST['NumTelefono'];
        //Creamos una validación rapida
        if(!empty($nombre) && !empty($edad)&& !empty($email) && !empty($telefono)){
            //PARA ACTUALIZAR LA INFORMACIÓN DEL CLIENTE
            $queryActualizarDatos=$conexion->prepare("UPDATE usuarios SET nombre=?, edad=?, email=?, telefono=? Where id=?");
            $queryActualizarDatos->bind_param("sissi",$nombre,$edad,$email,$telefono,$idUsuario);
            //Ejecutamos la query
            if($queryActualizarDatos->execute()){
                header("Location: indexUsuario.php?msg=actualizado");
                exit;
            }else{
                header("Location: indexUsuario.php?msg=errorActualizar");
                exit;
            }
        }else{
            header("Location: indexUsuario.php?msg=vacio");
            exit;
        }
    }
    //ACTUALIZAR ROL
    if($_POST["accion"]=="rol"){
        //Obtenemos la información del form
        $usuario=$_POST['usuario'];
        $conta=$_POST['contra'];
        //encriptamos la contra
        $contraEncriptada=password_hash($conta,PASSWORD_DEFAULT);

        //Verificamos si el usuario marco usar el antiguo usuario
        $mantener_usuario=isset($_POST['radUsuario']) ? $_POST['radUsuario']:'';
        //        ^                            ^                 ^           ^
        //  Variable destino              Condición          Si TRUE     Si FALSE

        //La logica es que si nombre del usuario concide con  la bd entonces esta marcado
        //Ya que el radButton devuelve lo del value, y se compara con el registrado

        if($mantener_usuario==$datosRol["usuario"]){
            //Preparamos la query para solo actualizar la contraseña
            $queryActualizarContra=$conexion->prepare("UPDATE rol set contra=? WHERE idusuario=?");
            $queryActualizarContra->bind_param("si",$contraEncriptada,$idUsuario);
            if($queryActualizarContra->execute()){
                header("Location: indexUsuario.php?msg=actualizado");
                exit;
            }else{
                header("Location: indexUsuario.php?msg=errorActualizar");
                exit;
            }

        }else{
            //Preparamos la query para validar que no hayan usuarios duplicados
            $queyBuscarUsuario=$conexion->prepare("SELECT * FROM rol WHERE usuario=? LIMIT 1");
            $queyBuscarUsuario->bind_param("s",$usuario);
            $queyBuscarUsuario->execute();
            $resultadoUsuario=$queyBuscarUsuario->get_result();
            if($resultadoUsuario->num_rows==0){
                //Preparamos la query para actualizar la info
                $queryActaulizarRol=$conexion->prepare("UPDATE rol SET usuario=?, contra=? WHERE idUsuario=? ");
                $queryActaulizarRol->bind_param("ssi",$usuario,$contraEncriptada,$idUsuario);
                if($queryActaulizarRol->execute()){
                    header("Location: indexUsuario.php?msg=actualizado");
                    exit;
                }else{
                    header("Location: indexUsuario.php?msg=errorActualizar");
                    exit;
                }
            }else{
                header("Location: indexUsuario.php?msg=yaTieneUsuario");
                exit;
            }
        }
    }
}//Fin del metodo $_SERVER["REQUEST_METHOOD"]=="POST"
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
        <a href="./vehiculo.php"><button type="button">Ver mis vehiculos</button></a>
        <a href="./editarVehiculo.php"><button type="button">Editar Vehiculos</button></a>
        <section>
            <h2>
                Bienvenido <?= $_SESSION["usuario"]; ?> 
                su id es: <?= $idUsuario?>
            </h2>
            <p>
                <!--$datos=variable["Nombre de la columna de la BD"]-->
                Su nombre es: <?= $datos["nombre"]?><br>
                Su Edad es: <?= $datos["edad"] ?? "no registrada" ?><br>
                Su correo es: <?= $datos["email"]?><br>
                Su telefono es <?= $datos["telefono"] ?>
            </p>
        </section>
        <section>
            <h2>¿Desea cambiar algo de su información personal?</h2>
            <form action="indexUsuario.php" method="POST" class="Formulario">

                <!--Para diferenciar los forms ya que hay mas de 1-->
                <input type="hidden" name="accion" value="personal">

                <label for="Nombre">ingresa tu nombre completo</label>
                <input type="text" name="Nombre" id="txtNombres" placeholder="EJemplo: Victor Manuel" required>
        
                <label for="Edad">Ingresa tu edad</label>
                <input type="text" name="Edad" id="txtEdades" placeholder="EJemplo: 20" required>

                <label for="Email">Ingresa tu Correo</label>
                <input type="text" name="Email" id="txtEmail" placeholder="EJemplo: vic@gmail.com" required>

                <label for="NumTelefono">Ingresa tu numero de telefono</label>
                <input type="text" name="NumTelefono" id="txtNumTelefono" placeholder="EJemplo: 71309080" required>

                <!-- <label for="usuario">Crea tu usuario</label>
                <input type="text" name="usuario" placeholder="Ejemplo Victor005" required>

                <label for="contra">Crea tu contraseña</label> -->
                <!-- <input type="text" name="contra" placeholder="Ejemplo: 1234" required> -->
                <button type="submit" id="btnEnviar">Ingresar</button>
            </form>
        </section>
        <section>
            <h2>¿Dese cambiar algo de su usuario?</h2>
            
            <label>
                Su usuario actual es:
                <label id="idUsuario_P"><?=$datosRol["usuario"]  ?></label><br>
            </label>
            <form action="indexUsuario.php" method="POST" class="Formulario">
                
                <!--Para diferenciar los forms ya que hay mas de 1-->
                <input type="hidden" name="accion" value="rol">

                <fieldset>
                    <legend>Manter usuario </legend>
                    <input type="radio" id="si" name="radUsuario" value="<?= $datosRol["usuario"] ?>" >
                    <label for="si">Si</label>
                    <input type="radio" id="No" name="radUsuario" value=" " checked>
                    <label for="No">No</label>
                </fieldset>
                <label for="usuario">Introdusca su nuevo usuario</label>
                <input type="text" name="usuario" id="txtUsuario" placeholder="Ejemplo: Vic005" required>

                <label for="contra">Introdusca su nueva contraseña</label>
                <input type="text" name="contra" placeholder="Ejemplo 1234" required>

                <button type="submit" id="btnEnviar">Actualizar</button>
                <a href="../../recuperarContra.php">¿Olvido su contraseña original?</a>
            </form>
        </section>
    </div>
    <!--Para las alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Para los scripts-->
    <script src="../../js/eventos.js"></script>
    <script src="../../js/usuarioEventos.js"></script>
    <footer>
        <p>
            &copy;LEPIOLA.inc. 
            <a href="../../index.html">Regresar a pagina principal</a>
        </p>
    </footer>
</body>
</html>