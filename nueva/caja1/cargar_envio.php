<?php
include_once "../conexion1.php";
session_start();


$sql= mysqli_query($conn, "SELECT env_costo FROM envio");
$output = array();

while ($row = mysqli_fetch_assoc($sql)) {
     $output[] = $row;
}

echo json_encode($output);