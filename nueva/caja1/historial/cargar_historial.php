<?php
include_once "../../conexion1.php";
session_start();
$usuario= $_SESSION["datosUsuarioCaja"]["usuario"];

$fecha=$_POST['fieldFecha'];

$sql= mysqli_query($conn, "SELECT * FROM his_clientes WHERE fecha='$fecha' order by hisc_id_histoClientes desc");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

    $ordenes=array();
    $sql1= mysqli_query($conn, "SELECT * FROM his_ventas WHERE hisc_id_histoClientes='$row[hisc_id_histoClientes]'");
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        $ordenes[]=$row1;
    }
    $row["ordenes"]=$ordenes;


     $output[] = $row;
}

echo json_encode($output);