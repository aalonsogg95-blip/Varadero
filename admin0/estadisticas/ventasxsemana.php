<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLES
$lun=$_POST["lunes"];
$sab=$_POST['sabado'];

//CLIENTES X SEMANA
$clientes = mysqli_query($conexion, "select count(*) from his_clientes where fecha between '$lun' and '$sab'") or die 
("Problemas en el select 2:".mysqli_error($conexion));
$cli = mysqli_fetch_array($clientes);
   $cli=number_format($cli[0]);

//INGRESOS X SEMANA
$ingresos = mysqli_query($conexion, "select sum(total) from his_clientes where fecha between '$lun' and '$sab'") or die 
("Problemas en el select 2:".mysqli_error($conexion));
$ing = mysqli_fetch_array($ingresos);
   $ing=number_format($ing[0]);


$datos=array($cli, $ing);
echo JSON_encode($datos);