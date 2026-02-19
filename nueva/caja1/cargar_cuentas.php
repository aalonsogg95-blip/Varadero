<?php
include_once "../conexion1.php";
session_start();



$sql= mysqli_query($conn, "SELECT * FROM clientes order by cli_id_cliente desc");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

    $ordenes=array();
    $sql1= mysqli_query($conn, "SELECT * FROM ordenes WHERE  cli_id_cliente='$row[cli_id_cliente]'");
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        $ordenes[]=$row1;
    }
     $row["ordenes"]=$ordenes;



     $output[] = $row;
}

echo json_encode($output);