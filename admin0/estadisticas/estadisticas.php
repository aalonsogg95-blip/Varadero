<?php
session_start();
    if (empty($_SESSION['usuario'])) {
        //Redireccionar
        header('Location: noacceso.html');
        //Impedir que se ejecute todo el archivo
        die();
    }else{
        
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Estadisticas</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../header.css">
    <link rel="stylesheet" href="estadisticas.css">
    
    <!-- ICONO -->
    <link rel="shortcut icon" type='image/x-icon' href='../../img/productos.png'> 
</head>
<body>
   
   <!-- CABECERA-->
  <header class='header'>
    <!-- TITULO -->
    <div class="header_title">
        <h1 class='header_tit'>Estadisticas</h1>
    </div>
    <!-- BOTON SALIR -->
    <div class="header_salir">
        <a href="sesionJulissa.php" class='header_cta' onclick='cerrarSesion("est")'></a>
    </div>
    
  </header>
  
  
  <!--FECHA -->
  
  <div class="fecha">
      <h2 id='fecha'></h2>
  </div>
  
   
   <!-- MENU NAVEGACION -->
   <nav class="menu">
       <a href="../inicio.html" class='menu_item menu_item-home'>Inicio</a>
       <a href="estadisticas.php" class='menu_item'>/Estadisticas</a>
   </nav>
   
   
   <!-- FORMULARIO AÑO Y MES -->
   <div class="form_buscar">
       <form id="formulario">
      <table>
        
         <tr>
             <td colspan="2">
             <input type="radio" class='radInp' id='radM' name='fech' value='mes' onchange="MostForm()" checked> <label for="radM">Mes</label>
             <input type="radio" class='radInp' id='radA' name='fech' value='anual' onchange="MostForm()" > <label for="radA">Año</label></td>
         </tr>
          <tr id='mes'>
              <td ><label for="" class='form_label'>Mes:</label>
              <select name="" id="mes_mes" class='form_input'>
                  <option value="1">Enero</option>
                  <option value="2">Febrero</option>
                  <option value="3">Marzo</option>
                  <option value="4">Abril</option>
                  <option value="5">Mayo</option>
                  <option value="6">Junio</option>
                  <option value="7">Julio</option>
                  <option value="8">Agosto</option>                 
                  <option value="9">Septiembre</option> 
                  <option value="10">Octubre</option> 
                  <option value="11">Noviembre</option>
                  <option value="12">Diciembre</option>  
              </select>
                  </td>
              <td><center><label for="" class='form_label'>Año:</label>
              <select name="" id="mes_anual" class='form_input formNum'>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
                  </select></center></td>
          </tr>
          <tr id='anual'>
              <td><label for="" >Año:</label>
              <select name="" id="ano_anual" class='form_input formNum'>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
                  <option value="2024">2024</option>
                  <option value="2025">2025</option>
                  <option value="2026">2026</option>
              </select>
              </td>
          </tr>
          
          <tr>
             <td colspan="2"><input type='submit' class='form_cta' value='Buscar'></td> 
          </tr>
          
      </table> 
    </form>  
   </div>
   
   <!-- INDICADORES -->
   <aside class='indicadores'>
      
       <div class="contentIndica">
        <div class='contNum'>
            <h1 class='num' id='clientes'></h1>
        </div>   
        <div class='conttext'>
            <p>Clientes</p>
        </div>   
       </div>
       <div class='contentIndica'>
           <div class='contNum'>
            <h1 class='num' id='productos'></h1>
            </div> 
           <div class='conttext'>
            <p>Productos</p>
        </div> 
       </div>
       <div class='contentIndica'>
            <div class='contNum'>
            <h1 class='num' id='ingresos'></h1>
            </div> 
           <div class='conttext'>
            <p>Ingresos</p>
        </div>
       </div>
       <div class='contentIndica'>
        <div class='contNum'>
        <h1 class='num' id='gastos'></h1>
        </div> 
       <div class='conttext'>
        <p>Gastos</p>
    </div>
   </div>
   <div class='contentIndica'>
        <div class='contNum'>
        <h1 class='num' id='utilidad'></h1>
        </div> 
       <div class='conttext'>
        <p>Utilidad</p>
    </div>
   </div>
   </aside> 
    
    
    
   
   <!-- CONTENIDO -->
   <section class="container" id='content'>
      <!-- CONTENEDOR DATOS RELEVANTES-->
      <div class="container_datos">
         <nav>
            <h2>Datos relevantes</h2>
         </nav>
         <div class='container_tabla'>
            <table>
               <tr>
                  <th>Día con mas ventas</th>
               </tr>
               <tr>
                  <td id='diaMas'></td>
               </tr>
               <tr>
                  <th>Clientes</th>
               </tr>
               <tr>
                  <td id='clientesCant'></td>
               </tr>
               <tr>
                  <th>Cliente mas frecuente</th>
               </tr>
               <tr>
                  <td id='clienteMas'></td>
               </tr>
               <tr>
                  <th>Día semana + ventas</th>
               </tr>
               <tr>
                  <td id='diaSemanaMas'></td>
               </tr>
            </table>
         </div>
      </div>



      <!-- CONSULTAR INFORMACIÓN POR SEMANA -->
      <div class='container_semanal'>
        <nav>
            <h2>Semanal</h2>
         </nav>
         <table>
             <tr>
            <td><label for="">Lunes: </label> <input type="date" id='fecLunes'></td>
            </tr>
            <tr>
            <td><label for="">Sabado:</label><input type="date" id='fecSabado'></td>
            </tr>
            <tr>
                <th><button class='cta' id='consultar'>Consultar</button></th>
            </tr>
        </table>

        <p class='semMen'>Selecciona un rango de días</p>

        <div class='resulSemana'>
            <table>
                <tr>
                    <th colspan="2">¡Resultado!</th>
                </tr>
                <tr>
                    <th>Clientes: </th><td id='cliSem'></td>
                </tr>
                <tr>
                    <th>Ingresos:</th><td id='ingSem'></td>
                </tr>
            </table>

        </div>
      </div>


      <!-- CONTENEDOR VENTAS POR DIA-->
      <div class='container_dias'>
         <nav>
            <h2>Ventas x día</h2>
         </nav>
         <div class='container_tabla' id='tablaDias'></div>
      </div>
   </section>


   <!-- MOSTRAR CANTIDAD DE PRODUCTOS VENDIDOS -->
<div class='productos' id='mostrarProducto'>
   
    
   </div>  
   
   
   <!-- GRAFICAS -->

   <!--  GRAFICA POR MES-->
   <article id='grafica_horario'>
       <canvas id="graHorario" width="700px" height="0px"></canvas>
   </article>


   <!--  GRAFICA POR MES-->
   <article id='grafica_mes'>
       <canvas id="graClientes" width="700px" height="250px"></canvas>
   </article>

   
   <!--  GRAFICA POR AÑO-->
<article id='graficas_ano'>
         
   <!-- CLIENTES X AÑO-->
   <article class='graficaano'>
       <canvas id="graClientes_ano" width="700px" height="250px"></canvas>
   </article>
   <!-- GARRAFONES X AÑO-->
   <article class='graficaano'>
       <canvas id="graProductos_ano" width="700px" height="250px"></canvas>
   </article>
   <!-- VENTAS X AÑO-->
   <article class='graficaano'>
       <canvas id="graIngresos_ano" width="700px" height="250px"></canvas>
   </article>
</article>  
    
    


<!-- INCLUIR JQUERY -->
<script src="../../jquery/jquery-3.5.1.min.js"></script>
<!-- GRAFICA JQUERY-->
<script src="../../jquery/Chart.min.js"></script>
<!-- FECHA -->
<script src="../fecha.js"></script>
<script src="../../jquery/usuario.js"></script>
</body>
</html>
<script type='text/javascript'>
    
    //EJECUTAR AL CARGAR EL DOCUMENTO
    $(document).ready(function(){

        //MOSTRAR FORMULARIO INICIAL
        MostForm();  

        //MOSTRAR AÑO Y MES EN FORMULARIO
        mesAnual();

        //BOTON DE BUSCAR EN FORMULARIO
        const formulario = document.querySelector('#formulario');
        formulario.addEventListener('submit', buscarEstadisticas);

        //BOTON INFORMACIÓN POR SEMANA
        const consultar= document.querySelector('#consultar');
        consultar.addEventListener('click', consultarSemana);
        
     fecha();//FECHA (FECHA.JS)
    //formatDate();
      
    /////ARCHIVO USUARIO.JS
    validarUsuario("est");
    

    });

    
    //MOSTRAR FORMULARIO INICIAL
    function MostForm(){
       let radButton= document.querySelectorAll('.radInp')[0];
        if(radButton.checked){
              $("#mes").show();
              $("#anual").hide();
         }else{
             $("#anual").show();
             $("#mes").hide();
        }
    }

    //MOSTRAR AÑO Y MES EN FORMULARIO
    function mesAnual(){
        const fecha= new Date();
        const mes=document.querySelector('#mes_mes');
        const anual=document.querySelector('#mes_anual');
        const anual_anual=document.querySelector('#ano_anual');
        if(mes) mes.value=fecha.getMonth()+1;
        if(anual) anual.value=fecha.getFullYear();
        if(anual_anual)anual_anual.value=fecha.getFullYear();
    }
    
    
    //BUSCAR ESTADISTICAS
    function buscarEstadisticas(e){
        e.preventDefault();//IMPEDIR QUE EL FORMULARIO SE ENVIE

          


        //COMPROBAR QUE ESTADISTICAS SE QUIERE MOSTRAR
      let radButton= document.querySelectorAll('.radInp')[0];
       if(radButton.checked){
        //MES

             //LIMPIADO GRAFICA DE CLIENTES POR MES
           if (window.GraficaClientes) {
                GraficaClientes.clear();
                GraficaClientes.destroy();
            }

            if (window.GraficaHora) {
                GraficaHora.clear();
                GraficaHora.destroy();
            }

            //VARIABLES
            const indicadores=document.querySelector('.indicadores');
            const mes=document.querySelector('#mes_mes').value;
            const anual=document.querySelector('#mes_anual').value;
            const contenedor =document.querySelector("#content");
            const graficoMes = document.querySelector("#graClientes");
            

            /*****/
            //INDICADORES
            $.ajax({
				type:'POST',
				url:'indicadores.php',
				data:{mes,anual},
				success:function(respo){
                    let resultado= eval(respo);
                
                    indicadores.style.display='flex';//MOSTRAR CASILLAS DE LOS INDICADORES
                    
                    //ASIGNAR RESULTADOS A CASILLAS DE INDICADORES
                    document.querySelector("#clientes").textContent=resultado[0];
                    document.querySelector('#productos').textContent=resultado[1];
                    document.querySelector('#ingresos').textContent="$"+resultado[2];
                    document.querySelector('#gastos').textContent="$"+resultado[3];
                    document.querySelector('#utilidad').textContent="$"+resultado[4];
				}
			});

            /*****/
            //DATOS RELEVANTES
                $.ajax({
                        type:'POST',
                        url:'datosRelevantes.php',
                        data:{mes,anual},
                        success:function(respo){
                            let resultado=eval(respo);
                        
                            contenedor.style.display="grid";//MOSTRAR CONTENEDOR DE INFORMACIÓN
                            
                            //ASIGNAR RESULTADOS A CASILLAS DE DATOS RELEVANTES
                             document.querySelector("#diaMas").innerHTML=resultado[0];
                             document.querySelector('#clientesCant').innerHTML=resultado[1];
                             document.querySelector("#clienteMas").innerHTML=resultado[2];
                             document.querySelector('#diaSemanaMas').innerHTML=resultado[3];
                        }
                    });

            /****/
            //VENTAS POR DÍA
            $.ajax({
                    type:'POST',
                    url:'ventasxdia.php',
                    data:{mes, anual},
                    success:function(respo){
                    $("#tablaDias").html(respo);
                        
                    }
                });

        //////////////////////////////////////////////////////////////////
			//CANTIDAD DE PRODUCTOS VENDIDOS DURANTE EL MES (PRODUCTOS AGRUPADOS)
			$.ajax({
				type:'POST',
				url:'mostrar_productos.php',
				data:{mes, anual},
				success:function(resp){
                    $('#mostrarProducto').show();
					$("#mostrarProducto").html(resp);
				}
			});


            

            /*****/
                        //GRAFICA POR HORA
                        $("#grafica_horario").show();
                        let grafica_hora= document.querySelector('#grafica_horario');
                        $.ajax({
                            type:'POST',
                            //  beforeSend: function() { Spinner(grafica_hora)},
                            // complete: function() { mostrarIndicadores()},
                            url:'grafica_hora.php',
                            data:{mes,anual},
                            success:function(respo){
                              let horas= eval(respo);
                              
                            
                            //   limpiarHtml(grafica_hora);
                                    
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
            //GRAFICA DE CLIENTES
                $("#grafica_mes").show();//MOSTRAR GRAFICA DEL MES
                $("#graficas_ano").hide();//OCULTAR GRAFICAS DEL AÑO
                
                //CONVERTIR ID A GRAFICA EN 2D
                let contexto = graficoMes.getContext('2d');
            
                $.ajax({
                    type:'POST',
                    url:'grafica_mes.php',
                    data:{mes,anual},
                    success:function(resps){
                    let resultado=eval(resps);
                    
                        //ARRAY PARA COLOCAR LOS DIAS DEL MES
                        let dia=[];
                        for (let i = 0; i<resultado.length; i++){
                            dia.push(i+1);
                        }
                        //GRAFICA
                        window.GraficaClientes=new Chart(contexto, {
                        type: 'bar',
                        data: {
                            labels:dia,
                            datasets: [{
                            label: 'Clientes por día',
                            data:resultado,
                            borderColor: ['#c0431c'],
                            borderWidth: 4,
                            backgroundColor: ['#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c',
                                            '#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c',
                                            '#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c',
                                            '#c0431c','#c0431c']
                            }]
                        },
                    
                        })//CERRAR GRAFICA
                    }
                });


       }else{
           //AÑO

           //LIMPIANDO GRAFICAS POR AÑO
           if(window.GraClientes && window.GraProductos && window.GraIngresos){
	                   window.GraClientes.clear(); window.GraClientes.destroy();
                       window.GraProductos.clear(); window.GraProductos.destroy();
                       window.GraIngresos.clear(); window.GraIngresos.destroy();
                }


           //VARIABLES
           const ano=document.querySelector('#ano_anual').value;
           let graClientes = document.querySelector("#graClientes_ano").getContext("2d");
           let graProductos = document.querySelector('#graProductos_ano').getContext('2d');
           let graIngresos = document.querySelector('#graIngresos_ano').getContext('2d');


           //GRAFICAS ANUALES
           $("#grafica").hide();
           $("#content").hide();
           $(".indicadores").hide();
           $("#grafica_mes").hide();
           $("#graficas_ano").show();  
           $("#grafica_horario").hide();
           $('#mostrarProducto').hide();
           

           //DATOS DE GRAFICAS POR AÑO
           $.ajax({
				    type:'POST',
				    url:'grafica_anual.php',
				    data:{ano},
				    success:function(respa){
                    let resultado=eval(respa);
                        
                    //CLIENTES POR MES
                    window.GraClientes=new Chart( graClientes, {
                    type: 'bar',
                    data: {
                        labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        datasets: [{
                        label: 'Clientes',
                        data:resultado[0],
                        borderColor: ['#c0431c'],
                        borderWidth: 4,
                        backgroundColor: ['#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c',
                                         '#c0431c','#c0431c','#c0431c','#c0431c','#c0431c']
                        }]
                    },
				})//CERRAR GRAFICA CLIENTES


                //PRODUCTOS POR MES
                window.GraProductos=new Chart( graProductos, {
                    type: 'bar',
                    data: {
                        labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        datasets: [{
                        label: 'Productos vendidos',
                        data:resultado[1],
                        borderColor: ['#c0431c'],
                        borderWidth: 4,
                        backgroundColor: ['#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c',
                                         '#c0431c','#c0431c','#c0431c','#c0431c','#c0431c']
                        }]
                    },
				})//CERRAR GRAFICA PRODUCTOS


                //INGRESOS POR MES
                window.GraIngresos=new Chart( graIngresos, {
                    type: 'bar',
                    data: {
                        labels:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        datasets: [{
                        label: 'Ingresos',
                        data:resultado[2],
                        borderColor: ['#c0431c'],
                        borderWidth: 4,
                        backgroundColor: ['#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c','#c0431c',
                                         '#c0431c','#c0431c','#c0431c','#c0431c','#c0431c']
                        }]
                    },
				})//CERRAR GRAFICA PRODUCTOS

                    }
                });  

       }
    }



 //BUSCAR INFORMACIÓN POR SEMANA
 function consultarSemana(){

        //VARIABLES
            let lunes= document.querySelector("#fecLunes").value;
            let sabado=document.querySelector("#fecSabado").value;


            //VALIDAR QUE LOS CAMPOS DE FORMULARIO LUNES Y SABADO, CONTENGAN TEXTO
        if(lunes && sabado){

            $(".resulSemana").show();
            $(".semMen").hide();
            $("#rep").show();

            $.ajax({
                    type:'POST',
                    url:'ventasxsemana.php',
                    data:{lunes, sabado},
                    success:function(respo){
                        let resultado = eval(respo);
                        console.log(resultado);
                        document.querySelector("#cliSem").innerHTML=resultado[0];
                        document.querySelector("#ingSem").innerHTML="$"+resultado[1];
                    }
                });
        }else{
            document.querySelector("#cliSem").innerHTML=0;
                    document.querySelector("#ingSem").innerHTML="$"+0;
                    $("#rep").hide();
        }
 }
    
    

</script>