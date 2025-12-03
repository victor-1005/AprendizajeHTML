<!--PHP-->
<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
    //Incluimos la conexion la BD
    include("./conexion.php");
    
    //Obtenemos los valores del form
    $idUsuario=$_POST['idUsuario'];
    $usuario=$_POST['usuario'];
    $contra=$_POST['contra'];
    //Encriptamos la contra
    $contraEncriptada= password_hash($contra, PASSWORD_DEFAULT);

    //Ahora preparamos una consulta para buscar el id usuario 
    $buscarId=$conexion->prepare("SELECT * from usuarios WHERE id=? LIMIT 1");
    $buscarId->bind_param("i",$idUsuario);
    $buscarId->execute();
    $resultado=$buscarId->get_result();

    if($resultado->num_rows==0){
        header("Location: crearContra.php?msg=noEncontrado");
        exit;
    }else{//Si encuentra el numero de vuelto es mayor a 0 entonces el usuario existe.
        //Preparamos otra consulta para buscar si el id ya esta registrado en la bd con rol
        $buscarRol=$conexion->prepare("SELECT * from rol WHERE idUsuario=? LIMIT 1");
        $buscarRol->bind_param("i",$idUsuario);
        $buscarRol->execute();
        $resultadoRol=$buscarRol->get_result();
        if($resultadoRol->num_rows==0){
            //Preparamos otra consulta para evitar que el usuario ya tenga cuenta
            $queryBuscarUsuario=$conexion->prepare(("SELECT * from rol WHERE usuario=? LIMIT 1"));
            $queryBuscarUsuario->bind_param("s",$usuario);
            $queryBuscarUsuario->execute();
            $resultado2=$queryBuscarUsuario->get_result();
            if($resultado2->num_rows==0){
                //Preparamos la otra consulta para insertar el usuario
                $queryCrearUsuario=$conexion->prepare("INSERT INTO rol (idUsuario, usuario, contra, rol)
                VALUES (?,?,?,'consumidor')");
                $queryCrearUsuario->bind_param("iss",$idUsuario,$usuario,$contraEncriptada);
                //Ejecutamos la query
                if($queryCrearUsuario->execute()){
                    header("Location: crearContra.php?msg=contraOk");
                    exit;
                }else{
                    header("Location: crearContra.php?msg=contraMal");
                    exit;
                }
            }else{
                header("Location: crearContra.php?msg=yaTieneUsuario");
                exit;
            }
        }else{//Si el usuario ya esta duplicado no dejamos que se dupliquen los datos
            header("Location: crearContra.php?msg=duplicado");
            exit;
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
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="./CSS/stilos.css">
</head>
<body>
    <header>
        <h1>Crea tu usuario y contraseña</h1>
    </header>
    <div class="Contenedor">
        <section>
            <h2>Crea tu usuario con tu numero id de la cuenta</h2>
            <form action="crearContra.php" method="POST" class="Formulario">
                <label for="idUsuario">introdusca su id</label>
                <input type="text" name="idUsuario" placeholder="Ejemplo: 1" required >

                <label for="usuario">Crea tu usuario</label>
                <input type="text" name="usuario" placeholder="Ejemplo Victor005" required>

                <label for="contra">Crea tu contraseña</label>
                <input type="text" name="contra" placeholder="Ejemplo: 1234" required>
                <button type="submit" id="btnEnviar">Ingresar</button>
            </form>
        </section>
    </div>
            <p>
            <a href="./login.php">Iniciar sesión</a>
        </p>
    <footer>
        <p>
            &copy; LEPIOLA.inc <br>
            <a href="./index.html">Regresar al index</a>
        </p>
    </footer>
    <!--Para las alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Para los scripts-->
    <script src="./js/eventos.js"></script>
</body>
</html>