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
        <form action="./login.php" method="POST" class="Formulario">
            <label for="nombre">Ingrese su nombre de usuario</label>
            <input type="text" name="nombre" placeholder="Ejemplo victor manuel" required>
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
    </article>
    <footer>
        <p>
            &copy;LEPIOLA.inc. 
            <a href="./index.html">Regresar a pagina principal</a>
        </p>
    </footer>
</body>
</html>