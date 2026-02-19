
/*===============================================
CARGAR
================================================*/
cargarUsuarios();
function cargarUsuarios(){
    let content = document.getElementById("contentUsuarios");
    let input = document.getElementById("campousuarios").value;
    let pagina = document.getElementById("pagina").value || 1;
    let num_registros = document.getElementById("num_registrosusuarios").value;



    $.ajax({
        type:'POST',
        beforeSend: function() { Spinner(content)},
        data:{input, num_registros, pagina},
        url:'usuarios/cargar_usuarios.php',
        success:function(resps){
            let datos=eval(resps);
       
                limpiarHtml(content);

                let registros=datos[0];
                let paginacion=datos[1];
                let totalRegistros=datos[2];
                let cont=registros.length;

                // Ordenar alfabéticamente por nombre
                 registros.sort((a, b) => {
                    return a.nombre_usuarios.localeCompare(b.nombre_usuarios);
                });

               

                document.querySelector('#numerosRegistrosUsuarios').innerHTML=`Mostrando ${cont} de ${new Intl.NumberFormat().format(totalRegistros)} registros`
                document.getElementById("nav-paginacion_usuarios").innerHTML = paginacion.join('');
                

                if(registros.length>0){
                    for(d=0; d<registros.length; d++){
                        let {nombre_usuarios, contrasena_usuarios, area_usuarios, estatus_usuarios, acceso_usuarios, id_usuario}=registros[d];

                        let string=JSON.stringify(registros[d]);

                        /**
                         * BOTÓN DE ESTADO DEL USUARIO
                         * Muestra "Activo" si estatus es 1, "Inactivo" si es 0
                         * Al hacer click, cambia al estado opuesto
                         */
                        let sta = estatus_usuarios == 1
                            ? `<a href='javascript:void(0)' class='btnStatus disponible' onclick='statusUsuarios(${id_usuario}, 0)'>Activo</a>`
                            : `<a href='javascript:void(0)' class='btnStatus agotado' onclick='statusUsuarios(${id_usuario}, 1)'>Inactivo</a>`;




                        /**
                         * VALIDAR Y FORMATEAR FECHA DE ACTUALIZACIÓN
                         * Si nunca se actualizó (fecha por defecto), muestra "Nuevo"
                         * Si tiene fecha, la formatea a formato legible
                         */
                        acceso_usuarios = acceso_usuarios === "0000-00-00 00:00:00"
                            ? "<span class='usuarioNuevo'>Nuevo</span>"
                            : formatearfechahora(acceso_usuarios);




                        /**
                         * BOTONES DE ACCIÓN PARA ADMIN
                         * 
                         */
                        const btns = area_usuarios == "admin" ? "" : `
                                    <div class='more-options'>
                                        <a href='javascript:void(0)' onclick='editarUsuarios(${string})'><i class="fa-solid fa-pen"></i></a>
                                        <a href='javascript:void(0)' class='eliminar' onclick='eliminarUsuarios(${id_usuario})'><i class="fa-solid fa-trash-can"></i></a>       
                                    </div>`;


                        if(area_usuarios=="admin"){
                            sta="Usuario principal";
                        }



                        let tr= document.createElement("tr");
                               
                            tr.innerHTML=`
                                        <td><i class="fa-solid fa-user"></i> ${nombre_usuarios}</td>
                                        <td><div class='divContrasena'>
                                                 <span id='pass${id_usuario}' class='spanPassword'>
                                                 <i class="fa-solid fa-asterisk"></i>
                                                 <i class="fa-solid fa-asterisk"></i>
                                                 <i class="fa-solid fa-asterisk"></i>
                                                 <i class="fa-solid fa-asterisk"></i>
                                                 <i class="fa-solid fa-asterisk"></i>
                                                 
                                                 </span>
                                                <a href='javascript:void(0)' class='btnTogglePassword' onclick='togglePassword(${id_usuario}, "${contrasena_usuarios}")'>
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </div>
                                           
                                        </td>
                                        <td>${area_usuarios}</td>
                                        <td>${acceso_usuarios}</td>
                                        <td>${sta}</td>
                                        <td>${btns}</td>
                                            
                                            `;

                        content.appendChild(tr);
                     }
                }else{
                    content.innerHTML=`<td colspan='8' class='tdnohay'> <p class='nohay cancelar-text'><i class="fa-solid fa-circle-exclamation"></i> No hay usuarios registrados</p></td>`;
                }

            }
        });
}



/**
 * ALTERNAR VISIBILIDAD DE CONTRASEÑA
 * Cambia entre asteriscos e la contraseña real
 * @param {number} id - ID del usuario
 * @param {string} password - Contraseña real
 */
function togglePassword(id, password) {
    const spanPass = document.getElementById(`pass${id}`);
    const icon = event.target.closest('i');
    
    // Verificar si está mostrando asteriscos (cuenta los iconos <i>)
    const isHidden = spanPass.querySelectorAll('i').length > 0;
    
    if (isHidden) {
        // Mostrar contraseña
        spanPass.textContent = password;
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        // Mostrar asteriscos
        spanPass.innerHTML = `
            <i class="fa-solid fa-asterisk"></i>
            <i class="fa-solid fa-asterisk"></i>
            <i class="fa-solid fa-asterisk"></i>
            <i class="fa-solid fa-asterisk"></i>
            <i class="fa-solid fa-asterisk"></i>`;
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Función para cambiar de página
function nextPageUsuarios(pagina) {
    document.getElementById('pagina').value = pagina
    cargarUsuarios();
}



document.getElementById("campousuarios").addEventListener("keyup", cargarUsuarios);
document.getElementById("num_registrosusuarios").addEventListener("change", cargarUsuarios);



/*===============================================
AGREGAR
================================================*/
function agregarUsuariosForm(){
    $("#formularioUsuarios").slideToggle();
    $("#usuarios").slideToggle();

  //CAMBIAR BOTON
$("#formularioUsuarios #btnagregar").show();
$("#formularioUsuarios #btneditar").hide();

//CAMBIAR ENCABEZADO
document.querySelector('#formheader').innerHTML=`Registrar usuario`;

    limpiarHtml(document.querySelector('.fields-messageUsuarios'));
    
    document.querySelector("#formularioUsuarios form").reset();

}

const formularioUsuarios = document.querySelector("#formularioUsuarios  form");
        continueBtnUsuarios= formularioUsuarios.querySelector(" #btnagregar"),
        errorMessageUsuarios= formularioUsuarios.querySelector('.fields-messageUsuarios');

        formularioUsuarios.onsubmit = (e)=>{
            e.preventDefault();
        }

        continueBtnUsuarios.onclick=()=>{

            //SPINNER
            continueBtnUsuarios.classList.add('is-loading');
            continueBtnUsuarios.querySelector('.btn-text').innerHTM =`Guardando...`;
            continueBtnUsuarios.disabled = true;

            // let usuario=sessionStorage.getItem("usuarioMelchor");

            let xhr=new XMLHttpRequest();
                xhr.open("POST", "usuarios/agregar_usuarios.php", true);
                xhr.onload=()=>{
                    if(xhr.readyState===XMLHttpRequest.DONE){
                        if(xhr.status===200){
                            let data=xhr.response;
                            // console.log(data);
                            
                            if(data=="success"){
                                ventanasModales("bien", "Usuario registrado");
                                agregarUsuariosForm();
                                cargarUsuarios();
                            
                            }else if(data=="error"){
                                ventanasModales("erro", "Usuario no registrado");
                              
                            }else{
                                errorMessageUsuarios.innerHTML=data;
                                errorMessageUsuarios.style.display="block"; 
                            }

                            continueBtnUsuarios.classList.remove('is-loading');
                            continueBtnUsuarios.querySelector('.btn-text').innerHTM = `Registrar <i class="fa-solid fa-arrow-right"></i>`;
                            continueBtnUsuarios.disabled = false;
                        }
                    }
                }
                //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
                const formData=new FormData(formularioUsuarios);
            
                xhr.send(formData);
        }



/*===================================================
EDITAR USUARIOS
=====================================================*/
function editarUsuarios(string){
$("#formularioUsuarios").slideToggle();
$("#usuarios").slideToggle();

let {id_usuario,nombre_usuarios, contrasena_usuarios, area_usuarios}=string;

//CAMBIAR ENCABEZADO
document.querySelector('#formheader').innerHTML=`Editar usuario`;

//CAMBIAR BOTON
$("#formularioUsuarios #btnagregar").hide();
$("#formularioUsuarios #btneditar").show();

document.querySelector('#formularioUsuarios .fields-messageUsuarios').innerHTML="";


//COLOAR DATOS
let form=document.querySelector('#formularioUsuarios form');
form.querySelector('input[name=Eiditem]').value=id_usuario;
form.querySelector('input[name=item1]').value=nombre_usuarios;
form.querySelector('input[name=item2]').value=contrasena_usuarios;
form.querySelector('select[name=item3]').value=area_usuarios;

}


const formeditarusuarios = document.querySelector("#formularioUsuarios form");
guardarBtnUsuarios= formeditarusuarios.querySelector("#formularioUsuarios  #btneditar");


formeditarusuarios.onsubmit = (e)=>{
    e.preventDefault();
}


guardarBtnUsuarios.onclick=()=>{

    let xhr=new XMLHttpRequest();
    xhr.open("POST", "usuarios/editar_usuarios.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                // console.log(data);
                if(data=="success"){
                    agregarUsuariosForm();
                    cargarUsuarios();
                    ventanasModales("bien", "Usuario actualizado");
                }else if(data=="error"){
                    ventanasModales("erro", "Usuario no actualizado");
                }else{
                    errorMessageUsuarios.innerHTML=data;
                    errorMessageUsuarios.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formeditarusuarios);

    xhr.send(formData);
}




/*===============================================
ELIMINAR USUARIOS
================================================*/
function eliminarUsuarios(id_usuario){
    $.ajax({
        type:'POST',
        url:'usuarios/eliminar_usuarios.php',
        data:{id_usuario},
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




/*===================================================
STATUS USUARIOS
=====================================================*/
function statusUsuarios(id_usuario, sta){
    
    $.ajax({
        type:'POST',
        url:'usuarios/status_usuarios.php',
        data:{id_usuario, sta},
        success:function(resps){
        let resultado=eval(resps);

                if(resultado>0){
                    ventanasModales("bien","Usuario actualizado");
                    cargarUsuarios();
                }else{
                    ventanasModales("erro","Usuario no actualizado");
                }
                
            }
    });

}
