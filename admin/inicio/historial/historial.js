/***************************************
CARGAR HISTORIAL DESDE LA BASE DE DATOS
********************************** */

let historial_mostrar=document.querySelector('#historial .content-tabla');
cargarHistorial();
let historial=[];
     function cargarHistorial(){
        let campofechabuscar= document.querySelector('#campofechabuscar').value;
        
        $.ajax({
        type:'POST',
        data:{campofechabuscar},
        beforeSend: function() { Spinner(historial_mostrar)},
        complete: function() { mostrarHistorial()},
        url:'historial/cargar_historial.php',
        success:function(resp){
            let datos=eval(resp);

                historial=datos[0];
                let gastos=datos[1];
            

                // console.log(datos);
                document.querySelector('#historial #ventasTot').textContent=historial.length;

                ///INGRESOS

                //EFECTIVO
                const efectivo = historial.filter(c => c.forma_pago === "Efectivo");
                
                const sumaTotalEfectivo = efectivo.reduce((sum, c) => sum + parseInt(c.total), 0);
                const sumaIvaEfectivo = efectivo.reduce((sum, c) => sum + parseInt(c.iva_facturas), 0);
                const sumaEnvioEfectivo = efectivo.reduce((sum, c) => sum + parseInt(c.envio), 0);
                const totalEfectivo=sumaTotalEfectivo+sumaIvaEfectivo+sumaEnvioEfectivo;
                document.querySelector('#ventasEfectivo').textContent="$"+new Intl.NumberFormat().format(totalEfectivo);

                //TARJETA
                const tarjeta = historial.filter(c => c.forma_pago === "Tarjeta");
                const sumaTotalTarjeta = tarjeta.reduce((sum, c) => sum + parseInt(c.total), 0);
                const sumaIvaTarjeta = tarjeta.reduce((sum, c) => sum + parseInt(c.iva_facturas), 0);
                const sumaEnvioTarjeta = tarjeta.reduce((sum, c) => sum + parseInt(c.envio), 0);
                const totalTarjeta=sumaTotalTarjeta+sumaIvaTarjeta+sumaEnvioTarjeta;
                document.querySelector('#ventasTarjeta').textContent="$"+new Intl.NumberFormat().format(totalTarjeta);

                //TRANSFERENCIA
                const transferencia = historial.filter(c => c.forma_pago === "Transferencia");
                const sumaTotalTransferencia = transferencia.reduce((sum, c) => sum + parseInt(c.total), 0);
                const sumaIvaTransferencia = transferencia.reduce((sum, c) => sum + parseInt(c.iva_facturas), 0);
                const sumaEnvioTransferencia = transferencia.reduce((sum, c) => sum + parseInt(c.envio), 0);
                const totalTransferencia=sumaTotalTransferencia+sumaIvaTransferencia+sumaEnvioTransferencia;
                document.querySelector('#ventasTransferencia').textContent="$"+new Intl.NumberFormat().format(totalTransferencia);

                //GASTOS
                document.querySelector('#ventasGastos').textContent="$"+new Intl.NumberFormat().format(gastos);
                
            }
        });
     }


    
      function mostrarHistorial(){
         limpiarHtml(historial_mostrar);

         if(historial.length>0){
             for(c=0; c<historial.length; c++){
                 let {hisc_id_histoClientes, consumo, lugar, total, envio, hora, fecha, forma_pago, iva_facturas, ordenes, observacion}=historial[c];

                 let stringHistorial=JSON.stringify(historial[c]);

                //  console.log(iva);



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
                        ? `<span class='formaPago' data-forma-pago-id="${hisc_id_histoClientes}"><i class='fa-solid ${pago.icono}'></i> ${pago.texto}</span>
                            <a href='javascript:void(0)' id='editarFormapago${hisc_id_histoClientes}' onclick='editarFormaPago(${hisc_id_histoClientes}, "${forma_pago}")'><i class="fa-solid fa-pen"></i></a>
                            <a href='javascript:void(0)' id='guardarFormapago${hisc_id_histoClientes}' style='display:none' onclick='guardarFormaPago(${hisc_id_histoClientes})'><i class="fa-solid fa-floppy-disk"></i></a>
                          
                            `
                        : "";
                                        



                   /**
                     * BOTONES DE ACCIÓN SEGÚN ESTADO DE LA ORDEN
                     * Si está pendiente (ord_status==1), oculta botones de edición
                     */
                    const textEliminar = usuario == "admin" ? ` <a href='javascript:void(0)' class='eliminarcuenta' onclick='eliminarCuenta(${hisc_id_histoClientes})'><i class="fa-solid fa-trash-can"></i></a>` : "";

                    

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
                const checkedFactura = iva_facturas != 0 ? `<div class='divFactura bd' id='checkFactura${hisc_id_histoClientes}'><label for='checkfactura'>Facturar</label> <input type='checkbox' id='checkfactura' checked disabled></div>` : "";
                const totalConIva = parseInt(total) + parseInt(iva_facturas);
                const totalFactura = iva_facturas != 0
                    ? `${new Intl.NumberFormat().format(total)} +(IVA: $${iva_facturas})= $${totalConIva}`
                    : new Intl.NumberFormat().format(total);


                //MOSTRAR VENTA
                let divMesa= document.createElement('div');
                    divMesa.classList.add("mesa");


                    let divCabecera= document.createElement('div');
                        divCabecera.classList.add("cabecera");
                        divCabecera.innerHTML=`<table>
                                                    <tr>
                                                        <th colspan='5' class='thPrincipal'>
                                                        ${textEliminar}
                                                        <span class='spanCliente'><i class="fa-solid fa-users"></i> ${lugar}</span>
                                                        ${textCelular}

                                                        ${checkedFactura}                

                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Total <span class='spanTotal'>$${totalFactura}</span></th>
                                                        <th>${textFormapago}</th>
                                                        <th><a href='javascript:void(0)' onclick='imprimirTicket(${stringHistorial}, ${total}, ${hisc_id_histoClientes}, ${consumo})'><i class="fa-solid fa-print"></i> Imprimir ticket</a></th>
                                                        
                                                        
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

                                    divMesa.appendChild(divOrdenes);

                 historial_mostrar.appendChild(divMesa);
              }

        }else{
            historial_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay historial de ventas en la fecha seleccionada</p>`;
        }
      }


/* /////////////////////////////////////////////////
IMPRIMIR TICKET
/////////////////////////////////////////////// */
function imprimirTicket(stringHistorial, total, hisc_id_histoClientes, consumo){
        // console.log(stringHistorial);
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
        hor: obtenerHora()
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



/* /////////////////////////////////////////////////
IMPRIMIR TICKET CORTE
/////////////////////////////////////////////// */
function imprimirTicketCorte(){

    /**
     * REDIRIGIR A TICKET DE CORTE CON TOTAL DE VENTAS
     */
    const totalVentas = document.querySelector('#ventasTot').textContent;
    const ventasEfectivo = document.querySelector('#ventasEfectivo').textContent
    .replace('$', '')
    .replace(/,/g, '');
    const ventasTarjeta = document.querySelector('#ventasTarjeta').textContent
    .replace('$', '')
    .replace(/,/g, '');
    const ventasTransferencia = document.querySelector('#ventasTransferencia').textContent
    .replace('$', '')
    .replace(/,/g, '');


    /**
     * CREAR OBJETO CON DATOS DE CORTE Y REDIRIGIR
     */
    const corte = {
        "ventas": totalVentas,
        "efectivo": ventasEfectivo,
        "tarjeta": ventasTarjeta,
        "transferencia": ventasTransferencia,
        "dineroencaja":localStorage.getItem("varaderoCaja"),
        "fecha":document.querySelector('#campofechabuscar').value
    };

    // Codificar datos en Base64
    const datosJSON = JSON.stringify(corte);
    const datosEncriptados = btoa(unescape(encodeURIComponent(datosJSON)));

    const url = `historial/ticket_corte.php?data=${datosEncriptados}`;
    window.open(url, '_blank');

}




/* /////////////////////////////////////////////////
EDITAR FORMA DE PAGO
/////////////////////////////////////////////// */
function editarFormaPago(hisc_id_histoClientes, forma_pago) {
    $(`#guardarFormapago${hisc_id_histoClientes}`).show();
    $(`#editarFormapago${hisc_id_histoClientes}`).hide();
    

    const formaPagoElement = document.querySelector(`[data-forma-pago-id="${hisc_id_histoClientes}"]`);
    
    if (!formaPagoElement) return;
    
    const opcionesFormaPago = [
        { valor: 'Efectivo', texto: 'Efectivo', icono: 'fa-money-bill' },
        { valor: 'Tarjeta', texto: 'Tarjeta', icono: 'fa-credit-card' },
        { valor: 'Transferencia', texto: 'Transferencia', icono: 'fa-bank' }
    ];
    
     const selectHTML = `
        <select id="selectFormaPago_${hisc_id_histoClientes}" class="forma-pago-select">
            ${opcionesFormaPago.map(op => 
                `<option value="${op.valor}" ${op.valor === forma_pago ? 'selected' : ''}>${op.texto}</option>`
            ).join('')}
        </select>
    `;

     // Reemplaza el contenido actual
    formaPagoElement.innerHTML = selectHTML;
 }



 function guardarFormaPago(hisc_id_histoClientes){
    $(`#guardarFormapago${hisc_id_histoClientes}`).hide();
    $(`#editarFormapago${hisc_id_histoClientes}`).show();


    let selectForma=document.querySelector(`#selectFormaPago_${hisc_id_histoClientes}`).value;

    $.ajax({
        type:'POST',
        data:{hisc_id_histoClientes, selectForma},
        url:'historial/editar_forma_pago.php',
        success:function(resp){
            let resultado=eval(resp);
                if(resultado>0){
                    cargarHistorial();
                    ventanasModales("bien","Forma de pago actualizada");
                }else{
                    ventanasModales("erro","Forma de pago no actualizada");
                }
            }
        });

 }


/* /////////////////////////////////////////////////
ELIMINAR CUENTA, SOLO EL ADMINISTRADOR PUEDE ELIMINAR
/////////////////////////////////////////////// */
function eliminarCuenta(hisc_id_histoClientes){
    
    $.ajax({
        type:'POST',
        data:{hisc_id_histoClientes},
        url:'historial/eliminar_cuentas.php',
        success:function(resp){
            let resultado=eval(resp);
                if(resultado>0){
                    cargarHistorial();
                    ventanasModales("bien","Cuenta eliminada");
                }else{
                    ventanasModales("erro","Cuenta no eliminada");
                }
            }
        });
}

 
