<!-- ================================ 
 MOSTRAR
====================================== -->

<section class='bd' id='usuarios'>
        <div class='titulo_usuarios bd titulo'>
            <h2>Usuarios</h2>
               
            </div>

            <div class="div_header bd">
                    <div class='bd filtro_filas'>
                        <div class="bd">
                                <label for="num_registros" class="col-form-label">Mostrar: </label>
                            </div>

                            <div class="bd">
                                <select name="num_registros" id="num_registrosusuarios" class="">
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
                            <a href="javascript:void(0)" onclick="agregarUsuariosForm()"><i class="fa-solid fa-circle-plus"></i> Agregar usuarios</a>
                            
                        </div>
                        <div class='inpt'>
                            <div class="">
                                <label for="campo" class="">Buscar: </label>
                            </div>
                            <div class="">
                                <input type="text" name="campo" id="campousuarios" placeholder='Nombre usuario...'>
                            </div>

                        
                        </div>
                        
                    </div>
                </div>
                
                    <div class="tabla">
                        <table>
                            <thead>
                                <tr>    
                                    <th>Nombre usuario</th>
                                    <th>Contraseña</th>
                                    <th>Área</th>
                                    <th>Último acceso</th>
                                    <th>Estatus</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="contentUsuarios">
                               
                            </tbody>
                        </table>
                    </div>

                    <div class="pie bd">
                        <div class="pie_texto bd">
                            <label id="numerosRegistrosUsuarios">Mostrando 0 de 0 registros</label>
                        </div>
                        
                        <div class="nav-paginacion bd" id="nav-paginacion_usuarios">
                        </div>

                            <input type="hidden" id="pagina" value="1">
                            <input type="hidden" id="orderCol" value="0">
                            <input type="hidden" id="orderType" value="asc">
                    </div>
</section>




<!-- ================================ 
 FORMULARIO USUARIOS
====================================== -->
<div id='formularioUsuarios' class='formulario bd' style='display:none'>
            <div class="container">
            <header>
                <span id='formheader'>Registro de usuario </span> 
                <a href="javascript:void(0)" onclick='agregarUsuariosForm()' class='cancelar-text'><i class="fa-solid fa-xmark"></i> Cancelar</a>
            </header>
               
            <form action="#">
                <div class="form first">

                    <div class="details personal">
                        <span class="title"><i class="fa-solid fa-address-card"></i> Datos del usuario</span>
                        <div class='fields-messageUsuarios cancelar-text' style='display:none'>
                         
                        </div>
                        <div class="fields">
                            <div class="input-field">
                                <label>*Nombre usuario</label>
                                <input type="hidden" name='Eiditem'>
                                <input type="text" name='item1' placeholder="Escribe nombre del usuario">
                            </div>  

                            <div class="input-field">
                                <label>*Contraseña</label>
                                <input type="text" name='item2' placeholder="*****">
                            </div> 

                             <div class="input-field">
                                <label>*Área</label>
                                <select name="item3" id="">
                                    <option value="" selected>Selecciona...</option>
                                    <option value="ordenar">Ordenar</option>
                                    <option value="caja">Caja</option>
                                    <option value="barra">Barra</option>
                                    <option value="cocina">Cocina</option>
                                </select>
                              
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

    
    <script src='usuarios/usuarios.js'></script>
