<?php

include_once "../../../conexion1.php";

//DATOS PERSONALES
$idfactura=mysqli_real_escape_string($conn, $_POST['id_factura']);



        $sql=mysqli_query($conn, "UPDATE facturas SET status_facturas=1 WHERE id_factura='${idfactura}'");
        if($sql){
            $id=1;
        }else{
            $id=0;
        }

    echo json_encode($id);

