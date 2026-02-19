<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////
//ZONA HORARIA 
     date_default_timezone_set('America/Mexico_City');
     
     //$f=date("Y-m-d");//FECHA ACTUAL COMPLETA


     $f=$_POST['fieldFecha'];
     //CARGAR CUENTAS
$cuentas=array();
$clientes = mysqli_query($conexion, "SELECT cli_lugar,cli_id_cliente,cli_consumo,cli_hora, cli_observacion from clientes
    where cli_fecha='$f'  order by cli_id_cliente desc") or die ("Problemas en el select 2:".mysqli_error($conexion));
            while($cli=mysqli_fetch_row($clientes)){


                $cliente=[
                    "idcliente"=>intval($cli[1]),
                    "lugar"=>$cli[0],
                    "consumo"=>$cli[2],
                    "hora"=>$cli[3],
                    "horaFormat"=> date("h:i a", strtotime($cli[3])),
                    "observacion"=>$cli[4],
                    "fechaVenta"=>$f
                    
                ];

                //VARIABLES
                $ordenes=[];
                $total=0;
                $contOrdPen=0;
       
                //ORDENES
                    $mostrarOrdenes = mysqli_query($conexion, "SELECT ord_id_orden, ord_categoria, ord_producto, ord_cantidad, ord_costo,ord_total,ord_status,ord_hora,ord_horaEntrega from ordenes
                where cli_id_cliente='$cli[1]' and ord_status!=0 order by ord_id_orden asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                while($ord=mysqli_fetch_row($mostrarOrdenes)){
                    $total+=$ord[5];
                    if($ord[6]==1){
                        $contOrdPen++;
                    }
    
                    
                    $orden=[
                        "idorden"=>intval($ord[0]),
                        "categoria"=>$ord[1],
                        "producto"=>$ord[2],
                        "cantidad"=>$ord[3],
                        "costo"=>$ord[4],
                        "total"=>$ord[5],
                        "status"=>$ord[6],
                        "ordHora"=>$ord[7],
                        "ordHoraEnt"=>$ord[8]
                    ];

                    array_push($ordenes, $orden);
                }
                $cliente["totalOrdenes"]=$total;
                $cliente["ordenes"]=$ordenes;
                $cliente['ordenesPendientes']=$contOrdPen;

                array_push($cuentas, $cliente);
            }

echo JSON_encode($cuentas);