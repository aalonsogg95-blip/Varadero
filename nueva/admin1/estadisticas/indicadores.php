<?php
//INCLUIR CONEXION 
require '../../conexion1.php';

/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$output=array();
//CLIENTES POR MES
$sql=mysqli_query($conn, "SELECT count(*) as ventas FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}'");
 $ventas = mysqli_fetch_assoc($sql);

 $output[] = $ventas["ventas"];


//INGRESOS
$sql2=mysqli_query($conn, "SELECT sum(total) as ingresos FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}'");
$ingresos = mysqli_fetch_assoc($sql2);
$ingresos = ($ingresos['ingresos'] !== null) ? $ingresos['ingresos'] : 0;
$output[]=$ingresos;



//GASTOS
$sql3=mysqli_query($conn, "SELECT sum(gas_costo) as gasto FROM gastos where MONTH(gas_fecha)='${mes}' and YEAR(gas_fecha)='${anual}'");
$gastos = mysqli_fetch_assoc($sql3);
$gastos = ($gastos['gasto'] !== null) ? $gastos['gasto'] : 0;
$output[] = $gastos;





//UTILIDAD
$output[] = $ingresos-$gastos;



 echo json_encode($output);