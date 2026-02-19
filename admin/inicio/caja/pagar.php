<?php
include_once "../../../conexion1.php";

session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];


//VARIABLES
$envio= $_POST['envio'];             
$cuenta= JSON_decode($_POST['strCuenta']);
$idcliente=$_POST['pagar_idcliente'];
$lugar=$cuenta->cli_lugar;
$observacion=$cuenta->cli_observacion;
$consumo=$_POST['pagar_consumo'];
$totalventa=$_POST['pagar_totalventa'];
$hora=$cuenta->cli_hora;
$f=$cuenta->cli_fecha;
$ordenes=$cuenta->ordenes;
$formapago=$_POST['selectformadepago'];
$factura=$_POST['checkFactura'];




for($o=0; $o<sizeof($ordenes); $o++){
    $idorden=$ordenes[$o]->ord_id_orden;
    $categoria=$ordenes[$o]->ord_categoria;
    $producto=$ordenes[$o]->ord_producto;
    $cantidad=$ordenes[$o]->ord_cantidad;
    $costo=$ordenes[$o]->ord_costo;
    $total=$ordenes[$o]->ord_total;
    $ordHora=date_create($ordenes[$o]->ord_hora);
    $ordHoraEnt=date_create($ordenes[$o]->ord_horaEntrega);
    
    $difference = date_diff($ordHora, $ordHoraEnt); 
    $minutes=0;
    // $minutes = $difference->days * 24 * 60;
    $minutes += $difference->h * 60;
    $minutes += $difference->i;


    $sql2=mysqli_query($conn, "INSERT into his_ventas(hisv_id_histoVentas,categoria, producto, cantidad, costo, total, fecha, tiempo_entrega,hisc_id_histoClientes) values ('$idorden','$categoria','$producto','$cantidad','$costo','$total','$f', '$minutes','$idcliente')"); 

        //ELIMINAR OBSERVACIONES DE ORDENES
        $sql1=mysqli_query($conn, "DELETE observaciones FROM observaciones WHERE ord_id_orden='$idorden'");
}


 //INSERTAR CLIENTE EN TABLA HIS_CLIENTES
 $sql3=mysqli_query($conn,"INSERT into his_clientes (hisc_id_histoClientes, consumo, lugar, observacion, total, envio, hora, fecha, forma_pago, usuario, cortesia) values ('$idcliente','$consumo','$lugar','$observacion',$totalventa,$envio,'$hora','$f','$formapago','$usuario',0)"); 
 if($sql3){  
    $id=1;
    if($factura==1){
      #0 SIGNIFICA FACTURA NO ENTREGADA
      #1 FACTURA ENTREGADA
      $iva=$totalventa*0.16;
      $sql4=mysqli_query($conn,"INSERT into facturas(id_histoClientes_facturas, status_facturas, iva_facturas) values ('$idcliente',0,'$iva')"); 
    }
 }else{
    $id=0;
 }
 
 
 echo json_encode($id);

