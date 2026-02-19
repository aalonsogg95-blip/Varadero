<?php
//INCLUIR CONEXION 
include_once '../../conexion1.php';



    $idhistorial=$_POST['hisc_id_histoClientes'];

    //ELIMINAR CATEGORIA
    mysqli_query($conn, "DELETE his_clientes FROM his_clientes
                    WHERE hisc_id_histoClientes='$idhistorial'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);



 echo json_encode($numFilasAfectadas);