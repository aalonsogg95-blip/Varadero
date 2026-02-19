//   /////////////////////////////////////////////////////////////
///AGREGAR PRODUCTO COMUN
function modalAgregarProductosFormulario(cli_id_cliente, cli_lugar){
    console.log(cli_lugar)
    $("#modalAgregarProducto").modal("show");
    document.querySelector("#modalAgregarProductoLabel").innerHTML=`<i class="fa-solid fa-circle-plus"></i> Agregar producto <span>(${cli_lugar})</span>`;
    //RESETEAR FORMULARIO
    limpiarHtml(document.querySelector('.fields-messageProductosComun'));
    document.querySelector('#modalAgregarProducto form').reset();
    document.querySelector('#modalAgregarProducto input[name=Eiditem]').value=cli_id_cliente;
}


const formproductoscomun = document.querySelector("#modalAgregarProducto form"),
    continueBtnProductoscomun= formproductoscomun.querySelector("#modalAgregarProducto #btnagregar"),
    errorTextProductoscomun= formproductoscomun.querySelector(".fields-messageProductosComun");

formproductoscomun.onsubmit = (e)=>{
    e.preventDefault();
}


continueBtnProductoscomun.onclick=()=>{

    //SPINNER
    continueBtnProductoscomun.classList.add('is-loading');
    continueBtnProductoscomun.querySelector('.btn-text').innerHTM =`Guardando...`;
    continueBtnProductoscomun.disabled = true;


    let xhr=new XMLHttpRequest();
    xhr.open("POST", "caja/agregar_producto_comun.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarProducto").modal("hide");
                    ventanasModales("bien", "Producto registrado");
                    cargarCuentas();
                }else if(data=="error"){
                    $("#modalAgregarProducto").modal("hide");
                    ventanasModales("erro", "Producto no registrado");
                }else{
                    errorTextProductoscomun.innerHTML=data;
                    errorTextProductoscomun.style.display="block"; 
                }

                continueBtnProductoscomun.classList.remove('is-loading');
                continueBtnProductoscomun.querySelector('.btn-text').innerHTM = `Registrar <i class="fa-solid fa-arrow-right"></i>`;
                continueBtnProductoscomun.disabled = false;
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formproductoscomun);
    xhr.send(formData);
}

function obtenerTotal(){
    let cantidad= document.querySelector('#modalAgregarProducto input[name=item2]').value || 0;
    let costo= document.querySelector('#modalAgregarProducto input[name=item3]').value || 0;
    let total= parseInt(cantidad)*parseInt(costo);
    document.querySelector('#modalAgregarProducto input[name=item4]').value=total;
}