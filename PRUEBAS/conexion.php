<?php
//Valores de conexion
$servidor="localhost";
$usuario="root";
$clave="";
$baseDatos="pruebas";
//Cadena de conexion 
$conexion = new mysqli($servidor,$usuario,$clave,$baseDatos);
//Abrimos la BD
if($conexion->connect_error){
    die("Error al conectar: ".$conexion->connect_error);
}
?>