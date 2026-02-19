<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];



$output=array();
$sqlclientes = mysqli_query($conn, "
    SELECT 
        hc.lugar,
        COUNT(*) as total_ventas,
        SUM(hc.total) as suma_total_ventas,
        MAX(hc.fecha) as ultima_fecha_venta
    FROM his_clientes hc
    WHERE MONTH(hc.fecha) = '$mes' AND YEAR(hc.fecha) = '$anual'
    GROUP BY hc.lugar
    ORDER BY total_ventas DESC
");
    while ($row = mysqli_fetch_assoc($sqlclientes)) {
        $output[]=$row;
    }


echo json_encode($output);