<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////

//VARIABLES
$concepto=$_POST['fieldConcepto']; 
$proveedor=$_POST['fieldProveedor'];
$frecuencia=$_POST['fieldFrencuencia'];
$pago=$_POST['fieldPago'];
$fecha=$_POST['fieldFecha'];
// $usuario=$_POST['usuario'];


 //INSERTAR CLIENTE
    $conexion->query("insert into gastos(gas_concepto, gas_proveedor, gas_frecuencia,gas_costo,gas_fecha) values 
    ('$concepto','$proveedor','$frecuencia','$pago','$fecha')"); 
    $idgasto=mysqli_insert_id($conexion);



    echo json_encode($idgasto);