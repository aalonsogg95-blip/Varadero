<?php
//INCLUIR ARCHIVO DE CONEXION
require '../../conexion.php';
//PASAR CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8");
///////////////////////////////////////////

///VARIABLE
$idgasto=$_POST['idgasto'];


//ELIMINAR GASTOS
mysqli_query($conexion, "DELETE gastos FROM gastos
    WHERE gas_id_gasto='$idgasto'"); 



//VALIDAR GASTO ELIMINADO
$buscarGasto= mysqli_query($conexion, "SELECT count(*) from gastos where gas_id_gasto='$idgasto'") or die 
                ("Problemas en el select 2:".mysqli_error($conexion));
                $buscarGas = mysqli_fetch_array($buscarGasto);


echo json_encode($buscarGas[0]);