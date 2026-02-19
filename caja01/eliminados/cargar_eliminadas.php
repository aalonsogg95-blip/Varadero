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
     
$f=date("Y-m-d");//FECHA ACTUAL COMPLETA

////////////////////////////////////////////////////

     //CARGAR CUENTAS ELIMINADAS, (CUENTA COMPLETA)
      $cuentas=array();
     $eliminados = mysqli_query($conexion, "SELECT * from clientes_eliminados  order by eli_fecha desc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                 while($eli=mysqli_fetch_row($eliminados)){
     
     
                     $clienteeliminado=[
                         "idclienteeliminado"=>$eli[0],
                         "consumo"=>$eli[1],
                         "lugar"=>$eli[2],
                         "horapedido"=>date("h:i A", strtotime($eli[3])),
                         "horaeliminado"=>date("h:i A", strtotime($eli[4])),
                         "fecha"=>date("d/m/y", strtotime($eli[5])),
                         "tipo"=>"Completa",
                         "fechaf"=>$eli[5]
                         
                     ];

                     //VARIABLES
                $ordenes=[];
                $total=0;

                
                //COMPROBAR QUE SI HAYA ORDENES
                $busOrden = mysqli_query($conexion, "SELECT count(*) from ordenes where cli_id_cliente='$eli[0]'") or die ("Problemas en el select 2:".mysqli_error($conexion));
                $bOrd = mysqli_fetch_array($busOrden);

                if($bOrd[0]>0){
                    /////////////////////////
                    //ORDENES
                    //ORDENES QUE SE ELIMINARON ANTES PRECIONAR EL BOTON PAGAR
                    $mostrarOrdenes = mysqli_query($conexion, "SELECT ord_id_orden, ord_categoria, ord_producto, ord_cantidad, ord_costo,ord_total,ord_status,ord_hora,ord_horaEntrega,ord_usuario from ordenes
                    where cli_id_cliente='$eli[0]' and ord_status=0 order by ord_id_orden asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                    while($ord=mysqli_fetch_row($mostrarOrdenes)){
                        $total+=$ord[5];

                        $orden=[
                            "idorden"=>$ord[0],
                            "categoria"=>$ord[1],
                            "producto"=>$ord[2],
                            "cantidad"=>$ord[3],
                            "costo"=>$ord[4],
                            "total"=>$ord[5],
                            "status"=>$ord[6],
                            "ordHora"=>$ord[7],
                            "ordHoraEnt"=>$ord[8],
                            "usuario"=>$ord[9]
                        ];

                        array_push($ordenes, $orden);
                    }
                    $clienteeliminado["totalOrdenes"]=$total;
                }else{
                    //////////////////////////////////
                    //ORDENES_HISELIMINADAS
                    //ORDENES QUE SE ELIMINARON DESDE EL HISTORIAL DE VENTAS
                    $totalh=0;
                    $mostrarOrdeneshis = mysqli_query($conexion, "SELECT ordeli_categoria, ordeli_producto, ordeli_cantidad, ordeli_costo,ordeli_total from ordenes_hiseliminadas
                    where hisc_id_histoClientes='$eli[0]' order by hisv_id_histoVentas asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                    while($ordh=mysqli_fetch_row($mostrarOrdeneshis)){
                        $totalh+=$ordh[4];

                        $ordenh=[
                            "categoria"=>$ordh[0],
                            "producto"=>$ordh[1],
                            "cantidad"=>$ordh[2],
                            "costo"=>$ordh[3],
                            "total"=>$ordh[4],
                            "status"=>0,
                            "ordHora"=>"",
                            "ordHoraEnt"=>"",
                            "usuario"=>"NA"
                        ];

                        array_push($ordenes, $ordenh);
                    }
                    $clienteeliminado["totalOrdenes"]=$totalh;
                }
                           

                $clienteeliminado["ordenes"]=$ordenes;
                array_push($cuentas, $clienteeliminado);
        }



        ////////////////////////////////////////////////////
        //CARGAR CUENTAS ELIMINADAS, (CUENTA SEPARADA)
        //ORDENES QUE SE ELIMINAN POR SEPARADO
        $ordeliminados = mysqli_query($conexion, "SELECT * from clientes_ordeliminadas
          order by id_clienteOrdEliminada asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                 while($eliord=mysqli_fetch_row($ordeliminados)){
     
     
                     $clienteordeliminado=[
                         "idclienteeliminado"=>$eliord[0],
                         "consumo"=>$eliord[1],
                         "lugar"=>$eliord[2],
                         "horapedido"=>date("h:i A", strtotime($eliord[3])),
                         "horaeliminado"=>date("h:i A", strtotime($eliord[4])),
                         "fecha"=>date("d/m/y", strtotime($eliord[5])),
                         "fechaf"=>$eliord[5],
                         "tipo"=>"Separado"
                         
                     ];

                     //VARIABLES
                $ordenes=[];
                $total=0;

                //ORDENES
                    $mostrarOrdenes = mysqli_query($conexion, "SELECT ord_id_orden, ord_categoria, ord_producto, ord_cantidad, ord_costo,ord_total,ord_status,ord_hora,ord_horaEntrega,ord_usuario from ordenes
                where cli_id_cliente='$eliord[0]' and ord_status=0 order by ord_id_orden asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                while($ord=mysqli_fetch_row($mostrarOrdenes)){
                    $total+=$ord[5];

                    $orden=[
                        "idorden"=>$ord[0],
                        "categoria"=>$ord[1],
                        "producto"=>$ord[2],
                        "cantidad"=>$ord[3],
                        "costo"=>$ord[4],
                        "total"=>$ord[5],
                        "status"=>$ord[6],
                        "ordHora"=>$ord[7],
                        "ordHoraEnt"=>$ord[8],
                        "usuario"=>$ord[9]
                    ];

                    array_push($ordenes, $orden);
                }
                $clienteordeliminado["totalOrdenes"]=$total;
                $clienteordeliminado["ordenes"]=$ordenes;

                array_push($cuentas, $clienteordeliminado);
        }




echo JSON_encode($cuentas);