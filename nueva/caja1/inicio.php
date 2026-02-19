<?php
     session_start();
     $usuario= $_SESSION["datosUsuarioCaja"]["usuario"];

    if($usuario==""){
         header("location: index.php");
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varadero | Caja</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="../boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="../spinner.css">
    <link rel="stylesheet" href="../ventanas.css">

    <link rel="shortcut icon" type='image/x-icon' href='../img/varadero_logo.png'>
</head>
<body>

    <!-- NAVBAR -->
    <nav id="navbar" class="bd">
        <div class="navbar_contenedor">
            <div class="navbar_logo bd">
                    <img src="../img/varadero_logo.png" alt="">
                    <h2>Caja</h2>
            </div>
    
            <div class="navbar_usuario bd">
                <h2>Bienvenido <?php echo "<span>$usuario</span>!"?></h2>
                <img class="navbar_avatar" src="../img/avatar.png" alt="">
                <a href="#/" onclick='cerrarSesion()'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
    
        </div>
    </nav>


        <div id='contador' class='bd'>
            <h1>Cuentas registradas: <span>0</span></h1>
            
        </div>


        <section id='principal' class='bd'>
        

        </section>

  

        <!-- MODAL AGREGAR PRODUCTO A VENTA -->
    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarProductoLabel"><span><i class="fa-solid fa-circle-plus"></i> Agregar</span> producto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">

                <form action="#">
                    <div class="error-txt-productos error-txt"></div>

                    <div class="field input bd">
                            <label for="">Cantidad</label>
                            <input type="number" name="Pcantidad"  required oninput='obtenerTotal()'>
                            <input type="hidden" name="idcliente">
                    </div>

                    <div class="field input bd">
                            <label for="">Nombre producto</label>
                            <input type="text" name="Pnombre" placeholder="Nombre..." required>
                    </div>

                    <div class="field input bd">
                            <label for="">Costo</label>
                            <input type="number" name="Pcosto" placeholder="$" oninput='obtenerTotal()' required>
                    </div>

                    <div class="field input bd">
                            <label for="">Total</label>
                            <input type="text" name="Ptotal" placeholder="$" readonly>
                    </div>
                
                    <div class="button input">
                            <input type="submit" class='btnAgregarProducto' value="Registrar">
                    </div>
                        
                  </form>
            
            
                </div>
            </div>
        </div>
    </div>




       <!-- MODAL ELIMINAR VENTA -->
       <div class="modal fade" id="modalEliminarCuentas" tabindex="-1" role="dialog" aria-labelledby="modalEliminarCuentasLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarCuentasLabel"><span><i class="fa-solid fa-trash-can"></i> Eliminar cuenta</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">

                            <table>
                                <tr>
                                    <th><input type="hidden" name='Eidcliente'>
                                        ¿Seguro que desea eliminar el cliente <span id='lugarEliminar'></span>?</th>

                                </tr> 
                                <tr>
                                    <td>
                                        <button class='btnNo' onclick='cancelarVentanaEliminar()'>No</button>
                                        <button onclick='eliminarCuenta()'>Si</button></td>
                                </tr>
                            </table>
            
                </div>
            </div>
        </div>
    </div>

   


     <!-- VENTANA MODAL GENERAL -->
     <div class="modal_confirmado" id='modal'>
            <p class='modal_text'></p>
        </div>



        <div id="resultado">

        </div>


   
        

    <div id='linkGastos'>
        <a href="gastos/gastos.php"><i class="fa-solid fa-money-bill-wave"></i></a>
    </div>



     <div id='linkHistorial'>
        <a href="historial/historial.php"><i class="fa-solid fa-clock-rotate-left"></i></a>
    </div>


    <footer>
        <p>v3</p>
    </footer>


    <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
    <div class="mensajeDispositivos">
            <img src="../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>

     
    <script src="../boostrap/bootstrap.bundle.min.js"></script> 
    <script src="../boostrap/popper.min.js"></script>
    <script src="../jquery/jquery-3.5.1.min.js"></script> 
    <script src="../jquery/generales.js"></script> 
    <script src="../jquery/ventanas.js"></script>
</body>
</html>
<script type="text/javascript">

     //CARGAR FUNCIONES AL RECARGAR PAGINA
     $(document).ready(function(){

        setInterval(()=>{
            contadorOrdenes();
        }, 5000);

        cargarCuentas();
        cargar_envio();


            $(window).focus(function() {
                cargarCuentas();
            });
        
     });

     let principal_mostrar= document.querySelector('#principal');

     function contadorOrdenes(){
        $.ajax({
        type:'POST',
        url:'contar_ordenes.php',
        success:function(resp){
            let resultado=parseInt(eval(resp));
                let contador= localStorage.getItem("contadorCajaVaradero");
                    //  console.log(contador);

                    if(!localStorage.getItem("contadorCajaVaradero")){
                       localStorage.setItem("contadorCajaVaradero", parseInt(0));//GUARDAR LOCALSTORAGE 
                    }else{
                        if(resultado>contador){
                            localStorage.setItem("contadorCajaVaradero", resultado);//GUARDAR LOCALSTORAGE 
                                cargarCuentas();  
                        }else if(resultado<contador){
                                  
                           localStorage.setItem("contadorCajaVaradero", resultado);//GUARDAR LOCALSTORAGE
                                cargarCuentas();  
                        }else{}
                    }
            }
        });
     }

     
     let cuentas=[];
     function cargarCuentas(){
        $.ajax({
        type:'POST',
        beforeSend: function() { Spinner(principal_mostrar)},
        complete: function() { mostrarCuentas()},
        url:'cargar_cuentas.php',
        success:function(resp){
            cuentas=eval(resp);
            //  console.log(cuentas);
                document.querySelector('#contador span').textContent=cuentas.length;
            }
        });
     }


      function mostrarCuentas(){
         limpiarHtml(principal_mostrar);
         if(cuentas.length>0){
             for(c=0; c<cuentas.length; c++){
                 let {cli_id_cliente, cli_consumo, cli_lugar, cli_observacion, cli_fecha, ordenes}=cuentas[c];

                 let stringCuenta=JSON.stringify(cuentas[c]);

                 let TOTALventa=ordenes.reduce((total, producto)=>total + parseInt(producto.ord_total),0);

    
                 let fecha=obtenerFecha();
                

                    //CELULAR
                    let textCelular="";
                    if(cli_observacion!="vacio"){
                        textCelular=`
                        <div class='tooltipp'>
                            <a href='#/' class='spanCelular' onclick='activarTooltip(${cli_id_cliente})' class='disparadorTooltip'><i class="fa-solid fa-phone"></i></a>

                            <div class='content_tooltip' id='tooltip${cli_id_cliente}'>
                                    <span class='spanRecomendacion'>${cli_observacion}</span>
                                </div>
                        </div>`;

                    }

                    //COSTO DOMCIILIO
                    let textEnvio="";
                    if(cli_consumo==3){
                        let envio = localStorage.getItem("costoEnvioVaradero");
                        textEnvio=`<label>Envio </label><input type='number' value=${envio} id='inputEnvio${cli_id_cliente}'>`;
                    }




                //MOSTRAR VENTA
                let divMesa= document.createElement('div');
                                divMesa.classList.add("mesa");

                                if(cli_consumo!=1){
                                    divMesa.classList.add("llevar");
                                }

                                let divCabecera= document.createElement('div');
                                    divCabecera.classList.add("cabecera");
                                    divCabecera.innerHTML=`<table>
                                                                <tr>
                                                                    <th colspan='5'>
                                                                    <a href='#/' class='eliminarcuenta' onclick='modalEliminarCuenta(${cli_id_cliente}, "${cli_lugar}")'><i class="fa-solid fa-trash-can"></i></a>
                                                                    ${cli_lugar}
                                                                    ${textCelular}
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                 <th>Total <span>$${new Intl.NumberFormat().format(TOTALventa)}</span></th>
                                                                 <th><a href='#/' onclick='pagar(${stringCuenta}, ${cli_id_cliente}, ${cli_consumo}, ${TOTALventa})'><i class="fa-solid fa-comment-dollar"></i> Pagar</a></th>
                                                                 <th><a href='#/' onclick='imprimirTicket(${stringCuenta}, ${TOTALventa}, ${cli_id_cliente}, ${cli_consumo})'><i class="fa-solid fa-print"></i> Ticket</a></th>
                                                                 <th>${textEnvio}</th>
                                                                 <th><a href='#/' class='agregar' onclick='modalAgregarProductosFormulario(${cli_id_cliente})'><i class="fa-solid fa-circle-plus"></i></a></th>
                                                                </tr>
                                                            </table>`

                             divMesa.appendChild(divCabecera);

                            //MOSTRAR DETALLES DE VENTA
                            let divOrdenes= document.createElement("div");
                                    divOrdenes.classList.add("ordenes");
                                    
                                    let tablaOrdenes= document.createElement("table");

                                  
                                    if(ordenes.length>0){
                               
                                        let thead= document.createElement('thead');
                                            thead.innerHTML=`<tr>
                                                           
                                                                <th>Cantidad</th>
                                                                <th>Categoria</th>
                                                                <th>Producto</th>
                                                                <th>Costo</th>
                                                                <th>Total</th>
                                                     
                                                            </tr>`;
                                                tablaOrdenes.appendChild(thead);
                            
                                                                 for(o=0;o<ordenes.length; o++){
                                                                    let {ord_id_orden, ord_categoria, ord_producto, ord_cantidad, ord_costo, ord_total, ord_status}=ordenes[o];

                                                                    let stringOrden=JSON.stringify(ordenes[o]);
                                                            
                                                                    let tbody0= document.createElement('tbody');

                                                                    //CANTIDAD
                                                                    let textCantidad=ord_cantidad+" pza"
                                                                    if(ord_cantidad>1){
                                                                        textCantidad=ord_cantidad+" pzas";
                                                                    }

                                                                    //ORDENES PENDIENTES
                                                                    let textEliminar=`<a href='#/' class='eliminar' onclick='eliminarOrden(${ord_id_orden})'><i class="fa-solid fa-circle-minus"></i></a>`;

                                                                    let textEditar=`<a href='#/' class='editar' id='editar${ord_id_orden}' onclick='editarCosto(${ord_id_orden}, ${ord_costo})'><i class="fa-solid fa-pen"></i></a>

                                                                            <a href='#/' class='guardar' id='guardar${ord_id_orden}' onclick='guardarCosto(${ord_id_orden}, ${ord_cantidad})'><i class="fa-solid fa-floppy-disk"></i></a>`;
                                                                    
                                                                    if(ord_status==1){
                                                                        tbody0.classList.add("pendiente");
                                                                        textEliminar="";
                                                                        textEditar="";
                                                                    }             

                                                                    tbody0.innerHTML=`<tr>
                                                                            <td>${textCantidad}</td>
                                                                        
                                                                            <td>${ord_categoria}</td>
                                                                            <td>${ord_producto}</td>
                                                                            <td class='tdcosto${ord_id_orden}'>
                                                                            <span>$${ord_costo}</span>
                                                                            
                                                                            ${textEditar}
                                                                            
                                                                            </td>
                                                                            <td>$${ord_total}</td>
                                                                            <td>
                                                                                ${textEliminar}
                                                                            </td>
                                                                            </tr>`;
                                                                    tablaOrdenes.appendChild(tbody0);
                                                                    
                                                                }
                                                                divOrdenes.appendChild(tablaOrdenes);
                                            
                                     }else{
                                        divOrdenes.innerHTML=`<p class='nohy'><i class="fa-solid fa-triangle-exclamation"></i>No hay ordenes registradas</p>`;
                                     }
                                     if(fecha==cli_fecha){

                                     }else{
                                        let divfecha=document.createElement("div");
                                            divfecha.classList.add("divfecha");
                                            divfecha.innerHTML=`<span><i class="fa-regular fa-calendar"></i> ${formatearFecha(cli_fecha)}</span>`;
                                            divOrdenes.appendChild(divfecha);
                                     }
                                                              
                                    
                                        divMesa.appendChild(divOrdenes);

                 principal_mostrar.appendChild(divMesa);
             }

        }else{
            principal_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay cuentas registradas</p>`;
        }
      }


      //ACTIVAR Y DESACTIVAR TOOLTIP
    function activarTooltip(cli_id_cliente){
        if(document.querySelector('#tooltip'+cli_id_cliente).classList.contains("active")){
            document.querySelector('#tooltip'+cli_id_cliente).classList.remove('active');
        }else{
            document.querySelector('#tooltip'+cli_id_cliente).classList.add('active');
        }
    }


     //EDITAR COSTOS
     function editarCosto(id_orden_ordenes, costo_ordenes){
        document.querySelector('.tdcosto'+id_orden_ordenes+' span').innerHTML=`<input type='number' value=${costo_ordenes}>`;

        $("#editar"+id_orden_ordenes).hide();
        $("#guardar"+id_orden_ordenes).show();
     }

     function guardarCosto(id_orden_ordenes, cantidad_ordenes){
        let costo=document.querySelector('.tdcosto'+id_orden_ordenes+' input').value;
        if(costo!=""){
            $.ajax({
            type:'POST',
            complete: function() { cargarCuentas()},
            data:{id_orden_ordenes, costo, cantidad_ordenes},
            url:'editar_costo.php',
            success:function(resp){
                let resultado=eval(resp);
                    if(resultado>0){
                        ventanasModales("bien","Costo actualizado");
                    }else{
                        ventanasModales("erro","Costo no actualizado");
                    }
                }
            });
        }else{
            ventanasModales("adve","Campo vacio");
        }
    }




     ///////////////////////////////////////////////////////////
    //PAGAR
    function pagar(stringCuenta,idcliente, consumo, totalventa){
          
          let ordenes= stringCuenta.ordenes;
          let pendientes= ordenes.filter(f=>f.ord_status==1);
            

       
              //OBTENER COSTO DE ENVIO
          let envio=0;
          if(consumo==3){
              envio= document.querySelector('#inputEnvio'+idcliente).value;
          }

        let strCuenta=JSON.stringify(stringCuenta);
            

          if(ordenes.length>0){
               if(pendientes==0){
                  $.ajax({
                      type:'POST',
                      url:'pagar.php',
                      data: {strCuenta, envio, consumo, totalventa, idcliente},
                      success:function(resp){
                        //    $("#resultado").html(resp);
                          let resultado=eval(resp);
                          
                              if(resultado>0){
                                  //ORDEN PAGADA
                                  ventanasModales("bien","Cuenta pagada");
                                  cargarCuentas();     
                              }else{
                                  //ORDEN NO PAGADA
                                  ventanasModales("erro","Cuenta no pagada");
                              }
                            }  
                      });
              }else{
                  ventanasModales("adve","Ordenes pendientes");
              }
          }else{
              ventanasModales("adve","No hay ordenes");
          }
          

    }

      //////////////////////////////////////////////////////////
      ///TICKET
      function imprimirTicket(stringCuenta, TOTALventa, idcliente, consumo){
         
        //VARIABLES
        let ordenesAgrupadas=[];

        //ORDENES DE LA CUENTA DEL CLIENTE
        let ordenes =stringCuenta.ordenes;
                if(ordenes.length>0){
                    for(o=0; o<ordenes.length; o++){

                    let {ord_producto, ord_categoria, ord_costo,ord_cantidad,ord_total}=ordenes[o];

                    const resultado = ordenesAgrupadas.filter(pro => pro.ord_producto == ord_producto  && pro.ord_categoria==ord_categoria && pro.ord_costo==ord_costo);
                    if(resultado.length>0){
                        resultado[0].ord_cantidad=parseInt(resultado[0].ord_cantidad)+parseInt(ord_cantidad);
                        resultado[0].ord_total=parseInt(resultado[0].ord_cantidad)*parseInt(ord_costo);
                    }else{
                        orden={
                            "ord_producto": ord_producto,
                            "ord_categoria":ord_categoria,
                            "ord_cantidad": parseInt(ord_cantidad),
                            "ord_costo": parseInt(ord_costo),
                            "ord_total": parseInt(ord_total)
                        }
                        ordenesAgrupadas.push(orden);
                    }
                }

               

        
                    //COSTO DE ENVIO
                    let envio=0;
                    if(consumo==3){
                        envio=document.querySelector('#inputEnvio'+idcliente).value;
                    }

                //GENERAR TICKET
                stringCuenta.ordenes=ordenesAgrupadas;
                let cuenta=JSON.stringify(stringCuenta);
                let hora=obtenerHora();
                
                setTimeout(()=>{
                    window.open("ticket_general.php?cli="+cuenta+"&env="+envio+"&tot="+TOTALventa+"&hor="+hora,'_blank');
                },500);

            }

      }

    ///////////////////////////////////////////////////////////////
    ///ELIMINAR CUENTA
        function modalEliminarCuenta(cli_id_cliente, cli_lugar){
            $("#modalEliminarCuentas").modal("show");
            document.querySelector('#lugarEliminar').textContent=cli_lugar;
            document.querySelector('input[name=Eidcliente]').value=cli_id_cliente;
        }

        function cancelarVentanaEliminar(){
            $("#modalEliminarCuentas").modal("hide");
        }
        function eliminarCuenta(){
            let idcliente=document.querySelector('input[name=Eidcliente]').value;
            let tipo="cuenta";
            $.ajax({
                type:'POST',
                complete: function() { cargarCuentas()},
                data:{idcliente, tipo},
                url:'eliminar.php',
                success:function(resp){
                    let resultado=eval(resp);
                    $("#modalEliminarCuentas").modal("hide");
                        if(resultado>0){
                            ventanasModales("bien","Cuenta eliminada");
                        }else{
                            ventanasModales("erro","Cuenta no eliminada");
                        }
                    }
                });
        }
       

      function eliminarOrden(ord_id_orden){
        let tipo="orden";
        $.ajax({
            type:'POST',
            complete: function() { cargarCuentas()},
            data:{ord_id_orden, tipo},
            url:'eliminar.php',
            success:function(resp){
                let resultado=eval(resp);
                    if(resultado>0){
                        ventanasModales("bien","Orden eliminada");
                    }else{
                        ventanasModales("erro","Orden no eliminada");
                    }
                }
            });
      }

      ////////////////////////////////////////////////////////////
      //CARGAR COSTO DE ENVIO
      function cargar_envio(){
            let geEnvio=localStorage.getItem("costoEnvioVaradero");
       
            if(geEnvio == null){
                $.ajax({
                type:'POST',
                url:'cargar_envio.php',
                success:function(respro){
                    let envio = eval(respro);
                    localStorage.setItem('costoEnvioVaradero', parseInt(envio[0].env_costo));
                  }
                });
            
            }
        }



    //   /////////////////////////////////////////////////////////////
      ///AGREGAR PRODUCTO COMUN
        function modalAgregarProductosFormulario(cli_id_cliente){
            $("#modalAgregarProducto").modal("show");
            //RESETEAR FORMULARIO
            $('.error-txt-productos').hide();
            document.querySelector('#modalAgregarProducto form').reset();
            document.querySelector('input[name=idcliente]').value=cli_id_cliente;
        }


        const formproductos = document.querySelector("#modalAgregarProducto form"),
            continueBtnProductos= formproductos.querySelector("#modalAgregarProducto .button .btnAgregarProducto"),
            errorTextProductos= formproductos.querySelector(".error-txt-productos");

        formproductos.onsubmit = (e)=>{
            e.preventDefault();
        }


        continueBtnProductos.onclick=()=>{
            let xhr=new XMLHttpRequest();
            xhr.open("POST", "agregar_producto.php", true);
            xhr.onload=()=>{
                if(xhr.readyState===XMLHttpRequest.DONE){
                    if(xhr.status===200){
                        let data=xhr.response;
                        
                        if(data=="success"){
                            $("#modalAgregarProducto").modal("hide");
                            ventanasModales("bien", "Producto registrado");
                            cargarCuentas();
                        }else if(data=="error"){
                            $("#modalAgregarProducto").modal("hide");
                            ventanasModales("erro", "Producto no registrado");
                        }else{
                            errorTextProductos.innerHTML=data;
                            errorTextProductos.style.display="block"; 
                        }
                    }
                }
            }
            //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
            const formData=new FormData(formproductos);
            xhr.send(formData);
        }

        function obtenerTotal(){
            let cantidad= document.querySelector('input[name=Pcantidad]').value || 0;
            let costo= document.querySelector('input[name=Pcosto]').value || 0;
            let total= parseFloat(cantidad)*parseFloat(costo);
            document.querySelector('input[name=Ptotal]').value=total;
        }

        function cerrarModal(){
            $("#modalAgregarProducto").modal("hide");
        }




     function cerrarSesion(){
        localStorage.removeItem("contadorCajaVaradero");
        localStorage.removeItem("costoEnvioVaradero");
        window.location.href="cerrar_sesion.php";
     }
   
    
    
</script>