<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////


//ELIMINAR ORDEN
    // mysqli_query($conexion, "DELETE ordenes
    //         FROM ordenes WHERE ord_status=4");


// mysqli_query($conexion, "DELETE clientes
//             FROM clientes WHERE cli_eliminado='0'");

// //ELIMINAR OBSERVACIONES DE ORDEN
// mysqli_query($conexion, "DELETE observaciones
//             FROM observaciones WHERE ord_id_orden='$id'");
