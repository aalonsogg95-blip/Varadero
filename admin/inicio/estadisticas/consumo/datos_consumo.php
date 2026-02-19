<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];



$output=array();


//CONSUMO
$sqlventas=mysqli_query($conn, "SELECT 
    consumo,
    COUNT(*) as total_transacciones,
    SUM(total) as total_monto
FROM his_clientes 
WHERE MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anual'
GROUP BY consumo
ORDER BY total_monto DESC");
    while ($row = mysqli_fetch_assoc($sqlventas)) {

       $output[]=$row;
    }


//ENVIO
$sqlenvio=mysqli_query($conn, "SELECT sum(envio) as env
FROM his_clientes 
WHERE MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anual'");
$sumarenvio = mysqli_fetch_assoc($sqlenvio);
$env=$sumarenvio["env"];    


$datos=array($output, $env);

echo json_encode($datos);