<?php

include_once "../../../conexion1.php";


session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];





$cuenta= JSON_decode($_POST['strCuenta']);
$idcliente=$cuenta->cli_id_cliente;
$lugar=$cuenta->cli_lugar;
$hora=$cuenta->cli_hora;
$consumo=$cuenta->cli_consumo;
$fecha=$cuenta->cli_fecha;
$observacion=$cuenta->cli_observacion;
$totalventa=$_POST['totalVenta'];

$envio= $_POST['envio'];     



 // PROCESAR ORDENES
    foreach($cuenta->ordenes as $orden) {
        // Extraer datos de la orden
        $idorden = $orden->ord_id_orden;
        $categoria = $orden->ord_categoria;
        $producto = $orden->ord_producto;
        $cantidad = $orden->ord_cantidad;
        $costo = $orden->ord_costo;
        $total = $orden->ord_total;
        
        // Calcular tiempo de entrega en minutos
        $ordHora = date_create($orden->ord_hora);
        $ordHoraEnt = date_create($orden->ord_horaEntrega);
        $difference = date_diff($ordHora, $ordHoraEnt);
        $minutes = ($difference->h * 60) + $difference->i;
        
        // Guardar venta en historial
        $sql2 = mysqli_query($conn, "INSERT INTO his_ventas(hisv_id_histoVentas, categoria, producto, cantidad, costo, total, fecha, tiempo_entrega, hisc_id_histoClientes) VALUES ('$idorden','$categoria','$producto','$cantidad','$costo','$total','$fecha','$minutes','$idcliente')");
        
        if (!$sql2) throw new Exception("Error al insertar venta: " . mysqli_error($conn));
        
        // Eliminar observaciones de la orden procesada
        mysqli_query($conn, "DELETE FROM observaciones WHERE ord_id_orden='$idorden'");
    }


 //INSERTAR CLIENTE EN TABLA HIS_CLIENTES
 $sql3=mysqli_query($conn,"INSERT into his_clientes (hisc_id_histoClientes, consumo, lugar, observacion, total, envio, hora, fecha, forma_pago, usuario, cortesia) values ('$idcliente','$consumo','$lugar','$observacion',$totalventa,$envio,'$hora','$fecha','Ninguna','$usuario',1)"); 
 if($sql3){  
    $id=1;
 }else{
    $id=0;
 }
 
 
 echo json_encode($id);
