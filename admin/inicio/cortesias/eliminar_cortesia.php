<?php
//INCLUIR CONEXION 
include_once '../../../conexion1.php';


 $idcliente=$_POST['hisc_id_histoClientes'];

    //ELIMINAR CORTESIAS
    mysqli_query($conn, "DELETE his_clientes FROM his_clientes
                    WHERE hisc_id_histoClientes='$idcliente'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

 echo json_encode($numFilasAfectadas);