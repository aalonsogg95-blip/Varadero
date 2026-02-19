<?php
//INCLUIR CONEXION 
include_once '../../../conexion1.php';


 $idcliente=$_POST['hisc_id_histoClientes'];

    //ELIMINAR CUENTA 
    mysqli_query($conn, "DELETE his_clientes FROM his_clientes
                    WHERE hisc_id_histoClientes='$idcliente'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);
    if($numFilasAfectadas>0){
        //ELIMINAR FACTURA SOLO SI HAY
            mysqli_query($conn, "DELETE facturas FROM facturas
                    WHERE id_histoClientes_facturas='$idcliente'"); 
    }

 echo json_encode($numFilasAfectadas);