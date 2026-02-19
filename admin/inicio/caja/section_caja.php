<!-- ================================ 
 MOSTRAR
====================================== -->

<section class='bd' id='caja'>
        <div class='titulo_caja bd titulo'>
            <h2>Caja</h2>
                <ul class='bd'>
                    <li><h6>Ventas Totales: </h6> <span id='ventasTotales'> 0</span></li>
                    <li><h6>Dinero en ventas: </h6> <span id='ventasEfectivo'> $0</span></li>
                </ul>

                <p><i class="fa-solid fa-repeat"></i> Las cuentas se actualizan automáticamente cada 50 segundos</p>
            </div>

            <!-- <div class="div_header bd">
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
                </div> -->
                
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

                    <div class="pie bd">
                        <div class="pie_texto bd">
                            <label id="numerosRegistrosCaja">Mostrando 0 de 0 registros</label>
                        </div>
                        
                        <div class="nav-paginacion bd" id="nav-paginacion_caja">
                        </div>

                            <input type="hidden" id="pagina" value="1">
                            <input type="hidden" id="orderCol" value="0">
                            <input type="hidden" id="orderType" value="asc">
                    </div>
</section>





<!-- =====================================
    MODALES
============================================= -->



 <!-- MODAL ELIMINAR VENTA -->
       <div class="modal fade" id="modalEliminarCuentas" tabindex="-1" role="dialog" aria-labelledby="modalEliminarCuentasLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalEliminarCuentasLabel"><span><i class="fa-solid fa-trash-can"></i> Eliminar cuenta</span></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal('modalEliminarCuentas')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">

                            <table>
                                <tr>
                                    <th><input type="hidden" name='Eidcliente'>
                                        ¿Seguro que desea eliminar el cliente <span id='lugarEliminar'></span>?</th>

                                </tr> 
                                <tr>
                                    <td><div class='btns-modal-eliminar'>
                                        <button class='btnNo' onclick="cerrarModal('modalEliminarCuentas')"><i class="fa-regular fa-circle-xmark"></i> No</button>
                                        <button onclick='eliminarCuenta()'><i class="fa-regular fa-circle-check"></i> Si</button></div></td>
                                </tr>
                            </table>
            
                </div>
            </div>
        </div>
    </div>


       <!-- MODAL AGREGAR PRODUCTO A VENTA -->
    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" role="dialog" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalAgregarProductoLabel"></h5>
            
            
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal('modalAgregarProducto')">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body text-center">



            <div id='formularioProductoComun' class='formulario bd'>
                        <div class="container">
                                <header>
                                    <span id='formheader'>Registro de producto común </span> 
                                </header>

                        <form action="#">
                            <div class="form first">

                                <div class="details personal">
                                    <span class="title"><i class="fa-solid fa-address-card"></i> Datos del producto</span>
                                    <div class='fields-messageProductosComun cancelar-text' style='display:none'></div>
                                    
                                    
                                    <div class="fields bd long">
                                        <div class="input-field">
                                            <label>*Nombre producto</label>
                                            <input type="hidden" name='Eiditem'>
                                            <input type="text" name='item1' placeholder="Escribe nombre del producto">
                                        </div>   
                                    </div>

                                    <div class="fields bd shorts">

                                        <div class="input-field">
                                            <label>*Cantidad</label>
                                            <input type="number" name='item2' placeholder="$0" oninput='obtenerTotal()'>
                                        </div>

                                        <div class="input-field">
                                            <label>*Costo</label>
                                            <input type="number" name='item3' placeholder="$0" oninput='obtenerTotal()'>
                                        </div>

                                        <div class="input-field">
                                            <label>*Total</label>
                                            <input type="number" name='item4' placeholder="$0">
                                        </div>

                                    </div>
                                    
                                </div>


                                <div class='btns bd'>
                                    <button id='btnagregar' class="btn">
                                        <span class="btn-spinner"></span>
                                        <span class="btn-text">Registrar <i class="fa-solid fa-arrow-right"></i></span>
                                    </button>
                                </div>
                                

                            </div>
                        </form>

                    </div>
            </div> 
            
                </div>
            </div>
        </div>
    </div>




<!-- MODAL CAMBIO -->
 <div class="modal fade" id="modalCambio" tabindex="-1" role="dialog" aria-labelledby="modalCambioLabel" aria-hidden="true" >
            <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCambioLabel"></h5>
                   
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal('modalCambio')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="fields bd">
                            <!-- <form class='formpago'> -->

                                    <div class='field_cantidades bd'>
                                        <table class='bd'>
                                            <tr>
                                                <td colspan='3'>
                                                    <div class="input-field bd">
                                                        <label for="">Forma de pago</label>
                                                        <select name="" id="selectformadepago" onchange='formaDePago(this)'>
                                                            <option value="Efectivo" selected>Efectivo</option>
                                                            <option value="Tarjeta">Tarjeta</option>
                                                            <option value="Transferencia" >Transferencia</option>
                                                        </select>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <tr class='tr1'>
                                                <td><h3 class="font-weight-bold">TOTAL</h3></td>
                                                <td><label for="fieldCostoFabricaDetalle">Recibí</label></td>
                                                <td><h5>Cambio</h5></td>
                                            </tr>
                                            <tr class='tr1'>
                                                <td><h1 id="totalCobrar">$0</h1></td>
                                                <td><center><input type="number" id="fieldBillete" onkeyup='calcularCambio(this)'></center></td>
                                                <td><h3 id="cambioBillete">$0</h3></td>
                                            </tr>
                                           
                                        </table>
                                    </div>

                                    
                                    
                        </div>
                        <div class='btn-cobrar'>
                            <button  class="btncobrar" onclick='pagar()'>Cobrar</button>
                        </div>
                        
                      
                </div>
            </div>
            </div>
        </div>
</div>







<!-- =====================================
            ENLACES EXTERNOS
============================================= -->

    
    <script src='caja/caja.js'></script>
    <script src='caja/modales_caja.js'></script>
