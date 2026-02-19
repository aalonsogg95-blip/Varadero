<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];

//ARREGLO DIAS
$dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
$days = array('','Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');



//FECHA CON MAS CLIENTES
$contMasClientes = mysqli_query($conexion, "select day(fecha),count(*) as tot from his_clientes where MONTH(fecha)='$mes' and year(fecha)='$anual' group by day(fecha) order by tot desc limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coClientes = mysqli_fetch_array($contMasClientes);

        if(empty($coClientes[0])){
            $coFecha="Ninguno";
            $coClientes=0;
        }else{
        	//OBTENER EL DIA DE LA SEMANA
        	$no = date("N", strtotime($anual."-".$mes."-".$coClientes[0]));
            $coFecha=$dias[$no]." ".$coClientes[0];
            //CANTIDAD DE GARRAFONES
            $coClientes=$coClientes[1];
        }

//CLIENTE MAS FRECUENTE
$contClienteFrecuente = mysqli_query($conexion, "select lugar,count(*) as tot from his_clientes where MONTH(fecha)='$mes' and year(fecha)='$anual' and consumo !=0 group by lugar order by tot desc limit 1; ") or die 
    ("Problemas en el select 2:".mysqli_error($conexion));
    $conCliFre = mysqli_fetch_array($contClienteFrecuente);
    if(!empty($conCliFre[0])){
        $conCliFre = $conCliFre[0]." (".$conCliFre[1].")";
    }else{
        $conCliFre = "Ninguno";
    }


//DIA DE LA SEMANA MAS VENTAS
$contDiaSemanaMas = mysqli_query($conexion, "select DAYOFWEEK(fecha) as dia,count(*) as tot from his_clientes where MONTH(fecha)='$mes' and year(fecha)='$anual' group by dia order by tot desc limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coMDia = mysqli_fetch_array($contDiaSemanaMas);

        if(empty($coMDia[0])){
            $coMDia="Ninguno";
        }else{
            $coMDia=$days[$coMDia[0]];
        }


$datos=array($coFecha,$coClientes, $conCliFre, $coMDia);

echo json_encode($datos);