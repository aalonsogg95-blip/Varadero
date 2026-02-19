<?php
include_once "../conexion1.php";


//VARIABLES
$envio= $_POST['envio'];             
$cuenta= JSON_decode($_POST['strCuenta']);
$idcliente=$_POST['idcliente'];
$lugar=$cuenta->cli_lugar;
$consumo=$_POST['consumo'];
$totalventa=$_POST['totalventa'];
$hora=$cuenta->cli_hora;
$f=$cuenta->cli_fecha;
$ordenes=$cuenta->ordenes;



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
 $sql3=mysqli_query($conn,"INSERT into his_clientes values ('$idcliente','$consumo','$lugar',$totalventa,$envio,'$hora','$f')"); 
 if($sql3){  
    $id=1;
 }else{
    $id=0;
 }
 
 
 echo json_encode($id);




// $totalCliente=$total+$envio;


//  if($num==1){
//     //VENTA GENERAL

//     $sql2=mysqli_query($conn, "INSERT INTO historial_clientes (id_historial_hiscli, consumo_hiscli, lugar_hiscli,total_hiscli, envio_hiscli, hora_hiscli, fecha_hiscli, usuario_hiscli) VALUES ('${idcliente}', '${consumo}','${lugar}','${total}','${envio}','${hora}','${fecha}', '$usuario')");
//     if($sql2){

//         ///ORDENES
//         for($o=0; $o<sizeof($ordenes); $o++){
//             $cantidad=$ordenes[$o]->cantidad_ordenes;
//             $categoria=$ordenes[$o]->categoria_ordenes;
//             $producto=$ordenes[$o]->producto_ordenes;
//             $totalOrden=$ordenes[$o]->total_ordenes;
//             $tamano=$ordenes[$o]->tamano_ordenes;
//             $costo=$ordenes[$o]->costo_ordenes;
//             $idorden=$ordenes[$o]->id_orden_ordenes;
//             $numero=$ordenes[$o]->numero_ordenes;
//             $extras=$ordenes[$o]->extra_ordenes;
//             $usuario=$ordenes[$o]->usuario_ordenes;


//             $sql3=mysqli_query($conn, "INSERT INTO historial_ordenes (id_historial_hisord,numero_hisord, categoria_hisord, producto_hisord, cantidad_hisord, tamano_hisord, extras_hisord, costo_hisord, total_hisord, fecha_hisord, usuario_hisord, id_historialhiscli_hisord) VALUES ('${idorden}', '${numero}','${categoria}','${producto}','${cantidad}','${tamano}','${extras}','${costo}','${totalOrden}','${fecha}','$usuario','${idcliente}')");
//             if($sql3){
//                 $cont++;
//             }
//         }

       

//     }

//         //VALIDAR SI TODO SE REGISTRO
//         if(($length==$cont) and ($lengthcombos==$contcombos)){
//             $id=1;
//         }else{
//             $id=0;
//         }


//  }else{
//     //VENTA INDIVIDUAL
//     for($o=0; $o<$length; $o++){
//         $idorden=$ordenes[$o]->id_orden_ordenes;
//         $sql=mysqli_query($conn, "UPDATE ordenes SET pago_ordenes=1 WHERE id_orden_ordenes=${idorden}");
//         if($sql){
//             $cont++;
//         }
//     }


//     for($c=0; $c<$lengthcombos; $c++){
//         $idcombo=$combos[$c]->id_ordenescombos_ordcom;
//         $sql1=mysqli_query($conn, "UPDATE ordenes_combos SET pago_ordcom=1 WHERE id_ordenescombos_ordcom=${idcombo}");
//         if($sql1){
//             $cont++;
//         }
//     }


    
//     if($cont==$length){
//         $id=1;
//     }else{
//         $id=0;
//     }
//  }



//   echo json_encode($id);