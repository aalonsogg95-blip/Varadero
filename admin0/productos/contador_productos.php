<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////


//FECHA
//ZONA HORARIA
date_default_timezone_set('America/Mexico_City');
//FECHA
$mes=date("m");
$anual=date("Y");


$pro=$_POST['producto'];

   ///COSTO DE ENVIO
    $costo_envio= mysqli_query($conexion, "SELECT env_costo FROM envio") or die ("Problemas en el select 2:".mysqli_error($conexion));
                  $cosenv = mysqli_fetch_array($costo_envio);


if($pro != ""){
/////////////////////////////////////////////////
//CONTAR CLIENTES
$contPro = mysqli_query($conexion, "select count(*) from productos 
WHERE (pro_producto like '%$pro%') or (pro_categoria like '%$pro%')") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);

$cont=array($coPro[0]);
    
}else{
    /////////////////////////////////////////////////
//CONTAR CLIENTES
$contPro = mysqli_query($conexion, "select count(*) from productos") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);
    
}

$datos=array($coPro[0],$cosenv[0]);
echo json_encode($datos);