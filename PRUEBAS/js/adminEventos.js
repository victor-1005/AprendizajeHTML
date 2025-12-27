console.log("Js adminEventos.js Cargado");
/*
<!--EL FLUJO ES 1: ENVIAR EL ID AL JS (adminEventos.js) EL CUAL RECIBE LA INFO
2: REDIRRECCIONA AL A_editarUsuario.php DONDE ESTA PROGRAMADA LA FUNCION
3: VALIDA LOS DATOS Y DESPUES DE ELIMIAR DEVUELVE ALA_verUsuarios.php PORQUE NO EXISTE UN ID-->
*/
const btnEliminar=document.getElementById("Eliminar");
if(btnEliminar){
    //ConfimarEliminarUsuario.
    function confirmarEliminarUsuario(idUsuario){
        Swal.fire({
            title: '¿Eliminar el Usuario?',
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
                window.location.href = `A_editarUsuario.php?accion=eliminarUsuario&id=${idUsuario}`;
            }
        });
    }
}