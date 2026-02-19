<?php
     session_start();
     $usuario= $_SESSION["datosUsuarioCaja"]["usuario"];

    if(!isset($_SESSION["datosUsuarioCaja"])){
         header("location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varadero | Gastos </title>

    <!-- CSS -->
    <link rel="stylesheet" href="../../fontawesome-free-6.4.0-web/css/all.min.css">

    <link rel="stylesheet" href="../../boostrap/bootstrap.min.css">
    <link rel="stylesheet" href="gastos.css">
    <link rel="stylesheet" href="../../ventanas.css">

    <link rel="shortcut icon" type='image/x-icon' href='../../img/varadero_logo.png'>
</head>
<body>

    <!-- NAVBAR -->
    <nav id="navbar" class="bd">
        <div class="navbar_contenedor">
            <div class="navbar_logo bd">
                    <img src="../../img/varadero_logo.png" alt="">
                    <h2>Gastos</h2>
            </div>
    
            <div class="navbar_usuario bd">
                <h2>Bienvenido <?php echo "<span>$usuario</span>!"?></h2>
                <img class="navbar_avatar" src="../../img/avatar.png" alt="">
                <a href="#/" onclick='cerrarSesion()'><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
    
        </div>
    </nav>

        <!-- GASTOS -->
        <section id="SectionGastos" class="bd">
                    <!-- <div class="navbar_principal bd">
                        <h2>Gastos <span id="contador_gastos"></span></h2>
                        <a href="#/" onclick="modalAgregarGastosFormulario()"><i class="fa-solid fa-circle-plus"></i>Agregar gasto</a>
                    </div> -->

                    <div id="gastos_buscar" class='bd'>
                        <h2>Consultar gastos</h2>
                        <div class='bd'>
                            <label for="pormes" class='radio'>
                                <input type='radio'  name='periodo' id='pormes' onclick='mostraBusquedaGastos()' value="1" checked>
                                <span></span>Por fecha
                            </label>
                            <label for="poranual" class='radio'>
                                <input type='radio'  name='periodo' id='poranual' onclick='mostraBusquedaGastos()' value="2">
                                <span></span>Por mes
                            </label>
                        </div>
                        <div class='gastos_fecha bd'>
                            <input type="date" placeholder='Producto/Categoria' id="gastos_field_fecha"><button onclick='buscarGastos()'>Buscar</button>
                        </div>
                        <div class='gastos_mes bd'>
                            <select id="gastos_field_mes">
                                <option value="01">Enero</option>
                                <option value="02">Febrero</option>
                                <option value="03">Marzo</option>
                                <option value="04">Abril</option>
                                <option value="05">Mayo</option>
                                <option value="06">Junio</option>
                                <option value="07">Julio</option>
                                <option value="08">Agosto</option>
                                <option value="09">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                            <select id="gastos_field_anual">
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                            </select>
                            <button onclick='buscarGastos()'>Buscar</button>
                        </div>
                    </div>
                    <div id="gastos_indicadores" class="bd">
                        <p>Gastos totales: <span id="gastostotales">0</span></p>
                        <p>Dinero en gastos: <span id="gastosdinero">$0</span></p>
                        <a href="#/" onclick="modalAgregarGastosFormulario()"><i class="fa-solid fa-circle-plus"></i>Agregar gasto</a>
                    </div>

                    <div id="gastos_mostrar" class="principal_mostrar bd">
                    
                    </div>
                    

            </section>
    

   


     <!-- VENTANA MODAL GENERAL -->
     <div class="modal_confirmado" id='modal'>
            <p class='modal_text'></p>
        </div>




        <!-- MODAL GASTOS -->
    <div class="modal fade" id="modalAgregarGastos" tabindex="-1" role="dialog" aria-labelledby="modalAgregarGastosLabel" aria-hidden="true" >
      <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalGastosLabel"><span><i class="fa-solid fa-circle-plus"></i> Agregar</span> Gasto</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerrarModal()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
                <div class="modal-body text-center">

                    <form action="#">
                        <div class="error-txt-gastos error-txt"></div>
                        <div class="field input bd">
                            <label for="">Nombre gasto</label>
                            <input type="text" name="Gnombre" required>
                            <input type="hidden" name="idgastos">
                        </div>

                        <div class="field input">
                            <label for="">Destino</label>
                            <input type="text" name="Gdestino" required>
                        </div>

                        <div class="field input">
                            <label for="">Total</label>
                            <input type="number" name="Gtotal" required>
                        </div>

                        <div class="field input">
                            <label for="">Fecha</label>
                            <input type="date" name="Gfecha" required>
                        </div>
                    
                        

                        <div class="button input">
                            <input type="submit" class='btnAgregarGastos' value="Registrar">
                            <input type="submit" class='btnEditarGastos btnEditar' value="Guardar">
                        </div>
                        

                    </form>
                
                
                </div>
          </div>
        </div>
      </div>
    </div>


   


     <div id='linkRegresar'>
        <a href="../inicio.php"><i class="fa-solid fa-circle-arrow-left"></i></a>
    </div>


    <!-- MENSAJE DE DISPOSITIVOS MOVILES -->
    <div class="mensajeDispositivos">
            <img src="../../img/varadero_logo.png" alt="">
            <p><i class="fa-solid fa-desktop"></i> ¡Esta sección solo esta disponible para computadora!</p>
        </div>


    
     
    <script src="../../boostrap/bootstrap.bundle.min.js"></script> 
    <script src="../../boostrap/popper.min.js"></script>
    <script src="../../jquery/jquery-3.5.1.min.js"></script> 
    <script src="../../jquery/generales.js"></script> 
    <script src="../../jquery/ventanas.js"></script>
    <script src="gastos.js"></script>
</body>
</html>
<script type="text/javascript">

     //CARGAR FUNCIONES AL RECARGAR PAGINA
     $(document).ready(function(){

        
        
     });

     function cerrarModal(){
        $("#modalAgregarGastos").modal("hide");
     }


     function cerrarSesion(){
        localStorage.removeItem("contadorCajaTeca")
        window.location.href="../cerrar_sesion.php";
     }
   
    
    
</script>