<?php
include_once "../conexion1.php";


$sql= mysqli_query($conn, "SELECT count(*) as total FROM clientes 
inner join ordenes on 
ordenes.cli_id_cliente = clientes.cli_id_cliente
 WHERE ord_status=1");
if($sql){
    $fila = mysqli_fetch_assoc($sql);

    // Obtener el valor del contador
    $contador = $fila['total'];

}


echo json_encode($contador);



// //////////////////////////////////////////
// //INLCUIR ARCHIVO A LA CONEXION
// require '../conexion.php';
// //PASAR FUNCION DE CONEXION A VARIABLE
// $conexion = conectarDB();
// $conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
// ////////////////////////////////////////////////////
// //ZONA HORARIA 
//      date_default_timezone_set('America/Mexico_City');
     
//      $f=date("Y-m-d");//FECHA ACTUAL COMPLETA


// //CONTAR ORDENES
// $contOrd = mysqli_query($conexion, "SELECT count(*) from ordenes 
//         inner join clientes on
//         clientes.id_cliente = ordenes.numcliente
//         where cli_fecha='$f'") or die 
//         ("Problemas en el select 2:".mysqli_error($conexion));
//         $coOrd = mysqli_fetch_array($contOrd);

//         //CAMBIOS DE ESTATUS
//         $contEntregado= mysqli_query($conexion, "SELECT count(*) from ordenes 
//         inner join clientes on
//         clientes.id_cliente = ordenes.numcliente
//         where cli_fecha='$f' and ord_status=2") or die 
//         ("Problemas en el select 2:".mysqli_error($conexion));
//         $coEnt = mysqli_fetch_array($contEntregado);

//         $count=$coOrd[0]+$coEnt[0];
        

// echo json_encode(intval($count));