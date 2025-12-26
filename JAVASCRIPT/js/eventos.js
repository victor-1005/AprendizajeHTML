//PARA SABER SI EXISTE EL BUTTON SE ACCIONA PARA QUE NO ROMPA EL JS
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