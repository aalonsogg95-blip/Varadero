<!-- ================================ 
 MOSTRAR
====================================== -->

<section class='bd' id='productos'>
            <div class='titulo_productos bd titulo'>
                <h2>Productos</h2>
            </div>

            <div class="div_header bd">
                    <div class='bd filtro_filas'>
                        <div class="bd">
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
                            </div>
                    </div>



                    <div class='filtro_input bd'>
                        <div class='link_agregar bd'>
                            <a href="javascript:void(0)" onclick="agregarProductosForm()"><i class="fa-solid fa-circle-plus"></i> Agregar productos</a>
                            
                        </div>
                        <div class='inpt'>
                            <div class="">
                                <label for="campo" class="">Buscar: </label>
                            </div>
                            <div class="">
                                <input type="text" name="campo" id="campoproductos" placeholder='Nombre producto...'>
                            </div>

                        
                        </div>
                        
                    </div>
                </div>
                
                    <div class="tabla">
                        <table>
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
                        </table>
                    </div>

                    <div class="pie bd">
                        <div class="pie_texto bd">
                            <label id="numerosRegistrosProductos">Mostrando 0 de 0 registros</label>
                        </div>
                        
                        <div class="nav-paginacion bd" id="nav-paginacion_productos">
                        </div>

                            <input type="hidden" id="pagina" value="1">
                            <input type="hidden" id="orderCol" value="0">
                            <input type="hidden" id="orderType" value="asc">
                    </div>
</section>


<!-- ================================ 
 FORMULARIO PRODUCTO
====================================== -->
<div id='formularioProductos' class='formulario bd' style='display:none'>
            <div class="container">
            <header>
                <span id='formheader'>Registro de producto </span> 
                <a href="javascript:void(0)" onclick='agregarProductosForm()' class='cancelar-text'><i class="fa-solid fa-xmark"></i> Cancelar</a>
            </header>
               
            <form action="#">
                <div class="form first">

                    <div class="details personal">
                        <span class="title"><i class="fa-solid fa-address-card"></i> Datos del producto</span>
                        <div class='fields-messageProductos cancelar-text' style='display:none'>
                         
                        </div>
                        <div class="fields">
                            <div class="input-field">
                                <label>*Nombre producto</label>
                                <input type="hidden" name='Eiditem'>
                                <input type="text" name='item1' placeholder="Escribe nombre del producto">
                            </div>  

                             

                             <div class="input-field">
                                <label>*Categoría</label>
                                <select name="item2" id="">
                                    <option value="" selected>Selecciona...</option>
                                    <option value="camarones">Camarones</option>
                                    <option value="filetes">Filetes</option>
                                    <option value="esp caliente">Esp caliente</option>
                                    <option value="cocteles">Cocteles</option>
                                    <option value="aguachiles">Aguachiles</option>
                                    <option value="ceviche">Ceviche</option>
                                    <option value="tostadas">Tostadas</option>
                                    <option value="tacos">Tacos</option>
                                    <option value="esp fria">Esp fria</option>
                                    <option value="mixologia">Mixología</option>
                                    <option value="cortes">Cortes</option>
                                    <option value="postre">Postre</option>
                                    <option value="bebidas">Bebidas</option>
                                    <option value="cervezas">Cervezas</option>
                                    <option value="snacks">Snacks</option>
                                    <option value="infantiles">Infantiles</option>
                                    <option value="licores">Licores</option>
                                    <option value="mariscadas">Mariscadas</option>
                                    <option value="extras">Extras</option>
                                    <option value="desayunos">Desayunos</option>
                                </select>
                              
                            </div> 

                            <div class="input-field">
                                <label>*Costo Venta</label>
                                <input type="number" name='item3' placeholder="$0">
                            </div> 

                            
                        </div>
                        
                    </div>


                    <div class='btns bd'>
                        <button id='btnagregar' class="btn">
                            <span class="btn-spinner"></span>
                            <span class="btn-text">Registrar <i class="fa-solid fa-arrow-right"></i></span>
                        </button>
                        <button id='btneditar' class="btn" style='display:none'>
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

    
    <script src='productos/productos.js'></script>
