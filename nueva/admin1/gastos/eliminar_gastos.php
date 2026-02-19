<?php
//INCLUIR CONEXION 
include_once '../../conexion1.php';


 $idgasto=$_POST['id_gasto_gastos'];

    //ELIMINAR CATEGORIA
    mysqli_query($conn, "DELETE gastos FROM gastos
                    WHERE gas_id_gasto='$idgasto'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

   


 echo json_encode($numFilasAfectadas);