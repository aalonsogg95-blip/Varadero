/*===============================================
CARGAR
================================================*/
mostraBusquedaGastos();
function mostraBusquedaGastos(){
    if(document.querySelector('input[name=periodo]:checked').value=="dia"){
        $(".div_buscar_fecha").show();
        $(".div_buscar_mes").hide();
    }else{
        $(".div_buscar_fecha").hide();
        $(".div_buscar_mes").show();
    }
    cargarGastos();
}


// cargarGastos();
function cargarGastos(){
    cargarCantidadesGastosTipos();
    let content = document.querySelector("#contentGastos");
    let input = document.getElementById("campogastos").value;
    let pagina = document.getElementById("pagina").value || 1;
    let num_registros = document.getElementById("num_registrosgastos").value;
    let tipogasto= document.querySelector('input[name=tipogasto]:checked').value;
    let tiempo=document.querySelector('input[name=periodo]:checked').value;
    let mes = document.getElementById("campomes").value;
    let anual = document.getElementById("campoanual").value;
     

    $.ajax({
        type:'POST',
        beforeSend: function() { Spinner(content)},
        data:{input, num_registros, pagina, tipogasto, tiempo, mes, anual},
        url:'gastos/cargar_gastos.php',
        success:function(resps){
            let datos=eval(resps);
            // console.log(datos);

            limpiarHtml(content);

                let registros=datos[0];
                let paginacion=datos[1];
                let totalRegistros=datos[2];
                let cont=registros.length;

                
                

                document.querySelector('#numerosRegistrosGastos').innerHTML=`Mostrando ${cont} de ${new Intl.NumberFormat().format(totalRegistros)} registros`
                document.getElementById("nav-paginacion_gastos").innerHTML = paginacion.join('');
                


                if(registros.length>0){

                  for(d=0; d<registros.length; d++){
                        let {gas_id_gasto, gas_concepto, gas_proveedor, gas_costo, gas_fecha, gas_tipo, gas_usuario}=registros[d];

                        let string=JSON.stringify(registros[d]);

                        let tr= document.createElement("tr");
                               
                            tr.innerHTML=`
                                        <td>${gas_concepto}</td>
                                        <td>${gas_proveedor}</td>
                                        <td>$${new Intl.NumberFormat('es-MX',{}).format(gas_costo)}</td>
                                        <td>${formatearFecha(gas_fecha)}</td>
                                        <td>${gas_tipo}</td>
                                        <td>${gas_usuario}</td>
                                       <td> 
                                            <div class='more-options'>
                                                <a href='javascript:void(0)' onclick='editarGastos(${string})'><i class="fa-solid fa-pen"></i></a>
                                                <a href='javascript:void(0)' class='eliminar' onclick='eliminarGastos(${gas_id_gasto})'><i class="fa-solid fa-trash-can"></i></a>       
                                            </div>
                                            
                                       </td>
                                            
                                            `;

                        content.appendChild(tr);
                     }
                   
                }else{
                    content.innerHTML=`<td colspan='8' class='tdnohay'> <p class='nohay cancelar-text'><i class="fa-solid fa-circle-exclamation"></i> No hay gastos registrados</p></td>`;
                }

            }
        });
}


// Función para cambiar de página
function nextPageGastos(pagina) {
    document.getElementById('pagina').value = pagina
    cargarGastos();
}


document.getElementById("campogastos").addEventListener("change", cargarGastos);
document.getElementById("num_registrosgastos").addEventListener("change", cargarGastos);



function cargarCantidadesGastosTipos(){
    let tiempo=document.querySelector('input[name=periodo]:checked').value;
    let mes = document.getElementById("campomes").value;
    let anual = document.getElementById("campoanual").value;
    let input = document.getElementById("campogastos").value;

    $.ajax({
        type:'POST',
        // beforeSend: function() { Spinner(content)},
        data:{input, tiempo, mes, anual},
        url:'gastos/cargar_cantidades_gastos.php',
        success:function(resps){
            let resultado= eval(resps);
            // console.log(resultado);

            //CONTADOR DE GASTOS TOTALES
            let contadorGastos=resultado.reduce((total, gasto)=>total + parseInt(gasto.contador),0);
            document.querySelector('#gastosTotales').textContent=contadorGastos;

            if(resultado[0].total > 0){
                document.querySelector('#tipogastocaja').classList.add("sumamayor0");
            }
            if(resultado[1].total > 0){
                document.querySelector('#tipogastoinsumos').classList.add("sumamayor0");
            }
            if(resultado[2].total > 0){
                document.querySelector('#tipogastopublicitarios').classList.add("sumamayor0");
            }
            if(resultado[3].total > 0){
                document.querySelector('#tipogastofijos').classList.add("sumamayor0");
            }
            if(resultado[4].total > 0){
                document.querySelector('#tipogastovariables').classList.add("sumamayor0");
            }
            if(resultado[5].total > 0){
                document.querySelector('#tipogastomermas').classList.add("sumamayor0");
            }

            document.querySelector('#tipogastocaja').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(resultado[0].total);
            document.querySelector('#tipogastoinsumos').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(resultado[1].total);
            document.querySelector('#tipogastopublicitarios').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(resultado[2].total);
            document.querySelector('#tipogastofijos').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(resultado[3].total);
            document.querySelector('#tipogastovariables').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(resultado[4].total);
            document.querySelector('#tipogastomermas').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(resultado[5].total);

            let totalgeneral=parseFloat(resultado[0].total)+parseFloat(resultado[1].total)+parseFloat(resultado[2].total)+parseFloat(resultado[3].total)+parseFloat(resultado[4].total)+parseFloat(resultado[5].total);
            //DINERO EN GASTOS
            if(totalgeneral>0){
                document.querySelector('#gastosEfectivo').classList.add("sumamayor0");
            }
                document.querySelector('#gastosEfectivo').textContent="$"+new Intl.NumberFormat('es-MX',{}).format(totalgeneral);
        }
    });
}


/*===============================================
AGREGAR
================================================*/




function agregarGastosForm(){
    $("#formularioGastos").slideToggle();
    $("#gastos").slideToggle();

    $("#btnagregarGastos").show();
    $("#btneditarGastos").hide();

    document.querySelector("#formularioGastos form").reset();
}



const formulariogastos = document.querySelector("#formularioGastos  form");
        continueBtnGastos= formulariogastos.querySelector(" #btnagregarGastos"),
        errorMessageGastos= formulariogastos.querySelector('.fields-messageGastos');

        formulariogastos.onsubmit = (e)=>{
            e.preventDefault();
        }

        continueBtnGastos.onclick=()=>{

            //SPINNER
            continueBtnGastos.classList.add('is-loading');
            continueBtnGastos.querySelector('.btn-text').innerHTM =`Guardando...`;
            continueBtnGastos.disabled = true;

            let xhr=new XMLHttpRequest();
                xhr.open("POST", "gastos/agregar_gastos.php", true);
                xhr.onload=()=>{
                    if(xhr.readyState===XMLHttpRequest.DONE){
                        if(xhr.status===200){
                            let data=xhr.response;
                            // console.log(data);
                            
                            if(data=="success"){
                                ventanasModales("bien", "Gasto registrado");
                                agregarGastosForm();
                                cargarGastos();
                            
                            }else if(data=="error"){
                                ventanasModales("erro", "Gasto no registrado");
                              
                            }else{
                                errorMessageGastos.innerHTML=data;
                                errorMessageGastos.style.display="block"; 
                            }

                            continueBtnGastos.classList.remove('is-loading');
                            continueBtnGastos.querySelector('.btn-text').innerHTM = `Registrar <i class="fa-solid fa-arrow-right"></i>`;
                            continueBtnGastos.disabled = false;
                        }
                    }
                }
                //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
                const formData=new FormData(formulariogastos);
            
                xhr.send(formData);
        }



/*===================================================
EDITAR GASTOS
=====================================================*/
function editarGastos(string){
    $("#formularioGastos").slideToggle();
    $("#gastos").slideToggle();
    let {gas_id_gasto, gas_concepto, gas_proveedor, gas_fecha, gas_costo, gas_tipo, gas_frecuencia}=string;
    
    //CAMBIAR ENCABEZADO
    document.querySelector('#formheaderGastos').innerHTML=`Editar Gasto`;
    
    //CAMBIAR BOTON
    $("#formularioGastos #btnagregarGastos").hide();
    $("#formularioGastos #btneditarGastos").show();
    
    document.querySelector('#formularioGastos .fields-messageGastos').innerHTML="";
    
    
    //COLOAR DATOS
    let form=document.querySelector('#formularioGastos form');
    form.querySelector('input[name=Eiditem]').value=gas_id_gasto;
        form.querySelector('input[name=item1]').value=gas_concepto;
        form.querySelector('input[name=item2]').value=gas_proveedor;
        form.querySelector('input[name=item3]').value=gas_costo;
        form.querySelector('select[name=item4]').value=gas_tipo;
        form.querySelector('select[name=item5]').value=gas_frecuencia;
        form.querySelector('input[name=item6]').value=gas_fecha;
        
}
    
    
    const formeditargastos = document.querySelector("#formularioGastos form");
    guardarBtnGastos= formeditargastos.querySelector("#formularioGastos  #btneditarGastos");    
    
    formeditargastos.onsubmit = (e)=>{
        e.preventDefault();
    }
    
    
    guardarBtnGastos.onclick=()=>{
        let xhr=new XMLHttpRequest();
        xhr.open("POST", "gastos/editar_gastos.php", true);
        xhr.onload=()=>{
            if(xhr.readyState===XMLHttpRequest.DONE){
                if(xhr.status===200){
                    let data=xhr.response;
                    // console.log(data);
                    if(data=="success"){
                        agregarGastosForm();
                        cargarGastos();
                        ventanasModales("bien", "Gasto actualizado");
                    }else if(data=="error"){
                        ventanasModales("erro", "Gasto no actualizado");
                    }else{
                        errorMessageGastos.innerHTML=data;
                        errorMessageGastos.style.display="block"; 
                    }
                }
            }
        }
        //WE HAVE TO SEND THE FROM DATA THROUGH AJAX TO PHP
        const formData=new FormData(formeditargastos);
    
        xhr.send(formData);
    }
    
    
    
    /*===============================================
    ELIMINAR 
    ================================================*/
    function eliminarGastos(id_gasto){
        $.ajax({
            type:'POST',
            url:'gastos/eliminar_gastos.php',
            data:{id_gasto},
            success:function(resps){
            let resultado=eval(resps);
    
                    if(resultado>0){
                         ventanasModales("bien","Gasto eliminado");
                          cargarGastos();
                        
                    }else{
                        ventanasModales("erro","Gasto no eliminado");
                    }
                    
                }
        });
    
    }
    