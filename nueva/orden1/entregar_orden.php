<?php
include_once "../conexion1.php";


$idorden=$_POST['ord_id_orden'];

$sql=mysqli_query($conn, "UPDATE ordenes SET ord_status=2 WHERE ord_id_orden=${idorden}");
        if($sql){
            $id=1;
        }else{
            $id=0;
        }


echo json_encode($id);