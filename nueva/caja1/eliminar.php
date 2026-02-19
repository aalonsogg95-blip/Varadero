<?php
//INCLUIR CONEXION 
include_once '../conexion1.php';


$tipo=$_POST['tipo'];

if($tipo=="cuenta"){
    $idcliente=$_POST['idcliente'];

    //ELIMINAR CATEGORIA
    mysqli_query($conn, "DELETE clientes FROM clientes
                    WHERE cli_id_cliente='$idcliente'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);
}else if($tipo=="orden"){
    $idorden=$_POST['ord_id_orden'];

    //ELIMINAR CATEGORIA
    mysqli_query($conn, "DELETE ordenes FROM ordenes
                    WHERE ord_id_orden='$idorden'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);
}

 

   


 echo json_encode($numFilasAfectadas);