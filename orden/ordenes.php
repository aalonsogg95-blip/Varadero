<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////


////////////////////////////////////////////////////
//ZONA HORARIA
date_default_timezone_set('America/Mexico_City');

     	//VARIABLES
     	$fecha=date("Y-m-d");
//////////////////////////////////////////7
$arrayOrdenes=array();

//SI HAY ORDENES PENDIENTES
    $mostrarOrd = mysqli_query($conexion, "SELECT ord_id_orden, cli_consumo,cli_lugar,ord_producto,ord_cantidad,ord_costo,ord_total,ord_hora,ord_status, ord_categoria from ordenes 
    inner join clientes on 
    clientes.cli_id_cliente = ordenes.cli_id_cliente
    where cli_fecha='$fecha' and cli_eliminado=0 order by ord_hora asc") or die 
            ("Problemas en el select 4:".mysqli_error($conexion));
            while($mosord=mysqli_fetch_row($mostrarOrd)){
                
            $obsOrd = mysqli_query($conexion, "select obs_observacion from observaciones where ord_id_orden='$mosord[0]' limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $obsOrd = mysqli_fetch_array($obsOrd);
                if(empty($obsOrd[0])){
                    $obs="";
                }else{
                    $obs=$obsOrd[0];
                }
                
     $orden=array(intval($mosord[0]),
                        intval($mosord[1]),
                        $mosord[2],
                        $mosord[3],
                        intval($mosord[4]),
                        intval($mosord[5]),
                        intval($mosord[6]),
                        $obs,
                        $fecha,
                        $mosord[7],
                        intval($mosord[8]),
                        $mosord[9]);  
                         
     array_push($arrayOrdenes, $orden);
                
            }

echo json_encode($arrayOrdenes);