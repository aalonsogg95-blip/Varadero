/***************************************
CARGAR ELIMINADOS DESDE LA BASE DE DATOS
********************************** */

let eliminados_mostrar=document.querySelector('#eliminados .content-tabla');
cargarEliminados();
let eliminados=[];
function cargarEliminados(){
    let mes=document.querySelector('#mes').value;
    let anual=document.querySelector('#año').value;

  $.ajax({
  type:'POST',
  data:{mes, anual},
  beforeSend: function() { Spinner(eliminados_mostrar)},
  complete: function() { mostrarEliminados()},
  url:'eliminados/cargar_eliminados.php',
  success:function(resp){
      eliminados=eval(resp);

          console.log(eliminados);
          document.querySelector('#eliminadosTotales').textContent=eliminados.lenght;
          
      }
  });
}


/**
 * MOSTRAR CUENTAS ELIMINADOS DE CLIENTES
 * 
 * 
 */
function mostrarEliminados(){
    limpiarHtml(eliminados_mostrar);

    if(eliminados.length>0){
        for(c=0; c<eliminados.length; c++){
            let {cli_id_cliente, cli_consumo, cli_lugar, cli_observacion, cli_fecha, ordenes, cli_factura}=eliminados[c];

            let TOTALventa=ordenes.reduce((total, producto)=>total + parseInt(producto.ord_total),0);

            //OBTENER LA FECHA ACTUAL
            let fecha=obtenerFecha();


           
            /**
             * CREAR TELÉFONO DEL CLIENTE
             * Genera span con icono y número si existe observación
             */
            const textCelular = (cli_observacion && cli_observacion !== "vacio") 
                ? `<span class='spanTelefonoCliente'>
                    <i class="fa-solid fa-phone"></i> ${cli_observacion}
                </span>`
                : "";
                    


            /**
             * VALIDAR Y CALCULAR FACTURA CON IVA
             * Calcula el total con IVA (16%) si está habilitada la facturación
             */
            const checkedFactura = cli_factura == 1 ? `<div class='divFactura bd' id='checkFactura${cli_id_cliente}'><label for='checkfactura'>Facturar</label> <input type='checkbox' value='${cli_factura}' id='checkfactura' onclick='checkedFactura(${cli_id_cliente})' checked></div>` : "";
            const iva = Math.round(TOTALventa * 0.16);
            const totalConIva = TOTALventa + iva;
            const totalFactura = cli_factura == 1
                ? `${new Intl.NumberFormat().format(TOTALventa)} +(IVA: $${iva})= $${totalConIva}`
                : new Intl.NumberFormat().format(TOTALventa);
            



        /**
         * CREAR CONTENEDOR DE LA MESA
         * Agrega clase "mesaanterior" si la cuenta no es del día actual
         */
        const divMesa = document.createElement('div');
              divMesa.classList.add("mesa")
              fecha !== cli_fecha && divMesa.classList.add("mesaanterior");


            let divCabecera= document.createElement('div');
                divCabecera.classList.add("cabecera");
                divCabecera.innerHTML=`<table>
                                            <tr>
                                                <th colspan='5' class='thPrincipal'>
                                                <a href='javascript:void(0)' class='eliminarcuenta' onclick='eliminarCuenta(${cli_id_cliente})'><i class="fa-solid fa-trash-can"></i></a>
                                                <span class='spanCliente'><i class="fa-solid fa-users"></i> ${cli_lugar}</span>
                                                ${textCelular}

                                                ${checkedFactura}
                                                

                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Total <span class='spanTotal'>$${totalFactura}</span></th>
                                                <th></th>
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


                                        /**
                                         * FORMATO DE CANTIDAD CON PLURALIZACIÓN
                                         */
                                        const textCantidad = ord_cantidad > 1 ? `${ord_cantidad} pzas` : `${ord_cantidad} pza`;



                                        /**
                                         * BOTONES DE ACCIÓN SEGÚN ESTADO DE LA ORDEN
                                         * Si está pendiente (ord_status==1), oculta botones de edición
                                         */
                                       
                                        if (ord_status == 1) tbody0.classList.add("ordenPendiente");    
                                        
                                        tbody0.innerHTML=`<tr>
                                                    <td>${textCantidad}</td>
                                                    <td>${ord_categoria}</td>
                                                    <td>${ord_producto}</td>
                                                    <td class='tdcosto${ord_id_orden}'><span>$${ord_costo}</span></td>
                                                    <td>$${ord_total}</td>
                                                </tr>`;
                                        tablaOrdenes.appendChild(tbody0);
                                        
                                    }
                                    divOrdenes.appendChild(tablaOrdenes);
                                    
                                }else{
                                    divOrdenes.innerHTML=`<p class='nohy'><i class="fa-solid fa-triangle-exclamation"></i>No hay ordenes registradas</p>`;
                                }


                                /**
                                 * DETERMINAR TIPO DE CONSUMO
                                 * Asigna el texto y icono según el tipo de servicio
                                 * 1 = Comer en el local, 2 = Llevar, 3 = Domicilio
                                 */
                                const tiposConsumo = {
                                    2: "<div class='bd divConsumo'><span class='spanLlevar'><i class='fa-solid fa-bag-shopping'></i> Llevar</span></div>",
                                    3: `<div class='bd divConsumo'><span class='spanDomicilio'><i class='fa-solid fa-motorcycle'></i> Domicilio +$${(cli_consumo == 3) ? parseInt(localStorage.getItem("varaderoEnvio") || 0) : 0}</span></div>`
                                };
                                const textConsumo = tiposConsumo[cli_consumo] || "";
                                divOrdenes.innerHTML += textConsumo;            
                            


                                /**
                                 * MENSAJE DE CUENTA ANTIGUA
                                 * Se muestra solo si la cuenta no es del día actual
                                 */
                                // if (fecha !== cli_fecha) {
                                    const divfecha = document.createElement("div");
                                    divfecha.classList.add("divfecha");
                                    divfecha.innerHTML = `
                                        <span>
                                            <i class="fa-solid fa-trash"></i> Cuenta eliminada: <i class="fa-regular fa-calendar"></i> ${formatearFecha(cli_fecha)}
                                        </span>`;
                                    divOrdenes.appendChild(divfecha);
                                // }        

                            
                            divMesa.appendChild(divOrdenes);

            eliminados_mostrar.appendChild(divMesa);
        }

    }else{
        eliminados_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay cuentas eliminadas</p>`;
    }
}


/* /////////////////////////////////////////////////
ELIMINAR CUENTA COMPLETA
/////////////////////////////////////////////// */

function eliminarCuenta(cli_id_cliente){

    $.ajax({
        type:'POST',
        complete: function() { cargarEliminados()},
        data:{cli_id_cliente},
        url:'caja/eliminar_cuentas_ordenes.php',
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