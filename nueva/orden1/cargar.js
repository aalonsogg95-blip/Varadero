

 //////////////////////////////////////////////////////
    ///CARGAR CATEGORIAS LOCALSTORAGE
    function cargarCategoriasLocal(){
        let getCategorias=localStorage.getItem("categoriasVaradero");//OBTENER LOCALSTORAGE (PRODUCTOS)
          //VALIDAR SI PRODUCTOS ESTA CREADO EN LOCALSTORAGE
          if(getCategorias == null){

        
                $.ajax({
                type:'GET',
                    url:'cargar_categorias.php',
                    success:function(resps){
                    let categorias=eval(resps);
                        localStorage.setItem("categoriasVaradero", JSON.stringify(categorias));
                        mostrarCategorias();
                        }
                });
            }else{
                mostrarCategorias();
            }
    }


     //////////////////////////////////////////////////////
    ///CARGAR PRODUCTOS LOCALSTORAGE
    function cargarProductosLocal(){
        let getProductos=localStorage.getItem("productosVaradero");//OBTENER LOCALSTORAGE (PRODUCTOS)
          //VALIDAR SI PRODUCTOS ESTA CREADO EN LOCALSTORAGE
          if(getProductos == null){
        
                $.ajax({
                type:'GET',
                    url:'cargar_productos.php',
                    success:function(resps){
                    let productos=eval(resps);
                        localStorage.setItem("productosVaradero", JSON.stringify(productos));
                        
                        }
                });
            }
            
    }


