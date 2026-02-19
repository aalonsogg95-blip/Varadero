
var meses=["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre","Diciembre"];

//FECHA EN LA PARTE SUPERIOR DE CADA PAGINA
function fecha(){
        const fecha = new Date();
        const sem= fecha.getDay();
        let hoy = fecha.getDate();
        if(hoy<10){
            hoy="0"+hoy;
        }
        const mes = fecha.getMonth(); 
        const ano = fecha.getFullYear();
        
        var semana=["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
    
        var StringFecha=semana[sem]+" "+hoy+" de "+meses[mes]+" del "+ano;
        document.getElementById("fecha").innerHTML=StringFecha;
    }


//FECHA PARA CAMPO DE FECHA EN FORMULARIO
function formatDate() {
    
    var d = new Date(),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) 
        month = '0' + month;
    if (day.length < 2) 
        day = '0' + day;

    
    var fe=document.getElementById('fechacamp');
    if(fe!=null){
        fe.value=year+"-"+month+"-"+day; 
    }
    
    var fecGasto=document.getElementById("fechacampp");
    if(fecGasto!=null){
        fecGasto.value=year+"-"+month+"-"+day;
    }
    
    //ESTADISTICAS
    var mes_mes=document.getElementById("mes_mes");
    var mes_anual=document.getElementById("mes_anual");
    if(mes_mes != null){
       mes_mes.value=month;
        anual.value=year;
       }
    var ano_anual=document.getElementById("ano_anual");
    if(ano_anual!=null){
        ano_anual.value=year;
    }
    
}

