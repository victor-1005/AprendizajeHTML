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