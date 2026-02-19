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
     
     $f=date("Y-m-d");//FECHA ACTUAL COMPLETA


// //CONTAR ORDENES
 $contOrd = mysqli_query($conexion, "SELECT count(*) from ordenes o
        inner join clientes c on
        c.cli_id_cliente=o.cli_id_cliente
 where c.cli_fecha='$f' and ord_status=1 and (ord_categoria !='Bebidas' and ord_categoria!='Licores' and ord_categoria!='Mixologia' and ord_categoria!='Cervezas')") or die 
         ("Problemas en el select 2:".mysqli_error($conexion));
         $coOrd = mysqli_fetch_array($contOrd);

echo json_encode($coOrd[0]);