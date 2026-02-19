<div class='navbar bd'>
    <div class='datos-sistema'>
        <p>Perfil: <span><?php echo $role; ?></span></p>
        <p class='navbar_version'><i class="fa-solid fa-star"></i> Versión 3.0</p>

        <p>Dinero en caja: <span class='spanCaja'></span> 
        <a href="javascript:void(0)" id='editCaja' onclick='editarCaja()'> <i class="fa-solid fa-pen"></i></a>
        <a href="javascript:void(0)" id='saveCaja'  style='display:none;' onclick='guardarCaja()'> <i class="fa-solid fa-floppy-disk"></i></a></p>

       <p>Costo envio: <span class='spanEnvio'></span> 
        <a href="javascript:void(0)" id='editEnvio' onclick='editarEnvio()'> <i class="fa-solid fa-pen"></i></a>
        <a href="javascript:void(0)" id='saveEnvio'  style='display:none;' onclick='guardarEnvio()'> <i class="fa-solid fa-floppy-disk"></i></a>
        </p>

       
    </div>
    

    <div class='atajos_teclado bd'>
        <!-- <p class='bd'>Atajos de teclado: </p>
        <ul class='bd'>
            <li><span>(c)</span> Buscar cliente</li>
            <li><span>(g)</span> Agregar gasto</li>
            <li><span>(p)</span> Agregar pago</li>
        </ul> -->
    </div>

    <div class='user bd'>
        <i class="fa-solid fa-circle-user"></i>
        <p class='bd'><?php echo $usuario; ?></p>
        <a href="javascript:void(0)" onclick='cerrarSesion()'><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
    
</div>





<script>

    //EJECUTAR AL CARGAR EL DOCUMENTO
     $(document).ready(function(){
            document.onkeyup = mostrarInformacionTecla;
            mostrarAtajos();
        });

    function cerrarSesion(){
        setTimeout(() => {
            window.location.href='../cerrar_sesion.php';
        }, 500);
        
    }

    //MOSTRAR INSTRUCCIONES DE ATAJOS DE TECLADO
    function mostrarAtajos(){
        let atajos_teclado=document.querySelector('.atajos_teclado');
        let ul=document.createElement("ul");
        if (document.getElementById('menu-clientes')) {
            ul.innerHTML+=`<li><span>(c)</span> Buscar cliente</li>`;
        }
        if (document.getElementById('menu-gastos')) {
            ul.innerHTML+=`<li><span>(g)</span> Agregar gasto</li>`;    
        }
        if (document.getElementById('menu-pagos')) {
            ul.innerHTML+=`<li><span>(p)</span> Agregar pago</li>`;    
        }

        if (ul.children.length > 0) {
            atajos_teclado.innerHTML=`<p class='bd'>Atajos de teclado: </p>`;
            atajos_teclado.appendChild(ul);
        }
        
    }



    //SELECCIONAR ELEMENTOS CON EL TECLADO
    function mostrarInformacionTecla(evObject){ 
        // Verificar si el usuario está escribiendo en algún elemento
        const elementoActivo = document.activeElement;
        const tagName = elementoActivo.tagName.toLowerCase();
        const tiposInput = ['input', 'textarea'];
        const esElementoEditable = elementoActivo.contentEditable === 'true';
        
        // Si está escribiendo en algún elemento, no ejecutar los atajos
        if (tiposInput.includes(tagName) || esElementoEditable) {
            return; // Salir de la función sin hacer nada
        }

        let letra = String.fromCharCode(evObject.which);

        switch(letra){
            case "C":
                if (document.getElementById('menu-clientes')) {
                    window.location.href = "inicio.php?clientes";
                    localStorage.setItem('buscarCliente', 'true');
                }
            break;
            
            case "G":
                if (document.getElementById('menu-gastos')) {
                    window.location.href = "inicio.php?gastos";
                    localStorage.setItem('abrirGastosForm', 'true');
                }
            break;
            
            case "P":
                if (document.getElementById('menu-pagos')) {
                    window.location.href = "inicio.php?pagos";
                    localStorage.setItem('abrirPagosForm', 'true');
                }
            break;
        }
    }



     /*===================================================
        EDITAR ENVIO
        =====================================================*/
        cargarEnvio();
        function cargarEnvio(){
            if(localStorage.getItem("varaderoEnvio")){
                document.querySelector('.spanEnvio').textContent="$"+localStorage.getItem("varaderoEnvio");
            }else{
                document.querySelector('.spanEnvio').textContent="$0";
            }
        }

        function editarEnvio(){
            let valor=(document.querySelector('.spanEnvio').textContent).replace('$', '');
            document.querySelector('.spanEnvio').innerHTML=`<input type='number' value='${valor}'>`;
            const inputElement = document.querySelector('.spanEnvio input');
                  inputElement.focus();
            $("#editEnvio").hide();
            $("#saveEnvio").show();
        }

        function guardarEnvio(){
            let input= document.querySelector('.spanEnvio input').value;
            localStorage.setItem("varaderoEnvio", input);
            cargarEnvio();
            $("#editEnvio").show();
            $("#saveEnvio").hide();
            cargarCuentas();
        }



        /*===================================================
        EDITAR CAJA
        =====================================================*/
        cargarCaja();
        function cargarCaja(){
            if(localStorage.getItem("varaderoCaja")){
                document.querySelector('.spanCaja').textContent="$"+new Intl.NumberFormat().format(localStorage.getItem("varaderoCaja"));
            }else{
                document.querySelector('.spanCaja').textContent="$0";
            }
        }
        
        function editarCaja(){
            let valor=(document.querySelector('.spanCaja').textContent).replace('$', '').replace(',','');
            document.querySelector('.spanCaja').innerHTML=`<input type='number' value='${valor}'>`;
            const inputElement = document.querySelector('.spanCaja input');
                  inputElement.focus();
            $("#editCaja").hide();
            $("#saveCaja").show();
        }

        function guardarCaja(){
            let input= document.querySelector('.spanCaja input').value;
            localStorage.setItem("varaderoCaja", input);
            cargarCaja();
            $("#editCaja").show();
            $("#saveCaja").hide();
        }





</script>