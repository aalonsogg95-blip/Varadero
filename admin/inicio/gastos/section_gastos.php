<!-- ================================ 
 MOSTRAR
====================================== -->
<?php
// Obtener el mes actual
$mesActual = date('m');
// Obtener el año actual
$añoActual = date('Y');
?>

<section class='bd' id='gastos'>
            <div class='titulo_gastos bd titulo'>
                <h2>Gastos</h2>
                <ul class='bd'>
                    <li><h6>Gastos Totales: </h6> <span id='gastosTotales'> 0</span></li>
                    <li><h6>Dinero en gastos: </h6> <span id='gastosEfectivo'> $0</span></li>
                </ul>
            </div>

            <div class="div_header bd">
                    <div class='bd filtro_filas'>
                        <div class="bd">
                                <label for="num_registros" class="col-form-label">Mostrar: </label>
                            </div>

                            <div class="bd">
                                <select name="num_registros" id="num_registrosgastos" class="">
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <div class="">
                                <label for="num_registros" class="">registros </label>
                            </div>
                    </div>

                    <div class='filtros_tipo bd'>
                        <ul>
                            <!-- <li><label class='radio'><input type="radio" value='Todos' name='tipogasto' checked>Todos <h6>$0</h6> <span></span></label></li> -->
                            <li><label class='radio'><input type="radio" value='Gastos caja' name='tipogasto' onclick='cargarGastos()' checked>Gastos caja <h6 id='tipogastocaja'>$0</h6> <span></span></label></li>
                            <li><label class='radio'><input type="radio" value='Gastos insumos' name='tipogasto' onclick='cargarGastos()'>Gastos insumos <h6 id='tipogastoinsumos'>$0</h6> <span></span></label></li>
                            <li><label class='radio'><input type="radio" value='Gastos publicitarios' name='tipogasto' onclick='cargarGastos()'>Gastos publicitarios <h6 id='tipogastopublicitarios'>$0</h6> <span></span></label></li>
                            <li><label class='radio'><input type="radio" value='Gastos fijos' name='tipogasto' onclick='cargarGastos()'>Gastos fijos <h6 id='tipogastofijos'>$0</h6> <span></span></label></li>
                            <li><label class='radio'><input type="radio" value='Gastos variables' name='tipogasto' onclick='cargarGastos()'>Gastos variables <h6 id='tipogastovariables'>$0</h6> <span></span></label></li>
                            <li><label class='radio'><input type="radio" value='Gastos mermas' name='tipogasto' onclick='cargarGastos()'>Gastos mermas <h6 id='tipogastomermas'>$0</h6><span></span></label></li>
                            <li><label class='radio'><input type="radio" value='Gastos nomina' name='tipogasto' onclick='cargarGastos()'>Gastos nomina <h6 id='tipogastonomina'>$0</h6><span></span></label></li>
                        </ul>
                    </div>


                    <div class='filtro_input bd'>
                        <div class='link_agregar'>
                            <a href="#/" onclick="agregarGastosForm()"><i class="fa-solid fa-circle-plus"></i> Agregar gasto</a>
                        </div>
                        <div class='filtro_tiempo bd'>
                            <label for="pormes" class='radio bd'>
                                <input type='radio'  name='periodo' id='pormes' onclick='mostraBusquedaGastos()' value="dia" checked>
                                <span></span>Por fecha
                            </label>
                            <label for="poranual" class='radio bd'>
                                <input type='radio'  name='periodo' id='poranual' onclick='mostraBusquedaGastos()' value="mes">
                                <span></span>Por mes
                            </label>
                        </div>
                        <div class='inpt'>

                            <div class='div_buscar_fecha bd' >
                                <div class="">
                                    <label for="campo" class="">Buscar: </label>
                                </div>
                                <div class="">
                                    <input type="date" name="campo" onchange='cargarGastos()' id="campogastos" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>

                            <div class='div_buscar_mes bd' style='display:none;'>
                                <div class="bd">
                                    <label for="campo" class="">Mes: </label>
                                </div>
                                <div class="bd">
                                    <select name="" id="campomes" onchange='cargarGastos()'>
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
                                </div>

                                <div class="bd">
                                    <label for="campo" class="">Año: </label>
                                </div>
                                <div class="bd">
                                    <select name="" id="campoanual" onchange='cargarGastos()'>
                                        <option value="2024" <?php echo ($añoActual == '2024') ? 'selected' : ''; ?>>2024</option>
                                        <option value="2025" <?php echo ($añoActual == '2025') ? 'selected' : ''; ?>>2025</option>
                                        <option value="2026" <?php echo ($añoActual == '2026') ? 'selected' : ''; ?>>2026</option>
                                        <option value="2027" <?php echo ($añoActual == '2027') ? 'selected' : ''; ?>>2027</option>
                                        <option value="2028" <?php echo ($añoActual == '2028') ? 'selected' : ''; ?>>2028</option>
                                        <option value="2029" <?php echo ($añoActual == '2029') ? 'selected' : ''; ?>>2029</option>
                                        <option value="2030" <?php echo ($añoActual == '2030') ? 'selected' : ''; ?>>2030</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                    <div class="tabla">
                         <table>
                            <thead>
                                <tr>    
                                    
                                    <th>Nombre gasto</th>
                                    <th>Proveedor</th>
                                    <th>Costo</th>
                                    <th>Fecha</th>
                                    <th>Tipo</th>
                                    <th>Usuario</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="contentGastos">
                               
                            </tbody>
                        </table>
                    </div>

                    <div class="pie bd">
                        <div class="pie_texto bd">
                            <label id="numerosRegistrosGastos">Mostrando 0 de 0 registros</label>
                        </div>
                        
                        <div class="nav-paginacion bd" id="nav-paginacion_gastos">
                        </div>

                            <input type="hidden" id="pagina" value="1">
                            <input type="hidden" id="orderCol" value="0">
                            <input type="hidden" id="orderType" value="asc">
                    </div>
</section>



<!-- ================================ 
 FORMULARIO PRODUCTO
====================================== -->
<div id='formularioGastos' class='formulario bd' style='display:none'>
            <div class="container">
            <header>
                <span id='formheaderGastos'>Registro de gasto </span> 
                <a href="#/" onclick='agregarGastosForm()' class='cancelar-text'><i class="fa-solid fa-xmark"></i> Cancelar</a>
            </header>
               
            <form action="#">
                <div class="form first">


                    <div class="details personal">
                        <span class="title"><i class="fa-solid fa-address-card"></i> Gastos caja</span>
                        <div class='fields-messageGastos cancelar-text' style='display:none'></div>
                    
                        <div class="fields">
                            <div class="input-field">
                                 <input type="hidden" name='Eiditem'>
                                <label>*Concepto</label>
                                <input type="text" name='item1' placeholder="Escribe nombre del producto">
                            </div>  

                            <div class="input-field">
                                <label>*Proveedor</label>
                                <input type="text" name='item2' placeholder="Escribe nombre proveedor">
                            </div> 

                            <div class="input-field">
                                <label>*Total</label>
                                <input type="number" name='item3' placeholder="$0">
                            </div> 
                        </div>

                        <div class="fields">
                             <div class="input-field">
                                <label for="">Tipo de gastos</label>
                               
                                <select name="item4" id="">
                                    <option value="">Seleccione una opción</option>
                                    <option value="Gastos caja">Gastos caja</option>
                                    <option value="Gastos insumos">Gastos insumos</option>
                                    <option value="Gastos publicitarios">Gastos publicitarios</option>
                                    <option value="Gastos fijos">Gastos fijos</option>
                                    <option value="Gastos variables">Gastos variables</option>
                                    <option value="Gastos mermas">Gastos mermas</option>
                                    <option value="Gastos nomina">Gastos nomina</option>
                                </select>
                            </div>

                            <div class="input-field">
                                <label>*Frecuencia</label>
                                <select name='item5'>
                                    <option value="No especificar">No especificar</option>
                                    <option value="Diario">Diario</option>
                                    <option value="Semanal">Semanal</option>
                                    <option value="Quincenal">Quincenal</option>
                                    <option value="Mensual">Mensual</option>
                                </select>
                            </div>
                              

                            <div class="input-field">
                                <label>*Fecha</label>
                                <input type="date" name='item6' value="<?php echo date('Y-m-d'); ?>" >
                            </div> 

                        </div>
                    </div>



                







                    <div class='btns bd'>
                        <button id='btnagregarGastos' class="btn">
                            <span class="btn-spinner"></span>
                            <span class="btn-text">Registrar <i class="fa-solid fa-arrow-right"></i></span>
                        </button>
                        <button id='btneditarGastos' class="btn" style='display:none'>
                            <span class="btn-spinner"></span>
                            <span class="btn-text">Guardar <i class="fa-solid fa-arrow-right"></i></span>
                        </button>
                    </div>
                    

                </div>
            </form>
        </div>
</div> 


  <!-- =====================================
                    ENLACES EXTERNOS
        ============================================= -->

    
        <script src='gastos/gastos.js'></script>

<script>
    // Al cargar la página, verificar si se debe abrir el formulario
    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('abrirGastosForm') === 'true') {
            localStorage.removeItem('abrirGastosForm'); // Limpiar el flag
            setTimeout(() => {
                agregarGastosForm();
            }, 300);
        }
    });
</script>