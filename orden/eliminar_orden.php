<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////

$id=$_POST['id'];


//ACTUALIZAR STATUS A 0 CANCELADO
// mysqli_query($conexion, "UPDATE ordenes SET
//                 ord_status=4 WHERE ord_id_orden='$id' LIMIT 1");




//OBSERVACIONES
//SI LA ORDEN CONTIENE OBSERVACIONES, ELIMINARLAS
$contObservaciones = mysqli_query($conexion, "SELECT count(*) from ordenes o
        inner join clientes c on
        c.cli_id_cliente = o.cli_id_cliente
        inner join observaciones ob on
        ob.ord_id_orden=o.ord_id_orden
        where o.ord_id_orden='$id'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coObs = mysqli_fetch_array($contObservaciones);

        if($coObs[0]>0){
                mysqli_query($conexion, "DELETE observaciones
                     FROM observaciones WHERE ord_id_orden='$id'"); 
        }

//ELIMINAR ORDEN
    mysqli_query($conexion, "DELETE ordenes
            FROM ordenes WHERE ord_id_orden='$id'");


// //ELIMINAR OBSERVACIONES DE ORDEN
// mysqli_query($conexion, "DELETE observaciones
//             FROM observaciones WHERE ord_id_orden='$id'");


//VALIDAR ORDEN ELIMINADA
$contOrd = mysqli_query($conexion, "SELECT count(*) from ordenes where ord_id_orden='$id' limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coOrd = mysqli_fetch_array($contOrd);

echo json_encode($coOrd[0]);

