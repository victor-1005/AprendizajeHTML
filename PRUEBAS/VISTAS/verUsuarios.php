<!--PHP-->
<?php
    //Inclimos la conexion a la bd
    include("../conexion.php");
    //Creamos la query
    $sql="SELECT * FROM usuarios";
    //Ejecutamos la consulta
    $resultado=$conexion->query($sql);
?>
<!--HTML-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Usuarios</title>
    <link rel="stylesheet" href="../CSS/stilos.css">
</head>
<body>
    <header>
        <h1>Usuarios Ingresados</h1>
    </header>
    <section>
        <a href="../index.html"><button>Regresar al index</button></a>
    <!--Aca iria una tabla leyendo la BD-->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Email</th>
                    <th>Telefono</th>
                </tr>
            </thead>
            <tbody>
                <?php if($resultado->num_rows>0):?>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?=$fila['id']?></td>
                        <td><?=$fila['nombre']?></td>
                        <td><?=$fila['edad']?></td>
                        <td><?= $fila['email'] ?></td>
                        <td><?= $fila['telefono'] ?></td>
                    </tr>
                <?php endwhile;?><!--Este es el fin del while-->
                <?php else:?><!--Este es el else si no hay ningun dato registrado-->
                    <tr>
                        <td colspan="5">No hay usuarios Registrados</td>
                    </tr>
                <?php endif;?>
            </tbody>
        </table>
    </section>
    <footer>
        <p>
            &copy;LEPIOLA.inc. 
        </p>
    </footer>
</body>
</html>