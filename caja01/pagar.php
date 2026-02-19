<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
//////////////////////////////////////////////
//ZONA HORARIA 
date_default_timezone_set('America/Mexico_City');
     
// $f=date("Y-m-d");//FECHA ACTUAL COMPLETA
////////////////////////////////

//VARIABLES
$envio= $_POST['envio'];             
$cuenta= JSON_decode($_POST['cuenta']);
$idcliente=$cuenta->idcliente;
$lugar=$cuenta->lugar;
$consumo=$cuenta->consumo;
$totalOrdenes=$cuenta->totalOrdenes;
$hora=$cuenta->hora;
$f=$cuenta->fechaVenta;
$ordenes=$cuenta->ordenes;



    for($o=0; $o<sizeof($ordenes); $o++){
        $idorden=$ordenes[$o]->idorden;
        $categoria=$ordenes[$o]->categoria;
        $producto=$ordenes[$o]->producto;
        $cantidad=$ordenes[$o]->cantidad;
        $costo=$ordenes[$o]->costo;
        $total=$ordenes[$o]->total;
        $ordHora=date_create($ordenes[$o]->ordHora);
        $ordHoraEnt=date_create($ordenes[$o]->ordHoraEnt);
        
        $difference = date_diff($ordHora, $ordHoraEnt); 
        $minutes=0;
        // $minutes = $difference->days * 24 * 60;
        $minutes += $difference->h * 60;
        $minutes += $difference->i;


         $conexion->query("insert into his_ventas(hisv_id_histoVentas,categoria, producto, cantidad, costo, total, fecha, tiempo_entrega,hisc_id_histoClientes) values ('$idorden','$categoria','$producto','$cantidad','$costo','$total','$f', '$minutes','$idcliente')"); 

            //ELIMINAR OBSERVACIONES DE ORDENES
                mysqli_query($conexion, "DELETE observaciones FROM observaciones WHERE ord_id_orden='$idorden'");
    }



 //INSERTAR CLIENTE EN TABLA HIS_CLIENTES
$conexion->query("insert into his_clientes values ('$idcliente','$consumo','$lugar',$totalOrdenes,$envio,'$hora','$f')"); 


$mostID = mysqli_query($conexion, "SELECT count(*) from his_clientes where hisc_id_histoClientes=$idcliente limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $mosId = mysqli_fetch_array($mostID);


echo json_encode($mosId[0]);
