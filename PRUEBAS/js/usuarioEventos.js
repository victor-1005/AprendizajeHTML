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