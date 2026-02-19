<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////


$mes=$_POST['fieldMes'];
$anual=$_POST['fieldAnual'];
$fecha=$_POST['fieldFecha'];
$period=$_POST['period'];
// $usuario=$_POST['usuario'];

$gastos=array();
//VALIDAR EL TIPO DE CONSULTA
//VALIDAR POR USUARIO
    // if($usuario=="julissa"){
        if($period==1){
            //POR FECHA
            $mostrarGastos = mysqli_query($conexion, "SELECT * from gastos where 
            gas_fecha='$fecha'") or die ("Problemas en el select 2:".mysqli_error($conexion));
                    while($mosGas=mysqli_fetch_row($mostrarGastos)){
        
                            // $hor= date("g:i A", strtotime($clienOrde[3]));
                                $gasto=[
                                    "idgasto"=>$mosGas[0],
                                    "concepto"=>$mosGas[1],
                                    "proveedor"=>$mosGas[2],
                                    "frecuencia"=>$mosGas[3],
                                    "costo"=>$mosGas[4],
                                    "fecha"=>$mosGas[5],
                                    "user"=>$mosGas[6],
                                    "fechaformat"=>date("d/m/Y", strtotime($mosGas[5]))
                                ];
        
                                array_push($gastos, $gasto);
                            }
        }else{
            //POR MES
            $mostrarGastos = mysqli_query($conexion, "SELECT * from gastos where 
            MONTH(gas_fecha)='$mes' and YEAR(gas_fecha)='$anual' order by gas_fecha desc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                    while($mosGas=mysqli_fetch_row($mostrarGastos)){
        
                            // $hor= date("g:i A", strtotime($clienOrde[3]));
                                $gasto=[
                                    "idgasto"=>$mosGas[0],
                                    "concepto"=>$mosGas[1],
                                    "proveedor"=>$mosGas[2],
                                    "frecuencia"=>$mosGas[3],
                                    "costo"=>$mosGas[4],
                                    "fecha"=>$mosGas[5],
                                    "user"=>$mosGas[6],
                                    "fechaformat"=>date("d/m/Y", strtotime($mosGas[5]))
                                ];
        
                                array_push($gastos, $gasto);
        
                            }
        }
    //  }else{
    //     if($period==1){
    //         //POR FECHA
    //         $mostrarGastos = mysqli_query($conexion, "SELECT * from gastos where 
    //         gas_fecha='$fecha' and gas_usuario='$usuario'") or die ("Problemas en el select 2:".mysqli_error($conexion));
    //                 while($mosGas=mysqli_fetch_row($mostrarGastos)){
        
    //                         // $hor= date("g:i A", strtotime($clienOrde[3]));
    //                             $gasto=[
    //                                 "idgasto"=>$mosGas[0],
    //                                 "concepto"=>$mosGas[1],
    //                                 "proveedor"=>$mosGas[2],
    //                                 "frecuencia"=>$mosGas[3],
    //                                 "costo"=>$mosGas[4],
    //                                 "fecha"=>$mosGas[5],
    //                                 "fechaformat"=>date("d/m/Y", strtotime($mosGas[5]))
    //                             ];
        
    //                             array_push($gastos, $gasto);
    //                         }
    //     }else{
    //         //POR MES
    //         $mostrarGastos = mysqli_query($conexion, "SELECT * from gastos where 
    //         MONTH(gas_fecha)='$mes' and YEAR(gas_fecha)='$anual' and gas_usuario='$usuario' order by gas_fecha desc") or die ("Problemas en el select 2:".mysqli_error($conexion));
    //                 while($mosGas=mysqli_fetch_row($mostrarGastos)){
        
    //                         // $hor= date("g:i A", strtotime($clienOrde[3]));
    //                             $gasto=[
    //                                 "idgasto"=>$mosGas[0],
    //                                 "concepto"=>$mosGas[1],
    //                                 "proveedor"=>$mosGas[2],
    //                                 "frecuencia"=>$mosGas[3],
    //                                 "costo"=>$mosGas[4],
    //                                 "fecha"=>$mosGas[5],
    //                                 "fechaformat"=>date("d/m/Y", strtotime($mosGas[5]))
    //                             ];
        
    //                             array_push($gastos, $gasto);
        
    //                         }
    //     }
    // }




 echo json_encode($gastos);