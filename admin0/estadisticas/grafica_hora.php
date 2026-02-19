<?php
//INCLUIR CONEXION 
require '../../conexion.php';
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$horIn = [];
$horFn = [];

$output=array();
for ($i = 9; $i <= 18; $i++) {
    $hora = sprintf('%02d:00', $i);
    
    $horaFin = sprintf('%02d:59', $i);


    //CLIENTES POR HORA
    $sql=mysqli_query($conexion, "SELECT count(*) as ventas FROM his_clientes where MONTH(fecha)='$mes' and YEAR(fecha)='$anual' and hora between '$hora' and '$horaFin'");
    $ventas = mysqli_fetch_assoc($sql);

    switch ($hora) {
        case '09:00': $hora="9:00 am"; break;
        case '10:00': $hora="10:00 am"; break;
        case '11:00': $hora="11:00 am"; break;
        case '12:00': $hora="12:00 pm"; break;
        case '13:00': $hora="1:00 pm"; break;
        case '14:00': $hora="2:00 pm"; break;
        case '15:00': $hora="3:00 pm"; break;
        case '16:00': $hora="4:00 pm"; break;
        case '17:00': $hora="5:00 pm"; break;
        case '18:00': $hora="6:00 pm"; break;
        
        }


    $datos=[
        "hora"=>$hora,
        "cantidad"=>$ventas["ventas"]
    ];


    $output[]=$datos;
}



 echo json_encode($output);