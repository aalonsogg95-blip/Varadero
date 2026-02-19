<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];



//CLIENTES POR MES
$contCli = mysqli_query($conexion, "select count(*) from his_clientes where year(fecha)='$anual' and MONTH(fecha)='$mes'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coCli = mysqli_fetch_array($contCli);
        $coCli=number_format($coCli[0]);

//PRODUCTOS VENIDOS POR MES
$contPro = mysqli_query($conexion, "select sum(cantidad) from his_ventas where year(fecha)='$anual' and MONTH(fecha)='$mes'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);
        $coPro=number_format($coPro[0]);

//INGRESOS POR MES
$contIng = mysqli_query($conexion, "select sum(total) from his_clientes where year(fecha)='$anual' and MONTH(fecha)='$mes'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coIng = mysqli_fetch_array($contIng);
        if(empty($coIng[0])){
                $coIng=0;
        }else{
                $coIng=$coIng[0];
        }


//GASTOS POR MES
$contGas = mysqli_query($conexion, "select sum(gas_costo) from gastos where year(gas_fecha)='$anual' and MONTH(gas_fecha)='$mes'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coGas = mysqli_fetch_array($contGas);
        if(empty($coGas[0])){
                $coGas=0;
        }else{
                $coGas=$coGas[0];
        }

       $utilidad = number_format($coIng-$coGas); 

         $coIng=number_format($coIng);
        $coGas=number_format($coGas);

//ARRAY DE DATOS
$datos=array($coCli,$coPro, $coIng, $coGas, $utilidad);

echo json_encode($datos);