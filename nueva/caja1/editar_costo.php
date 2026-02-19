<?php
//INCLUIR CONEXION 
include_once '../conexion1.php';


$idorden=$_POST['id_orden_ordenes'];
$costo=$_POST['costo'];
$cantidad=$_POST['cantidad_ordenes'];

$total=$costo*$cantidad;

$sql=mysqli_query($conn, "UPDATE ordenes SET ord_costo='$costo', ord_total='${total}' WHERE ord_id_orden=${idorden}");
        if($sql){
            $id=1;

        }else{
            $id=0;
        }

echo json_encode($id);