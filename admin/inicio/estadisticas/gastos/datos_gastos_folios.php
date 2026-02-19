<?php
//INCLUIR CONEXION 
include_once "../../../conexion.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$output=array();

$sqlgastos=mysqli_query($conn, "SELECT 
	 folio_gastos,
    nombre_trabajo_pedidos,
    COUNT(*) as total_gastos,
    SUM(total_gastos) as cantidad_total
  
FROM gastos 
INNER JOIN pedidos ON pedidos.id_pedido = gastos.folio_gastos
WHERE MONTH(fecha_gastos) = '$mes' AND YEAR(fecha_gastos) = '$anual'
GROUP BY nombre_trabajo_pedidos
ORDER BY cantidad_total DESC");
    while ($row = mysqli_fetch_assoc($sqlgastos)) {
        $output[]=$row;
       
    }

echo json_encode($output);