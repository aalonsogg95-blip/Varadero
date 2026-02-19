//VARIABLES GENERALES
let estadisticas_mostrar= document.querySelector('#estadisticas_mostrar');


function menuTiempo(str){
    if(str=="sol"){
        document.querySelectorAll('.menu_opciones a')[0].classList.add("activesol");
        document.querySelectorAll('.menu_opciones a')[1].classList.remove("activeluna");
    }else{
        document.querySelectorAll('.menu_opciones a')[0].classList.remove("activesol");
        document.querySelectorAll('.menu_opciones a')[1].classList.add("activeluna");
    }
}

mostraBusquedaEstadisticas();
function mostraBusquedaEstadisticas(){
    const fecha= new Date();
    let periodo=document.querySelector('input[name=periodo_estadisticas]:checked').value;
        
    if(periodo==1){
          $(".estadisticas_anual").hide();
          $(".estadisticas_mes").show();

          let mes=fecha.getMonth()+1;
          if(mes<10){
            mes="0"+mes;
          }
          document.querySelector('#estadisticas_field_mes').value=mes;
         document.querySelector('#estadisticas_field_anual').value=fecha.getFullYear();
          
     }else{
         $(".estadisticas_mes").hide();
         $(".estadisticas_anual").show();
         document.querySelector("#estadisticas_field_aanual").value=fecha.getFullYear();
         
    }
  
}

///////////////////////////////////////////////
//BUSCAR ESTADISTICAS
function buscarEstadisticas(){

    

    //COMPROBAR QUE ESTADISTICAS SE QUIERE MOSTRAR
     let per=document.querySelector('input[name=periodo_estadisticas]:checked').value;
    
    if(per==1){
        //MES
        $(".estadisticas_contenido").show();
        $(".estadisticas_contenido_anual").hide();
        $("#estadisticasMensaje").hide();

        const mes=document.querySelector('#estadisticas_field_mes').value;
        const anual=document.querySelector('#estadisticas_field_anual').value;

                        /*****/
                        //INDICADORES
                        $.ajax({
                            type:'POST',
                            // beforeSend: function() { Spinner(mostrar_indicadores)},
                            // complete: function() { mostrarIndicadores()},
                            url:'estadisticas/indicadores.php',
                            data:{mes,anual},
                            success:function(respo){
                              let indicadores= eval(respo);
                              

                                document.querySelector('.i1 h2').textContent=indicadores[0];
                                document.querySelector('.i2 h2').textContent="$"+new Intl.NumberFormat().format(indicadores[1]);
                                document.querySelector('.i3 h2').textContent="$"+new Intl.NumberFormat().format(indicadores[2]);
                                document.querySelector('.i4 h2').textContent="$"+new Intl.NumberFormat().format(indicadores[3]);
                               
                            }
                        });


                        /*****/
                        //DATOS RELEVENATES
                        $.ajax({
                            type:'POST',
                            url:'estadisticas/datos_relevantes.php',
                            data:{mes,anual},
                            success:function(respo){
                              let datos= eval(respo);
                       
                                    
                              document.querySelector('#tdclientefrecuente').textContent=datos[0]["cliente"];
                              document.querySelector('#diamasventas').textContent=datos[0]["dia"];
                              document.querySelector('#tdmostrador').textContent=datos[0]["mostrador"];
                              document.querySelector('#tddomicilio').textContent=datos[0]["domicilio"];
                            }
                        });



                        /*****/
                        //VENTAS POR DIA
                        let datos_ventas_mostrar=document.querySelector('.datos_ventas_mostrar');
                        
                        $.ajax({
                            type:'POST',
                             beforeSend: function() { Spinner(datos_ventas_mostrar)},
                            // complete: function() { mostrarIndicadores()},
                            url:'estadisticas/ventasxdia.php',
                            data:{mes,anual},
                            success:function(respo){
                              let ventas= eval(respo);
                            //   console.log(ventas);
                                    
                                    limpiarHtml(datos_ventas_mostrar);

                                    let table=document.createElement('table');
                                        let thead=document.createElement('thead');
                                        thead.innerHTML=`<tr>
                                                        <th>Número</th>
                                                        <th>Día</th>
                                                        <th>Ventas</th>
                                                        <th>Ingresos</th>
                                                    
                                                        <th>Gastos</th>
                                                        <th>Utilidad</th>
                                                        </tr>`;

                                        table.appendChild(thead);

                                        let tbody= document.createElement('tbody');
                                        for(v=0; v<ventas.length; v++){
                                           
                                            let {numero_dia, nombre_dia, ventas_totales, ingresos, gastos, utilidad}=ventas[v];

                                            //CLASE GASTOS
                                            let clase_Gastos="";
                                            if(gastos!=0){
                                                clase_Gastos=`class='tdGastos'`;
                                            }

                                            //CLASE UTILIDAD
                                            let clase_Utilidad="";
                                            let status=(utilidad).toString().includes("-");
                                            if(status){
                                                clase_Utilidad=`class='tdUtilidadRed'`;
                                            }else if(utilidad!=0){
                                                clase_Utilidad=`class='tdUtilidad'`;
                                            }
                                        


                                            let tr=document.createElement('tr');
                                                tr.innerHTML=`<td>${numero_dia}</td>
                                                            <td>${nombre_dia}</td>
                                                            <td>${ventas_totales}</td>
                                                            <td>$${new Intl.NumberFormat().format(ingresos)}</td>
                                             
                                                            <td ${clase_Gastos}>$${new Intl.NumberFormat().format(gastos)}</td>
                                                            <td ${clase_Utilidad}>$${new Intl.NumberFormat().format(utilidad)}</td>`;

                                                tbody.appendChild(tr);
                                        }
                                            table.appendChild(tbody);
                                

                                datos_ventas_mostrar.appendChild(table);
                            }
                        });


                        /*****/
                        //PRODUCTOS MAS VENDIDOS
                        let productos_vendidos_mostrar= document.querySelector('.productos_vendidos_mostrar');
                        $.ajax({
                            type:'POST',
                             beforeSend: function() { Spinner(productos_vendidos_mostrar)},
                            // complete: function() { mostrarIndicadores()},
                            url:'estadisticas/productos_vendidos.php',
                            data:{mes,anual},
                            success:function(respo){
                              let productos= eval(respo);

                            limpiarHtml(productos_vendidos_mostrar);

                                if(productos.length>0){
                                    for(p=0; p<productos.length; p++){
                                        let {categoria_hisord, producto_hisord, total}=productos[p];

                                        
                                        let li=document.createElement('li');
                                            li.innerHTML=`${producto_hisord} (${categoria_hisord}) <span>${total}</span>`;
    
                                        productos_vendidos_mostrar.appendChild(li);
                                    }
                                }else{
                                    productos_vendidos_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay registro de información</p>`;
                                }
                            
                            }
                        });


                        /*****/
                        //GRAFICA POR HORA
                        let grafica_hora= document.querySelector('#grafica_hora');
                        $.ajax({
                            type:'POST',
                             beforeSend: function() { Spinner(grafica_hora)},
                            // complete: function() { mostrarIndicadores()},
                            url:'estadisticas/grafica_hora.php',
                            data:{mes,anual},
                            success:function(respo){
                              let horas= eval(respo);
                              
                            
                              limpiarHtml(grafica_hora);
                                    
                                let canvasHora=document.createElement('canvas');
                                

                                let hrs=[];
                                let cantidades=[];
                                for (let i = 0; i<horas.length; i++){
                                        let { hora,cantidad}=horas[i];
                                        hrs.push(hora);
                                        cantidades.push(cantidad); 
                                }

                                //GRAFICA
                                window.GraficaHora=new Chart((canvasHora.getContext('2d')), {
                                type: 'bar',
                                data: {
                                    labels:hrs,
                                    datasets: [{
                                    label: 'Ventas x hora',
                                    data:cantidades,
                                    borderColor: ['#e33907'],
                                    borderWidth: 4,
                                    backgroundColor: '#e33907'
                                    }]
                                },
                            
                                })//CERRAR GRAFICA

                                grafica_hora.appendChild(canvasHora);
                          
                            }
                        });


                        /*****/
                        //GRAFICA POR HORA
                        let grafica_mes= document.querySelector('#grafica_mes');
                        $.ajax({
                            type:'POST',
                             beforeSend: function() { Spinner(grafica_mes)},
                            // complete: function() { mostrarIndicadores()},
                            url:'estadisticas/grafica_mes.php',
                            data:{mes,anual},
                            success:function(respo){
                              let ventasmes= eval(respo);
                            

                              limpiarHtml(grafica_mes);
                                    
                               let canvasVentas=document.createElement('canvas');
                              

                                //ARRAY PARA COLOCAR LOS DIAS DEL MES
                                    let dia=[];
                                    for (let i = 0; i<ventasmes.length; i++){
                                        dia.push(i+1);
                                    }
                                    
                                
                                    //GRAFICA
                                    window.GraficaClientes=new Chart((canvasVentas.getContext('2d')), {
                                    type: 'bar',
                                    data: {
                                        labels:dia,
                                        datasets: [{
                                        label: 'Ventas por día',
                                        data:ventasmes,
                                        borderColor: ['#e33907'],
                                        borderWidth: 4,
                                        backgroundColor: '#e33907'
                                        }]
                                    },
                                
                                    })//CERRAR GRAFICA
                                    grafica_mes.appendChild(canvasVentas);
                                    
                            }
                        });




    }else{
        //ANUAL
        $(".estadisticas_contenido_anual").show();
        $(".estadisticas_contenido").hide();
        $("#estadisticasMensaje").hide();


        const anual=document.querySelector('#estadisticas_field_aanual').value;



            /*****/
            //DATOS RELEVENATES
            let grafica_venta= document.querySelector('#grafica_venta');
            let grafica_ingresos= document.querySelector('#grafica_ingresos');
            let grafica_gastos= document.querySelector('#grafica_gastos');
            $.ajax({
                type:'POST',
                url:'estadisticas/grafica_anual.php',
                data:{anual},
                success:function(respo){
                    let datos= eval(respo);
                        let ventas=datos[0];   
                        let ingresos=datos[1]; 
                        let gastos=datos[2]; 



                        limpiarHtml(grafica_venta);
                        let canvasVentas=document.createElement('canvas');
                             //GRAFICA
                             window.GraficaClientes=new Chart((canvasVentas.getContext('2d')), {
                             type: 'bar',
                             data: {
                                 labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                                 datasets: [{
                                 label: 'Ventas por mes',
                                 data:ventas,
                                 borderColor: ['#e33907'],
                                 borderWidth: 4,
                                 backgroundColor: '#e33907'
                                 }]
                             },
                         
                             })//CERRAR GRAFICA
                             grafica_venta.appendChild(canvasVentas);


                        limpiarHtml(grafica_ingresos);
                            let canvasIngresos=document.createElement('canvas');
                                //GRAFICA
                                window.GraficaIngresos=new Chart((canvasIngresos.getContext('2d')), {
                                type: 'bar',
                                data: {
                                    labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                                    datasets: [{
                                    label: 'Ingresos por mes',
                                    data:ingresos,
                                    borderColor: ['#e33907'],
                                    borderWidth: 4,
                                    backgroundColor: '#e33907'
                                    }]
                                },
                            
                                })//CERRAR GRAFICA
                                grafica_ingresos.appendChild(canvasIngresos);



                        limpiarHtml(grafica_gastos);
                            let canvasGastos=document.createElement('canvas');
                                //GRAFICA
                                window.GraficaGastos=new Chart((canvasGastos.getContext('2d')), {
                                type: 'bar',
                                data: {
                                    labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                                    datasets: [{
                                    label: 'Gastos por mes',
                                    data:gastos,
                                    borderColor: ['#e33907'],
                                    borderWidth: 4,
                                    backgroundColor: '#e33907'
                                    }]
                                },
                            
                                })//CERRAR GRAFICA
                                grafica_gastos.appendChild(canvasGastos);


                }
            });

    }


}


