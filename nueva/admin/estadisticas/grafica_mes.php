<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLE
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$cantDias= array('0',32,29,32,31,32,31,32,32,31,32,31,32);

///ARRAY DE CLIENTES
$clientesXdia = array();

///CICLO PARA RECORRER LOS DIAS DEL MES
for($i = 1; $i <$cantDias[$mes]; $i++){
    
    $fecha=$anual."-".$num."-".$i;
    
  //CLIENTES POR DIA
    $contCli = mysqli_query($conexion, "select count(*) from his_clientes where year(fecha)='$anual' and MONTH(fecha)='$mes' and day(fecha)='$i'") or die 
    ("Problemas en el select 2:".mysqli_error($conexion));
    $coCli = mysqli_fetch_array($contCli);
    $coCli=number_format($coCli[0]);
    
    array_push($clientesXdia,$coCli);    
}


echo json_encode($clientesXdia);