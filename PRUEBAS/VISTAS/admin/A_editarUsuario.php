<!-- PHP -->
 <?php
    //inicamos la sesión
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: ../.php?error=sesion");
        exit;
    }
    //Evitar volver atrás después del logout
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    
    //Incluimos la conexion a la BD
    include("../../conexion.php");

    //Ahora con el metodo get obtenemos los valores de la información del usuario
    /*PARA RECUPERAR LOS DATOS DEL USUARIO A EDITAR, ESTE SE OBTIENE CON EL ID MANDADO EN EL FORM ATERIOR
    CON ESE ID COLOCAMOS LOS DATOS EN EL FORM Y DESPUES VEMOS COMO LOS ACTUALIZAMOS*/
    if(!isset($_GET['id'])){//por si pasa un error, que no se bugee
        header("Location: indexAdmin.php?msg=idInvalido");
        exit;
    }
    $idUsuario = $_GET['id'];
    //Obtenemos los datos del usuario
    $queryBuscarUsuario=$conexion->prepare("SELECT * FROM usuarios WHERE id=?");
    $queryBuscarUsuario->bind_param("i",$idUsuario);
    $queryBuscarUsuario->execute();
    $resultadoBuscarUsuario=$queryBuscarUsuario->get_result();
    $datosUsuario=$resultadoBuscarUsuario->fetch_assoc();

    //PARA SABER SI SE ELIMINA EL USUARIO
    /*asi se hace por si se usan funciones de js, 
    php entiende usar "accion" y verifica el mensaje "eliminarUsuario"(viene del js)*/
    if(isset($_GET["accion"]) && $_GET["accion"]==="eliminarUsuario"){

    }//Fin eliminar Usuario
    if($_SERVER["REQUEST_METHOD"]=="POST"){//Para actualizar la información
        //Declaramos los valores que vienen del form
        $id=$_POST['idUsuario'];
        $nombre=$_POST['Nombre'];
        $edad=$_POST['Edad'];
        $email=$_POST['Email'];
        $telefono=$_POST['NumTelefono'];

        //Creamos la query para actualizar la información
        $queryActualizarUsuario=$conexion->prepare("UPDATE usuarios SET nombre=?, edad=?, email=?, telefono=? WHERE id=?");
        $queryActualizarUsuario->bind_param("sissi",$nombre,$edad,$email,$telefono,$id);
        if($queryActualizarUsuario->execute()){
            //Redireccionamos a verUsuario
            header("Location: A_verUsuarios.php?id=$id&msg=UsuarioActualizado");
            exit;
        }else{
            header("Location: A_verUsuarios.php?$id&msg=Error");
            exit;
        }
    }
 ?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuarios</title>
    <link rel="stylesheet" href="../../css/stilos.css">
</head>
<body>
    <header>
        <h1>Edición de Usuarios</h1>
    </header>
    <div class="Contenedor">
        <section>
            <h2>Información del usuario</h2>
            <form action="A_editarUsuario.php?id=<?= $datosUsuario['id'] ?>" method="POST" class="Formulario">
                <input type="hidden" name="accion" value="modUsuario">

                <label for="idUsuario">Id del usuario</label>
                <input type="text" name="idUsuario" id="idUsuario" value="<?= $datosUsuario['id'] ?>" readonly>

                <label for="Nombre">ingresa tu nombre completo</label>
                <input type="text" name="Nombre" id="txtNombres" value="<?= $datosUsuario['nombre'] ?>" placeholder="EJemplo: Victor Manuel" required>
        
                <label for="Edad">Ingresa tu edad</label>
                <input type="text" name="Edad" id="txtEdades" value="<?= $datosUsuario['edad'] ?>" placeholder="EJemplo: 20" required>

                <label for="Email">Ingresa tu Correo</label>
                <input type="text" name="Email" id="txtEmail" value="<?= $datosUsuario['email'] ?>" placeholder="EJemplo: vic@gmail.com" required>

                <label for="NumTelefono">Ingresa tu numero de telefono</label>
                <input type="text" name="NumTelefono" id="txtNumTelefono" value="<?= $datosUsuario['telefono'] ?>" placeholder="EJemplo: 71309080" required>
                
                <button type="submit">Actualizar</button>
                <a href="./A_verUsuarios.php"><button type="button" class="Cancelar">Cancelar</button></a>
            </form>
        </section>
    </div>
    <!--PARA ALERTAS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--PARA LOS EVENTOS-->
    <script src="../../js/eventos.js"></script>
</body>
</html>