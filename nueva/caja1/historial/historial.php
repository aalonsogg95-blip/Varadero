<?php
     session_start();
     $usuario= $_SESSION["datosUsuarioCaja"]["usuario"];

    if(!isset($_SESSION["datosUsuarioCaja"])){
         header("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial </title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="../../boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="historial.css">
    <link rel="stylesheet" href="../../ventanas.css">

    <link rel="shortcut icon" type='image/x-icon' href='../../img/varadero_logo.png'>
</head>
<body>

    <!-- NAVBAR -->
    <nav id="navbar" class="bd">
        <div class="navbar_contenedor">
            <div class="navbar_logo bd">
                    <img src="../../img/varadero_logo.png" alt="">
                    <h2>Historial</h2>
            </div>
    
            <div class="navbar_usuario bd">
                <h2>Bienvenido <?php echo "<span>$usuario</span>!"?></h2>
                <img class="navbar_avatar" src="../../img/avatar.png" alt="">
                <a href="#/" onclick='cerrarSesion()'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
    
        </div>
    </nav>


        <div id='contador' class='bd'>
            <h1>Cuentas pagadas: <span>0</span></h1>
            <h2>$0</h2>

           <a href="#/" onclick='imprimirCorte()'><i class="fa-solid fa-print"></i> Imprimir corte</a>
        </div>


        <div id="filtros" class="bd">
            <div class='filtros_fecha bd'>
              <label for="">Buscar cuentas por fecha</label>
                <input type="date" id='fieldFecha' onchange='cargarHistorial()'>
            </div>
            <div class='filtros_nombre bd'>
                <input type="text" oninput='mostrarHistorial()' id='fieldNombre' placeholder='Lugar, cliente, mesa...'><button>Buscar</button>
            </div>
        </div>


        <section id='principal' class='bd'>
        

        </section>

  

     
      <!-- DINERO EN CAJA -->
      <div class="modal fade" id="modalCaja" tabindex="-1" role="dialog" aria-labelledby="modalCajaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center font-weight-bold" id="modalCajaLabel">Caja</h5>
              <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="ocultarModal()">
                <span aria-hidden="true">&times;</span>
              </button> -->
            </div>
            <div class="modal-body text-center">

            <form action="#">
                    <div class="error-txt-caja error-txt"></div>

                   

                    <div class="field input bd">
                            <label for="">En caja</label>
                            <input type="text" id='fieldDineroCaja' placeholder="$">
                    </div>
                
                    <div class="button input">
                            <input type="submit" class='btnAgregarCaja' value="Guardar">
                    </div>
                        
                  </form>
               
            </div>
          </div>
        </div>
      </div>



   


     <!-- VENTANA MODAL GENERAL -->
     <div class="modal_confirmado" id='modal'>
            <p class='modal_text'></p>
        </div>





   


     <div id='linkRegresar'>
        <a href="../inicio.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
    </div>

    <footer>
    <p>Caja <span id="spanDineroCaja">$0</span><a href="#/" onclick="dineroCajaFormulario()"><i class="fa-solid fa-pencil"></i></a></p>
    </footer>

    <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
    <div class="mensajeDispositivos">
            <img src="../../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>


    
     
    <script src="../../boostrap/bootstrap.bundle.min.js"></script> 
    <script src="../../boostrap/popper.min.js"></script>
    <script src="../../jquery/jquery-3.5.1.min.js"></script> 
    <script src="../../jquery/generales.js"></script> 
    <script src="../../jquery/ventanas.js"></script>
</body>
</html>
<script type="text/javascript">

     //CARGAR FUNCIONES AL RECARGAR PAGINA
     $(document).ready(function(){

        cargarHistorial();
        dineroCajaValidarFecha();
        
     });

     //ESTABLECER FECHA EN INPUT 
     const fecha = new Date();  
      let output = fecha.getFullYear() +"-"+ String(fecha.getMonth() + 1).padStart(2, '0')  + '-' + String(fecha.getDate()).padStart(2, '0');
    document.querySelector("#fieldFecha").value=output;

     let principal_mostrar= document.querySelector('#principal');





     let historial=[];
     let totalGeneral=0;
     function cargarHistorial(){

      let fieldFecha= document.querySelector('#fieldFecha').value || obtenerFecha();
       
        $.ajax({
        type:'POST',
        beforeSend: function() { Spinner(principal_mostrar)},
        complete: function() { mostrarHistorial()},
        data:{fieldFecha},
        url:'cargar_historial.php',
        success:function(resp){
            historial=eval(resp);

            // console.log(historial);

            let total=historial.reduce((total, producto)=>total + parseInt(producto.total),0);
            let totalEnvio=historial.reduce((total, producto)=>total + parseInt(producto.envio),0);
            totalGeneral=total+totalEnvio;

                document.querySelector("#contador h2").textContent="$"+new Intl.NumberFormat().format(totalGeneral);
                document.querySelector('#contador span').textContent=historial.length;
            }
        });
     }

      function mostrarHistorial(){
         
        let arrhistorial=[];
         //BUSCAR POR NOMBRE
         let fieldNombre= document.querySelector('#fieldNombre').value;
         if(fieldNombre!=""){
            historial.forEach(h=>{
                        let resultado= ((h.lugar).toLowerCase()).includes(fieldNombre.toLowerCase());
                          if(resultado){
                            arrhistorial.push(h);                     
                          }
                  });
            }else{
              arrhistorial=historial;
            }


        limpiarHtml(principal_mostrar);
        if(arrhistorial.length>0){

          
            
          for(a=0; a<arrhistorial.length; a++){
                 let {hisc_id_histoClientes, consumo, lugar, total, envio, hora, ordenes}=arrhistorial[a];

                 let stringCuenta=JSON.stringify(arrhistorial[a]);


                    //COSTO DOMCIILIO
                    let textEnvio="";
                    if(consumo==3 && envio!=0){
                        textEnvio=`<label>Envio </label><span> $${envio}</span>`;
                    }




                //MOSTRAR VENTA
                let divMesa= document.createElement('div');
                                divMesa.classList.add("mesa");

                                let divCabecera= document.createElement('div');
                                    divCabecera.classList.add("cabecera");
                                    divCabecera.innerHTML=`<table>
                                                                <tr>
                                                                    <th colspan='5'>
                                                                    <a href='#/' class='eliminarcuenta' onclick='eliminarCuenta(${hisc_id_histoClientes})'><i class="fa-solid fa-trash-can"></i></a>
                                                                    ${lugar}
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                 <th>Total <span>$${total}</span></th>
                                                                 
                                                                 <th><a href='#/' onclick='imprimirTicket(${stringCuenta})'><i class="fa-solid fa-print"></i> Ticket</a></th>
                                                                 <th>${textEnvio}</th>
                                                               
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
                                                                    let {hisv_id_histoVentas, categoria, producto, cantidad, costo, total}=ordenes[o];

                                                                    let stringOrden=JSON.stringify(ordenes[o]);
                                                            
                                                                    let tbody0= document.createElement('tbody');

                                                                    //CANTIDAD
                                                                    let textCantidad=cantidad+" pza"
                                                                    if(cantidad>1){
                                                                        textCantidad=cantidad+" pzas";
                                                                    }

                                                                    
                                                                       

                                                                    tbody0.innerHTML=`<tr>
                                                                            <td>${textCantidad}</td>
                                                                        
                                                                            <td>${categoria}</td>
                                                                            <td>${producto}</td>
                                                                            <td class='tdcosto${hisv_id_histoVentas}'>
                                                                            <span>$${costo}</span>
                                                                            
                                                                           
                                                                            
                                                                            </td>
                                                                            <td>$${total}</td>
                                                                            <td>
                                                                                
                                                                            </td>
                                                                            </tr>`;
                                                                    tablaOrdenes.appendChild(tbody0);
                                                                    
                                                                }
                                                                divOrdenes.appendChild(tablaOrdenes);
                                            
                                     }

                                     //HORA
                                     let divhora=document.createElement("div");
                                            divhora.classList.add("divHora");
                                            divhora.innerHTML=`<span><i class="fa-regular fa-clock"></i> ${formatearHora(hora)}</span>`;
                                            divOrdenes.appendChild(divhora);
                                                          
                                    
                                        divMesa.appendChild(divOrdenes);

                 principal_mostrar.appendChild(divMesa);
             }
    

        }else{
           
            principal_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay cuentas pagadas</p>`;
        }

      }


     function imprimirTicket(stringHistorial){

        //VARIABLES
        let ordenesAgrupadas=[];

        //ORDENES DE LA CUENTA DEL CLIENTE
        let ordenes =stringHistorial.ordenes;
                
                    for(o=0; o<ordenes.length; o++){

                    let {producto, categoria, costo,cantidad,total}=ordenes[o];

                    const resultado = ordenesAgrupadas.filter(pro => pro.producto == producto  && pro.categoria==categoria && pro.costo==costo);
                    if(resultado.length>0){
                        resultado[0].cantidad=parseInt(resultado[0].cantidad)+parseInt(cantidad);
                        resultado[0].total=parseInt(resultado[0].cantidad)*parseInt(costo);
                    }else{
                        orden={
                            "producto": producto,
                            "categoria":categoria,
                            "cantidad": parseInt(cantidad),
                            "costo": parseInt(costo),
                            "total": parseInt(total)
                        }
                        ordenesAgrupadas.push(orden);
                    }
                }


                stringHistorial.ordenes=ordenesAgrupadas;
                let historial=JSON.stringify(stringHistorial);

         window.open("ticket_historial.php?cli="+historial,'_blank');
     }

     /////////////////////////////////////////////////////
       //CAJA
       const formcaja = document.querySelector("#modalCaja form"),
            continueBtnCaja= formcaja.querySelector("#modalCaja .button .btnAgregarCaja"),
            errorTextCaja= formcaja.querySelector(".error-txt-caja");

        formcaja.onsubmit = (e)=>{
            e.preventDefault();
        }

       //DINERO EN CAJA, VALIDAR FECHA ACTUAL
       function dineroCajaValidarFecha(){
            const dineroLocal=JSON.parse(localStorage.getItem("DineroCajaVaradero")) || '';
            if(dineroLocal!=""){
                  document.querySelector('#spanDineroCaja').textContent="$"+dineroLocal.dinero;
                 if(dineroLocal.fecha ===obtenerFecha()){
                    $("#modalCaja").modal("hide");
                 }else{
                     $("#modalCaja").modal("show");
                     localStorage.removeItem("DineroCajaVaradero");
                 }
            }else{
                $("#modalCaja").modal("show");
            }
        }

       //DINERO EN CAJA, VENTANA MODAL
       function dineroCajaFormulario(){
            $("#modalCaja").modal("show");
            
            const dineroLocal=localStorage.getItem("DineroCajavaradero");
            if(dineroLocal!=null){
                let dineroobj=JSON.parse(dineroLocal);
                document.querySelector('#fieldDineroCaja').value=dineroobj.dinero;
            }
        }

        //GUARDAR DINERO EN CAJA EN LOCALSTORAGE
        continueBtnCaja.onclick=()=>{
            const fieldDineroCaja = document.querySelector('#fieldDineroCaja').value;

                if(fieldDineroCaja!=""){

                    let objDinero={
                        dinero :fieldDineroCaja,
                        fecha: obtenerFecha()
                    }

                    localStorage.setItem("DineroCajaVaradero", JSON.stringify(objDinero));//GUARDAR LOCALSTORAGE
                    dineroCajaValidarFecha();

                }else{
                
                } 
        };
        

    
    
    /////////////////////////////////////////////////////////////
    //IMPRIMIR CORTE
    function imprimirCorte(){
        
        let array=[];
        let datos={
            "encaja":(JSON.parse(localStorage.getItem("DineroCajaVaradero")).dinero) || 0,
            "ingresos":totalGeneral
        }

        array.push(datos);

        // console.log(array);
        let data=JSON.stringify(array);
        // let d=btoa(data);

        window.open("ticket_corte.php?dat="+data,'_blank');
    }


     ///////////////////////////////////////////////////////////////
    ///ELIMINAR CUENTA
    function eliminarCuenta(hisc_id_histoClientes){
        $.ajax({
            type:'POST',
            complete: function() { cargarHistorial()},
            data:{hisc_id_histoClientes},
            url:'eliminar_historial.php',
            success:function(resp){
                let resultado=eval(resp);
                    if(resultado>0){
                        ventanasModales("bien","Cuenta eliminada");
                    }else{
                        ventanasModales("erro","Cuenta no eliminada");
                    }
                }
            });
    }



     function cerrarSesion(){
        localStorage.removeItem("contadorCajaVaradero");
        localStorage.removeItem("costoEnvioVaradero");
        window.location.href="../cerrar_sesion.php";
     }
   
    
    
</script>