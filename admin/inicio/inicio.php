<?php

date_default_timezone_set('America/Mexico_City');

    session_start();
    $usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];
    $role= $_SESSION["datosUsuarioVaradero"]["role"];

    if(!isset($_SESSION["datosUsuarioVaradero"])){
        header("location: ../index.php");
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varadero | Administración</title>
    <link rel="shortcut icon" type='image/x-icon' href='../../img/varadero_logo.png'>

    <link rel="stylesheet" href="../../fontawesome-free-6.4.0-web/css/all.min.css">
    <link rel="stylesheet" href="../../boostrap/bootstrap.min.css">
    

    <link rel="stylesheet" href="inicio.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="stylesheet" href="mostrar.css">
    <link rel="stylesheet" href="formulario.css">
    <link rel="stylesheet" href="formulario_modal.css">
    <!-- 
    <link rel="stylesheet" href="formulario_modal.css">
    <link rel="stylesheet" href="modal_detalles.css"> -->

    <!-- ARCHIVOS DE UTILIDADES -->
     <link rel="stylesheet" href="../styles.css">
      <link rel="stylesheet" href="../../spinner.css">
    <link rel="stylesheet" href="../../ventanas.css">

    <!-- ARCHIVOS DE SECCIONES -->
     <link rel="stylesheet" href="productos/productos.css">
     <link rel="stylesheet" href="gastos/gastos.css">
     <link rel="stylesheet" href="caja/caja.css">
     <link rel="stylesheet" href="historial/historial.css">
     <link rel="stylesheet" href="usuarios/usuarios.css">
     <link rel="stylesheet" href="facturas/facturas.css">
     <link rel="stylesheet" href="eliminados/eliminados.css">
     <link rel="stylesheet" href="cortesias/cortesias.css">
     <link rel="stylesheet" href="estadisticas/estadisticas.css">
     <!-- <link rel="stylesheet" href="usuarios/usuarios.css">
     <link rel="stylesheet" href="ventas/ventas.css">
     <link rel="stylesheet" href="ventas/historial/historial.css">
     <link rel="stylesheet" href="clientes/historial_clientes/historial_clientes.css">
     <link rel="stylesheet" href="gastos/gastos.css">
     <link rel="stylesheet" href="pedidos/pedidos.css">
     <link rel="stylesheet" href="disenos/disenos.css">
     <link rel="stylesheet" href="almacen/almacen.css">
     <link rel="stylesheet" href="clientes/clientes.css">
     <link rel="stylesheet" href="produccion/produccion.css">
     <link rel="stylesheet" href="pagos/pagos.css">
     <link rel="stylesheet" href="cotizaciones/cotizaciones.css">
     <link rel="stylesheet" href="estadisticas/estadisticas.css">
     <link rel="stylesheet" href="clientes/cotizaciones/clientes_cotizaciones.css"> -->


    <script src="../../jquery/jquery-3.5.1.min.js"></script>

    <!-- ARCHIVOS DE FUNCIONALIDADES-->
    <script src="../../jquery/generales.js"></script>
    <script src="../../jquery/ventanas.js"></script>

    <!-- GRAFICAS -->
     <script src="../../jquery/Chart.min.js"></script>  

    <!-- BOOSTRAP -->
    <script src="../../boostrap/bootstrap.bundle.min.js"></script> 
    <script src="../../boostrap/popper.min.js"></script>
  

</head>
<body>

    <?php
        include_once "navbar.php";
        include_once "sidebar.php";
    ?>

        <section id='principal' class='bd'>
                <div id='resultado'></div>
                <?php
                
                    $menu="";
                    if(isset($_GET['caja'])){
                        $menu='caja';
                        include_once "caja/section_caja.php";
                    }else if(isset($_GET['historial'])){
                        $menu='historial';
                        include_once "historial/section_historial.php";
                    }else if(isset($_GET['gastos'])){
                        $menu='gastos';
                        include_once "gastos/section_gastos.php";
                    }else if(isset($_GET['productos'])){
                        $menu='productos';
                        include_once "productos/section_productos.php";
                    }else if(isset($_GET['facturas'])){
                        $menu='facturas';
                        include_once "facturas/section_facturas.php";
                    }else if(isset($_GET['eliminados'])){
                        $menu='eliminados';
                        include_once "eliminados/section_eliminados.php";
                    }else if(isset($_GET['usuarios'])){
                        $menu='usuarios';
                        include_once "usuarios/section_usuarios.php";
                    }else if(isset($_GET['cortesias'])){
                        $menu='cortesias';
                        include_once "cortesias/section_cortesias.php";
                    }else if(isset($_GET['estadisticas'])){
                        $menu='estadisticas';
                        include_once "estadisticas/section_estadisticas.php";
                    }else{
                        $menu='caja';
                        include_once "caja/section_caja.php";
                    }
                ?>
        </section>


         <!-- VENTANA MODAL GENERAL -->
        <div class="modal_confirmado" id='modal'>
            <p class='modal_text'></p>
        </div>


        <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
        <div class="mensajeDispositivos">
            <img src="../../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>

    


        <!-- =====================================
                   MODALES
        ============================================= -->
        <!-- MODAL SESION NO INICIADA -->
        <div class="modal fade" id="modalNoSesion" tabindex="-1" role="dialog" aria-labelledby="modalNoSesionLabel" aria-hidden="true" >
                    <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title bd" id="modalNoSesionLabel"><i class="fa-solid fa-user-lock"></i> Sesión expirada</h5>
                        
                            
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal('modalNoSesion')">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">

                            <div class='div_mensaje'>
                                <img src="../../img/nosesion.svg" alt="">
                                <p>Sesión expirada. Inicia sesión nuevamente.</p>
                            </div>

                        </div>
                    </div>
                    </div>
                </div>
        </div>


    
</body>
</html>
<script src="../../jquery/Chart.min.js"></script> 


<script>
    //EJECUTAR AL CARGAR EL DOCUMENTO
    $(document).ready(function(){
        
         
       
    });

    let usuario='<?php echo $usuario; ?>';
    let m='<?php echo $menu; ?>';
    if(m!=""){
        document.querySelector('#menu-'+m).classList.add("active");
    }


    function cerrarModal(string){
        $("#"+string).modal("hide");
    }

   
</script>