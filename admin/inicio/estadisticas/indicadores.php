<?php
//INCLUIR CONEXION 
require '../../../conexion1.php';

/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];




//VENTAS POR MES, MES SELECCIONADO Y AÑO SELECCIONADO
$sqlventas=mysqli_query($conn, "SELECT count(*) as totalventas FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}'");
$ventas = mysqli_fetch_assoc($sqlventas);
$output[]=intval($ventas["totalventas"]);

//INGRESOS
$sqlingresos=mysqli_query($conn, "SELECT sum(total) as ingresos FROM his_clientes where MONTH(fecha)='${mes}' and YEAR(fecha)='${anual}'");
$ingresos = mysqli_fetch_assoc($sqlingresos);
$output[]=($ingresos['ingresos'] !== null) ? $ingresos['ingresos'] : 0;

//GASTOS
$sqlgastos=mysqli_query($conn, "SELECT sum(gas_costo) as gasto FROM gastos where MONTH(gas_fecha)='${mes}' and YEAR(gas_fecha)='${anual}'");
$gastos = mysqli_fetch_assoc($sqlgastos);
$output[]=($gastos['gasto'] !== null) ? $gastos['gasto'] : 0;

$output[]=(($ingresos['ingresos'] !== null) ? $ingresos['ingresos'] : 0) - (($gastos['gasto'] !== null) ? $gastos['gasto'] : 0);






/************************
 * DATOS A COMPARAR CON OTROS MESES 
 */


$meses = [
    "", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

//MES CON LA MAYOR CANTIDAD DE PEDIDOS
$sqlMasVentas=mysqli_query($conn, " SELECT MONTH(fecha) as mes, COUNT(*) as total_ventas 
    FROM his_clientes
    WHERE YEAR(fecha) = '${anual}' 
    GROUP BY MONTH(fecha) 
    ORDER BY total_ventas DESC 
    LIMIT 1");
$masventas = mysqli_fetch_assoc($sqlMasVentas);

$outputmas[]=$meses[$masventas["mes"]]." ".$masventas["total_ventas"]." ventas";
$numeros[]=intval($masventas["total_ventas"]);




//MES CON LA MAYOR CANTIDAD DE INGRESOS
$sqlMesMasIngresos = mysqli_query($conn, "
    SELECT 
        MONTH(fecha) as mes,
        SUM(total) as total_ingresos 
    FROM his_clientes 
    WHERE YEAR(fecha) = '${anual}' 
    GROUP BY MONTH(fecha) 
    ORDER BY total_ingresos DESC 
    LIMIT 1");
$mesMasIngresos = mysqli_fetch_assoc($sqlMesMasIngresos);

$outputmas[]=$meses[$mesMasIngresos["mes"]]." $".number_format($mesMasIngresos["total_ingresos"])." ingresos";
$numeros[]=intval($mesMasIngresos["total_ingresos"]);



//MES CON LA MAYOR CANTIDAD DE GASTOS
$sqlMesMasGastos = mysqli_query($conn, "
    SELECT 
        MONTH(gas_fecha) as mes,
        SUM(gas_costo) as total_gastos 
    FROM gastos 
    WHERE YEAR(gas_fecha) = '${anual}' 
    GROUP BY MONTH(gas_fecha) 
    ORDER BY total_gastos DESC 
    LIMIT 1
");
$mesMasGastos = mysqli_fetch_assoc($sqlMesMasGastos);
$masgastototal=($mesMasGastos["total_gastos"] !== null) ? $mesMasGastos["total_gastos"] : 0;
$masgastomes=($mesMasGastos["mes"] !== null) ? $mesMasGastos["mes"] : 0;
if($masgastomes!=0 && $masgastototal!=0){
    $outputmas[] = $meses[$masgastomes] . " $" . number_format($masgastototal) . " gastos";
    $numeros[]=intval($masgastototal);
}

 $outputmas[]="";
 $numeros[]="";



$datos=array($output, $outputmas, $numeros);

 echo json_encode($datos);