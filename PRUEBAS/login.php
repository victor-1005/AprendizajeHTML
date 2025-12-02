<!--PHP-->
<?php
    //Añadimos la bd
    include("./conexion.php");
    //iniciamos la sesión
    session_start();//Permie guardar los datos del cliente
    if($_SERVER["REQUEST_METHOD"]==="POST"){//de ley ya que el usuario siempre reincia el form
        //Datos necesarios
        $usuario=$_POST['usuario'];
        $contra=$_POST['contra'];
        //  CONSULTAS PREPARADAS
        //Creamos la consulta segura.
        //la "s" significa string y $usuario la info del usuario, el "bind_param" son parametros que se reemplazan el "?"
        $query=$conexion->prepare("SELECT * FROM rol WHERE usuario =? LIMIT 1");
        $query->bind_param("s",$usuario);
        //Ejecutar la query
        $query->execute();
        //Devuelve los datos de la BD
        $resultado=$query->get_result();

        //Usuario NO encontrado
        if($resultado->num_rows==0){
            header("Location: login.php?error=usuario");
            exit;
        }

        //Obtenemos los datos del usuaio. que se convierten en array $datos
        $datos=$resultado->fetch_assoc();
        //Verificamos la contraseña $contra del usuario, $datos['contra'] viene de la bd encriptada
        if(!password_verify($contra,$datos['contra'])){//!password_very de ley automaticamente compara contraseña encriptadas
            header("Location: login.php?error=pass");
            exit;
        }
        //Creamos los datos de la sesión
        //Variable a guardar y $datos['valor'] viene de la BD
        $_SESSION['idUsuario'] = $datos['idUsuario'];
        $_SESSION['usuario'] = $datos['usuario'];
        $_SESSION['rol'] = $datos['rol'];

        // Redirigir según el rol
        if ($datos['rol'] == "consumidor") {
            header("Location: VISTAS/usuario/indexUsuario.php");
            exit;
        }
        if($datos['rol']=="administrador"){
            header("Location: VISTAS/admin/indexAdmin.php");
            exit;
        }
        // Rol desconocido
        header("Location: login.php?error=rol");
        exit;
    }
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./CSS/stilos.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Inicio de sesión</h1>
    </header>
    <section>
        <form action="login.php?accion=login" method="POST" class="Formulario">
            <label for="usuario">Ingrese su nombre de usuario</label>
            <input type="text" name="usuario" placeholder="Ejemplo victor manuel" required>
            <label for="contra">Ingresa tu contraseña</label>
            <input type="text"name="contra" placeholder="1234">
            <button type="submit">Ingresar</button>
        </form>
    </section>
    <article>
        <p>
            ¿No tienes una cuenta de usuario?
            <a href="./crearCuenta.php">Crear cuenta</a>
        </p>
        <p>
            ¿Ya tienes cuenta pero no usuario?
            <a href="./crearContra.php">Crear Contraseña y Usuario</a>
        </p>
    </article>
    <!--Para las alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Para los scripts-->
    <script src="./js/eventos.js"></script>
    <footer>
        <p>
            &copy;LEPIOLA.inc. 
            <a href="./index.html">Regresar a pagina principal</a>
        </p>
    </footer>
</body>
</html>


