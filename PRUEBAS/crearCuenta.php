<!--Conexion y procesamiento de datos-->
<?php
// -------------------------
// PROCESAR DATOS CUANDO SE ENVÍE EL FORMULARIO
// -------------------------

$mensaje="";//Para mosrar el feedback al usuario

if($_SERVER["REQUEST_METHOD"]=="POST"){//Para verificar si el usuario "Reinicio el form"

    //Abrimos la BD
    include("conexion.php");

    //Declaramos los valores que esperamos del form
    //POST es variable de ley que obtiene la info despues del post
    $nombre=$_POST['Nombre'];//Lo que esta entre comillas debe conicidir con el name del input
    $edad=$_POST['Edad'];
    $email=$_POST['Email'];
    $telefono=$_POST['NumTelefono'];

    //Creamos una validación rapida
    if(!empty($nombre) && !empty($edad)&& !empty($email) && !empty($telefono)){
        //si no esta vacio insertamos la bd
        
        //Creamos la query
        $sql="INSERT INTO usuarios (nombre, edad, email, telefono)
         VALUES('$nombre', '$edad', '$email', '$telefono')";

        //Ejecutamos la query
        if($conexion->query($sql)===TRUE){
            //Para que el js funcione
            header("Location: crearCuenta.php?status=ok");
            exit;
            //Para que se imprima el p
            $mensaje=" Cuenta Creada con éxito.";
        }else{
            //Para que funcione el js
            header("Location: crearCuenta.php?status=error");
            exit;
            //Para que se imprima el p
            $mensaje="Error al guardar: ".$conexion->error;
        }
    }else{#if de que todo este lleno
        // También podrías redirigir con otro tipo de error:
        header("Location: crearCuenta.php?status=vacio");
        exit;
        //Para que se imprima el p
        $mensaje="Debes llenar todos los camos";
    }
}
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta</title>
    <link rel="stylesheet" href="./CSS/stilos.css">
</head>
<body>
    <h1>Crea tu cuenta facilmente</h1>
    <!--Mostrar el mensaje despues de enviar-->
    <?php if(!empty($mensaje)): ?><!--si la variable NO ESTA VACIA muestra el siguiente P HTML-->
        <p style="background:#eee; padding:10px; border-radius:5px;">
             <?=$mensaje?><!--forma abreviada de imprimir <//?php echo $mensaje; ?>-->
        </p>
    <?php endif; ?><!--Cierre del if-->
    <section>
        <form action="crearCuenta.php" method="POST" class="Formulario">
            <label for="Nombre">ingresa tu nombre completo</label>
            <input type="text" name="Nombre" id="txtNombres" placeholder="EJemplo: Victor Manuel" required>
        
            <label for="Edad">Ingresa tu edad</label>
            <input type="text" name="Edad" id="txtEdades" placeholder="EJemplo: 20" required>

            <label for="Email">Ingresa tu Correo</label>
            <input type="text" name="Email" id="txtEmail" placeholder="EJemplo: vic@gmail.com" required>

            <label for="NumTelefono">Ingresa tu numero de telefono</label>
            <input type="text" name="NumTelefono" id="txtNumTelefono" placeholder="EJemplo: 71309080" required>
            <button type="submit" id="btnEnviar">Ingresar</button>
        </form>
    </section>
    <footer>
        <p>
            &copy;LEPIOLA.inc. 
            <a href="./index.html">Regresar a pagina principal</a>
        </p>
    </footer>
    <!--Para las alertas-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Para los scripts-->
    <script src="./js/eventos.js"></script>
</body>
</html>