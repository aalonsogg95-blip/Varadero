<!-- ================================ 
 MOSTRAR CORTESIAS
====================================== -->

<section class='bd' id='cortesias'>
        <div class='titulo_cortesias bd titulo'>
            <h2>Cortesias</h2>
                <ul class='bd'>
                    <li><h6>Cortesias: </h6> <span id='cortesiasTotales'> 0</span></li>
                </ul>

            </div>

             <div class="div_header bd">
                    <div class='bd filtro_filas'>
                        
                    </div>


                    <div class='filtro_input bd'>
                        
                        <div class='inpt'>
                            <div class="">
                                <label for="campo" class="">Buscar: </label>
                            </div>
                            <div class="">
                                <!-- <input type="date" name="campo" id="campofechabuscar" value='<?php echo date('Y-m-d'); ?>' onchange='cargarHistorial()'> -->
                                 <?php
                                    $mesActual = date('n');  // Número del mes (1-12)
                                    $añoActual = date('Y');  // Año actual
                                    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
                                 ?>
                                <select name="mes" id="mes" onchange='cargarCortesias()'>
                                    <?php for($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($i == $mesActual) ? 'selected' : ''; ?>>
                                            <?php echo $meses[$i]; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>

                                <select name="año" id="año" onchange='cargarCortesias()'>
                                    <?php for($i = 2020; $i <= $añoActual + 1; $i++): ?>
                                        <option value="<?php echo $i; ?>" <?php echo ($i == $añoActual) ? 'selected' : ''; ?>>
                                            <?php echo $i; ?>
                                        </option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                        
                        </div>
                        
                    </div>
                </div> 
                
                    <div class="content-tabla bd">
                       
                    </div>

                   
</section>


<!-- =====================================
            ENLACES EXTERNOS
============================================= -->

    
    <script src='cortesias/cortesias.js'></script>