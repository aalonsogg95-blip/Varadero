<?php
//INCLUIR CONEXION 
require '../../conexion1.php';

/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


//DIAS
$dias = array('','Lunes','Martes','Miércoles','Jueves','Viernes','Sabado', 'Domingo');

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $mes, $anual);

$output=array();
//CICLO PARA RECORRER LOS DIAS DEL MES
for($i = 1; $i <$daysInMonth+1; $i++){
       
            $fecha = $anual."-".$mes."-".$i;
            
        	$num = date("N", strtotime($fecha));



            //CLIENTES POR DIA
            $sql=mysqli_query($conn, "SELECT count(*) as ventas FROM his_clientes where fecha='${fecha}'");
            $ventas = mysqli_fetch_assoc($sql);

            //INGRESOS POR DIA
            $sql2=mysqli_query($conn, "SELECT sum(total) as ingresos FROM his_clientes where fecha='${fecha}'");
            $ingresos = mysqli_fetch_assoc($sql2);
            $ingresos = ($ingresos['ingresos'] !== null) ? $ingresos['ingresos'] : 0;

             //GASTOS POR DIA
             $sql3=mysqli_query($conn, "SELECT sum(gas_costo) as gasto FROM gastos where fecha='${fecha}'");
             $gastos = mysqli_fetch_assoc($sql3);
             $gastos = ($gastos['gasto'] !== null) ? $gastos['gasto'] : 0;

       

            

            $datos=[
                "numero_dia"=>$i,
                "nombre_dia"=>$dias[$num],
                "ventas_totales"=>$ventas["ventas"],
                "ingresos"=>$ingresos,
                "gastos"=>$gastos,
                "utilidad"=>$ingresos-$gastos,
                
            ];

            $output[]=$datos;

}


echo json_encode($output);