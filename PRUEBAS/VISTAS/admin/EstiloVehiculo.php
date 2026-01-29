<!-- PHP -->
<?php

?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilos vehiculo</title>
    <link rel="stylesheet" href="../../CSS/stilos.css">
    <link rel="stylesheet" href="../../CSS/stilosJS.css">
</head>
<body>
    <header>
        <h1>Edicion estilos de vehiculos</h1>
    </header>
    <div class="Contenedor">
        <section>
            <h2>Escoja el tipo de estilo para vehiculo</h2>
            <div class="Zona" id="Zona2">
                <div class="llanta_1" id="llanta_1" draggable="true">
                    
                </div>
                <div class="chasis" id="chasis" draggable="true"></div>
            </div>
        </section>
        <section>
            <h2>Soltar los items aqui</h2>
            <article>
                <div id="Zona" class="Zona">
                    <div class="llanta_2" id="llanta_2" draggable="true">
                    
                </div>
                </div>
            </article>
        </section>
    </div>
    <footer>
        Fin
    </footer>
    <!--PARA ALERTAS-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--PARA LOS EVENTOS-->
    <script src="../../js/eventos.js"></script>
    <script src="../../js/adminEventos.js"></script>
</body>
</html>