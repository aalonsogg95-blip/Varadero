<?php
//INCLUIR CONEXION 
include_once '../../../conexion1.php';


 $idcliente=$_POST['cli_id_cliente'];

    //ELIMINAR CUENTAS
    mysqli_query($conn, "DELETE clientes FROM clientes
                    WHERE cli_id_cliente='$idcliente'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

 echo json_encode($numFilasAfectadas);