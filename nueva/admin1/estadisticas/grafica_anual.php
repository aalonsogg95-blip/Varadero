<?php
//INCLUIR CONEXION 
require '../../conexion.php';

/////////////////////////////////////////////////

//VARIABLES
$anual=$_POST['anual'];

$ventas=array();
$ingresos=array();
$gastos=array();

//CICLO PARA RECORRER LOS DIAS DEL MES
for($i = 1; $i <13; $i++){

     //CLIENTES POR MES
     $sql=mysqli_query($conn, "SELECT count(*) as ventas FROM his_clientes where Month(fecha)='$i' and Year(fecha)='${anual}'");
     $venta = mysqli_fetch_assoc($sql);

     $ventas[]=$venta["ventas"];


     //INGRESOS POR MES
     $sql2=mysqli_query($conn, "SELECT sum(total) as ingresos FROM his_clientes where Month(fecha)='$i' and Year(fecha)='${anual}'");
     $ingreso = mysqli_fetch_assoc($sql2);
     $ingresos[] = ($ingreso['ingresos'] !== null) ? $ingreso['ingresos'] : 0;


      //GASTOS POR MES
      $sql3=mysqli_query($conn, "SELECT sum(total) as gasto FROM gastos where Month(gas_fecha)='$i' and Year(gas_fecha)='${anual}'");
      $gasto = mysqli_fetch_assoc($sql3);
      $gastos[] = ($gasto['gasto'] !== null) ? $gasto['gasto'] : 0;


}

$output=array($ventas, $ingresos, $gastos);

echo json_encode($output);