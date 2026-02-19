<!-- ================================ 
 MOSTRAR
====================================== -->

<section class='bd' id='historial'>
        <div class='titulo_historial bd titulo'>
            <h2>Historial</h2>
                <ul class='bd'>
                    <li><h6>Ventas Totales: </h6> <span id='ventasTot'> 0</span></li>
                    <li><h6>Efectivo: </h6> <span id='ventasEfectivo' style='color:green'> $0</span></li>
                    <li><h6>Tarjeta: </h6> <span id='ventasTarjeta' style='color:green'> $0</span></li>
                    <li><h6>Transferencia: </h6> <span id='ventasTransferencia' style='color:green'> $0</span></li>
                    <li><h6>Gastos: </h6> <span id='ventasGastos' style='color:red'> $0</span></li>
                    <li><a href="javascript:void(0)" onclick='imprimirTicketCorte()'><i class="fa-solid fa-print"></i> Imprimir corte</a></li>
                </ul>

            </div>

             <div class="div_header bd">
                    <div class='bd filtro_filas'>
                        <!-- <div class="bd">
                                <label for="num_registros" class="col-form-label">Mostrar: </label>
                            </div>

                            <div class="bd">
                                <select name="num_registros" id="num_registrosproductos" class="">
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="500">500</option>
                                </select>
                            </div>

                            <div class="">
                                <label for="num_registros" class="">registros </label>
                            </div> -->
                    </div>


                    <div class='filtro_input bd'>
                        <!-- <div class='link_agregar bd'>
                            <a href="javascript:void(0)" onclick="agregarProductosForm()"><i class="fa-solid fa-circle-plus"></i> Agregar productos</a>
                            
                        </div> -->
                        <div class='inpt'>
                            <div class="">
                                <label for="campo" class="">Buscar: </label>
                            </div>
                            <div class="">
                                <input type="date" name="campo" id="campofechabuscar" value='<?php echo date('Y-m-d'); ?>' onchange='cargarHistorial()'>
                            </div>

                        
                        </div>
                        
                    </div>
                </div> 
                
                    <div class="content-tabla bd">
                        <!-- <table>
                            <thead>
                                <tr>    
                                    
                                    <th>Nombre producto</th>
                                    <th>Categoría</th>
                                    <th>Costo Ven</th>
                                    <th>Fecha de creación</th>
                                    <th>Estatus</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="contentProductos">
                               
                            </tbody>
                        </table> -->
                    </div>

                    <!-- <div class="pie bd">
                        <div class="pie_texto bd">
                            <label id="numerosRegistrosHistorial">Mostrando 0 de 0 registros</label>
                        </div>
                        
                        <div class="nav-paginacion bd" id="nav-paginacion_caja">
                        </div>

                            <input type="hidden" id="pagina" value="1">
                            <input type="hidden" id="orderCol" value="0">
                            <input type="hidden" id="orderType" value="asc">
                    </div> -->
</section>


<!-- =====================================
            ENLACES EXTERNOS
============================================= -->

    
    <script src='historial/historial.js'></script>