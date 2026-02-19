/***************************************
CARGAR CORTESIAS DESDE LA BASE DE DATOS
********************************** */

let cortesias_mostrar=document.querySelector('#cortesias .content-tabla');
cargarCortesias();
let cortesias=[];
function cargarCortesias(){
    let mes=document.querySelector('#mes').value;
    let anual=document.querySelector('#año').value;

  $.ajax({
  type:'POST',
  data:{mes, anual},
  beforeSend: function() { Spinner(cortesias_mostrar)},
  complete: function() { mostrarCortesias()},
  url:'cortesias/cargar_cortesias.php',
  success:function(resp){
      cortesias=eval(resp);

          document.querySelector('#cortesiasTotales').textContent=cortesias.length;
          
      }
  });
}


/**
 * MOSTRAR CORTESIAS DE CLIENTES
 * 
 * 
 */
function mostrarCortesias(){
    limpiarHtml(cortesias_mostrar);

    if(cortesias.length>0){
        for(c=0; c<cortesias.length; c++){
            let {hisc_id_histoClientes, consumo, lugar, observacion, fecha, ordenes, total}=cortesias[c];



           
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
             * BOTONES DE ACCIÓN SEGÚN ESTADO DE LA ORDEN
             * Si está pendiente (ord_status==1), oculta botones de edición
             */
            const textEliminar = usuario == "admin" ? ` <a href='javascript:void(0)' class='eliminarcuenta' onclick='eliminarCortesia(${hisc_id_histoClientes})'><i class="fa-solid fa-trash-can"></i></a>` : "";
                    


        /**
         * CREAR CONTENEDOR DE LA MESA
         * Agrega clase "mesaanterior" si la cuenta no es del día actual
         */
        const divMesa = document.createElement('div');
              divMesa.classList.add("mesa")


            let divCabecera= document.createElement('div');
                divCabecera.classList.add("cabecera");
                divCabecera.innerHTML=`<table>
                                            <tr>
                                                <th colspan='5' class='thPrincipal'>
                                                ${textEliminar}
                                                <span class='spanCliente'><i class="fa-solid fa-users"></i> ${lugar}</span>
                                                ${textCelular}

                                        
                                                

                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Total <span class='spanTotal'>$${total}</span></th>
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
                                        let {categoria, producto, cantidad, costo, total}=ordenes[o];


                                      
                                        let tbody0= document.createElement('tbody');


                                        /**
                                         * FORMATO DE CANTIDAD CON PLURALIZACIÓN
                                         */
                                        const textCantidad = cantidad > 1 ? `${cantidad} pzas` : `${cantidad} pza`;



                                        /**
                                         * BOTONES DE ACCIÓN SEGÚN ESTADO DE LA ORDEN
                                         * Si está pendiente (ord_status==1), oculta botones de edición
                                         */
                                       
                                          
                                        
                                        tbody0.innerHTML=`<tr>
                                                    <td>${textCantidad}</td>
                                                    <td>${categoria}</td>
                                                    <td>${producto}</td>
                                                    <td><span>$${costo}</span></td>
                                                    <td>$${total}</td>
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
                                    3: `<div class='bd divConsumo'><span class='spanDomicilio'><i class='fa-solid fa-motorcycle'></i> Domicilio +$${(consumo == 3) ? parseInt(localStorage.getItem("varaderoEnvio") || 0) : 0}</span></div>`
                                };
                                const textConsumo = tiposConsumo[consumo] || "";
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
                                            <i class='fa-solid fa-gift'></i> Cortesia el: <i class="fa-regular fa-calendar"></i> ${formatearFecha(fecha)}
                                        </span>`;
                                    divOrdenes.appendChild(divfecha);
                                // }        

                            
                            divMesa.appendChild(divOrdenes);

            cortesias_mostrar.appendChild(divMesa);
        }

    }else{
        cortesias_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay cuentas eliminadas</p>`;
    }
}


/* /////////////////////////////////////////////////
ELIMINAR CORTESIA COMPLETA
/////////////////////////////////////////////// */

function eliminarCortesia(hisc_id_histoClientes){

    $.ajax({
        type:'POST',
        complete: function() { cargarCortesias()},
        data:{hisc_id_histoClientes},
        url:'cortesias/eliminar_cortesia.php',
        success:function(resp){
            let resultado=eval(resp); 
                if(resultado>0){
                    ventanasModales("bien","Cortesia eliminada");
                }else{
                    ventanasModales("erro","Cortesia no eliminada");
                }
            }
        });
}