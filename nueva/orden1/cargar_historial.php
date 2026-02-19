<?php

include_once "../conexion1.php";

$sql=mysqli_query($conn, "SELECT * FROM clientes order by cli_id_cliente desc");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

        //ORDENES
        $ordenes=[];
        $sql1=mysqli_query($conn, "SELECT * FROM ordenes
          WHERE cli_id_cliente='$row[cli_id_cliente]'");
          while ($row_orden = mysqli_fetch_assoc($sql1)) {
               $ordenes[] = $row_orden;
          }


     $row["ordenes"]=$ordenes;
     $output[] = $row;
}

echo json_encode($output);