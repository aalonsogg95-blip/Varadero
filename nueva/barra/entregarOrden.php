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
$h= date("H:i:s");//HORA ACTUAL


//VARIABLES
$idorden=$_POST['idorden'];

//ACTUALIZAR STATUS
mysqli_query($conexion, "UPDATE ordenes SET
                ord_status=2 WHERE ord_id_orden='$idorden' LIMIT 1");

//ACTUALIZAR LA HORA DE ENTREGA
mysqli_query($conexion, "UPDATE ordenes SET
ord_horaEntrega='$h' WHERE ord_id_orden='$idorden' LIMIT 1");

//VALIDAR ORDEN ENTREGADA
$contOrd = mysqli_query($conexion, "SELECT ord_status from ordenes where ord_id_orden='$idorden' limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coOrd = mysqli_fetch_array($contOrd);

echo json_encode($coOrd[0]);