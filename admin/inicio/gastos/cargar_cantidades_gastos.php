<?php
//INCLUIR CONEXION 
include_once "../../../conexion1.php";

session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];

$user = ($usuario=="admin") ? '' : 'AND gas_usuario="'.$usuario.'"';

//VARIABLES
$fecha = isset($_POST['input']) ? $conn->real_escape_string($_POST['input']) : null;
$tiempo= isset($_POST['tiempo']) ? $conn->real_escape_string($_POST['tiempo']) : null;
$mes= isset($_POST['mes']) ? $conn->real_escape_string($_POST['mes']) : null;
$anual= isset($_POST['anual']) ? $conn->real_escape_string($_POST['anual']) : null;

if($tiempo=="dia"){
    //POR FECHA
    $filtro = " AND DATE(gas_fecha) = '$fecha' $user";
}else{
    //POR MES
    $filtro = " AND MONTH(gas_fecha) = '$mes' AND YEAR(gas_fecha) = '$anual' $user";
}

/////////////////////////////////////////////////
$tipos=["Gastos caja", "Gastos insumos", "Gastos publicitarios", "Gastos fijos", "Gastos variables", "Gastos mermas"];
$output=[];

for($i=0; $i<sizeof($tipos); $i++){
    $sqlgastos=mysqli_query($conn, "SELECT sum(gas_costo) as total, count(*) as contador FROM gastos where gas_tipo='{$tipos[$i]}' $filtro");
        $gasto= mysqli_fetch_assoc($sqlgastos);
       

        $resultado = [
                "Tipogasto" => $tipos[$i],
                "total" => $gasto["total"] ?? 0,
                "contador" => $gasto["contador"] ?? 0
            ];
        array_push($output, $resultado);
}


echo json_encode($output, JSON_UNESCAPED_UNICODE);

