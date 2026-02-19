

/*===============================================
CARGAR
================================================*/
cargarProductos();
function cargarProductos(){
    let content = document.getElementById("contentProductos");
    let input = document.getElementById("campoproductos").value;
    let pagina = document.getElementById("pagina").value || 1;
    let num_registros = document.getElementById("num_registrosproductos").value;

    

    // $("#formularioClientes").hide();

    $.ajax({
        type:'POST',
        beforeSend: function() { Spinner(content)},
        data:{input, num_registros, pagina},
        url:'productos/cargar_productos.php',
        success:function(resps){
            let datos=eval(resps);
       
                limpiarHtml(content);

                let registros=datos[0];
                let paginacion=datos[1];
                let totalRegistros=datos[2];
                let cont=registros.length;

                // Ordenar alfabéticamente por nombre
                 registros.sort((a, b) => {
                    return a.pro_producto.localeCompare(b.pro_producto);
                });

               

                document.querySelector('#numerosRegistrosProductos').innerHTML=`Mostrando ${cont} de ${new Intl.NumberFormat().format(totalRegistros)} registros`
                document.getElementById("nav-paginacion_productos").innerHTML = paginacion.join('');
                

                if(registros.length>0){
                    for(d=0; d<registros.length; d++){
                        let {pro_id_producto, pro_producto, pro_categoria, pro_costo, pro_fecha, pro_status}=registros[d];

                        let string=JSON.stringify(registros[d]);

                        ///STATUS PRODUCTO
                        let sta="";
                        if(pro_status==1){
                            sta=`<a href='javascript:void(0)' class='btnStatus disponible' onclick='statusProductos(${pro_id_producto}, 0)'>Disponible</a>`;
                        }else{
                            sta=`<a href='javascript:void(0)' class='btnStatus agotado' onclick='statusProductos(${pro_id_producto}, 1)'>Agotado</a>`;
                        }

                        let tr= document.createElement("tr");
                               
                            tr.innerHTML=`
                                        <td data-titulo='Nombre producto:'>${pro_producto}</td>
                                        <td data-titulo='Categoría:'>${pro_categoria}</td>
                                        <td data-titulo='Costo Ven:'>$${new Intl.NumberFormat('es-MX',{}).format(pro_costo)}</td>
                                        <td data-titulo='Costo Ven:'>${formatearFecha(pro_fecha)}</td>
                                        <td>${sta}</td>
                                       <td> 
                                            <div class='more-options'>
                                                <a href='javascript:void(0)' onclick='editarProducto(${string})'><i class="fa-solid fa-pen"></i></a>
                                                <a href='javascript:void(0)' class='eliminar' onclick='eliminarProducto(${pro_id_producto})'><i class="fa-solid fa-trash-can"></i></a>       
                                            </div>
                                            
                                       </td>
                                            
                                            `;

                        content.appendChild(tr);
                     }
                }else{
                    content.innerHTML=`<td colspan='8' class='tdnohay'> <p class='nohay cancelar-text'><i class="fa-solid fa-circle-exclamation"></i> No hay productos registrados</p></td>`;
                }

            }
        });
}



// Función para cambiar de página
function nextPageProductos(pagina) {
    document.getElementById('pagina').value = pagina
    cargarProductos();
}



document.getElementById("campoproductos").addEventListener("keyup", cargarProductos);
document.getElementById("num_registrosproductos").addEventListener("change", cargarProductos);



/*===============================================
AGREGAR
================================================*/
function agregarProductosForm(){
    $("#formularioProductos").slideToggle();
    $("#productos").slideToggle();

  //CAMBIAR BOTON
$("#formularioProductos #btnagregar").show();
$("#formularioProductos #btneditar").hide();

//CAMBIAR ENCABEZADO
document.querySelector('#formheader').innerHTML=`Registrar producto`;

    limpiarHtml(document.querySelector('.fields-messageProductos'));
    

    document.querySelector("#formularioProductos form").reset();

    cargarCategoriasSelect();
}

const formulario = document.querySelector("#formularioProductos  form");
        continueBtn= formulario.querySelector(" #btnagregar"),
        errorMessage= formulario.querySelector('.fields-messageProductos');

        formulario.onsubmit = (e)=>{
            e.preventDefault();
        }

        continueBtn.onclick=()=>{

            //SPINNER
            continueBtn.classList.add('is-loading');
            continueBtn.querySelector('.btn-text').innerHTM =`Guardando...`;
            continueBtn.disabled = true;

            // let usuario=sessionStorage.getItem("usuarioMelchor");

            let xhr=new XMLHttpRequest();
                xhr.open("POST", "productos/agregar_productos.php", true);
                xhr.onload=()=>{
                    if(xhr.readyState===XMLHttpRequest.DONE){
                        if(xhr.status===200){
                            let data=xhr.response;
                            // console.log(data);
                            
                            if(data=="success"){
                                ventanasModales("bien", "Producto registrado");
                                agregarProductosForm();
                                cargar();
                            
                            }else if(data=="error"){
                                ventanasModales("erro", "Producto no registrado");
                              
                            }else{
                                errorMessage.innerHTML=data;
                                errorMessage.style.display="block"; 
                            }

                            continueBtn.classList.remove('is-loading');
                            continueBtn.querySelector('.btn-text').innerHTM = `Registrar <i class="fa-solid fa-arrow-right"></i>`;
                            continueBtn.disabled = false;
                        }
                    }
                }
                //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
                const formData=new FormData(formulario);
            
                xhr.send(formData);
        }


/*===================================================
EDITAR PRODUCTOS
=====================================================*/
function editarProducto(string){
$("#formularioProductos").slideToggle();
$("#productos").slideToggle();

let {pro_id_producto, pro_producto, pro_categoria, pro_costo}=string;

//CAMBIAR ENCABEZADO
document.querySelector('#formheader').innerHTML=`Editar producto`;

//CAMBIAR BOTON
$("#formularioProductos #btnagregar").hide();
$("#formularioProductos #btneditar").show();

document.querySelector('#formularioProductos .fields-messageProductos').innerHTML="";


// //COLOAR DATOS
let form=document.querySelector('#formularioProductos form');
form.querySelector('input[name=Eiditem]').value=pro_id_producto;
form.querySelector('input[name=item1]').value=pro_producto;
form.querySelector('select[name=item2]').value=pro_categoria;
form.querySelector('input[name=item3]').value=pro_costo;

}


const formeditarproductos = document.querySelector("#formularioProductos form");
guardarBtnProductos= formeditarproductos.querySelector("#formularioProductos  #btneditar");


formeditarproductos.onsubmit = (e)=>{
    e.preventDefault();
}


guardarBtnProductos.onclick=()=>{

    let xhr=new XMLHttpRequest();
    xhr.open("POST", "productos/editar_productos.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                // console.log(data);
                if(data=="success"){
                    agregarProductosForm();
                    cargar();
                    ventanasModales("bien", "Producto actualizado");
                }else if(data=="error"){
                    ventanasModales("erro", "Producto no actualizado");
                }else{
                    errorMessage.innerHTML=data;
                    errorMessage.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formeditarproductos);

    xhr.send(formData);
}



/*===============================================
ELIMINAR 
================================================*/
function eliminarProducto(id_producto){
    $.ajax({
        type:'POST',
        url:'productos/eliminar_productos.php',
        data:{id_producto},
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





/*===============================================
CARGAR CATEGORIAS SELECT
================================================*/

function cargarCategoriasSelect(valor){
    let categoriasselect= document.querySelector('select[name=item3]');
    $.ajax({
        type:'POST',
        url:'productos/cargar_categorias_select.php',
        success:function(resps){
            let categorias=eval(resps);
            
                limpiarHtml(categoriasselect);

                const defaultOption1 = document.createElement('option');
                defaultOption1.text = 'Selecciona una categoría';
                defaultOption1.value = '';
                categoriasselect.appendChild(defaultOption1);


                if(categorias.length>0){
                
                    for(c=0; c<categorias.length; c++){
                        let {nombre_categorias, id_categoria}=categorias[c];

                        let opt=document.createElement('option');
                            opt.value=id_categoria;
                            opt.textContent=nombre_categorias;

                            if(valor==nombre_categorias){
                                opt.selected=true;
                            }

                            categoriasselect.appendChild(opt);
                    }
                } 
            }
    });
}




/*===================================================
STATUS PRODUCTOS
=====================================================*/
function statusProductos(id_producto, sta){
    
    $.ajax({
        type:'POST',
        url:'productos/status_productos.php',
        data:{id_producto, sta},
        success:function(resps){
        let resultado=eval(resps);

                if(resultado>0){
                    ventanasModales("bien","Producto actualizado");
                    cargarProductos();
                }else{
                    ventanasModales("erro","Producto no actualizado");
                }
                
            }
    });

}

















