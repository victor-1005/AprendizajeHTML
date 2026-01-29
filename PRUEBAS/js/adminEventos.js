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

/*PARA PODER USAR LA FUNCION DE DRGABLE PARA APRENDER A USAR JS DE ARRASTRE Y SUELTA*/
const zona= document.getElementById("Zona");
if(zona){
    //Creamos la otra constante que es llanta 1 de prueba
    const llanta_1= document.getElementById("llanta_1");
    const llanta_2= document.getElementById("llanta_2");
    const chasis= document.getElementById("chasis");
    const zona2= document.getElementById("Zona2");
    
    //Cuando se empieza a arrastrase la llanta_1
    llanta_1.addEventListener("dragstart", function (e){
        e.dataTransfer.setData("text",e.target.id);
    });

    //Para permitir soltar
    zona.addEventListener("dragover",function (e){
        e.preventDefault();
    });

    //Al Soltar
    zona.addEventListener("drop", function(e){
        e.preventDefault();
        const id=e.dataTransfer.getData("text");
        const elemento = document.getElementById(id);
        zona.appendChild(elemento);
    });


    //Al regresar el elemento a la zona2 incialmente
    //Para permitir soltar
    llanta_2.addEventListener("dragstart", function (e){
        e.dataTransfer.setData("text",e.target.id);//id es nombre temporal el cual agarra el id orignal
    });
    chasis.addEventListener("dragstart", function (e){
        e.dataTransfer.setData("text",e.target.id);
    });

    zona2.addEventListener("dragover",function (e){
        e.preventDefault();
    });

    //Al Soltar
    zona2.addEventListener("drop", function(e){
        e.preventDefault();
        const id2=e.dataTransfer.getData("text");
        const elemento2 = document.getElementById(id2);
        zona2.appendChild(elemento2);
    });

}