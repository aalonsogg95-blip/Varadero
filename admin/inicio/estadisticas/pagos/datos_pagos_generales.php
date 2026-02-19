<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];



$output=array();


//PAGOS
$sqlventas=mysqli_query($conn, "SELECT 
    forma_pago,
    COUNT(*) as total_transacciones,
    SUM(total) as total_monto
FROM his_clientes 
WHERE MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anual'
GROUP BY forma_pago
ORDER BY total_monto DESC");
    while ($row = mysqli_fetch_assoc($sqlventas)) {

       $output[]=$row;
    }




echo json_encode($output);