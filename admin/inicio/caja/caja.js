//EJECUTAR AL CARGAR EL DOCUMENTO
$(document).ready(function(){
    focusVentana();

}); 


/////////////////////////////////////////////////////////////////////
    //ACTUALIZAR PAGINA AUTOMATICA CUANDO SE SUSPENDE EL DISPOSITIVO O SE CAMBIA DE PESTAÑA*****************
    function focusVentana(){
        $(window).focus(function() {
                ///MOSTRAR ORDENES REALIZADAS
                cargarCuentas();
                
            });
    }





/**
 * Monitorea y sincroniza el contador de órdenes con el servidor
 * 
 * Esta función realiza las siguientes operaciones:
 * 1. Consulta el número actual de órdenes desde el servidor
 * 2. Compara con el valor almacenado localmente
 * 3. Actualiza el localStorage y recarga las cuentas si hay cambios
 * 
 * // Llamar periódicamente para mantener sincronizado*/
 setInterval(contadorOrdenes, 50000);//50 SEGUNDOS
 
function contadorOrdenes() {
    $.ajax({
        type: 'POST',
        url: 'caja/contar_ordenes.php',
        dataType: 'json', // Especificar tipo de datos esperado
        timeout: 5000, // Timeout de 5 segundos
        
        success: function(respuesta) {
            try {
                // Parsear la respuesta del servidor de forma segura
                const ordenesActuales = parseInt(respuesta, 10);
                
                // Validar que sea un número válido
                if (isNaN(ordenesActuales)) {
                    // console.error('Respuesta inválida del servidor:', respuesta);
                    return;
                }
                
                // Constante para la clave del localStorage
                const CLAVE_STORAGE = 'contadorCajaVaraderoV3';
                
                // Obtener el contador almacenado localmente
                const contadorLocal = parseInt(localStorage.getItem(CLAVE_STORAGE), 10);
                
                // Inicializar si no existe el valor en localStorage
                if (isNaN(contadorLocal)) {
                    localStorage.setItem(CLAVE_STORAGE, ordenesActuales.toString());
                    // console.log('Contador inicializado:', ordenesActuales);
                    return;
                }
                
                // Detectar cambios y actualizar si es necesario
                if (ordenesActuales !== contadorLocal) {
                    localStorage.setItem(CLAVE_STORAGE, ordenesActuales.toString());
                    // console.log(`Contador actualizado: ${contadorLocal} → ${ordenesActuales}`);
                    cargarCuentas();
                }
                
            } catch (error) {
                console.error('Error procesando contador de órdenes:', error);
            }
        },
    });
}




























/***************************************
CARGAR CUENTAS DESDE LA BASE DE DATOS
********************************** */
let cuentas_mostrar=document.querySelector('#caja .content-tabla');
cargarCuentas();
let cuentas=[];
     function cargarCuentas(){
        let pagina = document.querySelector("#caja #pagina").value || 1;

        $.ajax({
        type:'POST',
        data:{pagina},
        beforeSend: function() { Spinner(cuentas_mostrar)},
        complete: function() { mostrarCuentas()},
        url:'caja/cargar_cuentas.php',
        success:function(resp){
            let datos=eval(resp);

                cuentas=datos[0];
                let paginacion=datos[1];
                let totalRegistros=datos[2];
                let cont=cuentas.length;
                let sumaTotalventas=datos[4];

                // console.log(sumaTotalventas);
                document.querySelector('#ventasTotales').textContent=totalRegistros;
                document.querySelector('#ventasEfectivo').textContent="$"+new Intl.NumberFormat('es-MX').format(sumaTotalventas)
                document.querySelector('#numerosRegistrosCaja').innerHTML=`Mostrando ${cont} de ${new Intl.NumberFormat().format(totalRegistros)} registros`
                document.getElementById("nav-paginacion_caja").innerHTML = paginacion.join('');
            }
        });
     }


     // Función para cambiar de página
    function nextPageCaja(pagina) {
        document.getElementById('pagina').value = pagina
        cargarCuentas();
    }





/**
 * MOSTRAR CUENTAS DE CLIENTES
 * 
 * 
 */
function mostrarCuentas(){
    limpiarHtml(cuentas_mostrar);

    if(cuentas.length>0){
        for(c=0; c<cuentas.length; c++){
            let {cli_id_cliente, cli_consumo, cli_lugar, cli_observacion, cli_fecha, ordenes, cli_factura}=cuentas[c];

            let stringCuenta=JSON.stringify(cuentas[c]);
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
            const checkedFactura = cli_factura == 1 ? "checked" : "";
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
              divMesa.id = `ancla${cli_id_cliente}`;
              fecha !== cli_fecha && divMesa.classList.add("mesaanterior");


            let divCabecera= document.createElement('div');
                divCabecera.classList.add("cabecera");
                divCabecera.innerHTML=`<table>
                                            <tr>
                                                <th colspan='5' class='thPrincipal'>
                                                <a href='javascript:void(0)' class='eliminarcuenta' onclick='modalEliminarCuenta(${cli_id_cliente}, "${cli_lugar}")'><i class="fa-solid fa-trash-can"></i></a>
                                                <span class='spanCliente'><i class="fa-solid fa-users"></i> ${cli_lugar}</span>
                                                ${textCelular}

                                                <div class='divFactura bd' id='checkFactura${cli_id_cliente}'>
                                                <label for='checkfactura${cli_id_cliente}'>Facturar</label> <input type='checkbox' value='${cli_factura}' id='checkfactura${cli_id_cliente}' onclick='checkedFactura(${cli_id_cliente})' ${checkedFactura}></div>

                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Total <span class='spanTotal'>$${totalFactura}</span></th>
                                                <th><a href='javascript:void(0)' onclick='modalCambioPagar(${stringCuenta}, ${cli_id_cliente}, ${cli_consumo}, ${TOTALventa}, "${cli_lugar}")'><i class="fa-solid fa-comment-dollar"></i> Pagar cuenta</a></th>
                                                <th><a href='javascript:void(0)' onclick='imprimirTicket(${stringCuenta}, ${TOTALventa}, ${cli_id_cliente}, ${cli_consumo})'><i class="fa-solid fa-print"></i> Imprimir ticket</a></th>

                                                <th><a href='javascript:void(0)' onclick='ventaCortesia(${stringCuenta}, ${TOTALventa})'><i class="fa-solid fa-gift"></i> Cortesía</a></th>
                                                
                                                <th><a href='javascript:void(0)' class='agregar' onclick='modalAgregarProductosFormulario(${cli_id_cliente}, "${cli_lugar}")'><i class="fa-solid fa-circle-plus"></i> Agregar producto</a></th>
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
                                        const textEliminar = ord_status == 1 ? "" : `
                                            <a href='javascript:void(0)' class='eliminarorden' onclick='eliminarOrden(${ord_id_orden})'>
                                                <i class="fa-solid fa-circle-minus"></i>
                                            </a>`;

                                        const textEditar = ord_status == 1 ? "" : `
                                            <a href='javascript:void(0)' class='editar' id='editar${ord_id_orden}' onclick='editarCosto(${ord_id_orden}, ${ord_costo})'>
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href='javascript:void(0)' class='guardar' style='display:none' id='guardar${ord_id_orden}' onclick='guardarCosto(${ord_id_orden}, ${ord_cantidad}, ${cli_id_cliente})'>
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </a>`;

                                        if (ord_status == 1) tbody0.classList.add("ordenPendiente");    
                                        
                                        

                                        tbody0.innerHTML=`<tr>
                                                    <td>${textCantidad}</td>
                                                    <td>${ord_categoria}</td>
                                                    <td>${ord_producto}</td>
                                                    <td class='tdcosto${ord_id_orden}'><span>$${ord_costo}</span>${textEditar}</td>
                                                    <td>$${ord_total}</td>
                                                    <td>${textEliminar}</td>
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
                                if (fecha !== cli_fecha) {
                                    const divfecha = document.createElement("div");
                                    divfecha.classList.add("divfecha");
                                    divfecha.innerHTML = `
                                        <span>
                                            Elimina la venta si no se realizó o presiona "Pagar cuenta" para quitarla de la lista.
                                            <br>
                                            Cuenta desde: <i class="fa-regular fa-calendar"></i> ${formatearFecha(cli_fecha)}
                                        </span>`;
                                    divOrdenes.appendChild(divfecha);
                                }        

                            
                            divMesa.appendChild(divOrdenes);

            cuentas_mostrar.appendChild(divMesa);
        }

    }else{
        cuentas_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay cuentas registradas</p>`;
    }
}
















/* /////////////////////////////////////////////////
PAGAR
/////////////////////////////////////////////// */
let pagar_stringCuenta="", pagar_idcliente=0, pagar_consumo=0, pagar_totalventa=0;


//MODAL CAMBIO
function modalCambioPagar(stringCuenta,idcliente, consumo, totalventa, cli_lugar){
    $("#modalCambio").modal("show");
    document.querySelector('#modalCambioLabel').innerHTML=`<i class="fa-solid fa-comment-dollar"></i> Pagar <span>(${cli_lugar})</span>`;
    pagar_stringCuenta=stringCuenta;
    pagar_idcliente=idcliente;
    pagar_consumo=consumo;
    pagar_totalventa=totalventa;

    //IVA EN CASO DE REQUERIR FACTURA
    let checkFactura = document.querySelector(`#checkFactura${idcliente} input`).value;
    if(checkFactura==1){
        totalventa=Math.round(totalventa*0.16)+(totalventa)
    }

    //COSTO DE ENVIO SOLO EN CONSUMO PARA LLEVAR
    totalventa+= (consumo === 3) ? parseInt(localStorage.getItem("varaderoEnvio") || 0) : 0;
    

    document.querySelector('#totalCobrar').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(totalventa);
}

function formaDePago(val){
    let valor=val.value;
    if( valor!='Efectivo'){
        $(".tr1").hide();
    }else{
        $(".tr1").show();
    }
}

function calcularCambio(val){
     let cambio=parseInt(val.value)-pagar_totalventa;
    if(val.value=="" || val.value==0){
        cambio=0;
    }
    document.querySelector('#cambioBillete').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(cambio);
}

 //PAGAR
function pagar(){
        
        let ordenes= pagar_stringCuenta.ordenes;
        let pendientes= ordenes.filter(f=>f.ord_status==1);
        let strCuenta=JSON.stringify(pagar_stringCuenta);
        let selectformadepago= document.querySelector('#selectformadepago').value;
        
        
    
        // Obtener costo de envío
        const envio = (pagar_consumo === 3) ? parseInt(localStorage.getItem("varaderoEnvio") || 0) : 0;
        
        //IVA EN CASO DE REQUERIR FACTURA
        let checkFactura = document.querySelector(`#checkFactura${pagar_idcliente} input`).value


        if(ordenes.length>0){
            if(pendientes==0){
                $.ajax({
                    type:'POST',
                    url:'caja/pagar.php',
                    data: {strCuenta, envio, pagar_consumo, pagar_totalventa, pagar_idcliente,selectformadepago,checkFactura},
                    success:function(resp){
                    //    $("#resultado").html(resp);
                        let resultado=eval(resp);
                        $("#modalCambio").modal("hide");
                        
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


/* /////////////////////////////////////////////////
IMPRIMIR TICKET
/////////////////////////////////////////////// */
function imprimirTicket(stringCuenta, TOTALventa, idcliente, consumo){
   
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
const ordenes = stringCuenta.ordenes;

// Validar que existan órdenes
if (!ordenes || ordenes.length === 0) {
    console.warn('No hay órdenes para procesar');
    return;
}

// Procesar cada orden
ordenes.forEach(orden => {
    const { ord_producto, ord_categoria, ord_costo, ord_cantidad, ord_total } = orden;
    
    // Buscar si ya existe una orden con el mismo producto, categoría y costo
    const ordenExistente = ordenesAgrupadas.find(
        item => item.ord_producto === ord_producto && 
                item.ord_categoria === ord_categoria && 
                item.ord_costo === ord_costo
    );
    
    if (ordenExistente) {
        // Actualizar orden existente
        ordenExistente.ord_cantidad += parseInt(ord_cantidad, 10);
        ordenExistente.ord_total = ordenExistente.ord_cantidad * ordenExistente.ord_costo;
    } else {
        // Agregar nueva orden
        ordenesAgrupadas.push({
            ord_producto: ord_producto,
            ord_categoria: ord_categoria,
            ord_cantidad: parseInt(ord_cantidad, 10),
            ord_costo: parseInt(ord_costo, 10),
            ord_total: parseInt(ord_total, 10)
        });
    }
});


//IVA EN CASO DE REQUERIR FACTURA
let checkFactura = document.querySelector(`#checkFactura${idcliente} input`).value


// GENERAR TICKET (Código comentado - descomenta para usar)
stringCuenta.ordenes = ordenesAgrupadas;
    
    const datos = {
        cli: JSON.stringify(stringCuenta),
        env: localStorage.getItem("varaderoEnvio") || 0,
        tot: TOTALventa,
        hor: obtenerHora(),
        fac:checkFactura
    };
    
    // Codificar datos en Base64
    const datosJSON = JSON.stringify(datos);
    const datosEncriptados = btoa(unescape(encodeURIComponent(datosJSON)));
    
    // URL limpia con un solo parámetro encriptado
    const url = `caja/imprimir_ticket.php?data=${encodeURIComponent(datosEncriptados)}`;
    
    setTimeout(() => {
        window.open(url, '_blank');
    }, 500);

}



/* /////////////////////////////////////////////////
ACTIVAR CHECK DE FACTURA
/////////////////////////////////////////////// */
function checkedFactura(cli_id_cliente){
    // console.log(cli_id_cliente);
    let factura=document.querySelector(`#checkFactura${cli_id_cliente} input`).value;
        if(factura==1){
            factura=0;
        }else{
            factura=1;
        }
    

    $.ajax({
        type:'POST',
        data:{cli_id_cliente, factura},
        url:'caja/check_factura.php',
        success:function(resp){
            let resultado=eval(resp);
                if(resultado>0){
                    cargarCuentas();
                    // ventanasModales("bien","Orden eliminada");
                }else{
                    // ventanasModales("erro","Orden no eliminada");
                }
            }
        });
}















/* /////////////////////////////////////////////////
ELIMINAR CUENTA COMPLETA
/////////////////////////////////////////////// */
function modalEliminarCuenta(cli_id_cliente, cli_lugar){
    $("#modalEliminarCuentas").modal("show");
    document.querySelector('#lugarEliminar').textContent=cli_lugar;
    document.querySelector('input[name=Eidcliente]').value=cli_id_cliente;
}


function eliminarCuenta(){
    let idcliente=document.querySelector('input[name=Eidcliente]').value;
    let tipo="cuenta";
    $.ajax({
        type:'POST',
        complete: function() { cargarCuentas()},
        data:{idcliente, tipo},
        url:'caja/eliminar_cuentas_ordenes.php',
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







/* /////////////////////////////////////////////////
ELIMINAR ORDEN POR SEPARADO
/////////////////////////////////////////////// */
function eliminarOrden(ord_id_orden){
    let tipo="orden";
    $.ajax({
        type:'POST',
        complete: function() { cargarCuentas()},
        data:{ord_id_orden, tipo},
        url:'caja/eliminar_cuentas_ordenes.php',
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














/**
 * GESTIÓN DE COSTOS EN ÓRDENES
 * Permite editar y guardar el costo de una orden
 */

/**
 * Activa el modo edición del costo
 * @param {number} idOrden - ID de la orden
 * @param {number} costoActual - Costo actual de la orden
 */
function editarCosto(idOrden, costoActual) {
    const inputCosto = `<input type='number' value='${costoActual}' class='input-costo'>`;
    document.querySelector(`.tdcosto${idOrden} span`).innerHTML = inputCosto;
    
    $(`#editar${idOrden}`).hide();
    $(`#guardar${idOrden}`).show();
}

/**
 * Guarda el costo editado en la base de datos
 * @param {number} idOrden - ID de la orden
 * @param {number} cantidad - Cantidad de la orden
 */
function guardarCosto(idOrden, cantidad, cli_id_cliente) {
    const costo = document.querySelector(`.tdcosto${idOrden} input`).value;
    
    // Validar que el costo no esté vacío
    if (!costo) {
        ventanasModales("adve", "Campo vacío");
        return;
    }
    
    // Enviar datos al servidor
    $.ajax({
        type: 'POST',
        url: 'caja/editar_costo.php',
        data: { idOrden, costo, cantidad },
        success: function(resp) {
            const resultado = parseInt(resp);
            const mensaje = resultado > 0 
                ? { tipo: "bien", texto: "Costo actualizado" }
                : { tipo: "erro", texto: "Costo no actualizado" };
            
            ventanasModales(mensaje.tipo, mensaje.texto);

            
        },
        error: function() {
            ventanasModales("erro", "Error al conectar con el servidor");
        },
        complete: function() {
            cargarCuentas();

            setTimeout(() => {
                        

                        const elemento = document.querySelector(`#ancla${cli_id_cliente}`);
                        if(elemento){
                            elemento.scrollIntoView({ 
                                behavior: 'smooth',
                                block: 'start'
                            });

                            // Agregar la clase después del scroll
                            setTimeout(() => {
                                elemento.classList.add('highlight');
                            }, 500); // Espera 500ms para que termine el scroll

                            // Remover la clase después de unos segundos
                            setTimeout(() => {
                                elemento.classList.remove('highlight');
                            }, 3000); // Se quita después de 3 segundos
                        }

                    }, 500); // Espera 500ms para que termine el scroll
        }
    });
}


/**
 * VENTAS A CORTESIAS
 * CORTESIAS 
 */
function ventaCortesia(stringCuenta, totalVenta){
    let strCuenta=JSON.stringify(stringCuenta);
    // Obtener costo de envío
    const envio = localStorage.getItem("varaderoEnvio") || 0;
    // console.log(totalVenta);

    $.ajax({
        type:'POST',
        data:{strCuenta, envio, totalVenta},
        url:'caja/ventas_cortesias.php',
        success:function(resp){
            let resultado=eval(resp);
            console.log(resultado);
                if(resultado>0){
                    cargarCuentas();
                    ventanasModales("bien","Cortesia entregada");
                }else{
                    ventanasModales("erro","Cortesia no entregada");
                }
            }
        });
}