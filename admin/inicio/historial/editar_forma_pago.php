<?php

include_once "../../../conexion1.php";

//DATOS PERSONALES
$idcliente=mysqli_real_escape_string($conn, $_POST['hisc_id_histoClientes']);
$formapago=mysqli_real_escape_string($conn, $_POST['selectForma']);


        $sql=mysqli_query($conn, "UPDATE his_clientes SET forma_pago='$formapago' WHERE hisc_id_histoClientes='${idcliente}'");
        if($sql){
            $id=1;
        }else{
            $id=0;
        }

    echo json_encode($id);

