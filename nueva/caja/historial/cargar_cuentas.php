<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////
//ZONA HORARIA 
date_default_timezone_set('America/Mexico_City');
     
// $f=date("Y-m-d");//FECHA ACTUAL COMPLETA
$f=$_POST['fieldFecha'];
////////////////////////////////////////////////////

     //CARGAR VENTAS
     $ventas=array();
     $hisclientes = mysqli_query($conexion, "SELECT * from his_clientes where fecha='$f'  order by hisc_id_histoClientes desc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                 while($hisc=mysqli_fetch_row($hisclientes)){
     
                    $totalVenta=$hisc[3]+$hisc[4];
     
                     $cliente=[
                         "idhistocliente"=>$hisc[0],
                         "consumo"=>$hisc[1],
                         "lugar"=>$hisc[2],
                         "totalVenta"=>$totalVenta,
                         "envio"=>$hisc[4],
                         "horaped"=>$hisc[5],
                         "fecha"=>$f,
                         "hora"=>date("h:i a", strtotime($hisc[5])),
                     ];


                    //VARIABLES
                $ordenes=[];

                //ORDENES
                    $mostrarOrdenes = mysqli_query($conexion, "SELECT hisv_id_histoVentas,categoria, producto, cantidad, costo, total,tiempo_entrega from his_ventas
                where hisc_id_histoClientes='$hisc[0]' order by hisv_id_histoVentas asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                while($ord=mysqli_fetch_row($mostrarOrdenes)){

                    $minutes = $ord[6];
                    $zero    = new DateTime('@0');
                    $offset  = new DateTime('@' . $minutes * 60);
                    $diff    = $zero->diff($offset);
                    $tiempo=$diff->format('%h h, %i min');

                    $orden=[
                        "hisv_id_histoVentas"=>$ord[0],
                        "categoria"=>$ord[1],
                        "producto"=>$ord[2],
                        "cantidad"=>$ord[3],
                        "costo"=>$ord[4],
                        "total"=>$ord[5],
                        "tiempoEntrega"=>$tiempo,
                    ];

                    array_push($ordenes, $orden);
                }
                
                 $cliente["ordenes"]=$ordenes;

             array_push($ventas, $cliente);
        }


echo JSON_encode($ventas);