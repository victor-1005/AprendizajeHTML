console.log("JS cargado");
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

//Creamos la fucion saludar
function guardarPHP(){
    let nombres= document.getElementById("txtNombres").value;
    let edades=document.getElementById("txtEdades").value;

    //alert("Hola: "+nombre+" Su edad es: "+edad+" \nBienvenido");
    //Alerta mejorada js
    Swal.fire({
        title: '¡Bienvenido!',
        html: `Hola <strong>${nombres}</strong><br>Tu edad es: <strong>${edades}</strong>`,
        icon: 'success',
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#3085d6'
    }); 
}
//Asignamos la información
// Para el botón de la otra página:
const btnAceptar = document.getElementById("btnAceptar");
if (btnAceptar) {
    btnAceptar.addEventListener("click", saludar);
}

// Para el botón de esta página:
//const btnEnviar = document.getElementById("btnEnviar");
//if (btnEnviar) {
  //  btnEnviar.addEventListener("click", guardarPHP);
//}


//FUNCION DE ALERTA CUANDO SE GUARDE LA INFO
// Verifica si la URL contiene ?status=ok o ?status=error
const params = new URLSearchParams(window.location.search);
const status = params.get("status");

if (status === "ok") {
    Swal.fire({
        title: "¡Registro exitoso!",
        html: "Los datos fueron guardados correctamente.",
        icon: "success",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#3085d6"
    }).then(() => {
        // quitar el parámetro de la URL sin recargar
        window.history.replaceState({}, document.title, "crearCuenta.php");
    });
}

if (status === "error") {
    Swal.fire({
        title: "Ocurrió un error",
        html: "No se pudieron guardar los datos.",
        icon: "error",
    }).then(() => {
        window.history.replaceState({}, document.title, "crearCuenta.php");
    });
}
