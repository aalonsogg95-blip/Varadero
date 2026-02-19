<?php
    session_start();
  echo $usuario= $_SESSION["datosUsuarioAdmin"]["usuario"];
//     if($usuario==""){
//          header("location: index.php");
//     }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="../boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="productos/productos.css">
    <link rel="stylesheet" href="gastos/gastos.css">
    <link rel="stylesheet" href="../ventanas.css">
    <link rel="stylesheet" href="../spinner.css">
    <link rel="stylesheet" href="usuarios/usuarios.css">
    <link rel="stylesheet" href="estadisticas/estadisticas.css">

    <!-- <link rel="stylesheet" href="estadisticas/estadisticas.css"> -->

    <link rel="shortcut icon" type='image/x-icon' href='../img/varadero_logo.png'>

</head>
<body>

    <!-- NAVBAR -->
    <nav id="navbar" class="bd">
        <div class="navbar_contenedor">
            <div class="navbar_logo bd">
                    <img src="../img/varadero_logo.png" alt="">
                    <p id='pfechaActual'></p>
            </div>
    
            <div class="navbar_usuario bd">
                <h2>Bienvenido <?php echo "<span>$usuario</span>!"?></h2>
                <img class="navbar_avatar" src="../img/avatar.png" alt="">
                <a href="#/" onclick='cerrarSesion()'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
    
        </div>
        
    </nav>


    <!-- BARRA LATERAL -->
    <aside id="lateral" class="bd">
        <div class="lateral_menu bd">
            <div class="lat"><a href="#/" id='categorias'><i class="fa-solid fa-utensils"></i></a></div>
            <div class="lat"><a href="#/" id='productos'><i class="fa-solid fa-shrimp"></i></a></div>
            <div class="lat"><a href="#/" id='gastos'><i class="fa-solid fa-money-bill-wave"></i></a></div>
            <div class="lat"><a href="#/" id='usuarios'><i class="fa-solid fa-user"></i></a></div>
            <div class="lat"><a href="#/" id='estadisticas'><i class="fa-solid fa-chart-simple"></i></a></div>
        </div>
    </aside>



    <!-- PARTE PRINCIPAL -->
    <div id="principal">


            <!-- CATEGORIAS -->
            <section id="SectionCategorias" class="bd">
                <div class="navbar_principal bd">
                    <h2>Categorias <span id="contador_categorias"></span></h2>
                    <a href="#/" onclick="modalAgregarCategoriasFormulario()"><i class="fa-solid fa-circle-plus"></i>Agregar categoría</a>
                </div>

                <div id="categorias_mostrar" class="principal_mostrar bd">
                
                </div>        
            </section>

            <!-- PRODUCTOS -->
            <section id="SectionProductos" class="bd">
                    <div class="navbar_principal bd">
                        <h2>Productos <span id="contador_productos"></span></h2>
                        <a href="#/" onclick="modalAgregarProductosFormulario()"><i class="fa-solid fa-circle-plus"></i>Agregar producto</a>
                    </div>

                        <div id='productos_buscar' class='bd'>
                            <input type="text" placeholder='Producto/Categoria'><button>Buscar</button>
                        </div>



                    <div id="productos_mostrar" class="principal_mostrar bd">
                    
                    </div>
                    

            </section>

        
            <!-- GASTOS -->
            <section id="SectionGastos" class="bd">
                    <div class="navbar_principal bd">
                        <h2>Gastos <span id="contador_gastos"></span></h2>
                        <a href="#/" onclick="modalAgregarGastosFormulario()"><i class="fa-solid fa-circle-plus"></i>Agregar gasto</a>
                    </div>

                    <div id="gastos_buscar" class='bd'>
                        <h2>Consultar gastos</h2>
                        <div class='bd'>
                            <label for="pormes" class='radio'>
                                <input type='radio'  name='periodo' id='pormes' onclick='mostraBusquedaGastos()' value="1" checked>
                                <span></span>Por fecha
                            </label>
                            <label for="poranual" class='radio'>
                                <input type='radio'  name='periodo' id='poranual' onclick='mostraBusquedaGastos()' value="2">
                                <span></span>Por mes
                            </label>
                        </div>
                        <div class='gastos_fecha bd'>
                            <input type="date" placeholder='Producto/Categoria' id="gastos_field_fecha"><button onclick='buscarGastos()'>Buscar</button>
                        </div>
                        <div class='gastos_mes bd'>
                            <select id="gastos_field_mes">
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <select id="gastos_field_anual">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            <button onclick='buscarGastos()'>Buscar</button>
                        </div>
                    </div>
                    <div id="gastos_indicadores" class="bd">
                        <p>Gastos totales: <span id="gastostotales">0</span></p>
                        <p>Dinero en gastos: <span id="gastosdinero">$0</span></p>
                        <p>Tipo gasto: 
                            <label for="tipodia" class='radio'>
                                <input type='radio'  name='tipogasto' id='tipodia' onclick='buscarGastos()' value="Día" checked>
                                <span></span>Día
                            </label>
                            <label for="tiponoche" class='radio'>
                                <input type='radio'  name='tipogasto' id='tiponoche' onclick='buscarGastos()' value="Noche">
                                <span></span>Noche
                            </label></p>
                    </div>

                    <div id="gastos_mostrar" class="principal_mostrar bd">
                    
                    </div>
            </section>


            <!-- USUARIOS -->
            <section id="SectionUsuarios" class="bd">
                <div class="navbar_principal bd">
                    <h2>Usuarios <span id="contador_usuarios"></span></h2>
                    <a href="#/" onclick="modalAgregarUsuariosFormulario()"><i class="fa-solid fa-circle-plus"></i>Agregar usuario</a>
                </div>

                <div id="usuarios_mostrar" class="principal_mostrar bd">
                
                </div>        
            </section>

    

             <!-- ESTADISTICAS -->
             <section id="SectionEstadisticas" class="bd">
                    <div class="navbar_principal bd">
                        <h2>Estadísticas</h2>
                        <div class="menu_opciones">
                            <a href="#/" class='activesol' onclick='menuTiempo("sol")'><i class="fa-regular fa-sun"></i></a>
                            <a href="#/" onclick='menuTiempo("luna")'><i class="fa-regular fa-moon"></i></a>
                        </div>
                        
                    </div>

                    <div id='estadisticas_buscar' class='bd'>
                        <h2>Consultar estadisticas</h2>
                        <div class='bd'>
                            <label for="poranual_estadisticas" class='radio'>
                                <input type='radio'  name='periodo_estadisticas' id='poranual_estadisticas' onclick='mostraBusquedaEstadisticas()' value="1" checked>
                                <span></span>Por mes
                            </label>

                            <label for="pormes_estadisticas" class='radio'>
                                <input type='radio'  name='periodo_estadisticas' id='pormes_estadisticas' onclick='mostraBusquedaEstadisticas()' value="2">
                                <span></span>Por año
                            </label>
                            
                        </div>
                        <div class='estadisticas_anual bd'>
                            <label for="">Año</label>
                            <select id="estadisticas_field_aanual">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                        </div>
                        <div class='estadisticas_mes bd'>
                            <label for="">Mes</label>
                            <select id="estadisticas_field_mes">
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <label for="">Año</label>
                            <select id="estadisticas_field_anual">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            
                        </div>
                        <button onclick='buscarEstadisticas()'>Buscar</button>
                    </div>

                    <div id="estadisticas_mostrar" class="principal_mostrar bd">
                    
                    <p class='nohay' id="estadisticasMensaje"><i class="fa-solid fa-circle-info"></i>Seleccione un opción...!</p>

                        <div class='estadisticas_contenido bd'>


                            <!-- INDICADORES -->
                            <div class='indicadores bd'>
                                <h3>Indicadores</h3>
                                <div class="contenedor_indicadores">
                                    <div class='indicadores_items i1'>
                                        <h2>0</h2>
                                        <p class='m-0'>Ventas</p>
                                    </div>
                                    <div class='indicadores_items i2'>
                                        <h2>$0</h2>
                                        <p class='m-0'>Ingresos</p>
                                    </div>
                                   
                                    <div class='indicadores_items i3'>
                                        <h2>$0</h2>
                                        <p class='m-0'>Gastos</p>
                                    </div>
                                    <div class='indicadores_items i4'>
                                        <h2>$0</h2>
                                        <p class='m-0'>Utilidad</p>
                                    </div>
                                </div>
                            </div>


                            <!-- DATOS RELEVANTES Y VENTAS DIARIAS -->
                            <div class="datos bd">
                                <div class="datos_relevantes bd">
                                    <h3>Datos relevantes</h3>
                                    <div class="datos_relevantes_mostrar">
                                        <table>
                                            <tr>
                                                <th>Cliente frecuente</th>
                                            </tr>
                                            <tr>
                                                <td id="tdclientefrecuente"></td>
                                            </tr>
                                            <tr>
                                                <th>Día con más ventas</th>
                                            </tr>
                                            <tr>
                                                <td id='diamasventas'></td>
                                            </tr>
                                            <tr>
                                                <th>Mostrador</th>
                                            </tr>
                                            <tr>
                                                <td id="tdmostrador"></td>
                                            </tr>
                                            <tr>
                                                <th>Domicilio</th>
                                            </tr>
                                            <tr>
                                                <td id="tddomicilio"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="datos_ventas bd">
                                    <h3>Ventas por día</h3>
                                    <div class="datos_ventas_mostrar">

                                    </div>
                                </div>
                            </div>

                            
                            <div class="productos_vendidos">
                               <h3>Productos más vendidos</h3>
                               <div class="productos_vendidos_mostrar">

                               </div>
                            </div>


                            <!-- GRAFICAS -->
                            <div class="graficas bd">
                                    <!--  GRAFICA POR HORA DE VENTA-->
                                <aside class="grafica bd">
                                    <h3>Grafica ventas x hora</h3>
                                    <div id='grafica_hora'>

                                    </div>

                                </aside>
                            
                                <!--  GRAFICA POR MES-->
                                <aside class="grafica bd">
                                    <h3>Grafica ventas x día</h3>
                                    <div id='grafica_mes'>

                                    </div>
                                </aside>
                            </div>
                                
                        </div>


                        <!-- ANUAL -->
                        <div class="estadisticas_contenido_anual">
                            <!--  GRAFICA VENTAS -->
                            <aside class="grafica bd">
                                <h3>Grafica ventas x mes</h3>
                                <div id='grafica_venta'>

                                </div>

                            </aside>
                        
                            <!--  GRAFICA INGRESOS -->
                            <aside class="grafica bd">
                                <h3>Grafica ingresos x mes</h3>
                                <div id='grafica_ingresos'>

                                </div>
                            </aside>

                             <!--  GRAFICA POR MES-->
                             <aside class="grafica bd">
                                <h3>Grafica gastos x mes</h3>
                                <div id='grafica_gastos'>

                                </div>
                            </aside>

                        </div>


                    </div>
                    

                </section>

    
        </div>




    



    <!-- MODAL CATEGORIAS -->
    <div class="modal fade" id="modalAgregarCategorias" tabindex="-1" role="dialog" aria-labelledby="modalAgregarCategoriasLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalCategoriasLabel"><span><i class="fa-solid fa-circle-plus"></i> Agregar</span> Categoría</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">

                <form action="#">
                    <div class="error-txt-categorias error-txt"></div>
                    <div class="field input bd">
                            <label for="">Nombre categoría</label>
                            <input type="text" name="Cnombre" placeholder="Nombre..." required>
                            <input type="hidden" name="idcategoria">
                    </div>

                    <div class="field input bd">
                            <label for="">Tipo de categoría</label>
                           
                            <select name="Ctipo" id="">
                                <option value="" selected disabled>Selecciona una opción..</option>
                                <option value="Día">Día</option>
                                <option value="Noche">Noche</option>
                            </select>      
                    </div>

                    <div class="field input bd">
                            <label for="">Color</label>
                            <input type="color" id="colorPicker" name="Ccolor" value="#eb8d36">
                    </div>
                    

                    <div class="button input">
                            <input type="submit" class='btnAgregarCategorias' value="Registrar">
                            <input type="submit" class='btnEditarCategorias btnEditar' value="Guardar">
                    </div>
                    

                </form>
            
            
                </div>
                </div>
            </div>
    </div>



    <!-- MODAL PRODUCTOS -->
    <div class="modal fade" id="modalAgregarProductos" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProductosLabel" aria-hidden="true" >
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalProductosLabel"><span><i class="fa-solid fa-circle-plus"></i> Agregar</span> Productos</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">

                <form action="#">
                    <div class="error-txt-productos error-txt"></div>
                    <div class="field input bd">
                        <label for="">Nombre producto</label>
                        <input type="text" name="Pnombre" placeholder="Complete Name" required>
                        <input type="hidden" name="idproducto">
                    </div>
                 
                        <div class="field input bd">
                            <label for="">Categoría</label>
                            <select name="Pcategoria" id="selectCategorias"></select>
                        </div>

                        <div class="field input bd">
                            <label for="">Costo</label>
                            <input type="number" name="Pcosto" placeholder="Complete Name" required>
                          
                        </div>

                   

                    <div class="field input bd">
                            <label for="">Área</label>
                            <select name="Parea" id="selectArea">
                                <option value="" disabled selected>Elíge una opción</option>
                                <option value="1">Cocina</option>
                                <option value="2">Barra</option>
                                <option value="3">Na</option>
                            </select>
                        </div>

                  
                    
                    <div class="button input bd">
                        <input type="submit" class='btnAgregarProductos' value="Registrar">
                        <input type="submit" class='btnEditarProductos btnEditar' value="Guardar">
                    </div>
                    

                </form>
               
               
            </div>
          </div>
        </div>
      </div>
    </div>


  

    
    <!-- MODAL GASTOS -->
    <div class="modal fade" id="modalAgregarGastos" tabindex="-1" role="dialog" aria-labelledby="modalAgregarGastosLabel" aria-hidden="true" >
      <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalGastosLabel"><span><i class="fa-solid fa-circle-plus"></i> Agregar</span> Gasto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <div class="modal-body text-center">

                    <form action="#">
                        <div class="error-txt-gastos error-txt"></div>
                        <div class="field input bd">
                            <label for="">Nombre gasto</label>
                            <input type="text" name="Gnombre" required>
                            <input type="hidden" name="idgastos">
                        </div>

                        <div class="field input">
                            <label for="">Destino</label>
                            <input type="text" name="Gdestino" required>
                        </div>

                        <div class="field input">
                            <label for="">Total</label>
                            <input type="number" name="Gtotal" required>
                        </div>

                        <div class="field input bd">
                            <label for="">Tipo</label>
                            <select name="Gtipo" id="selectArea">
                                <option value="" disabled selected>Elíge una opción</option>
                                <option value="Día">Día</option>
                                <option value="Noche">Noche</option>
                            </select>
                        </div>

                        <div class="field input">
                            <label for="">Fecha</label>
                            <input type="date" name="Gfecha" required>
                        </div>
                    
                        

                        <div class="button input">
                            <input type="submit" class='btnAgregarGastos' value="Registrar">
                            <input type="submit" class='btnEditarGastos btnEditar' value="Guardar">
                        </div>
                        

                    </form>
                
                
                </div>
          </div>
        </div>
      </div>
    </div>



    <!-- MODAL USUARIOS -->
    <div class="modal fade" id="modalAgregarUsuarios" tabindex="-1" role="dialog" aria-labelledby="modalAgregarUsuariosLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalUsuariosLabel"><span><i class="fa-solid fa-circle-plus"></i> Agregar</span> Usuario</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">

                <form action="#">
                    <div class="error-txt-usuarios error-txt"></div>
                    <div class="field input bd">
                            <label for="">Nombre usuario</label>
                            <input type="text" name="Unombre" placeholder="Nombre..." required>
                            <input type="hidden" name="idusuario">
                    </div>
                    
                    <div class="field input bd">
                            <label for="">Contraseña</label>
                            <input type="text" name="Ucontrasena" placeholder="Contraseña.." required>
                            
                    </div>

                    <div class="field input bd">
                            <label for="">Área</label>
                            <select name="Uarea" id="">
                                <option value="" disabled selected>Selecciona una opción</option>
                                <option value="cocina">Cocina</option>
                                <option value="ordenar">Ordenar</option>
                                <option value="caja">Caja</option>
                                <option value="barra">Barra</option>
                                <option value="admin">Admin</option>
                            </select>
                            
                    </div>

                    <div class="button input">
                            <input type="submit" class='btnAgregarUsuarios' value="Registrar">
                            <input type="submit" class='btnEditarUsuarios btnEditar' value="Guardar">
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






           <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
        <div class="mensajeDispositivos">
            <img src="../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>



    
    
    
    
    <script src="../boostrap/bootstrap.bundle.min.js"></script> 
    <script src="../jquery/Chart.min.js"></script>

    
    
    <script src="../boostrap/popper.min.js"></script>
    <script src="../jquery/jquery-3.5.1.min.js"></script> 
    <script src="../jquery/generales.js"></script> 
    <script src="../jquery/ventanas.js"></script>


    <script src="categorias/categorias.js"></script>
    <script src="productos/productos.js"></script>
    <script src="usuarios/usuarios.js"></script>
    <script src="gastos/gastos.js"></script>
    <script src="estadisticas/estadisticas.js"></script>
  
    <!-- 
    <script src="productos/detalles/detalles.js"></script>
   
    <script src="estadisticas/estadisticas.js"></script>
     -->

   
</body>
</html>

<script>

    //EJECUTAR AL CARGAR EL DOCUMENTO
    $(document).ready(function(){
        
        document.querySelector('#pfechaActual').innerHTML=`<i class="fa-regular fa-calendar"></i>${fechaActualNavbar()}`;

        
    });
  
    
    


    ///////////////////////////////////////
    //OPCIONES DEL MENU LATERAL

    
    
        //BUSCAR OPCION SELECCIONADA EN EL LOCALSTORAGE
        if(localStorage.getItem("opcionMenuVaradero")==null){
            localStorage.setItem("opcionMenuVaradero", JSON.stringify("categorias"));
            let parentnode=document.querySelector("#categorias").parentNode;
                parentnode.classList.add("active");
                menuContenedores("categorias"); 
        }else{
            let iditem=JSON.parse(localStorage.getItem("opcionMenuVaradero"));
            let parentnode=document.querySelector("#"+iditem).parentNode;
            parentnode.classList.add("active");
            menuContenedores(iditem);
        }



    let menu=document.querySelectorAll(".lateral_menu a");
    menu.forEach(element => {
            
        element.addEventListener('click',()=>{

            limpiarLinksMenu();
            
            let divLat=element.parentNode;
            divLat.classList.add("active");

    //         //OCULTAR PARTE PRINCIPAL
                $("#SectionCategorias").hide();
                $("#SectionProductos").hide();
                $("#SectionGastos").hide();
                $("#SectionEstadisticas").hide();
                $("#SectionUsuarios").hide();
    //      

    //          //ESTADISTICAS
    //         $(".estadisticas_contenido_anual").hide();
    //         $(".estadisticas_contenido").hide();
    //         $("#estadisticasMensaje").show();


            let valor=(element.getAttribute("id"));
            localStorage.setItem("opcionMenuVaradero", JSON.stringify(valor));
            
            menuContenedores(valor);
        })
    });

     function menuContenedores(valor){
          switch(valor){
                case "categorias":
                    $("#SectionCategorias").show();
                    cargarCategorias();
                break;
                case "productos":
                    $("#SectionProductos").show();
                    cargarProductos();
                break;
                case "gastos":
                    $("#SectionGastos").show();
                    mostraBusquedaGastos();
                break;
                case "usuarios":
                    $("#SectionUsuarios").show();
                    cargarUsuarios();
                break;
                case "estadisticas":
                    $("#SectionEstadisticas").show();
                break;
             }
     }

   

    function limpiarLinksMenu(){
        //REMOVE ACTIVE
        for(m=0; m<menu.length; m++){
                let mparent=menu[m].parentNode;
                mparent.classList.remove("active");
            }
    }




    function cerrarModal(){
        $("#modalAgregarProductos").modal("hide");
        $("#modalAgregarCategorias").modal("hide");
    //     $("#modalAgregarGastos").modal("hide");
    //     $("#modalAgregarSabores").modal("hide");
        $("#modalAgregarUsuarios").modal("hide");
     }


    function cerrarSesion(){
        localStorage.removeItem("opcionMenuVaradero");
        window.location.href="cerrar_sesion.php";
    }
</script>