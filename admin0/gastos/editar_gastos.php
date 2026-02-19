<?php
//INCLUIR ARCHIVO DE CONEXION
require '../../conexion.php';
//PASAR CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8");
///////////////////////////////////////////

///VARIABLE
$idgasto=$_POST['idgasto'];
$fieldGasto=$_POST['col1'];
$fieldProveedor=$_POST['col2'];
$fieldFrecuencia=$_POST['col3'];
$fieldCosto=$_POST['col4'];
$fieldFecha=$_POST['col5'];


//MODIFICAR
mysqli_query($conexion, "UPDATE gastos SET
                gas_concepto='$fieldGasto', gas_proveedor='$fieldProveedor',gas_frecuencia='$fieldFrecuencia',gas_costo='$fieldCosto',gas_fecha='$fieldFecha' where gas_id_gasto='$idgasto'");


$buscarGasto= mysqli_query($conexion, "SELECT count(*) from gastos where gas_concepto='$fieldGasto' and gas_proveedor='$fieldProveedor' and gas_frecuencia='$fieldFrecuencia' and gas_costo='$fieldCosto' and gas_fecha='$fieldFecha' and gas_id_gasto='$idgasto'") or die 
                ("Problemas en el select 2:".mysqli_error($conexion));
                $buscarGas = mysqli_fetch_array($buscarGasto);


echo json_encode($buscarGas[0]);