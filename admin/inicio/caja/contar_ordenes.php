<?php
include_once "../../../conexion1.php";


$sql= mysqli_query($conn, "SELECT count(*) as total FROM clientes 
inner join ordenes on 
ordenes.cli_id_cliente = clientes.cli_id_cliente
 WHERE ord_status=1");
if($sql){
    $fila = mysqli_fetch_assoc($sql);

    // Obtener el valor del contador
    $contador = $fila['total'];

}


echo json_encode($contador);

