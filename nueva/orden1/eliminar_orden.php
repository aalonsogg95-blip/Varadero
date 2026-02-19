<?php
//INCLUIR CONEXION 
include_once '../conexion1.php';


 $idorden=$_POST['ord_id_orden'];

    //ELIMINAR EMPLEADO
    mysqli_query($conn, "DELETE ordenes FROM ordenes
                    WHERE ord_id_orden='$idorden'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);


 echo json_encode($numFilasAfectadas);