<!-- PHP -->
 <?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("Location: ../.php?error=sesion");
        exit;
    }
    //Evitar volver atrás después del logout
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    //Incluimos la conexio
    include("../../conexion.php");

    //Preparamos una consulta para poder colocar toda la información de los usuairos
    $queryListarUsuarios=$conexion->prepare("SELECT * FROM usuarios");
    $queryListarUsuarios->execute();
    $resultadoListarUsuarios=$queryListarUsuarios->get_result();
    //Almacenamos la informacion en un array
    $listaUsuarios=[];
    while($f=$resultadoListarUsuarios->fetch_assoc()){
        $listaUsuarios[]=$f;
    }

 ?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Registrados</title>
    <link rel="stylesheet" href="../../CSS/stilos.css">
</head>
<body>
    <header>
        <h1>Usuarios Registrados</h1>
    </header>
    <div class="Contenedor">
        <a href="./indexAdmin.php"><button type="button">Volver al index</button></a>
        <a href="../../logout.php"><button type="button">Cerrar sesión</button></a>
        <section>
            <h2>Usurios en el sistema</h2>
            <table>
                <thead>
                    <tr>
                        <th>idUsuario</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>Email</th>
                        <th>Telefono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($listaUsuarios)>0):?>
                        <?php foreach($listaUsuarios as $fila):?>
                            <tr>
                                <td><?= $fila['id'] ?></td>
                                <td><?= $fila['nombre'] ?></td>
                                <td><?= $fila['edad'] ?></td>
                                <td><?= $fila['email'] ?></td>
                                <td><?= $fila['telefono'] ?></td>
                                <td>
                                    <button type="button" class="Editar">Modificar</button>
                                    <button type="button" class="Eliminar">Eliminar </button>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">NO hay usuarios Registrados</td>
                        </tr>
                    <?php endif;?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>