<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////
//ZONA HORARIA
date_default_timezone_set('America/Mexico_City');

//FECHA
$fecha=date("Y-m-d");
$hora= date("H:i:s");
//////////////////////////////////////////////////


    //VARIABLE
    $usuario=$_POST['usuario'];
    $venta=json_decode($_POST['venta']);
         $idhistocliente=$venta->idhistocliente;
         $consumo=$venta->consumo;
         $lugar=$venta->lugar;
         $horapedido=$venta->horaped;
         $ordenes=$venta->ordenes;

    //VALIDAR QUE USUARIO ELIMINO LA CUENTA
    if($usuario=="cajaadmin"){
        //DUEÑO, ELIMINAR VENTA

        //ELIMINAR ORDENES 
        mysqli_query($conexion, "DELETE his_ventas FROM his_ventas WHERE hisc_id_histoClientes='$idhistocliente'"); 

        //ELIMINAR CLIENTE
        mysqli_query($conexion, "DELETE his_clientes FROM his_clientes WHERE hisc_id_histoClientes='$idhistocliente'");
        
    }else{

        //EMPLEADO, GUARDAR LA VENTA ELIMINADA
         $conexion->query("insert into clientes_eliminados values ($idhistocliente, $consumo,'$lugar','$horapedido','$hora','$fecha')");
            //COMPROBAR INSERCCION DEL CLIENTE ELIMINADO
              $busEliminado = mysqli_query($conexion, "SELECT count(*) from clientes_eliminados where id_clienteeliminado='$idhistocliente'") or die   ("Problemas en el select 2:".mysqli_error($conexion));                 
              $busEli = mysqli_fetch_array($busEliminado);

                 if($busEli[0]>0){
                    
                      for($o=0; $o<sizeof($ordenes); $o++){
                        $idhistoventa=$ordenes[$o]->hisv_id_histoVentas;
                        $categoria=$ordenes[$o]->categoria;
                        $producto=$ordenes[$o]->producto;
                        $cantidad=$ordenes[$o]->cantidad;
                        $costo=$ordenes[$o]->costo;
                        $total=$ordenes[$o]->total;

                        $conexion->query("insert into ordenes_hiseliminadas(hisv_id_histoVentas, ordeli_categoria, ordeli_producto, ordeli_cantidad, ordeli_costo, ordeli_total, ordeli_fecha, hisc_id_histoClientes)  values ('$idhistoventa','$categoria','$producto','$cantidad','$costo','$total','$fecha','$idhistocliente')"); 
                    
                      }
                    
                 }

    }



        //COMPROBAR QUE CLIENTE SE HAYAN ELIMINADO CORRECTAMENTE
        $busCliente = mysqli_query($conexion, "SELECT count(*) from his_clientes where hisc_id_histoClientes='$idhistocliente'") or die ("Problemas en el select 2:".mysqli_error($conexion));
            $cli = mysqli_fetch_array($busCliente);

  echo JSON_encode($cli[0]);

