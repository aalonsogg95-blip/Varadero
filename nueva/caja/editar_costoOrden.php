<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////


//VARIABLES
$idorden=$_POST["idorden"];
$inptCosto=$_POST["inptCosto"];
$cantidad=$_POST["cantidad"];

$total= $cantidad*$inptCosto;
//ACTUALIZAR STATUS
mysqli_query($conexion, "UPDATE ordenes SET
                ord_costo=$inptCosto, ord_total=$total WHERE ord_id_orden='$idorden'  LIMIT 1");

 $buscarCosto= mysqli_query($conexion, "SELECT count(*) from ordenes where ord_id_orden='$idorden' and ord_costo=$inptCosto and ord_total=$total") or die  ("Problemas en el select 2:".mysqli_error($conexion));
 $busCo = mysqli_fetch_array($buscarCosto);


 echo JSON_encode($busCo[0]);