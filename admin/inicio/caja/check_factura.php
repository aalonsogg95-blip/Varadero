<?php

include_once "../../../conexion1.php";

//DATOS PERSONALES
$idcliente=mysqli_real_escape_string($conn, $_POST['cli_id_cliente']);
$factura=mysqli_real_escape_string($conn, $_POST['factura']);


        $sql=mysqli_query($conn, "UPDATE clientes SET cli_factura=$factura WHERE cli_id_cliente='${idcliente}'");
        if($sql){
            $id=1;
        }else{
            $id=0;
        }

    echo json_encode($id);

