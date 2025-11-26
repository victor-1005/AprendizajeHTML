//Creamos la fucion saludar
function saludar(){
    let nombre= document.getElementById("txtNombre").value;
    let edad=document.getElementById("txtedad").value;

    //alert("Hola: "+nombre+" Su edad es: "+edad+" \nBienvenido");
    //Alerta mejorada js
    Swal.fire({
        title: '¡Bienvenido!',
        html: `Hola <strong>${nombre}</strong><br>Tu edad es: <strong>${edad}</strong>`,
        icon: 'success',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3085d6'
    }); 
}
//Asginamos la funcion al boton
document.getElementById("btnAceptar").addEventListener("click",saludar);