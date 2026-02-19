/***************************************
CARGAR FACTURAS DESDE LA BASE DE DATOS
********************************** */

let facturas_mostrar=document.querySelector('#facturas .content-tabla');
cargarFacturas();
let facturas=[];
function cargarFacturas(){
  $.ajax({
  type:'POST',
  beforeSend: function() { Spinner(facturas_mostrar)},
  complete: function() { mostrarFacturas()},
  url:'facturas/cargar_facturas.php',
  success:function(resp){
      facturas=eval(resp);

          console.log(facturas);
          document.querySelector('#facturasPendientes').textContent=facturas.lenght;
          
      }
  });
}



function mostrarFacturas(){
    limpiarHtml(facturas_mostrar);

    if(facturas.length>0){
        for(c=0; c<facturas.length; c++){
            let {venta, id_factura, iva_facturas, id_histoClientes_facturas, hisc_id_histoClientes, consumo, lugar, total, envio, hora, fecha, forma_pago, iva, ordenes, observacion, fecha_venta_facturas}=facturas[c];


                let stringFactura=JSON.stringify(facturas[c]);

                /**
                 * DETERMINAR FORMA DE PAGO
                 * Asigna el icono y texto según el método de pago utilizado
                 */
                const formasPago = {
                    "Efectivo": {
                        icono: "fa-money-bill",
                        texto: "Efectivo"
                    },
                    "Tarjeta": {
                        icono: "fa-credit-card",
                        texto: "Tarjeta"
                    },
                    "Transferencia": {
                        icono: "fa-money-check-dollar",
                        texto: "Transferencia"
                    }
                };

                const pago = formasPago[forma_pago];
                const textFormapago = pago
                    ? `<span class='formaPago'><i class='fa-solid ${pago.icono}'></i> ${pago.texto}</span>`
                    : "";



            /**
             * CREAR TELÉFONO DEL CLIENTE
             * Genera span con icono y número si existe observación
             */
            const textCelular = (observacion && observacion !== "vacio") 
                ? `<span class='spanTelefonoCliente'>
                    <i class="fa-solid fa-phone"></i> ${observacion}
                </span>`
                : "";
                


            /**
             * VALIDAR Y CALCULAR FACTURA CON IVA
             * Calcula el total con IVA (16%) si está habilitada la facturación
             */
            const checkedFactura = `<div class='divFactura bd' id='checkFactura${hisc_id_histoClientes}'><label for='checkfactura'>Facturar</label> <input type='checkbox' id='checkfactura' checked disabled></div>`;
            const totalConIva = parseInt(iva_facturas)+parseInt(total);
            const totalFactura =  `${new Intl.NumberFormat().format(total)} +(IVA: $${iva_facturas})= $${totalConIva}`
                


            //MOSTRAR VENTA
            let divMesa= document.createElement('div');
                divMesa.classList.add("mesa");


                let divCabecera= document.createElement('div');
                    divCabecera.classList.add("cabecera");
                    divCabecera.innerHTML=`<table>
                                                <tr>
                                                    <th colspan='5' class='thPrincipal'>
                                                    <span class='spanCliente'><i class="fa-solid fa-users"></i> ${lugar}</span>
                                                    ${textCelular}

                                                    ${checkedFactura}                

                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th>Total <span class='spanTotal'>$${totalFactura}</span></th>
                                                    <th>${textFormapago}</th>
                                                    <th><a href='javascript:void(0)' onclick='imprimirTicket(${stringFactura}, ${total}, ${hisc_id_histoClientes}, ${consumo})'><i class="fa-solid fa-print"></i> Imprimir ticket</a></th>
                                                    
                                                    
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
                                                              let { categoria, producto, cantidad, costo, total,tiempo_entrega}=ordenes[o];

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
                                                                      <td>$${costo}</td>
                                                                      <td>$${total}</td>
                                                                      
                                                                      </tr>`;
                                                              tablaOrdenes.appendChild(tbody0);
                                                              
                                                          }
                                                          divOrdenes.appendChild(tablaOrdenes);


                                              /**
                                               * DETERMINAR TIPO DE CONSUMO
                                               * Asigna el texto y icono según el tipo de servicio
                                               * 1 = Comer en el local, 2 = Llevar, 3 = Domicilio
                                               */
                                              const tiposConsumo = {
                                                  2: "<div class='bd divConsumo'><span class='spanLlevar'><i class='fa-solid fa-bag-shopping'></i> Llevar</span></div>",
                                                  3: `<div class='bd divConsumo'><span class='spanDomicilio'><i class='fa-solid fa-motorcycle'></i> Domicilio +$${envio}</span></div>`
                                              };
                                              const textConsumo = tiposConsumo[consumo] || "";
                                              divOrdenes.innerHTML += textConsumo;            
                                          
                                                          
                                }else{
                                  divOrdenes.innerHTML=`<p class='nohy'><i class="fa-solid fa-triangle-exclamation"></i>No hay ordenes registradas</p>`;
                                }


                                /**
                               * BOTON PARA ENTREGAR FACTURA
                               * Se muestra solo si hay factura pendiente en estatus 0
                               */
                              
                                  const divEstatusFactura = document.createElement("div");
                                  divEstatusFactura.classList.add("divEstatusFactura");
                                  divEstatusFactura.innerHTML = `
                                      <a href='javascript:void(0)' onclick='entregarFactura(${id_factura})'><i class="fa-regular fa-circle-check"></i> Factura entregada</a>
                                      <span>
                                          Factura solicitada desde: ${formatearFecha(fecha)}
                                      </span>`;
                                  divOrdenes.appendChild(divEstatusFactura);
                              



                              divMesa.appendChild(divOrdenes);
                facturas_mostrar.appendChild(divMesa);
          }

  }else{
      facturas_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay facturas pendientes</p>`;
  }
}



/***************************************
ENTREGAR FACTURA
********************************** */
function entregarFactura(id_factura){
  $.ajax({
        type:'POST',
        url:'facturas/status_facturas.php',
        data:{id_factura},
        success:function(resps){
        let resultado=eval(resps);

                if(resultado>0){
                    ventanasModales("bien","Factura entregada");
                    cargarFacturas();
                }else{
                    ventanasModales("erro","Factura no entregada");
                }
                
            }
    });
}



/* /////////////////////////////////////////////////
IMPRIMIR TICKET
/////////////////////////////////////////////// */
function imprimirTicket(stringHistorial, total, hisc_id_histoClientes, consumo){
       
/**
 * Agrupa órdenes del cliente por producto, categoría y costo
 * 
 * Combina múltiples órdenes del mismo producto sumando cantidades y totales,
 * evitando duplicados en la lista final.
 * 
 * @description
 * - Si el producto ya existe: suma la cantidad y recalcula el total
 * - Si el producto es nuevo: lo agrega al array
 * 
 * @example
 * // Entrada: [
 * //   {ord_producto: "Pizza", ord_cantidad: 2, ord_costo: 100},
 * //   {ord_producto: "Pizza", ord_cantidad: 1, ord_costo: 100}
 * // ]
 * // Salida: [
 * //   {ord_producto: "Pizza", ord_cantidad: 3, ord_costo: 100, ord_total: 300}
 * // ]
 */

// Array para almacenar órdenes consolidadas
const ordenesAgrupadas = [];

// Obtener las órdenes del cliente
const ordenes = stringHistorial.ordenes;

// Validar que existan órdenes
if (!ordenes || ordenes.length === 0) {
    // console.warn('No hay órdenes para procesar');
    return;
}

// Procesar cada orden
ordenes.forEach(orden => {
    const { producto, categoria, costo, cantidad, total } = orden;
    
    // Buscar si ya existe una orden con el mismo producto, categoría y costo
    const ordenExistente = ordenesAgrupadas.find(
        item => item.ord_producto === producto && 
                item.ord_categoria === categoria && 
                item.ord_costo === costo
    );
    
    if (ordenExistente) {
        // Actualizar orden existente
        ordenExistente.ord_cantidad += parseInt(cantidad, 10);
        ordenExistente.ord_total = ordenExistente.ord_cantidad * ordenExistente.ord_costo;
    } else {
        // Agregar nueva orden
        ordenesAgrupadas.push({
            ord_producto: producto,
            ord_categoria: categoria,
            ord_cantidad: parseInt(cantidad, 10),
            ord_costo: parseInt(costo, 10),
            ord_total: parseInt(total, 10)
        });
    }
});


// //IVA EN CASO DE REQUERIR FACTURA
// let checkFactura = document.querySelector(`#checkFactura${hisc_id_histoClientes} input`).value


// GENERAR TICKET (Código comentado - descomenta para usar)
stringHistorial.ordenes = ordenesAgrupadas;
    
    const datos = {
        cli: JSON.stringify(stringHistorial),
        env: localStorage.getItem("varaderoEnvio") || 0,
        tot: total,
        hor: obtenerHora(),
    };
    
    // Codificar datos en Base64
    const datosJSON = JSON.stringify(datos);
    const datosEncriptados = btoa(unescape(encodeURIComponent(datosJSON)));
    
    // URL limpia con un solo parámetro encriptado
    const url = `historial/imprimir_ticket_historial.php?data=${encodeURIComponent(datosEncriptados)}`;
    
    setTimeout(() => {
        window.open(url, '_blank');
    }, 500);

}