<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$categorias=array();
$cantidades=array();

$sqlgastos=mysqli_query($conn, "SELECT 
    gas_tipo,
    SUM(gas_costo) as monto_total
FROM gastos 
WHERE MONTH(gas_fecha) = '$mes' AND YEAR(gas_fecha) = '$anual'
GROUP BY gas_tipo
ORDER BY monto_total DESC");
    while ($row = mysqli_fetch_assoc($sqlgastos)) {
        $categorias[]=$row["gas_tipo"];
        $cantidades[]=$row["monto_total"];
    }


 $output=array($categorias, $cantidades);
echo json_encode($output);