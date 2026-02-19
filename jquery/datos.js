//////////////////////////////////////////////
      ///GUARDAR PRODUCTOS EN LOCAL STORAGE
      function Productos(){
          let gePro=localStorage.getItem("Productos");//OBTENER LOCALSTORAGE (PRODUCTOS)
         
          //VALIDAR SI PRODUCTOS ESTA CREADO EN LOCALSTORAGE
          if(gePro == null){
              //NO ESTA CREADO
             
               $.ajax({
				type:'POST',
				url:'productos.php',
				data:{
                    dir:1
                },//ARREGLO CE CATEGORIAS
				success:function(respro){
					var product = eval(respro);
                    
                   localStorage.setItem('productosVara', JSON.stringify(product));//CREAR LOCALSTORAGE (PRODUCTOS)
				}//CERRAR SUCCESS
               });//CERRAR AJAX    
            
          }else{
             //SI ESTA CREADO     
          }//CERRAR IF //VALIDAR SI PRODUCTOS ESTA CREADO EN LOCALSTORAGE 
          
      }//CERRAR FUNCION *//GUARDAR PRODUCTOS EN LOCAL STORAGE





