//VARIABLES GENERALES
let usuarios_mostrar= document.querySelector('#usuarios_mostrar');

function modalAgregarUsuariosFormulario(){
    $("#modalAgregarUsuarios").modal("show");
    //CAMBIAR ENCABEZADO
    document.querySelector('#modalUsuariosLabel span').innerHTML=`<i class="fa-solid fa-circle-plus"></i> Agregar`;
    //CAMBIAR BOTON
    $(".btnAgregarUsuarios").show();
    $(".btnEditarUsuarios").hide();

    //RESETEAR FORMULARIO
    $('.error-txt-usuarios').hide();
    document.querySelector('#modalAgregarUsuarios form').reset();
}


const formusuarios = document.querySelector("#modalAgregarUsuarios form"),
    continueBtnUsuarios= formusuarios.querySelector("#modalAgregarUsuarios .button .btnAgregarUsuarios"),
    errorTextUsuarios= formusuarios.querySelector(".error-txt-usuarios");

formusuarios.onsubmit = (e)=>{
    e.preventDefault();
}


continueBtnUsuarios.onclick=()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "usuarios/agregar_usuarios.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarUsuarios").modal("hide");
                    ventanasModales("bien", "Usuario registrado");
                    cargarUsuarios();
                }else if(data=="error"){
                    $("#modalAgregarUsuarios").modal("hide");
                    ventanasModales("erro", "Usuario no registrado");
                }else{
                    errorTextUsuarios.innerHTML=data;
                    errorTextUsuarios.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formusuarios);
   
    xhr.send(formData);
}



//////////
///MOSTRAR
let usuarios=[];
function cargarUsuarios(){
    $.ajax({
        type:'GET',
        beforeSend: function() { Spinner(usuarios_mostrar)},
        complete: function() {mostrarUsuarios()},
        url:'usuarios/cargar_usuarios.php',
        success:function(resps){
         usuarios=eval(resps);
            document.querySelector('#contador_usuarios').textContent=usuarios.length;
            //  mostrarCategorias(categorias);
            }
    });
}


function mostrarUsuarios(){

limpiarHtml(usuarios_mostrar);
if(usuarios.length>0){

    let table=document.createElement("table");
        table.classList.add("table", "table-sm");
        
        let thead=document.createElement('thead');
            thead.innerHTML=`<tr>
                            <th>Nombre</th>
                            <th>Contraseña</th>
                            <th>Área</th>
                            <th></th>
                            </tr>`;
            table.appendChild(thead);
        let tbody= document.createElement('tbody');

        for(u=0; u<usuarios.length; u++){
            let {ses_id_sesion,ses_usuario, ses_contrasena, ses_area}=usuarios[u];


            let stringUsuarios=JSON.stringify(usuarios[u]);


            let tr=document.createElement("tr");
                tr.innerHTML=`<td>${ses_usuario}</td>
                                <td>${ses_contrasena}</td>
                                <td>${ses_area}</td>
                                <td>
                                <a href='#/' onclick='modalEditarUsuarios(${stringUsuarios})'><i class="fa-solid fa-pen"></i></a>
                                <a href='#/' class='eliminar' onclick='eliminarUsuarios(${ses_id_sesion})'><i class="fa-solid fa-trash-can"></i></a>
                                </td>`;

            tbody.appendChild(tr);
            }


        table.appendChild(tbody);
        usuarios_mostrar.appendChild(table);

}else{
    usuarios_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay usuarios registradas</p>`;
}
}



////////////
///ELIMINAR
function eliminarUsuarios(ses_id_sesion){
    $.ajax({
        type:'POST',
        url:'usuarios/eliminar_usuarios.php',
        data:{ses_id_sesion},
        success:function(resps){
        let resultado=eval(resps);

                if(resultado>0){
                     ventanasModales("bien","Usuario eliminado");
                    cargarUsuarios();
                    
                }else{
                    ventanasModales("erro","Usuario no eliminado");
                }
                
            }
    });
}


/////////
//EDITAR
function modalEditarUsuarios(stringUsuarios){
    let {ses_id_sesion, ses_usuario, ses_contrasena, ses_area}=stringUsuarios;
    $("#modalAgregarUsuarios").modal("show");

    //CAMBIAR ENCABEZADO
    document.querySelector('#modalUsuariosLabel span').innerHTML=`<i class="fa-solid fa-pen"></i>Editar`;

    //CAMBIAR BOTON
    $(".btnAgregarUsuarios").hide();
    $(".btnEditarUsuarios").show();


    //COLOAR DATOS
    let form=document.querySelector('#modalAgregarUsuarios form');
    form.querySelector('input[name=idusuario]').value=ses_id_sesion;
    form.querySelector('input[name=Unombre]').value=ses_usuario;
    form.querySelector('input[name=Ucontrasena]').value=ses_contrasena;
    form.querySelector('select[name=Uarea]').value=ses_area;


}




let guardarBtnUsuarios= formusuarios.querySelector("#modalAgregarUsuarios .button .btnEditarUsuarios");
guardarBtnUsuarios.onclick=()=>{
 
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "usuarios/editar_usuarios.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarUsuarios").modal("hide");
                    ventanasModales("bien", "Usuario actualizado");
                    cargarUsuarios();
                }else if(data=="error"){
                    $("#modalAgregarUsuarios").modal("hide");
                    ventanasModales("erro", "Usuario no actualizado");

                }else{
                    errorTextUsuarios.innerHTML=data;
                    errorTextUsuarios.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formusuarios);
   
    xhr.send(formData);
}