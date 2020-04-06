function abrirModal(){
    document.getElementById("vModal").style.display="block";
    document.getElementById("msj").innerHTML="";

}

function cerrarModal(){
    document.getElementById("vModal").style.display="none";

}

function subirFoto(id){
    window.location.assign("subirFotos.php?id="+id);
}


function validarFormulario(){
    var flag = false;
    for (var i=1; i<4; i++){
        if (document.getElementById("c"+i).value == "") flag = true;
    }

    if (flag){
        document.getElementById("msj").innerHTML="Debe llenar los campos nombre, descripción y precio";
    }else{
        document.getElementById("msj").innerHTML="";
        document.getElementById("f2").submit();
   }
}