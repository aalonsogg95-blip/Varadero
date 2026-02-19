//ELIMINAR SESION DE USUARIO
function cerrarSesion(area){
    if(area=="ord"){
        sessionStorage.removeItem('usserO');
        //ELIMINAR LOCALSTORAGE
        localStorage.removeItem("consumoVara");
        localStorage.removeItem("lugarVaradero");
        localStorage.removeItem("productosVara");  
        localStorage.removeItem("obserCelularVaradero");
        //REDIRECCIONAR
        window.location.href="../index.html";
    }else if(area=="coc"){
        sessionStorage.removeItem('usserCoc');
        //ELIMINAR LOCALSTORAGE
        localStorage.removeItem("contadorPendCoc");
        localStorage.removeItem("mosOrdenes");
        //REDIRECCIONAR
        window.location.href="index.html";
    }else if(area=="caj"){
        sessionStorage.removeItem('usserCaj');
        //ELIMINAR LOCALSTORAGE
        localStorage.removeItem("contadorEntCaj");
        //REDIRECCIONAR
        window.location.href="index.html";
    }else if(area=="adm"){
        sessionStorage.removeItem('usserA');
      
        //window.location.href="index.html";
    }else if(area=="pro"){
        sessionStorage.removeItem('usserA');
       
        //window.location.href="../index.html";
    }else if(area=="est"){
        sessionStorage.removeItem('usserA');
      
        //window.location.href="../index.html";
    }else if(area=="gas"){
        sessionStorage.removeItem('usserA');
      
       //window.location.href="../index.html";
    }    
}



//VALIDAR LA SESION DE USUARIO
function validarUsuario(area){

    if(area=="ord"){
        if(sessionStorage.getItem('usserO')){
        }else{
            //ELIMINAR LOCALSTORAGE
        localStorage.removeItem("consumoVara");
        localStorage.removeItem("lugarVaradero");
        localStorage.removeItem("productosVara");  
        localStorage.removeItem("obserCelularVaradero");
        //REDIRECCIONAR
            window.location.href="../index.html"; }
    
    }else if(area=="coc"){
        if(sessionStorage.getItem('usserCoc')){
        }else{
            //ELIMINAR LOCALSTORAGE
            localStorage.removeItem("ContadorPendCoc");
            localStorage.removeItem("mosOrdenes");
            //REDIRECCIONAR
            window.location.href="index.html"; }

    }else if(area=="caj"){
            if(sessionStorage.getItem('usserCaj')){
            }else{
                //ELIMINAR LOCALSTORAGE
                localStorage.removeItem("ContadorEntCaj");
                //REDIRECCIONAR
                window.location.href="index.html"; }
    
    }else if(area=="adm"){
            if(sessionStorage.getItem('usserA')){
            }else{ window.location.href="index.html"; }
    
    }else if(area=="pro"){
        if(sessionStorage.getItem('usserA')){
        }else{window.location.href="../index.html"; }

    }else if(area=="est"){

        if(sessionStorage.getItem('usserA')){
        }else{ window.location.href="../index.html"; }

    }else if(area=="gas"){

        if(sessionStorage.getItem('usserA')){
        }else{ window.location.href="../index.html"; }

    }
}



//INICIO DE SESION EN INDEX
//VALIDAR SI YA SE HABIA INICIADO SESION
function sesion(i){
    switch(i){
        case 1: 
        //ORDENES
                //SI LA SESION YA EXISTE
                if(sessionStorage.getItem('usserO')){
                    //YA EXISTE, REDIRECCIONAR A ORDENES
                    window.location.href="orden/orden.html";
                }else{
                    //NO EXISTE, LIMPIAR EL LOCAL STORAGE
                    localStorage.removeItem("consumoVara");
                    localStorage.removeItem("lugarVaradero");
                    localStorage.removeItem("productosVara");  
                    localStorage.removeItem("obserCelularVaradero");  
                }
        break;
        case 2:
            //COCINA
                //SI LA SESION YA EXISTE
                if(sessionStorage.getItem('usserCoc')){
                    //YA EXISTE, REDIRECCIONAR A ORDENES
                    window.location.href="cocina.html";
                }else{
                    console.log("coc");
                    //NO EXISTE, LIMPIAR EL LOCAL STORAGE
                    localStorage.removeItem("ContadorPendCoc");
                    localStorage.removeItem("mosOrdenes");
                }
        break;
        case 3:
            //CAJA
                 //SI LA SESION YA EXISTE
                 if(sessionStorage.getItem('usserCaj')){
                    //YA EXISTE, REDIRECCIONAR A ORDENES
                    window.location.href="caja.html";
                }else{
                    //NO EXISTE, LIMPIAR EL LOCAL STORAGE
                    localStorage.removeItem("ContadorEntCaj");
                }
        break;
    }
    
}