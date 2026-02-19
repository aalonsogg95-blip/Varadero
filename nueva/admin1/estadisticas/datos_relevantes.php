<?php
//INCLUIR CONEXION 
require '../../conexion1.php';

/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];




///CLIENTE MAS FRECUENTE
$sql=mysqli_query($conn, "SELECT lugar, COUNT(*) AS total FROM his_clientes WHERE MONTH(fecha) = '$mes' AND YEAR(fecha) = '$anual' AND consumo = 3 GROUP BY lugar ORDER BY total DESC LIMIT 1");
$clientes = mysqli_fetch_assoc($sql);
$cliente = ($clientes['lugar_hiscli'] !== null) ? $clientes['lugar_hiscli']." (".$clientes['total'].")" : "Ninguno";

//DIA CON MAS VENTAS
$sql=mysqli_query($conn, "SELECT day(fecha) as fecha,count(*) as total FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}' group by day(fecha) order by total desc limit 1");
 $dias = mysqli_fetch_assoc($sql);
 $dia = ($dias['fecha'] !== null) ? $dias['fecha']."/".$mes."/".$anual." (".$dias['total'].")" : "Ninguno";

//MOSTRADOR
$sql=mysqli_query($conn, "SELECT count(*) as ventas FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}' and consumo=1");
 $mostrador = mysqli_fetch_assoc($sql);

//DOMICILIO
$sql=mysqli_query($conn, "SELECT count(*) as ventas FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}' and consumo=3");
 $domicilio = mysqli_fetch_assoc($sql);



 $datos=[
    "cliente"=>$cliente,
    "dia"=>$dia,
    "mostrador"=>$mostrador["ventas"],
    "domicilio"=>$domicilio["ventas"],
 
];

$output[]=$datos;


echo json_encode($output);