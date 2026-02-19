<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////
//ZONA HORARIA
date_default_timezone_set('America/Mexico_City');

//FECHA
$fecha=date("Y-m-d");
//$hora= date("H:i:s");
$ho=date('H')-1;
$mi=date('i');
$se=date('s');


$hora=$ho.":".$mi.":".$se;
//////////////////////////////////////////////////




    //VARIABLE
    $idorden=$_POST['idorden'];
    $usuario=$_POST['usuario'];
    $cuenta=JSON_decode($_POST['cuenta']);
        $idcliente=$cuenta->idcliente;
        $consumo=$cuenta->consumo;
        $lugar=$cuenta->lugar;
        $observacion=$cuenta->observacion;
        $horapedido=$cuenta->hora;
      



    //VALIDAR QUE USUARIO ELIMINO LA ORDEN
    if($usuario=="cajaadmin"){

             //ELIMINAR ORDEN
     mysqli_query($conexion, "DELETE ordenes FROM ordenes WHERE ord_id_orden='$idorden'"); 
      //ELIMINAR OBSERVACIONES DE ORDEN
      mysqli_query($conexion, "DELETE observaciones FROM observaciones WHERE ord_id_orden='$idorden'"); 

           //COMPROBAR QUE ORDEN SE HAYA ELIMINADO CORRECTAMENTE
     $busOrden = mysqli_query($conexion, "SELECT count(*) from ordenes where ord_id_orden='$idorden'") or die 
            ("Problemas en el select 2:".mysqli_error($conexion));
            $ord = mysqli_fetch_array($busOrden);

    }else{
        //EMPLEADO, GUARDAR LA VENTA ELIMINADA

        //BUSCAR SI CLIENTE ELIMINADO YA SE REGISTRO ANTERIORMENTE
        $buscarEliminado = mysqli_query($conexion, "SELECT id_clienteOrdEliminada from clientes_ordeliminadas where cli_id_cliente='$idcliente'") or die 
            ("Problemas en el select 2:".mysqli_error($conexion));
            $bus = mysqli_fetch_array($buscarEliminado);
            $idclienteeliminado=$bus[0];

            if(empty($idclienteeliminado)){
                //NO SE REGISTRO
                $conexion->query("insert into clientes_ordeliminadas (eliord_consumo,eliord_lugar,eliord_horapedido,eliord_horaeliminado, eliord_fecha, cli_id_cliente)
                values ($consumo,'$lugar','$horapedido','$hora','$fecha','$idcliente')");
                $idclienteeliminado=mysqli_insert_id($conexion);
            }else{}
          


            mysqli_query($conexion, "UPDATE ordenes SET ord_status=0, cli_id_cliente='$idclienteeliminado' WHERE ord_id_orden='$idorden' LIMIT 1");


            $busOrden = mysqli_query($conexion, "SELECT count(*) from ordenes where ord_id_orden='$idorden' and ord_status=2") or die 
            ("Problemas en el select 2:".mysqli_error($conexion));
            $ord = mysqli_fetch_array($busOrden);
    }




  echo JSON_encode($ord[0]);