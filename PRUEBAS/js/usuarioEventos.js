console.log("Js UsuarioEventos.js Cargado");
//PARA VALIDAR QUE EXISTAN LOS OBJETOS CUANDO SE LLAMEN
const radsiUSUARIO= document.getElementById("si");
if(radsiUSUARIO){
    console.log("JS Usuario Cargado")
    function ObtenerUsuario(){//.textContent es para labels, y value para texbox
        let Usuario=document.getElementById("idUsuario_P").textContent;
        return Usuario;
    }
    function MantenerUsuario(){
        let usuario=ObtenerUsuario();
        const radButton= document.getElementById("si");
        if(radButton.checked){
            document.getElementById("txtUsuario").value=usuario;
            document.getElementById("txtUsuario").readOnly=true;//Usamos readOnly para que el php pueda leer los datos
            //Y que el usuario no puede modificarlos
        }else{
            document.getElementById("txtUsuario").value="";
            document.getElementById("txtUsuario").readOnly=false;//Usamos readOnly para que el php pueda leer los datos
            //Y que el usuario no puede modificarlos
        }
    }
    document.getElementById("si").addEventListener("click",MantenerUsuario);
    document.getElementById("No").addEventListener("click",MantenerUsuario);
}

//PARA VALIDAR SI EXISTE EL OBJETO CUANDO SE LLAME EN EL FORM EDITARVHICULO.PHP
const radbuttonSiVEHICULO=document.getElementById("si_Vehiculo");
if(radbuttonSiVEHICULO){
    //PARA MANTENER LA PLACA
    function obtenerPlaca(){//.textContent es para labels, y value para texbox
        let placa=document.getElementById("Placa_Vehiculo_P").textContent;
        return placa;
    }
    function mantenerPlaca(){
        let placa=obtenerPlaca();
        const radbuttonSi=document.getElementById("si_Vehiculo");
        //validamos si esta chequedo
        if(radbuttonSi.checked){
            document.getElementById("matricula").value=placa;
            document.getElementById("matricula").readOnly=true;//Usamos readOnly para que el php pueda leer los datos
            //Y que el usuario no puede modificarlos
        }else{
            document.getElementById("matricula").value="";
            document.getElementById("matricula").readOnly=false;//Usamos readOnly para que el php pueda leer los datos
            //Y que el usuario no puede modificarlos
        }
    }
    //ASIGNAMOS LOS VALORES DE LA FUNCION
    document.getElementById("si_Vehiculo").addEventListener("click",mantenerPlaca);
    document.getElementById("no_Vehiculo").addEventListener("click",mantenerPlaca);
}

/*
<!--EL FLUJO ES 1: ENVIAR EL ID AL JS (usuarioEventos.js) EL CUAL RECIBE LA INFO
2: REDIRRECCIONA AL editarVehiculo DONDE ESTA PROGRAMADA LA FUNCION
3: VALIDA LOS DATOS Y DESPUES DE ELIMIAR DEVUELVE AL vehiculo.php PORQUE NO EXISTE UN ID-->
 */
const btnElimiar = document.getElementById("Eliminar");
if(btnElimiar){
    //ConfirmarEliminacionvehiculo
    function confirmarEliminacionVehiculo(idAutomotor) {
        Swal.fire({
            title: '¿Eliminar vehículo?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirige a la acción eliminar
                window.location.href = `editarVehiculo.php?accion=eliminarVehiculo&id=${idAutomotor}`;
            }
        });
    }
    //Asignamos los valores de las funciones
    // document.getElementById("Eliminar").addEventListener("click",confirmarEliminacionVehiculo);
}

//PARA CANCELAR EL SERVICIO O PRESTACION O LA TAREA....
/*EL FLUJO ES 1: ENVIAR EL ID AL JS (usuarioEventos.js) EL CUAL RECIBE LA INFO
2: REDIRRECCIONA AL EdicionTarea DONDE ESTA PROGRAMADA LA FUNCION
3:CANCELA EL SERVICIO Y REDIRECCIONA A tareasVehiculo.php ya que es donde se genero la funcion--> */
const btnCancelarServicio=document.getElementById("Cancelar");
if(btnCancelarServicio){
   
    //ConfirmarEliminacionvehiculo
    function confirmarCancelarServicio(idServicio) {
        Swal.fire({
            title: '¿Cancelar Servicio?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, Cancelar',
            cancelButtonText: 'Regresar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirige a la acción eliminar
                window.location.href = `EdicionTarea.php?accion=eliminarServicio&id=${idServicio}`;
            }
        });
    }
}