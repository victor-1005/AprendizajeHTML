//PARA SABER SI EXISTE EL BUTTON SE ACCIONA PARA QUE NO ROMPA EL JS
console.log("eventos.js Cargado");
const btnCambiarTexto=document.getElementById("btnCambiarTexto");
if(btnCambiarTexto){
    function cambiar(event){
         // Evita que el formulario se envíe y recargue la página ya que usamos un submit....
        event.preventDefault();

        //Obtenemos los valores de textbox
        let var1= document.getElementById("txtNombre").value;
        //Validamos que no este vacio
        let nombre = validarString(var1);
        //Cambiamos el label por el nombre
        document.getElementById("R_lblnombre").innerText=nombre;
        //Cambiamos el texbox por el nombre
        document.getElementById("R_txtnombre").value=nombre;
    }
    //adicionamos la accion
    document.getElementById("btnCambiarTexto").addEventListener("click",cambiar);
}
//Texto directo en consola
const textoConsola=document.getElementById("consol_log");
if(textoConsola){
    let txt= document.getElementById("consol_log");
    function texto(){
        console.group("Información a mostrar");
        console.log("Esto sirve para mostrar información en cosola agrupada")
        console.groupEnd();
        return "Esto aparece en la consola\n no es necesario crear una funcion";
    }
    function escribir(){
        document.getElementById("consol_log").innerText=texto();
    }
    document.getElementById("Accionar").addEventListener("click",escribir);
}

//Texto De asertos
const textoAserto=document.getElementById("Asertos");
if(textoAserto){
    function Aserto(){
        console.assert(5<10,"5 es menor que 10");
        //No hace nada
        console.assert(5<0,"5 es menor que 0");
        // Muestra el mensaje indicado con un aviso de error
        document.getElementById("Asertos").innerText="Esto es como una asertación de condicion solo menciona si es falso o que bajo consola";
    }
    document.getElementById("Accionar_Asertos").addEventListener("click",Aserto);
}

//FUNCIONES AUXILARES
function validarString(valor){
    if(!isNaN(valor)){
        alert("No puede estar vacio el valor o con numeros \nIntente de nuevo");
    }else{
        alert("Dato: ",valor);
        return valor;
    }
}
function validarInt(valor){
    if(isNaN(valor)){
        alert("No puede estar vacio el valor o con texto \nIntente de nuevo");
    }else{
        alert("Dato: ",valor);
        return valor;
    }
}