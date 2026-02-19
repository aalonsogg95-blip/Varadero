<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];



$output=array();


//CORTESIAS
$sqlcortesias=mysqli_query($conn, "SELECT 
    SUM(total) as total_monto
FROM his_clientes 
WHERE MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anual' and cortesia=1");
    while ($row = mysqli_fetch_assoc($sqlcortesias)) {
       $output[]=$row;
    }



$datos=array($output);

echo json_encode($datos);