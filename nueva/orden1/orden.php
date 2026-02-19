<?php
     session_start();
        $usuario= $_SESSION["datosUsuarioOrdenar"];

    if($usuario==""){
         header("location: ../index.php");
    }
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenar</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="../boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="orden.css">
    <!-- <link rel="stylesheet" href="combos.css">
    <link rel="stylesheet" href="../ventanas.css"> -->

    <link rel="shortcut icon" type='image/x-icon' href='../img/varadero_logo.png'>
</head>
<body>

    <!-- NAVBAR -->
    <nav id="navbar" class="bd">
        <div class="navbar_contenedor">
            <div class="navbar_logo bd">
                    <img src="../img/varadero_logo.png" alt="">
                    <h2>Ordenar</h2>
            </div>
    
            <div class="navbar_usuario bd">
                <h2>Bienvenido <?php echo "<span>$usuario</span>!"?></h2>
                <img class="navbar_avatar" src="../img/avatar.png" alt="">
                <a href="#/" onclick='cerrarSesion()'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
    
        </div>
    </nav>

    <!-- CATEGORIAS -->
    <section id="categorias" class='bd'>
        <a href="#/" class='iconomenu'><i class="fa-solid fa-bars"></i></a>
        <!-- VENTANA DE MENU -->
        <div class="menu-window" id="menu-window">
            <a href="#/" class="closeMenu" onclick="cerrarMenu()"><i class="fa-solid fa-circle-xmark"></i></a>
                <ul>
            
                </ul>
        </div>
       <div class='mostrar_categorias'>

       </div>
    </section>

    <!-- CONSUMO -->
    <section id="consumo" class='bd'>
    
        <aside class='contenedor_consumo bd'>
            <table>
                <tr>
                    <th>Consumo</th>
                </tr>
                <tr>
                    <th class='bd'>
                    <label class='radio'>Local
                        <input type='radio' name='consumo'
                        value='1' id='Local' checked onclick='mostrarConsumo()'>
                        <span></span>
                        </label>
                    
                    <label class='radio'>Para llevar
                        <input type='radio' name='consumo'
                        value='2' id='Llevar' onclick='mostrarConsumo()'>
                        <span></span>
                        </label>
                    
                    <label class='radio'>Domicilio 
                        <input type='radio' name='consumo'
                        value='3' id='Domicilio' onclick='mostrarConsumo()'>
                        <span></span>
                        </label>
                    </th>
                </tr>
                <tr>
                    <td>
                        <div class='tdmesa tdconsumo bd'>
                            <label for="">Mesa</label>
                                <select name="" id="">
                                    <option value="M1">M1</option>
                                    <option value="M2">M2</option>
                                    <option value="M3">M3</option>
                                    <option value="M4">M4</option>
                                    <option value="M5">M5</option>
                                    <option value="M6">M6</option>
                                    <option value="M7">M7</option>
                                    <option value="M8">M8</option>
                                    <option value="M9">M9</option>
                                    <option value="M10">M10</option>
                                    <option value="M11">M11</option>
                                    <option value="M12">M12</option>
                                    <option value="M13">M13</option>
                                    <option value="M14">M14</option>
                                    <option value="M15">M15</option>
                                </select>
                        </div>
                        <div class='tdnombre tdconsumo bd'>
                            
                         
                                <label for="">Nombre</label>
                                    <input type="text" placeholder='Nombre del cliente'>
                                
                                    <label for="" class='bd'>Celular</label>
                                <input type="number" placeholder='000 000 00 00'>

                            

                        </div>
                        <div class='tddireccion tdconsumo bd'>
                            <label for="" class='bd'>Domicilio</label>
                                <input type="text" placeholder='Domicilio'>

                            <label for="" class='bd'>Celular</label>
                            <input type="number" placeholder='000 000 00 00'>
                        </div>

                    </td>
                </tr>
                
            </table>
        </aside>
        <aside class='bd' id='mostrar_historial'>
           
        </aside>


    </section>

  

     <!-- VENTANA MODAL GENERAL -->
     <div class="modal_confirmado" id='modal'>
            <p class='modal_text'></p>
        </div>



        <div class="modal fade" id="modalFormularioOrdenar" tabindex="-1" role="dialog" aria-labelledby="modalFormularioOrdenarLabel" aria-hidden="true" >
            <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalFormularioOrdenarLabel"><i class="fa-solid fa-circle-plus"></i><span></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">

                <form action="#">
                    <div class="error-txt-ordenar error-txt"></div>
                    <div class="field input bd">
                        <label for="">Productos</label>
                        <select name="Oproducto" id="" onchange='productoSeleccionado(this)'>

                        </select>
                    </div>

                    <div class='name-details'>
                        <div class="field input bd">
                                <label for="">Cantidad</label>
                                <input type="number" name="Ocantidad" value='1' oninput='totalOrden()' placeholder="0" required>
                            </div>

                            <div class="field input bd">
                                <label for="">Costo</label>
                                <input type="number" name="Ocosto" oninput='totalOrden()' placeholder="$0" required>
                        </div>
                    </div>
                        <div class="field input bd">
                            <label for="">Total</label>
                            <input type="number" name="Ototal" value=0 placeholder="$0" readonly required>
                          
                        </div>

                        <div class="field  input radios bd">
                            <label for="">Observaciones</label>
                            <ul class='bd'>
                                <li class='bd'>
                                    <label class='radio'>Si
                                        <input type='radio' name='observacionesInput'
                                        value='Si' onclick='mostrarObservacionesInput()'>
                                        <span></span>
                                    </label>
                                </li>
                                <li class='bd'>
                                    <label class='radio'>No
                                        <input type='radio' name='observacionesInput'
                                        value='No'  onclick='mostrarObservacionesInput()' checked>
                                        <span></span>
                                    </label>
                                </li>
                            </ul>
                        </div>
                        <div class="field input inputObservaciones bd">
                            <textarea name="Oobseravciones" id="" cols="10" rows="10" placeholder="Escribe las observaciones aquí...">

                            </textarea>    
                        </div>
                    
                    <div class="button input bd">
                        <input type="submit" class='btnAgregarOrdenar' value="Registrar">
                        
                    </div>
                    

                </form>
               
               
            </div>
          </div>
            </div>
            </div>
        </div>



         <!-- MODAL ACTUALIZAR -->
    <div class="modal fade" id="modalActualizar" tabindex="-1" role="dialog" aria-labelledby="modalActualizarLabel" aria-hidden="true" >

        <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="modalActualizarLabel"><span><i class="fa-solid fa-gear"></i></span> Actualización de productos</h5>
            </div>
            <div class="modal-body text-center">

                    <p>Se han realizado actualizaciones en los productos, es necesario iniciar sesión nuevamente para poder ver las actualizaciones.</p>

                    <div class="modall-footer justify-content-center">
                        <button type="button" class="btn btnColor" id="btnAceptarSalir" onclick="cerrarSesion()">Aceptar</button>
                    </div>
                    
                    </div>
                </div>
            </div>
    </div>






        <footer class='bd'>
            <ul>
                <li>        
                    <label class='radio'>Todos
                        <input type='radio' name='filtroUsuarios'
                        value='Todos' id='Utodos' checked onclick='mostrarHistorial()'>
                        <span></span>
                    </label>
                </li>
                
                <li>       
                    <label class='radio'><?php echo $usuario; ?>
                        <input type='radio' name='filtroUsuarios'
                        value='<?php echo $usuario; ?>' id='Uusuario' onclick='mostrarHistorial()'>
                        <span></span>
                    </label>
                </li>
            </ul>
                <ul class='bd'>
                    <li>
                    <label class='radio'>Local
                                <input type='radio' name='consumoHistorial'
                                value='1' id='HLocal' checked onclick='mostrarHistorial()'>
                                <span></span>
                    </label></li>
                    <li>        
                    <label class='radio'>Para llevar
                        <input type='radio' name='consumoHistorial'
                        value='2' id='HLlevar' onclick='mostrarHistorial()'>
                        <span></span>
                    </label></li>
                    <li>       
                    <label class='radio'>Domicilio 
                        <input type='radio' name='consumoHistorial'
                        value='3' id='HDomicilio' onclick='mostrarHistorial()'>
                        <span></span>
                    </label></li>
                </ul>
        </footer>
    

    <script src="../boostrap/bootstrap.bundle.min.js"></script> 
    <script src="../boostrap/popper.min.js"></script>
    <script src="../jquery/jquery-3.5.1.min.js"></script> 
    <script src="../jquery/generales.js"></script> 
    <script src="../jquery/ventanas.js"></script>
    <script src="cargar.js"></script>

    
</body>
</html>
<script type="text/javascript">

     //CARGAR FUNCIONES AL RECARGAR PAGINA
     $(document).ready(function(){

         cargarCategoriasLocal();
         cargarProductosLocal();

         cargarHistorial();
            focusVentana();

            mostrarConsumo();
     });


     function focusVentana(){
        $(window).focus(function() {
                cargarHistorial();
                validarActualizacion();
            });
    }


     /////////////////////////////////////////////////
     //CATEGORIAS
     function mostrarCategorias(){
        let categorias_mostrar=document.querySelector('.mostrar_categorias');

        let ulcelulares=document.querySelector('#categorias .menu-window ul');

        limpiarHtml(categorias_mostrar);
        let getCategorias=localStorage.getItem("categoriasVaradero");
        if(getCategorias!=null){
            let categorias= JSON.parse(getCategorias);
            if(categorias.length>0){
                
                let ul=document.createElement("ul");
        
                for(c=0; c<categorias.length; c++){
                    let {id_categoria_categorias,nombre_categorias, color_categorias}=categorias[c];

                        let li= document.createElement("li");
                        li.style.backgroundColor=color_categorias;
                            li.innerHTML=`<a href='#/' onclick='mostrarFormulario(${id_categoria_categorias}, "${nombre_categorias}")'>${nombre_categorias}</a>`;
                
                        ul.appendChild(li);
                        
                }

                for(c=0; c<categorias.length; c++){
                    let {id_categoria_categorias,nombre_categorias, color_categorias}=categorias[c];

                        let li= document.createElement("li");
                            li.style.backgroundColor=color_categorias;
                            li.innerHTML=`<a href='#/' onclick='mostrarFormulario(${id_categoria_categorias}, "${nombre_categorias}")'>${nombre_categorias}</a>`;
                    
                            ulcelulares.appendChild(li);
                       
                        
                }
                categorias_mostrar.appendChild(ul);
            }else{
                categorias_mostrar.innerHTML=`<p class='nohay nohaycategorias'><i class="fa-solid fa-triangle-exclamation"></i>No hay categorias registrados</p>`;
            }
            
        }else{
            categorias_mostrar.innerHTML=`<p class='nohay nohaycategorias'><i class="fa-solid fa-triangle-exclamation"></i>No hay categorias registrados</p>`;
        }
     }

      ///MOSTRAR CATEGORIAS PARA CELULARES
      const menuIcon = document.querySelector('#categorias .iconomenu');
        const menuWindow = document.getElementById('menu-window');

        menuIcon.addEventListener('click', () => {
            menuWindow.style.top = '0px';
        });
        function cerrarMenu(){
            menuWindow.style.top = '-1000px';
        }

     //////////////////////////////////////////////
     //CONSUMO
     function mostrarConsumo(){
        let consumo= document.querySelector('input[name=consumo]:checked').value;

        $(".tdconsumo").hide();

        switch(consumo){
            case "1": document.querySelector('.tdmesa').style.display='flex'; break;
            case "2": document.querySelector('.tdnombre').style.display='flex'; break;
            case "3": document.querySelector('.tddireccion').style.display='flex'; break;
        }
     }



     ///////////////////////////////////////////////////
     ///MOSTRAR FORMULARIO DE ORDENAR
     function mostrarFormulario(id_categoria_categorias, nombre_categorias){
        cerrarMenu();
            $("#modalFormularioOrdenar").modal("show");
            document.querySelector('#modalFormularioOrdenarLabel span').textContent=nombre_categorias;

            localStorage.setItem("nombrecategoriaVaradero",nombre_categorias);

            document.querySelector("#modalFormularioOrdenar form").reset();

            let Oproducto= document.querySelector('select[name=Oproducto]');
            limpiarHtml(Oproducto);
            let option=document.createElement('option');
                option.value="";
                option.disabled=true;
                option.selected=true;
                option.text="Elige un producto";
       
            Oproducto.appendChild(option);

            let getProductos=localStorage.getItem("productosVaradero");
                if(getProductos!=null){
                    id_categoria_categorias=id_categoria_categorias.toString();
                    let arrayproductos= JSON.parse(getProductos);
                        let productos= arrayproductos.filter(f=>f.id_categoria_productos==id_categoria_categorias);
                           
                            if(productos.length>0){
                                for(p=0; p<productos.length; p++){
                                    let {nombre_productos, id_producto_productos}=productos[p];

                                    let stringProductos=JSON.stringify(productos[p]);

                                let opt=document.createElement('option');
                                    opt.textContent=nombre_productos;
                                    opt.value=stringProductos;
                                    Oproducto.appendChild(opt);
                                }
                            }
                }

                mostrarObservacionesInput();
     }

     function productoSeleccionado(valor){
        let producto=valor.value;
        if(producto!=""){
            producto=JSON.parse(producto);
            let {costo_productos}= producto;
            document.querySelector('input[name=Ocosto]').value=costo_productos;
        }
        totalOrden();
     }

     function totalOrden(){
        let costo=parseInt(document.querySelector('input[name=Ocosto]').value);
        let cantidad=parseInt(document.querySelector('input[name=Ocantidad]').value);
        let total=costo*cantidad;

        document.querySelector('input[name=Ototal]').value=total;
     }


     function mostrarObservacionesInput(){
        let observacionesInput= document.querySelector('input[name=observacionesInput]:checked').value;
        if(observacionesInput=="Si"){
            $(".inputObservaciones").show();
        }else{
            $(".inputObservaciones").hide();
        }

     }



     const formordenar = document.querySelector("#modalFormularioOrdenar form"),
    continueBtnOrdenar= formordenar.querySelector("#modalFormularioOrdenar .button .btnAgregarOrdenar"),
    errorTextOrdenar= formordenar.querySelector(".error-txt-ordenar");

        formordenar.onsubmit = (e)=>{
            e.preventDefault();
        }


    continueBtnOrdenar.onclick=()=>{
        let xhr=new XMLHttpRequest();
            xhr.open("POST", "agregar_orden.php", true);
            xhr.onload=()=>{
                if(xhr.readyState===XMLHttpRequest.DONE){
                    if(xhr.status===200){
                        let data=xhr.response;
                            // console.log(data);
                            if(data=="success"){
                                $("#modalFormularioOrdenar").modal("hide");
                                ventanasModales("bien", "Orden registrada");
                                cargarHistorial();
                            }else if(data=="error"){
                                $("#modalFormularioOrdenar").modal("hide");
                                ventanasModales("erro", "Orden no registrada");
                            }else{
                                errorTextOrdenar.innerHTML=data;
                                errorTextOrdenar.style.display="block"; 
                            }
                    }
                }
            }
            //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
            const formData=new FormData(formordenar);
            let Ocategoria=localStorage.getItem("nombrecategoriaVaradero");
            formData.append("Ocategoria", Ocategoria);

            let consumo= document.querySelector('input[name=consumo]:checked').value;
            let lugar="", obser="vacio";    
                if(consumo==1){
                    lugar=document.querySelector('.tdmesa select').value;
                }else if(consumo==2){
                    lugar=document.querySelector('.tdnombre input[type=text]').value;
                    obser=document.querySelector('.tdnombre input[type=number]').value || "vacio";
                }else if(consumo==3){
                    lugar=document.querySelector('.tddireccion input[type=text]').value;
                    obser=document.querySelector('.tddireccion input[type=number]').value || "vacio";
                }
                console.log(obser);
            formData.append("consumo", consumo);
            formData.append("lugar", lugar);
            formData.append("obser", obser);
            formData.append("mesero", document.querySelector('.navbar_usuario h2 span').textContent);

            xhr.send(formData);
    }



    /////////////////////////////////////////////////////////////////////////
    ///CARGAR HISTORIAL
    let mostrar_historial=document.querySelector('#mostrar_historial');
    let historial=[];
    function cargarHistorial(){
        $.ajax({
            type:'GET',
            beforeSend: function() { Spinner(mostrar_historial)},
            complete: function() {mostrarHistorial()},
            url:'cargar_historial.php',
            success:function(resps){
            historial=eval(resps);
               
                }
        });
    }

    function mostrarHistorial(){
        limpiarHtml(mostrar_historial);
        
        // FILTRO POR CONSUMO
        let consumoHistorial= document.querySelector('input[name=consumoHistorial]:checked').value;

        let consumoOrdenes=historial.filter(f=>f.cli_consumo==consumoHistorial);

        //FILTRO X USUARIO
        let filtroUsuarios= document.querySelector('input[name=filtroUsuarios]:checked').value;

        let clientes="";
        if(filtroUsuarios!="Todos"){
            clientes=consumoOrdenes.filter(f=>f.cli_mesero==filtroUsuarios);
        }else{
            clientes=consumoOrdenes;
        }
        


        if(clientes.length>0){
            for(c=0; c<clientes.length; c++){
                let {ordenes, cli_lugar, cli_observacion, cli_hora, cli_mesero, cli_id_clientes}=clientes[c];
                console.log(ordenes);

                let liObservacion="";
                if(cli_observacion!="vacio"){
                    liObservacion=`<li>${cli_observacion}</li>`;
                }
                
                let divClientes= document.createElement('div');
                    divClientes.classList.add("divClientes");
                    divClientes.innerHTML=`<ul>
                                                <li><h2>${cli_lugar}</h2></li>
                                                ${liObservacion}
                                           </ul>`;


                    let divOrdenes= document.createElement('div');
                        divOrdenes.classList.add("divOrdenes");

                            if(ordenes.length>0){
                                let table= document.createElement('table');
                                table.innerHTML=`<thead><tr>
                                                    <th></th>
                                                    <th>Cantidad</th>
                                                    <th>Producto</th>
                                                    <th>Costo</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr></thead>`;

                                    divOrdenes.appendChild(table);
                                    let tbody=document.createElement('tbody');

                                for(o=0; o<ordenes.length; o++){
                                    let {ord_categoria, ord_producto, ord_cantidad, ord_costo, ord_status, ord_total, ord_id_orden}=ordenes[o];

                                        

                                        let tr= document.createElement('tr');
                                        let tdEliminar="", tdEntregar="";
                                        if(ord_status=="1"){
                                            
                                            tr.classList.add("trPendiente");
                                            
                                            tdEliminar=`<a href='#/' class='eliminarRow' onclick='eliminarOrden(${ord_id_orden})'><i class="fa-solid fa-circle-minus"></i></a>`;

                                            tdEntregar=`<a href='#/' class='entregar' onclick='entregarOrden(${ord_id_orden})'><i class="fa-solid fa-circle-check"></i></a>`;
                                        }
                                      
                                        
                                            tr.innerHTML=`  <td>${tdEliminar}</td>
                                                            <td>${ord_cantidad}</td>
                                                            <td><i class='icategoria'>(${ord_categoria}) </i>${ord_producto}</td>
                                                            <td>$${ord_costo}</td>
                                                            <td>$${ord_total}</td>
                                                            <td>${tdEntregar}</td>`;
                                            
                                    tbody.appendChild(tr);
                                }
                                    table.appendChild(tbody);
                                    
                            }else{
                                divOrdenes.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay ordenes registradas</p>`;
                            }

                        
                            
                        divClientes.appendChild(divOrdenes);
                    

                mostrar_historial.appendChild(divClientes);

            }
        }else{
            mostrar_historial.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay cuentas registradas</p>`;
        }

    }


    function eliminarOrden(ord_id_orden){
        $.ajax({
            type:'POST',
            url:'eliminar_orden.php',
            data:{ord_id_orden},
            success:function(resps){
            let resultado=eval(resps);
        
                    if(resultado>0){
                        ventanasModales("bien","Orden eliminada");
                        cargarHistorial();
                        
                    }else{
                        ventanasModales("erro","Orden no eliminada");
                    }
                    
                }
        });
    }


    function entregarOrden(ord_id_orden){
        $.ajax({
            type:'POST',
            url:'entregar_orden.php',
            data:{ord_id_orden},
            success:function(resps){
            let resultado=eval(resps);
        
                    if(resultado>0){
                        // ventanasModales("bien","Orden entregada");
                        cargarHistorial();
                        
                    }else{
                        // ventanasModales("erro","Orden no eliminada");
                    }
                    
                }
        });
    }
     

    function cerrarModal(){
        $("#modalFormularioOrdenar").modal("hide");
    }



     ///////////////////////////////////////////
     ///VALIDAR ACTUALIZACIONES DEL SISTEMA
     function validarActualizacion(){
        $.ajax({
            type:'POST',
            url:'validar_actualizaciones.php',
            success:function(resp){
                let resultado=eval(resp);
                    if(resultado>0){
                        $("#modalActualizar").modal("show");
                    }
                }
            });
     }


     ///////////////////////////////
     //CERRAR SESION
     function cerrarSesion(){
        localStorage.removeItem("categoriasVaradero");
        localStorage.removeItem("productosVaradero");
        window.location.href="../cerrar_sesion.php";
     }
   
    
    
</script>