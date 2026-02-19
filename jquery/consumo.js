

    //**  CODIGO QUE SE EJECUTA AL CARGAR EL ARCHIVO VENTA.HTML
    //CONTENEDOR CONSUMO
    


    //VARIABLES
    const Local= document.querySelector('#meslocal');
    const Llevar= document.querySelector('#nomllevar');
    const Domicilio= document.querySelector('#dirdomicilio');
    
    



    //AGREGAR EVENTO AL HACER CLICK EN LOS RADIOS INPUT DE CONSUMO
    const consumoProductos=  document.querySelectorAll('.conPro');
        consumoProductos.forEach(con=>con.addEventListener('click',()=>{
            mostrarConsumoPro();
            //totalVenta();
            
      }));

      //AGREGAR EVENTO AL ESCRIBIR TEXTO EN LOS CAMPOS DE CONSUMO
    const campConsumo=  document.querySelectorAll('.campConsumo');
        campConsumo.forEach(con=>con.addEventListener('change',()=>{
            ajustarContenidoCampo();
            
    }));


     

      
      //CONSUMO AL CARGAR LA PAGINA 
      //SI NO ESTA GUARDADO CONSUMO EN EL NAVEGADOR, POR DEFECTO ES *LOCAL M1
      function consumoInicial(){
        let consumo= JSON.parse(localStorage.getItem('consumoVara')) || 1;
        let cons=document.querySelectorAll(".conPro")[consumo-1].checked='true';
        
        let lugar= JSON.parse(localStorage.getItem('lugarVaradero')) || [];
        if(lugar.length==0){
          lugar[0]="M1";
            lugar[1]='';
            lugar[2]='';
          localStorage.setItem("lugarVaradero", JSON.stringify(lugar));
        }
        


      }
    



      //MOSTRAR LOS CAMPOS PARA AGREGAR INFORMACIÓN DE CONSUMO
      function mostrarConsumoPro(){
        //OBTENER EL NUMERO RADIO BUTTON CHECKEADO *LOCAL(1) *PARA LLEVAR(2) *DOMICILIO(3)
        let con=document.querySelector("input[name=consumo]:checked").value;
     
              

            switch(con){
                //LOCAL
                case '1': $("#mesa").show(); $("#nombre").hide(); $("#direccion").hide();
                //ajustarContenidoCampo();
                break;
                //LLEVAR
                case '2': $("#nombre").show(); $("#mesa").hide(); $("#direccion").hide();
               //SI CONTADOR ES MAYOR QUE 0 MOSTRAR CONTENEDOR CON CAMPOS ADICIONALES   
                break;
                //DOMICILIO
                case '3': $("#direccion").show(); $("#mesa").hide(); $("#nombre").hide();
                //SI CONTADOR ES MAYOR QUE 0 MOSTRAR CONTENEDOR CON CAMPOS ADICIONALES
                
                break;
            }

            //FUNCIONES
            mostrarContenidoCampo();//MOSTRAR INFORMACIÓN EN LOS CAMPOS DE CONSUMO
            obserCelularMostrar();//MOSTRAR INFORMACIÓN EN LOS CAMPOS ADICIONALES DE CONSUMO
            //ACTUALIZAR NUMERO DE CONSUMO
            localStorage.setItem('consumoVara', con);
        }



    //CAMPOS DE CONSUMO
            //*LOCAL - MESA:
            //*PARA LLEVAR - NOMBRE:
            //*DOMICILIO - DIRECCIÓN:
      

      //GUARDAR INFORMACIÓN ADICIONAL DEL CLIENTE
        //LA FUNCION SE EJECUTA AL CAMBIAR CLICK EN LOS CAMPOS DE CONSUMO
        function ajustarContenidoCampo(){

            let lugar= JSON.parse(localStorage.getItem('lugarVaradero')) || [];
          
            lugar[0]=(Local.value);
            lugar[1]=((Llevar.value).normalize("NFD").replace(/[\u0300-\u036f-#""]/g, ""));
            lugar[2]=((Domicilio.value).normalize("NFD").replace(/[\u0300-\u036f-#""]/g, ""));
            
        localStorage.setItem("lugarVaradero", JSON.stringify(lugar));

      }

      //MOSTRAR INFORMACIÓN ALMACENADA EN LOCALSTORAGE
        //LA FUNCION SE EJECUTA, AL PRECIONAR EN LOS RADIO BUTTONS
      function mostrarContenidoCampo(){
        //console.log("Mostrar contenido de campos")
        let lugar= JSON.parse(localStorage.getItem('lugarVaradero')) || [];
        //console.log(lugar[0]);
        Local.value=lugar[0] || "M1";
        Llevar.value=lugar[1] || "";
        Domicilio.value=lugar[2] || "";
      }



      /********************************************************** */
    //OBSERVACIONES CAMPO 
            //*PARA LLEVAR OBS:
            //*DOMICILIO CELL:

        //GUARDAR INFORMACIÓN ADICIONAL - OBSERVACIONES Y CELULAR
        //LA FUNCION SE EJECUTA AL CAMBIAR CLICK EN LOS CAMPOS DE OBSERVACIONES Y CELULAR
      function obserCelular(){
          
        let llevObs=(document.querySelector('#llevObs').value).normalize("NFD").replace(/[\u0300-\u036f-#""]/g, "");
        let celular=(document.querySelector('#celular').value).normalize("NFD").replace(/[\u0300-\u036f-#""]/g, "");

        let obserCelular=[llevObs, celular];
        localStorage.setItem("obserCelularVaradero", JSON.stringify(obserCelular));

    }


    //MOSTRAR INFORMACIÓN ALMACENADA EN LOCALSTORAGE
        //LA FUNCION SE EJECUTA, AL PRECIONAR EN LOS RADIO BUTTONS
    function obserCelularMostrar(){
        let obs, cel;
      let obserCelular=(JSON.parse(localStorage.getItem("obserCelularVaradero"))) || [];
      if(obserCelular.length==0){
          obs  = obserCelular="";
          cel= obserCelular="";
      }else{
           obs=obserCelular[0];
           cel=obserCelular[1];
      }
      let llevObs=document.querySelector('#llevObs').value=obs;
      let celular=document.querySelector('#celular').value=cel;
    }








 



















