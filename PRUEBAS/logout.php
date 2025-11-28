<?php
session_start();      // Iniciar sesión para poder destruirla
session_unset();      // Borra todas las variables de sesión
session_destroy();    // Destruye la sesión por completo

// Evitar que el usuario regrese con el botón "atrás"
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");

// Redirigir al login
header("Location: login.php?logout=ok");
exit;
?>