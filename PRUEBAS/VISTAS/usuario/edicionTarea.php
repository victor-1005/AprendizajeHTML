<?php
    //Agregamos la coneion a la bd EDICION TAREA
    include("../../conexion.php");
//Recuperamos el id del servicio para poder realizar la accion de cancelar
    if(!isset($_GET['id'])){
        header("Location: tareasVehiculo.php?msg=idServicioNovalido");
    }
    $idServicio=$_GET['id'];
    //Ahora con ese id nospreparamos para cancelar el servicio.
    if(isset($_GET["accion"]) && $_GET["accion"]==="eliminarServicio"){
        //Preparamos la query para actualizar el servicio a cancelada
        $queryCancelarServicio=$conexion->prepare("UPDATE tarea SET estado=? WHERE idServicio=?");
        $Var_ServicioCancelado="cancelada";
        $queryCancelarServicio->bind_param("ss",$Var_ServicioCancelado,$idServicio);
        if($queryCancelarServicio->execute()){
            header("Location: tareasVehiculo.php?msg=servicioCancelado");
            exit;
        }else{
            header("Location: tareasVehiculo.php?msg=errorCancelarServicio");
            exit;
        }
    }
?>