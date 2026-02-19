<?php
//INCLUIR CONEXION 
require '../../conexion.php';

/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$output=array();
//PRODUCTOS MAS VENDIDOS
$sql=mysqli_query($conn, "SELECT producto, categoria, sum(cantidad) AS total FROM his_ventas
where  MONTH(fecha)='$mes' and YEAR(fecha)='$anual' GROUP BY producto, categoria
ORDER BY total desc");

while ($row = mysqli_fetch_assoc($sql)) {
   
    $output[] = $row;
}


echo json_encode($output);