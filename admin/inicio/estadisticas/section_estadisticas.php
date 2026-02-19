 <!-- ESTADISTICAS -->
  <?php
// Obtener el mes actual
$mesActual = date('m');
// Obtener el año actual
$añoActual = date('Y');
?>

 <div id="estadisticas" class="bd">
                    <div class="navbar_principal bd">
                        <h2>Estadísticas</h2>
                        
                    </div>

                    <div id='estadisticas_buscar' class='bd'>
                        <h2>Consultar estadisticas</h2>
                        <div class='bd'>
                            <!-- <label for="poranual_estadisticas" class='radio'>
                                <input type='radio'  name='periodo_estadisticas' id='poranual_estadisticas' onclick='mostraBusquedaEstadisticas()' value="1" checked>
                                <span></span>Por mes
                            </label>

                            <label for="pormes_estadisticas" class='radio'>
                                <input type='radio'  name='periodo_estadisticas' id='pormes_estadisticas' onclick='mostraBusquedaEstadisticas()' value="2">
                                <span></span>Por año
                            </label> -->
                            
                        </div>
                        <div class='estadisticas_anual bd'>
                            <!-- <label for="">Año</label>
                            <select id="estadisticas_field_aanual">
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select> -->
                        </div>
                        <div class='estadisticas_mes bd'>
                            <label for="">Mes</label>
                            <select id="estadisticas_field_mes">
                                <option value="01" <?php echo ($mesActual == '01') ? 'selected' : ''; ?>>Enero</option>
                                <option value="02" <?php echo ($mesActual == '02') ? 'selected' : ''; ?>>Febrero</option>
                                <option value="03" <?php echo ($mesActual == '03') ? 'selected' : ''; ?>>Marzo</option>
                                <option value="04" <?php echo ($mesActual == '04') ? 'selected' : ''; ?>>Abril</option>
                                <option value="05" <?php echo ($mesActual == '05') ? 'selected' : ''; ?>>Mayo</option>
                                <option value="06" <?php echo ($mesActual == '06') ? 'selected' : ''; ?>>Junio</option>
                                <option value="07" <?php echo ($mesActual == '07') ? 'selected' : ''; ?>>Julio</option>
                                <option value="08" <?php echo ($mesActual == '08') ? 'selected' : ''; ?>>Agosto</option>
                                <option value="09" <?php echo ($mesActual == '09') ? 'selected' : ''; ?>>Septiembre</option>
                                <option value="10" <?php echo ($mesActual == '10') ? 'selected' : ''; ?>>Octubre</option>
                                <option value="11" <?php echo ($mesActual == '11') ? 'selected' : ''; ?>>Noviembre</option>
                                <option value="12" <?php echo ($mesActual == '12') ? 'selected' : ''; ?>>Diciembre</option>
                            </select>
                            <label for="">Año</label>
                            <select id="estadisticas_field_anual">
                                <option value="2024" <?php echo ($añoActual == '2024') ? 'selected' : ''; ?>>2024</option>
                                <option value="2025" <?php echo ($añoActual == '2025') ? 'selected' : ''; ?>>2025</option>
                                <option value="2026" <?php echo ($añoActual == '2026') ? 'selected' : ''; ?>>2026</option>
                                <option value="2027" <?php echo ($añoActual == '2027') ? 'selected' : ''; ?>>2027</option>
                                <option value="2028" <?php echo ($añoActual == '2028') ? 'selected' : ''; ?>>2028</option>
                                <option value="2029" <?php echo ($añoActual == '2029') ? 'selected' : ''; ?>>2029</option>
                                <option value="2030" <?php echo ($añoActual == '2030') ? 'selected' : ''; ?>>2030</option>
                            </select>
                            
                        </div>
                        <button onclick='buscarEstadisticas()'>Buscar</button>
                    </div>

                    <div id="estadisticas_mostrar" class="principal_mostrar bd">
                    

                            <p class='nohay' id="estadisticasMensaje"><i class="fa-solid fa-circle-info"></i> No información disponible con los datos seleccionados..!</p>

                
                            <!-- INDICADORES -->
                            <div class='indicadores bd' style='display:none'>
                                <h3>Indicadores</h3>
                                <div class="contenedor_indicadores bd" >

                                </div>
                            </div>

                            <div class='estadisticas_contenido bd' style='display:none'>


                            <!-- BOTONES DEL MENU -->
                            <div class='menu_estadisticas bd' >
                                <ul>
                                    <li><a href="javascript:void(0)" class='active'><i class="fa-solid fa-folder"></i> Generales</a></li>
                                    <li><a href="javascript:void(0)"><i class='fa-solid fa-users'></i> Clientes</a></li>
                                    <li><a href="javascript:void(0)"><i class="fa-solid fa-shop"></i> Consumo</a></li>
                                    <li><a href="javascript:void(0)"><i class='fa-solid fa-layer-group'></i> Categorias</a></li>
                                    <li><a href="javascript:void(0)"><i class='fa-solid fa-fish'></i> Productos</a></li>
                                    <li><a href="javascript:void(0)"><i class='fa-solid fa-credit-card'></i> Pagos</a></li>
                                    <li><a href="javascript:void(0)"><i class='fa-solid fa-coins'></i> Gastos</a></li>
                                    <li><a href="javascript:void(0)"><i class='fa-solid fa-gift'></i> Cortesias</a></li>
                                </ul>
                            </div>


                                <!-- DATOS GENERALES -->
                                <aside id='datosgenerales' style='display:none' class='bd'>

                                </aside>

                                <!-- DATOS CLIENTES -->
                                <aside id='datosclientes' style='display:none' class='bd'>

                                </aside>

                                <!-- DATOS CONSUMO -->
                                <aside id='datosconsumo' style='display:none' class='bd'>
                                    <div class='datosmostrar_consumo bd'>
                                            
                                        </div>
                                </aside>

                                <!-- DATOS CATEGORIAS -->
                                <aside id='datoscategorias' style='display:none' class='bd'>
                                    <div class='graficas bd'>
                                        <div id='grafica_categorias' class='bd'>

                                        </div>
                                    </div>
                                </aside>

                                <!-- DATOS PRODUCTOS -->
                                <aside id='datosproductos' style='display:none' class='bd'>
                                    <div class='graficas bd'>
                                        <div id='grafica_productos' class='bd'>

                                        </div>

                                        <div id='grafica_productos_comida' class='bd'>

                                        </div>
                                    </div>
                                    
                                </aside>

                                <!-- DATOS PAGOS -->
                                <aside id='datospagos' style='display:none' class='bd'>
                                        <div class='datosmostrar_pagos bd'>
                                            
                                        </div>
                                        <div class='datosusuarios_pagos bd'>
                                            
                                        </div>

                                        <div class='tablapagos bd'>
                                            
                                        </div>  
                                </aside>


                                <!-- DATOS GASTOS -->
                                <aside id='datosgastos' style='display:none' class='bd'>

                                        <div class='tablagastos bd'>
                                            
                                        </div>  

                                    <div class='graficas bd'>
                                        <div id='grafica_gastos' class='bd'>

                                        </div>
                                    </div>
                                </aside>

                                <!-- DATOS CORTESIAS -->
                                <aside id='datoscortesias' style='display:none' class='bd'>
                                    <div class='datosmostrar_cortesias bd'>
                                            
                                        </div>
                                </aside>
                            

                                    
                            </div>
                                
                        </div>




                    </div>
                    

        </div>


        <!-- =====================================
                    ENLACES EXTERNOS
        ============================================= -->

    
        <script src='estadisticas/estadisticas.js'></script>