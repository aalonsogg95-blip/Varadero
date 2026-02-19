

///////////////////////////////////////////////
    //FUNCIONES GENERALES



    //SPINNER DE CARGANDO
    function Spinner(contenedor){
        const divSpinner = document.createElement('div');
        divSpinner.classList.add('spinner');
        divSpinner.innerHTML=`
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>`;
        contenedor.appendChild(divSpinner);
    }

     

    //LIMPIAR CONTENEDOR
    function limpiarHtml(contenedor){
            while(contenedor.firstChild){
                contenedor.removeChild(contenedor.firstChild);
            }
        }



    //OBTENER FECHA
    function obtenerFecha(){
        let FECHAGeneral= new Date();
         let fecha =FECHAGeneral.getFullYear() +"-"+ String(FECHAGeneral.getMonth() + 1).padStart(2, '0')  + '-' + String(FECHAGeneral.getDate()).padStart(2, '0');
         return fecha;
    }

    //OBTENER HORA
    function obtenerHora(){
        //HORA DEL SISTEMA JAVASCRIPT
        const fechaHora = new Date();
        let h = fechaHora.getHours();
        let m= fechaHora.getMinutes();
        var s = fechaHora.getSeconds()
            let hora=h+":"+m+":"+s;
            return hora;
    }



    //FORMATEAR FECHA
    function formatearFecha(fechaISO){
       // Dividir la cadena en año, mes y día
       var partes = fechaISO.split('-');
       var anual = partes[0];
       var mes = partes[1];
       var dia = partes[2];

       // Formatear la fecha como "DD/MM/YYYY"
       let fechaFormateada = `${dia}/${mes}/${anual}`;
       return fechaFormateada;
    }



   ///FORMATEAR HORA
   function formatearHora(horaActual){
        // Dividir la cadena de tiempo en horas, minutos y segundos
        var [horas, minutos, segundos] = horaActual.split(':');
        let tip="am";

            if(horas>=12){
                tip="pm";
            }

            switch(horas){
                case "13": horas=1; break;
                case "14": horas=2; break;
                case "15": horas=3; break;
                case "16": horas=4; break;
                case "17": horas=5; break;
                case "18": horas=6; break;
                case "19": horas=7; break;
                case "20": horas=8; break;
                case "21": horas=9; break;
                case "22": horas=10; break;
                case "23": horas=11; break;
                case "00": horas=1; break;
            }


            horas = (horas < 10 ? '0' : '') + horas;
            // minutos = (minutos < 10 ? '0' : '') + minutos;
            segundos = (segundos < 10 ? '0' : '') + segundos;

            let horaFormateada=horas+":"+minutos+" "+tip;


        // // Convertir a un objeto Date para manejar el formato de 12 horas
        // var fecha = new Date(2000, 0, 1, horas, minutos, segundos);
        // // Obtener la cadena de tiempo en formato de 12 horas (hh:mm tt)
        // var horaFormateada = fecha.toLocaleString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true }).toLocaleLowerCase();
        return horaFormateada;  // Salida: 09:00 AM
   }
    



   //CORTAR DIAS TRANSCURRIDOS
   function diasTranscurridos(fecha){
        // Fecha de referencia "2023-12-13"
        let fechaReferencia = new Date(fecha);

        // Fecha actual
        let fechaActual = new Date();

        // Diferencia en milisegundos
        let diferenciaEnMilisegundos = fechaActual - fechaReferencia;

        // Convertir la diferencia de milisegundos a días
        let diasTranscurridos = (Math.floor(diferenciaEnMilisegundos / (1000 * 60 * 60 * 24)));

        let cadena="";
        if(diasTranscurridos==1){
            cadena = diasTranscurridos+" dia";
        }else{
            cadena= diasTranscurridos+" dias";
        }


        return cadena;
   }


   //FECHA ACTUAL EN NAVBAR
   function fechaActualNavbar(){
        // Obtener la fecha actual
        let fechaActual = new Date();

        // Obtener el día, el mes y el año
        let dia = fechaActual.getDate();
        let mes = obtenerNombreMes(fechaActual.getMonth()); // Obtener el nombre del mes
        let año = fechaActual.getFullYear();

        // Función para obtener el nombre del mes
        function obtenerNombreMes(numeroMes) {
            const meses = [
                "ene", "feb", "mar", "abr", "may", "jun",
                "jul", "ago", "sep", "oct", "nov", "dic"
            ];
            return meses[numeroMes];
        }

        // Formatear la fecha como "14 dic 2023"
        let fechaFormateada = `${dia} ${mes} ${año}`;
        return fechaFormateada;
        // console.log(fechaFormateada);
   }