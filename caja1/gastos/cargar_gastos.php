<?php

include_once "../../conexion1.php";


$mes=$_POST['fieldMes'];
$anual=$_POST['fieldAnual'];
$fecha=$_POST['fieldFecha'];
$periodo=$_POST['periodo'];


session_start();
$usuario= $_SESSION["datosUsuarioCaja"]["usuario"];


if($periodo==1){
    
        $sql=mysqli_query($conn, "SELECT * FROM gastos where gas_fecha='${fecha}'");
    
}else{
    
        $sql=mysqli_query($conn, "SELECT * FROM gastos where MONTH(gas_fecha)='${mes}' and YEAR(gas_fecha)='${anual}'");

    
}


$output = array();

while ($row = mysqli_fetch_assoc($sql)) {
   
    $output[] = $row;
}

echo json_encode($output);