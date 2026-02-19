//VARIABLES GENERALES
let estadisticas_mostrar= document.querySelector('#estadisticas_mostrar');



///////////////////////////////////////////////
//BUSCAR ESTADISTICAS
// buscarEstadisticas();
function buscarEstadisticas(){
    $(".estadisticas_contenido").show();
    $(".indicadores").show();
     $("#estadisticasMensaje").hide();
    

        const mes=document.querySelector('#estadisticas_field_mes').value;
        const anual=document.querySelector('#estadisticas_field_anual').value;

        

                        /*****/
                        //INDICADORES
                        
                       
                        $.ajax({
                            type:'POST',
                            url:'estadisticas/indicadores.php',
                            data:{mes,anual},
                            success:function(respo){
                              let datos= eval(respo);
                            //   console.log(datos);
                              let indicadores=datos[0];
                              let maximos=datos[1];
                              let numeros=datos[2];

                              let contenedor_indicadores=document.querySelector('.contenedor_indicadores')

                              limpiarHtml(contenedor_indicadores);
                              
                              //MOSTRAR INDICADORES
                              if(indicadores[0]!=0){
                                   

                                    let titulos=["Pedidos","Ingresos <span> (pagos)</span>","Gastos","Utilidad"];
                                    for(i=0; i<titulos.length; i++){

                                        let numero=indicadores[i];
                                        if(i!=0){
                                            numero="$"+new Intl.NumberFormat().format(indicadores[i]);
                                        }

                                        //VALIDAR DIRECCIÓN DE LA FLECHA
                                        let arrow="<i class='arrowdown'></i>";
                                        if(indicadores[i]>numeros[i]){
                                            arrow=`<i class='arrowup'></i>`;
                                        }else if(i==3){
                                            arrow="";
                                        }

                                        let divindicadores=document.createElement('div');
                                            divindicadores.classList.add("indicadores_items");
                                            divindicadores.innerHTML=`<h2 class='bd'>${arrow} ${numero}</h2>
                                                    <p class='titulo bd'>${titulos[i]}</p>
                                                    <p class='subtitulo bd'><i class="fa-solid fa-star"></i> ${maximos[i]}</p>`;
                                        contenedor_indicadores.appendChild(divindicadores);
                                    }
                                }else{
                                    $(".estadisticas_contenido").hide();
                                    $(".indicadores").hide();
                                    $("#estadisticasMensaje").show();
                                }                            
                            }
                        });


                        estadisticasEspecificas(mes, anual);

}




/**
 * OPCIONES DEL MENU PARA VISUALIZAR DATOS
 * ESTADISTICOS
 * ***/
// document.addEventListener('DOMContentLoaded', function() {

function estadisticasEspecificas(mes, anual){
    // Obtener todos los enlaces del menú
    const menuLinks = document.querySelectorAll('.menu_estadisticas a');

    

    
    // Función para manejar la selección de sección
    function manejarSeccion(valor) {
        // console.log('Sección actual:', valor);
        
        if(valor.trim() === "Generales"){
            // console.log("Mostrando sección Generales");
            datosGenerales(mes, anual);
            // Aquí va tu código para mostrar Generales
            
        } else if(valor.trim() === "Clientes"){
            // console.log("Mostrando sección Clientes");
            // Aquí va tu código para mostrar Clientes
            datosClientes(mes, anual);

        } else if(valor.trim() === "Consumo"){
            // console.log("Mostrando sección Clientes");
            // Aquí va tu código para mostrar Clientes
            datosConsumo(mes, anual);
               
        } else if(valor.trim() === "Categorias"){
            // console.log("Mostrando sección Categorías");
            // Aquí va tu código para mostrar Categorías
            datosCategorias(mes, anual);

        } else if(valor.trim() === "Productos"){
            // console.log("Mostrando sección Productos");
            // Aquí va tu código para mostrar Productos
            datosProductos(mes, anual)

        } else if(valor.trim() === "Pagos"){
            // console.log("Mostrando sección Pagos");
            // Aquí va tu código para mostrar Pagos
            datosPagos(mes, anual);

        } else if(valor.trim() === "Gastos"){
            // console.log("Mostrando sección Gastos");
            // Aquí va tu código para mostrar Gastos
            datosGastos(mes, anual);
        } else if(valor.trim() === "Cortesias"){
            datosCortesias(mes, anual)
        }
    }
    
    // Mostrar la sección activa inicial (Generales)
    const seccionActiva = document.querySelector('.menu_estadisticas a.active');
    if(seccionActiva) {
        manejarSeccion(seccionActiva.textContent);
    }
    
    // Agregar evento click a cada enlace
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();

            let opciones=["datosgenerales","datosclientes", "datosconsumo", "datoscategorias", "datosproductos", "datospagos", "datosgastos", "datoscortesias"];
                opciones.forEach(function(opcion) {
                    $("#" + opcion).hide();
                });

            // Remover la clase 'active' de todos los enlaces
            menuLinks.forEach(function(item) {
                item.classList.remove('active');
            });
            
            // Agregar la clase 'active' al enlace clickeado
            this.classList.add('active');
            
            let valor = this.textContent;
            manejarSeccion(valor);
        });
    });
// });
}



/*===============================================
DATOS GENERALES
================================================*/
function datosGenerales(mes, anual){
    $("#datosgenerales").show();
    let contenedor=document.querySelector('#datosgenerales');
    limpiarHtml(contenedor);
    // console.log(mes, anual);

    $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(contenedor)},
            url:'estadisticas/generales/ventasxdia.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
                // console.log(datos);
                
                limpiarHtml(contenedor);

                let table=document.createElement("table");
                    table.innerHTML=`<thead>
                                        <tr>
                                            <th>Número</th>
                                            <th>Día</th>
                                            <th>Ventas</th>
                                            <th>Ingresos</th>
                                            <th>Gastos</th>
                                            <th>Utilidad</th>
                                        </tr>
                                        </thead>`;
                contenedor.appendChild(table);
                for(i=0; i<datos.length; i++){
                    let {numero_dia, nombre_dia, ventas_totales, ingresos, gastos, utilidad}=datos[i];


                    let classsing='';
                    if(ingresos!=0){
                        classsing='tdingresos';
                    }

                    let classsgas='';
                    if(gastos!=0){
                        classsgas='tdgastos';
                    }

                    let classsuti="";
                    let iconarrow="";
                    if(utilidad>0){
                        classsuti="tdpostivo";
                        iconarrow="<i class='arrowup'></i>";
                    }else if(utilidad==0){
                        
                    }else{
                        classsuti="tdnegativo";
                        iconarrow="<i class='arrowdown'></i>";
                    }

                    let trclass="na";
                    if(ingresos==0 && gastos==0){
                        trclass='vacio';
                    }



                    let tr=document.createElement("tr");
                        tr.classList.add(trclass);
                        tr.innerHTML=`<td>${numero_dia}</td>
                                      <td>${nombre_dia}</td>
                                      <td>${ventas_totales}</td>
                                      <td class='${classsing}'>$${new Intl.NumberFormat().format(ingresos)}</td>
                                      <td class='${classsgas}'>$${new Intl.NumberFormat().format(gastos)}</td>
                                      <td class='${classsuti}'>${iconarrow} $${new Intl.NumberFormat().format(utilidad)}</td>`;

                    table.appendChild(tr);
                    
                }
            },
        })

}



/*===============================================
DATOS CLIENTES
================================================*/
function datosClientes(mes, anual){
    $("#datosclientes").show();
    let contenedor=document.querySelector('#datosclientes');

    $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(contenedor)},
            url:'estadisticas/clientes/clientes_recurrentes.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
                // console.log(datos);
               
                limpiarHtml(contenedor);

                let table=document.createElement("table");
                    table.innerHTML=`<thead>
                                        <tr>
                                            <th>Cliente</th>
                                            <th>Número de pedidos</th>
                                            <th>Ingresos en pedidos</th>
                                            <th>Último fecha de pedido</th>
                                        </tr>
                                        </thead>`;
                contenedor.appendChild(table);
                for(i=0; i<datos.length; i++){
                    let {nombre_clientes,total_ventas,suma_total_ventas, ultima_fecha_venta, lugar}=datos[i];

                    let tr=document.createElement("tr");
                        tr.innerHTML=`<td><i class='fa-solid fa-users'></i>  ${lugar}</td>
                                      <td>${total_ventas}</td>
                                      <td>$${new Intl.NumberFormat().format(suma_total_ventas)}</td>
                                      <td>${formatearFecha(ultima_fecha_venta)}</td>`;

                    table.appendChild(tr);
                }
            },
        })

}


/*===============================================
DATOS CLIENTES
================================================*/
function datosConsumo(mes, anual){
    $("#datosconsumo").show();
    // let contenedor=document.querySelector('#datosconsumo');

    let datosmostrar_consumo=document.querySelector('.datosmostrar_consumo');
    $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(datosmostrar_consumo)},
            url:'estadisticas/consumo/datos_consumo.php',
            data:{mes,anual},
            success:function(respo){
              let resultado= eval(respo);
                // console.log(datos);

                let datos=resultado[0];
                let envio=resultado[1];

                limpiarHtml(datos);

                if(datos.length>0){
                    datosmostrar_consumo.innerHTML=`<h3>Datos generales de pagos</h3>`;
                    let ul=document.createElement('ul');
                    
                    const tiposConsumo = {
                        1: 'Local',
                        2: 'Llevar',
                        3: 'Domicilio'
                    };
                    
                    for(i=0; i<datos.length; i++){
                        let {consumo, total_transacciones, total_monto}=datos[i];
                        
                        let tipoConsumoNombre = tiposConsumo[consumo] || 'Desconocido';
                        
                        let li=document.createElement('li');
                        if(consumo==3){
                            li.innerHTML=`${tipoConsumoNombre} <p>${total_transacciones}</p><span>$${new Intl.NumberFormat().format(total_monto)}</span> <i class="fa-solid fa-motorcycle"></i> Env $${new Intl.NumberFormat().format(envio)}`;
                        }else{
                            li.innerHTML=`${tipoConsumoNombre} <p>${total_transacciones}</p><span>$${new Intl.NumberFormat().format(total_monto)}</span>`;
                        }
                        
                        ul.appendChild(li);

                    }
                    datosmostrar_consumo.appendChild(ul);
                }

            },
        })

}



/*===============================================
DATOS CATEGORIAS
================================================*/
function datosCategorias(mes, anual){
     $("#datoscategorias").show();
    let contenedor=document.querySelector('#datoscategorias');


    //DATOS GRAFICA
     $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(document.querySelector('#grafica_categorias'))},
            url:'estadisticas/categorias/datos_categorias.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
              let categorias=datos[0];
              let cantidades=datos[1];

              //GRAFICA
              let grafica_categorias= document.querySelector('#grafica_categorias');
               // Limpiar contenedor
                grafica_categorias.innerHTML = '';
                
                // Destruir gráfica anterior si existe
                if (window.GraficaCategorias) {
                    window.GraficaCategorias.destroy();
                }
                

              let canvasCategorias=document.createElement('canvas');
                    window.GraficaCategorias=new Chart((canvasCategorias.getContext('2d')), {
                    type: 'bar',
                    data: {
                        labels:categorias,
                        datasets: [{
                        label: 'Categorías más vendidas',
                        data:cantidades,
                        borderColor: ['#003366'],
                        borderWidth: 4,
                        backgroundColor: '#003366'
                        }]
                    },
                
                    })//CERRAR GRAFICA

                    grafica_categorias.appendChild(canvasCategorias);

            }
        });
}


/*===============================================
DATOS PRODUCTOS
================================================*/
function datosProductos(mes, anual){
    $("#datosproductos").show();
    let contenedor=document.querySelector('#datosproductos');


    //DATOS GRAFICA
     $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(document.querySelector('#grafica_productos'))},
            url:'estadisticas/productos/datos_productos.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
              let productos=datos[0];
              let cantidades=datos[1];

              //GRAFICA
              let grafica_productos= document.querySelector('#grafica_productos');
               // Limpiar contenedor
                grafica_productos.innerHTML = '';
                
                // Destruir gráfica anterior si existe
                if (window.GraficaProductos) {
                    window.GraficaProductos.destroy();
                }
                

              let canvasProductos=document.createElement('canvas');
                    window.GraficaProductos=new Chart((canvasProductos.getContext('2d')), {
                    type: 'bar',
                    data: {
                        labels:productos,
                        datasets: [{
                        label: 'Productos más vendidos (Bebidas)',
                        data:cantidades,
                        borderColor: ['#003366'],
                        borderWidth: 4,
                        backgroundColor: '#003366'
                        }]
                    },
                
                    })//CERRAR GRAFICA

                    grafica_productos.appendChild(canvasProductos);

            }
        });


        //DATOS GRAFICA
     $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(document.querySelector('#grafica_productos_comida'))},
            url:'estadisticas/productos/datos_productos_comida.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
              let productos=datos[0];
              let cantidades=datos[1];

              //GRAFICA
              let grafica_productos_comida= document.querySelector('#grafica_productos_comida');
               // Limpiar contenedor
                grafica_productos_comida.innerHTML = '';
                
                // Destruir gráfica anterior si existe
                if (window.GraficaProductosComida) {
                    window.GraficaProductosComida.destroy();
                }
                

              let canvasProductosComida=document.createElement('canvas');
                    window.GraficaProductos=new Chart((canvasProductosComida.getContext('2d')), {
                    type: 'bar',
                    data: {
                        labels:productos,
                        datasets: [{
                        label: 'Productos más vendidos (Comida)',
                        data:cantidades,
                        borderColor: ['#003366'],
                        borderWidth: 4,
                        backgroundColor: '#003366'
                        }]
                    },
                
                    })//CERRAR GRAFICA

                    grafica_productos.appendChild(canvasProductosComida);

            }
        });
}


/*===============================================
DATOS PAGOS
================================================*/
function datosPagos(mes, anual){
    $("#datospagos").show();


     //DATOS GENERALES DE PAGOS
    let datosmostrar_pagos=document.querySelector('.datosmostrar_pagos');
    $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(datosmostrar_pagos)},
            url:'estadisticas/pagos/datos_pagos_generales.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
                // console.log(datos);
                limpiarHtml(datosmostrar_pagos);

                //  let datosgenerales=["Pedidos con iva"];
                if(datos.length>0){

                    datosmostrar_pagos.innerHTML=`<h3>Datos generales de pagos</h3>`;
                    let ul=document.createElement('ul');
                    for(i=0; i<datos.length; i++){
                        let {forma_pago, total_transacciones, total_monto}=datos[i];

                        let li=document.createElement('li');
                            li.innerHTML=` ${forma_pago} <p>${total_transacciones} </p><span> $${new Intl.NumberFormat().format(total_monto)}</span>`;
                            ul.appendChild(li);
                    }
                    datosmostrar_pagos.appendChild(ul);
                }
            }
        });



}



/*===============================================
DATOS GASTOS
================================================*/
function datosGastos(mes, anual){
    $("#datosgastos").show();

    //  //DATOS GASTOS
    // let tablagastos=document.querySelector('.tablagastos');
    //  $.ajax({
    //         type:'POST',
    //          beforeSend: function() { Spinner(tablagastos)},
    //         url:'estadisticas/gastos/datos_gastos_folios.php',
    //         data:{mes,anual},
    //         success:function(respo){
    //           let datos= eval(respo);
    //             // console.log(datos);

                
    //             limpiarHtml(tablagastos);
    //             tablagastos.innerHTML=`<h3>Gastos por folio</h3>`;
    //             let table=document.createElement("table");
    //                 table.innerHTML=`<thead>
    //                                     <tr>
    //                                         <th>Folio</th>
    //                                         <th>Nombre trabajo</th>
    //                                         <th>Total de gastos</th>
    //                                         <th>Monto de gastos</th>
    //                                     </tr>
    //                                     </thead>`;
    //             tablagastos.appendChild(table);
    //             for(i=0; i<datos.length; i++){
    //                 let {folio_gastos, nombre_trabajo_pedidos, total_gastos, cantidad_total}=datos[i];

    //                 let tr=document.createElement("tr");
    //                     tr.innerHTML=`<td>${folio_gastos}</td>
    //                                   <td>${nombre_trabajo_pedidos}</td>
    //                                   <td>${total_gastos}</td>
    //                                   <td class='tdgastos'>$${new Intl.NumberFormat('es-MX',{
    //                                             minimumFractionDigits: 2,
    //                                             maximumFractionDigits: 2
    //                                         }).format(cantidad_total)}</td>`;

    //                 table.appendChild(tr);
    //             }
    //         }
    //     });











    //DATOS GRAFICA
     $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(document.querySelector('#grafica_gastos'))},
            url:'estadisticas/gastos/grafica_gastos_categoria.php',
            data:{mes,anual},
            success:function(respo){
              let datos= eval(respo);
            //   console.log(datos);
              let tipos=datos[0];
              let cantidades=datos[1];

          

              //GRAFICA
              let grafica_gastos= document.querySelector('#grafica_gastos');
               // Limpiar contenedor
                grafica_gastos.innerHTML = '';
                
                // Destruir gráfica anterior si existe
                if (window.GraficaGastos) {
                    window.GraficaGastos.destroy();
                }
                

              let canvasGastos=document.createElement('canvas');
                    window.GraficaGastos=new Chart((canvasGastos.getContext('2d')), {
                    type: 'bar',
                    data: {
                        labels:tipos,
                        datasets: [{
                        label: 'Gastos por tipo',
                        data:cantidades,
                        borderColor: ['#DC3545'],
                        borderWidth: 4,
                        backgroundColor: '#DC3545'
                        }]
                    },
                
                    })//CERRAR GRAFICA

                    grafica_gastos.appendChild(canvasGastos);

            }
        });
}


/*===============================================
DATOS CLIENTES
================================================*/
function datosCortesias(mes, anual){
    $("#datoscortesias").show();
    // let contenedor=document.querySelector('#datosconsumo');

    let datosmostrar_cortesias=document.querySelector('.datosmostrar_cortesias');
    $.ajax({
            type:'POST',
             beforeSend: function() { Spinner(datosmostrar_cortesias)},
            url:'estadisticas/cortesias/datos_cortesias.php',
            data:{mes,anual},
            success:function(respo){
              let resultado= eval(respo);
                // console.log(datos);

                let datos=resultado[0];
               

                limpiarHtml(datos);

                if(datos.length>0){
                    datosmostrar_cortesias.innerHTML=`<h3>Datos generales de cortesias</h3>`;
                    let ul=document.createElement('ul');
                    
            
                    for(i=0; i<datos.length; i++){
                        let {total_monto}=datos[i];
                        
                       
                        
                        let li=document.createElement('li');
                            li.innerHTML=`Valor de las cortesias <span>$${new Intl.NumberFormat().format(total_monto)}</span> `;
                       
                        
                        ul.appendChild(li);

                    }
                    datosmostrar_cortesias.appendChild(ul);
                }

            },
        })

}
