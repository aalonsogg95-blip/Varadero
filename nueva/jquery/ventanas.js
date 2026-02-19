////////////////////////////////////////////////////////////////////
     ///VENTANAS MODALES-MENSAJE
     function ventanasModales(tipo,mensaje){

        //MOSTRAR MODAL
        $("#modal").slideToggle('fast');
                        

        //AGREGAR TEXTO AL MENSAJE
        let modal_text= document.querySelector(".modal_text");
        modal_text.textContent=mensaje;
        //VALIDAR EL TIPO DE MENSAJE
        switch(tipo){
            case 'bien':
            modal_text.classList.remove('adv');
            modal_text.classList.remove('err');
            break;
            case 'adve':
            modal_text.classList.add('adv');
            modal_text.classList.remove('err');
            break;
            case 'erro':
            modal_text.classList.remove('adv');
            modal_text.classList.add('err');
            break;
        }

        //OCULTAR MODAL
        setTimeout(function (){
                $("#modal").slideToggle('fast');

            //ELIMINAR SPAN
                if(document.querySelector('#modal span')){
                    document.querySelector('#modal span').remove();
                    }else{
                        
                    }
                },2000
            );

    }