//VARIABLES GENERALES
let gastos_mostrar= document.querySelector('#gastos_mostrar');


function modalAgregarGastosFormulario(){
    $("#modalAgregarGastos").modal("show");
    //CAMBIAR ENCABEZADO
    document.querySelector('#modalGastosLabel span').innerHTML=`<i class="fa-solid fa-circle-plus"></i> Agregar`;
    //CAMBIAR BOTON
    $(".btnAgregarGastos").show();
    $(".btnEditarGastos").hide();

    //RESETEAR FORMULARIO
    $('.error-txt-gastos').hide();
    document.querySelector('#modalAgregarGastos form').reset();

    ///MOSTRAR FECHA EN INPUT
    let fechaActual = new Date();
    // Obtener los componentes de la fecha
    let año = fechaActual.getFullYear();
    let mes = (fechaActual.getMonth() + 1).toString().padStart(2, '0');
    let dia = fechaActual.getDate().toString().padStart(2, '0');

    // Formatear la fecha en el formato deseado
    document.querySelector('#modalAgregarGastos input[name=Gfecha]').value = `${año}-${mes}-${dia}`;

}


const formgastos = document.querySelector("#modalAgregarGastos form"),
    continueBtnGastos= formgastos.querySelector("#modalAgregarGastos .button .btnAgregarGastos"),
    errorTextGastos= formgastos.querySelector(".error-txt-gastos");

formgastos.onsubmit = (e)=>{
    e.preventDefault();
}


continueBtnGastos.onclick=()=>{
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "gastos/agregar_gastos.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarGastos").modal("hide");
                    ventanasModales("bien", "Gasto registrado");
                    buscarGastos();

                    

                }else if(data=="error"){
                    $("#modalAgregarGastos").modal("hide");
                    ventanasModales("erro", "Gasto no registrado");
                }else{
                    errorTextGastos.innerHTML=data;
                    errorTextGastos.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formgastos);
   
    xhr.send(formData);
}



function mostraBusquedaGastos(){
    const fecha= new Date();
    let output =fecha.getFullYear() +"-"+ String(fecha.getMonth() + 1).padStart(2, '0')  + '-' + String(fecha.getDate()).padStart(2, '0');
    let periodo=document.querySelector('input[name=periodo]:checked').value;
        
    if(periodo==1){
          $(".gastos_mes").hide();
          $(".gastos_fecha").show();

          document.querySelector("#gastos_field_fecha").value=output;
     }else{
         $(".gastos_fecha").hide();
         $(".gastos_mes").show();

         let mes=fecha.getMonth()+1;
          if(mes<10){
            mes="0"+mes;
          }

         document.querySelector('#gastos_field_mes').value=mes;
         document.querySelector('#gastos_field_anual').value=fecha.getFullYear();
    }
    buscarGastos();
}




//BUSCAR GASTOS
let gastos=[];
 
function buscarGastos(){
       let periodo=document.querySelector('input[name=periodo]:checked').value;
       let fieldMes=document.querySelector("#gastos_field_mes").value || 0;
       let fieldAnual=document.querySelector("#gastos_field_anual").value || 0;
       let fieldFecha=document.querySelector("#gastos_field_fecha").value || 0;
       let tipo= document.querySelector('input[name=tipogasto]:checked').value;
       $.ajax({
           type:'POST',
           url:'gastos/cargar_gastos.php',
            beforeSend: function() { Spinner(gastos_mostrar)},
           complete: function() { mostrarGastos()},
           data:{fieldMes,fieldAnual,fieldFecha,periodo, tipo},
           success:function(resps){
                gastos=eval(resps);
                
            document.querySelector('#gastostotales').textContent=gastos.length
            document.querySelector('#gastosdinero').textContent="$"+new Intl.NumberFormat().format(gastos.reduce((total, gasto)=>parseInt(total)+ parseInt(gasto.gas_costo),0));
               
           }
       });
   }


function mostrarGastos(){
    limpiarHtml(gastos_mostrar);
    if(gastos.length>0){

       let table=document.createElement("table");
           table.classList.add("table", "table-sm");
           
           let thead=document.createElement('thead');
               thead.innerHTML=`<tr>
                       
                               <th>Concepto</th>
                               <th>Desino</th>
                               <th>Total</th>
                               <th>Fecha</th>
                               <th>Tipo</th>
                               <th></th>
                               </tr>`;
               table.appendChild(thead);
           let tbody= document.createElement('tbody');

           for(g=0; g<gastos.length; g++){
               let {gas_id_gasto, gas_concepto, gas_proveedor, gas_costo, gas_fecha,gas_tipo}=gastos[g];


               let stringGastos=JSON.stringify(gastos[g]);

               let tr=document.createElement("tr");
                   tr.innerHTML=`<td>${gas_concepto}</td>
                                 <td>${gas_proveedor}</td>
                                 <td>$${new Intl.NumberFormat().format(gas_costo)}</td>
                                 <td>${formatearFecha(gas_fecha)}</td>
                                 <td>${gas_tipo}</td>
                                 <td>
                                   <a href='#/' onclick='modalEditarGastos(${stringGastos})'><i class="fa-solid fa-pen"></i></a>
                                   <a href='#/' class='eliminar' onclick='eliminarGastos(${gas_id_gasto})'><i class="fa-solid fa-trash-can"></i></a>
                                 </td>`;

               tbody.appendChild(tr);
           }


           table.appendChild(tbody);
           gastos_mostrar.appendChild(table);

   }else{
       gastos_mostrar.innerHTML=`<p class='nohay'><i class="fa-solid fa-triangle-exclamation"></i>No hay gastos registrados</p>`;
   }
}



/////////
//ELIMINAR
function eliminarGastos(id_gasto_gastos){
    $.ajax({
        type:'POST',
        url:'gastos/eliminar_gastos.php',
        data:{id_gasto_gastos},
        success:function(resps){
        let resultado=eval(resps);
     
                if(resultado>0){
                     ventanasModales("bien","Gasto eliminado");
                    buscarGastos();
                    
                }else{
                    ventanasModales("erro","Gasto no eliminado");
                }
                
            }
    });
}


/////////
//EDITAR
function modalEditarGastos(stringGastos){
    let {id_gasto_gastos, nombre_gastos, destino_gastos, total_gastos, fecha_gastos}=stringGastos;
    $("#modalAgregarGastos").modal("show");

    //CAMBIAR ENCABEZADO
    document.querySelector('#modalGastosLabel span').innerHTML=`<i class="fa-solid fa-pen"></i>Editar`;

    //CAMBIAR BOTON
    $(".btnAgregarGastos").hide();
    $(".btnEditarGastos").show();


    //COLOAR DATOS
    let form=document.querySelector('#modalAgregarGastos form');
    form.querySelector('input[name=idgastos]').value=id_gasto_gastos;
    form.querySelector('input[name=Gnombre]').value=nombre_gastos;
    form.querySelector('input[name=Gdestino]').value=destino_gastos;
    form.querySelector('input[name=Gtotal]').value=total_gastos;
    form.querySelector('input[name=Gfecha]').value=fecha_gastos;
    
}




let guardarBtnGastos= formgastos.querySelector("#modalAgregarGastos .button .btnEditarGastos");
guardarBtnGastos.onclick=()=>{
 
    let xhr=new XMLHttpRequest();
    xhr.open("POST", "gastos/editar_gastos.php", true);
    xhr.onload=()=>{
        if(xhr.readyState===XMLHttpRequest.DONE){
            if(xhr.status===200){
                let data=xhr.response;
                
                if(data=="success"){
                    $("#modalAgregarGastos").modal("hide");
                    ventanasModales("bien", "Gasto actualizado");
                    buscarGastos();
                }else if(data=="error"){
                    $("#modalAgregarGastos").modal("hide");
                    ventanasModales("erro", "Gasto no actualizado");

                }else{
                    errorTextGastos.innerHTML=data;
                    errorTextGastos.style.display="block"; 
                }
            }
        }
    }
    //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
    const formData=new FormData(formgastos);
   
    xhr.send(formData);
}
