

//VARIABLES GENERALES
let productos_mostrar= document.querySelector('#productos_mostrar');


function modalAgregarProductosFormulario(){
    $("#modalAgregarProductos").modal("show");
    //CAMBIAR ENCABEZADO
    document.querySelector('#modalProductosLabel span').innerHTML=`<i class="fa-solid fa-circle-plus"></i> Agregar`;
    //CAMBIAR BOTON
    $(".btnAgregarProductos").show();
    $(".btnEditarProductos").hide();

    //RESETEAR FORMULARIO
    $('.error-txt-productos').hide();
    document.querySelector('#modalAgregarProductos form').reset();

    cargarCategoriasSelect(null);
}


const formproductos = document.querySelector("#modalAgregarProductos form"),
    continueBtnProductos= formproductos.querySelector("#modalAgregarProductos .button .btnAgregarProductos"),
    errorTextProductos= formproductos.querySelector(".error-txt-productos");

formproductos.onsubmit = (e)=>{
    e.preventDefault();
}


continueBtnProductos.onclick=()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "productos/agregar_productos.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                    if(data=="success"){
                        $("#modalAgregarProductos").modal("hide");
                        ventanasModales("bien", "Producto registrado");
                        cargarProductos();
                    }else if(data=="error"){
                        $("#modalAgregarProductos").modal("hide");
                        ventanasModales("erro", "Producto no registrado");
                    }else{
                        errorTextProductos.innerHTML=data;
                        errorTextProductos.style.display="block"; 
                    }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formproductos);
   
    xhr.send(formData);
}

let productos=[];
function cargarProductos(){
    $.ajax({
        type:'GET',
        beforeSend: function() { Spinner(productos_mostrar)},
        complete: function() { buscarProductos()},
        url:'productos/cargar_productos.php',
        success:function(resps){
         productos=eval(resps);
             
            document.querySelector('#contador_productos').textContent=productos.length;
            //  mostrarProductos(productos);
            }
    });
}





//EJECUTAR FUNCION DE BUSCAR AL PRECIONAR TECLA EN CAMPO DE BUSCAR REPORTE
document.querySelector("#productos_buscar input").addEventListener("input", buscarProductos);



function buscarProductos(){
    //BUSCAR POR NOMBRE

  let arrproductos=[];

   let fieldBuscar=document.querySelector('#productos_buscar input').value;
    if(fieldBuscar!=""){
           productos.forEach(p=>{
                      let resultado= ((p.nombre_productos).toLowerCase()).includes(fieldBuscar.toLowerCase());
                      let resultado1= ((p.nombre_categorias).toLowerCase()).includes(fieldBuscar.toLowerCase());
                         if(resultado || resultado1){
                          arrproductos.push(p);                     
                         }
                });
    }else{
       arrproductos=productos;
    }
     mostrarProductos(arrproductos);
}


 function mostrarProductos(arrproductos){

     limpiarHtml(productos_mostrar);
     if(arrproductos.length>0){

        let table=document.createElement("table");
            table.classList.add("table", "table-sm");
            
            let thead=document.createElement('thead');
                thead.innerHTML=`<tr>
                        
                                <th>Nombre</th>
                                <th>Costo</th>
                                <th>Categoria</th>
                                <th>Status</th>
                                <th>Área</th>
                                <th></th>
                                </tr>`;
                table.appendChild(thead);
            let tbody= document.createElement('tbody');

            for(p=0; p<arrproductos.length; p++){
                let {id_producto_productos,nombre_productos, nombre_categorias, status_productos, area_productos, costo_productos}=arrproductos[p];


                let stringProductos=JSON.stringify(arrproductos[p]);

                
                //STATUS
                let linkStatus=`<a href='#/' class='linkDisponible linkStatus' onclick='statusProducto(${id_producto_productos}, 0)'>Disponible</a>`;
                if(status_productos==0){
                    linkStatus=`<a href='#/' class='linkAgotado linkStatus' onclick='statusProducto(${id_producto_productos}, 1)'>Agotado</a>`;
                }

                //AREA
                let textArea="Barra";
                if(area_productos==1){
                    textArea="Cocina";
                }else if(area_productos==3){
                    textArea="Na";
                }


                


                let tr=document.createElement("tr");
                    tr.innerHTML=`<td>${nombre_productos}</td>
                                  <td>${nombre_categorias}</td>
                                  <td>$${costo_productos}</td>
                                  <td>${linkStatus}</td>
                                  <td>${textArea}</td>
                                 
                                  <td>
                                    <a href='#/' onclick='modalEditarProductos(${stringProductos})'><i class="fa-solid fa-pen"></i></a>
                                    <a href='#/' class='eliminar' onclick='eliminarProductos(${id_producto_productos})'><i class="fa-solid fa-trash-can"></i></a>
                                  </td>`;

                tbody.appendChild(tr);
            }


            table.appendChild(tbody);
            productos_mostrar.appendChild(table);

    }else{
        productos_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay productos registrados</p>`;
    }
 }


 /////////
//ELIMINAR
function eliminarProductos(id_producto_productos){
    $.ajax({
        type:'POST',
        url:'productos/eliminar_productos.php',
        data:{id_producto_productos},
        success:function(resps){
        let resultado=eval(resps);
     
                if(resultado>0){
                     ventanasModales("bien","Producto eliminado");
                    cargarProductos();
                    
                }else{
                    ventanasModales("erro","Producto no eliminado");
                }
                
            }
    });
}






/////////
//EDITAR
function modalEditarProductos(stringProductos){
    let {id_producto_productos,nombre_productos, nombre_categorias, area_productos, costo_productos}=stringProductos;

    $("#modalAgregarProductos").modal("show");

    //CAMBIAR ENCABEZADO
    document.querySelector('#modalProductosLabel span').innerHTML=`<i class="fa-solid fa-pen"></i>Editar`;

    //CAMBIAR BOTON
    $(".btnAgregarProductos").hide();
    $(".btnEditarProductos").show();

    

    //COLOAR DATOS
    let form=document.querySelector('#modalAgregarProductos form');
    form.querySelector('input[name=idproducto]').value=id_producto_productos;
    form.querySelector('input[name=Pnombre]').value=nombre_productos;
    form.querySelector('select[name=Parea]').value=area_productos;
    form.querySelector('input[name=Pcosto]').value=costo_productos;
    
    
    cargarCategoriasSelect(nombre_categorias);
}




let guardarBtnProductos= formproductos.querySelector("#modalAgregarProductos .button .btnEditarProductos");
guardarBtnProductos.onclick=()=>{
 
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "productos/editar_productos.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                // console.log(data); 
                if(data=="success"){
                    $("#modalAgregarProductos").modal("hide");
                    ventanasModales("bien", "Producto actualizado");
                    cargarProductos();
                }else if(data=="error"){
                    $("#modalAgregarProductos").modal("hide");
                    ventanasModales("erro", "Producto no actualizado");

                }else{
                    errorTextProductos.innerHTML=data;
                    errorTextProductos.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formproductos);
   
    xhr.send(formData);
}




///////////
///CARGAR CATEGORIAS SELECT
function cargarCategoriasSelect(nombre){
    let selectCategorias= document.querySelector("#selectCategorias");
        let opt=document.createElement('option');
            opt.value="";
            opt.disabled=true;
            opt.selected=true;
            opt.text="Elige una categoría";
        limpiarHtml(selectCategorias);
        selectCategorias.appendChild(opt);
    $.ajax({
            type:'GET',
            url:'productos/cargar_categorias.php',
            success:function(resps){
            let categorias=eval(resps);
    
                    for(c=0; c<categorias.length; c++){
                        let {id_categoria_categorias, nombre_categorias}=categorias[c];
                            let option=document.createElement('option');
                                option.value=id_categoria_categorias;
                                option.text=nombre_categorias;

                                if(nombre==nombre_categorias){
                                    option.selected=true;
                                }

                            selectCategorias.appendChild(option);
                    }
                
                    
                }
        });
}



//////////////////////////////////
//STATUS DE PRODUCTO
function statusProducto(id_producto_productos, num){
    
    $.ajax({
        type:'POST',
        url:'productos/status_productos.php',
        data:{id_producto_productos, num},
        success:function(resps){
     
            cargarProductos();
    
                
            }
    });
}