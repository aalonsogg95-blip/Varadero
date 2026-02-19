<?php
//INCLUIR CONEXION 
require '../../conexion1.php';

/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $mes, $anual);

$output=array();
//CICLO PARA RECORRER LOS DIAS DEL MES
for($i = 1; $i <$daysInMonth+1; $i++){
            $fecha = $anual."-".$mes."-".$i;

            //CLIENTES POR DIA
            $sql=mysqli_query($conn, "SELECT count(*) as ventas FROM his_clientes where fecha='${fecha}'");
            $ventas = mysqli_fetch_assoc($sql);


        $output[]=$ventas["ventas"];

}

echo json_encode($output);