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

// Para el botón de esta página: YA NO LO NECESITAMOS COMO ERA DE PRUEBAS XD
//const btnEnviar = document.getElementById("btnEnviar");
//if (btnEnviar) {
  //  btnEnviar.addEventListener("click", guardarPHP);
//}


//FUNCION DE ALERTA CUANDO SE GUARDE LA INFO
// Verifica si la URL contiene ?msg=ok o ?msg=error
const params = new URLSearchParams(window.location.search);
const msg = params.get("msg");

if (msg === "ok") {
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

if (msg === "error") {
    Swal.fire({
        title: "Ocurrió un error",
        html: "No se pudieron guardar los datos.",
        icon: "error",
    }).then(() => {
        window.history.replaceState({}, document.title, "crearCuenta.php");
    });
}
//Cierre de sesión
const param = new URLSearchParams(window.location.search);
const logout = param.get("logout");
if(logout=="ok"){
    Swal.fire({
        icon:"info",
        title:"Sesión cerrada",
        text:"Has cerradao sesión correctamente",
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        window.history.replaceState({}, document.title, "login.php");
    });
}
//Contraseña incorrecta
const paramContra = new URLSearchParams(window.location.search);//Parametros de ley
const msgContra = paramContra.get("error");//esto es lo que definimos arriba del php  cuando colocamos header
if(msgContra=="pass"){
    Swal.fire({
        icon:"error",
        title:"Contraseña Incorrecta",
        text:"Ingresa la contraseña correcta",
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        window.history.replaceState({}, document.title, "login.php");
    });
}
if(msgContra=="usuario"){
    Swal.fire({
        icon:"warning",
        title:"Usuario no encontrado",
        text:"Usuario no registrado en el sistema",
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        window.history.replaceState({}, document.title, "login.php");
    });
}
if(msgContra=="rol"){
     Swal.fire({
        icon:"error",
        title:"ERROR",
        text:"Error desconocido",
        timer: 1500,
        showConfirmButton: false
    }).then(() => {
        window.history.replaceState({}, document.title, "login.php");
    });
}
