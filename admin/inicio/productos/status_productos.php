<?php

include_once "../../../conexion1.php";

//DATOS PERSONALES
$idproducto=mysqli_real_escape_string($conn, $_POST['id_producto']);
$sta=mysqli_real_escape_string($conn, $_POST['sta']);


        $sql=mysqli_query($conn, "UPDATE productos SET pro_status=$sta WHERE pro_id_producto='${idproducto}'");
        if($sql){
            $id=1;
        }else{
            $id=0;
        }

    echo json_encode($id);

