//VARIABLES GENERALES
let categorias_mostrar= document.querySelector('#categorias_mostrar');

function modalAgregarCategoriasFormulario(){
    $("#modalAgregarCategorias").modal("show");
    //CAMBIAR ENCABEZADO
    document.querySelector('#modalCategoriasLabel span').innerHTML=`<i class="fa-solid fa-circle-plus"></i> Agregar`;
    //CAMBIAR BOTON
    $(".btnAgregarCategorias").show();
    $(".btnEditarCategorias").hide();

    //RESETEAR FORMULARIO
    $('.error-txt-categorias').hide();
    document.querySelector('#modalAgregarCategorias form').reset();
}


const formcategorias = document.querySelector("#modalAgregarCategorias form"),
    continueBtnCategorias= formcategorias.querySelector("#modalAgregarCategorias .button .btnAgregarCategorias"),
    errorTextCategorias= formcategorias.querySelector(".error-txt-categorias");

formcategorias.onsubmit = (e)=>{
    e.preventDefault();
}


continueBtnCategorias.onclick=()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "categorias/agregar_categorias.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarCategorias").modal("hide");
                    ventanasModales("bien", "Categoría registrada");
                    cargarCategorias();
                }else if(data=="error"){
                    $("#modalAgregarCategorias").modal("hide");
                    ventanasModales("erro", "Categoría no registrada");
                }else{
                    errorTextCategorias.innerHTML=data;
                    errorTextCategorias.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formcategorias);
   
    xhr.send(formData);
}


//////////
///MOSTRAR
let categorias=[];
function cargarCategorias(){
    $.ajax({
        type:'GET',
        beforeSend: function() { Spinner(categorias_mostrar)},
        complete: function() {mostrarCategorias()},
        url:'categorias/cargar_categorias.php',
        success:function(resps){
         categorias=eval(resps);
            document.querySelector('#contador_categorias').textContent=categorias.length;
            //  mostrarCategorias(categorias);
            }
    });
}


function mostrarCategorias(){

limpiarHtml(categorias_mostrar);
if(categorias.length>0){

    let table=document.createElement("table");
        table.classList.add("table", "table-sm");
        
        let thead=document.createElement('thead');
            thead.innerHTML=`<tr>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Color</th>
                            <th>Productos vinculados</th>
                            <th></th>
                            </tr>`;
            table.appendChild(thead);
        let tbody= document.createElement('tbody');

        for(c=0; c<categorias.length; c++){
            let {id_categoria_categorias,nombre_categorias, contador, tipo_categorias, color_categorias}=categorias[c];


            let stringCategorias=JSON.stringify(categorias[c]);

            //ICONO SOL
            let icon="";
            if(tipo_categorias=="Día"){
                icon=`<i class="fa-regular fa-sun" style="color: #FFD700;"></i>`;
            }else{
                icon=`<i class="fa-regular fa-moon" style="color: black;"></i>`;
            }

            let tr=document.createElement("tr");
                tr.innerHTML=`<td>${nombre_categorias}</td>
                                <td>${icon}</td>
                                <td><i class="fa-solid fa-circle" style="color: ${color_categorias}"></i></td>
                                <td>${contador}</td>
                                <td>
                                <a href='#/' onclick='modalEditarCategorias(${stringCategorias})'><i class="fa-solid fa-pen"></i></a>
                                <a href='#/' class='eliminar' onclick='eliminarCategorias(${id_categoria_categorias}, ${contador})'><i class="fa-solid fa-trash-can"></i></a>
                                </td>`;

            tbody.appendChild(tr);
            }


        table.appendChild(tbody);
        categorias_mostrar.appendChild(table);

}else{
    categorias_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay categorias registradas</p>`;
}
}


////////////
///ELIMINAR
function eliminarCategorias(id_categoria_categorias, contador){
    $.ajax({
        type:'POST',
        url:'categorias/eliminar_categorias.php',
        data:{id_categoria_categorias},
        success:function(resps){
        let resultado=eval(resps);

                if(resultado>0){
                     ventanasModales("bien","Categoría eliminada");
                    cargarCategorias();
                    
                }else{
                    ventanasModales("erro","Categoría no eliminada");
                }
                
            }
    });
}


/////////
//EDITAR
function modalEditarCategorias(stringCategorias){
    let {id_categoria_categorias,nombre_categorias, tipo_categorias, color_categorias}=stringCategorias;
    $("#modalAgregarCategorias").modal("show");

    //CAMBIAR ENCABEZADO
    document.querySelector('#modalCategoriasLabel span').innerHTML=`<i class="fa-solid fa-pen"></i>Editar`;

    //CAMBIAR BOTON
    $(".btnAgregarCategorias").hide();
    $(".btnEditarCategorias").show();


    //COLOAR DATOS
    let form=document.querySelector('#modalAgregarCategorias form');
    form.querySelector('input[name=idcategoria]').value=id_categoria_categorias;
    form.querySelector('input[name=Cnombre]').value=nombre_categorias;
    form.querySelector('select[name=Ctipo]').value=tipo_categorias;
    form.querySelector('input[name=Ccolor]').value=color_categorias;


}




let guardarBtnCategorias= formcategorias.querySelector("#modalAgregarCategorias .button .btnEditarCategorias");
guardarBtnCategorias.onclick=()=>{
 
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "categorias/editar_categorias.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarCategorias").modal("hide");
                    ventanasModales("bien", "Categoría actualizada");
                    cargarCategorias();
                }else if(data=="error"){
                    $("#modalAgregarCategorias").modal("hide");
                    ventanasModales("erro", "Categoría no actualizada");

                }else{
                    errorTextCategorias.innerHTML=data;
                    errorTextCategorias.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formcategorias);
   
    xhr.send(formData);
}
