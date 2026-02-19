<?php
include_once "../../../conexion1.php";

//VARIABLES
$mes=$_POST['mes'];
$anual=$_POST['anual'];

$sql=mysqli_query($conn, "SELECT * FROM clientes where cli_eliminado=1 and MONTH(cli_fecha)='$mes' and YEAR(cli_fecha)='$anual'");
$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

        //CARGAR DETALLES VENTAS
        $ordenes=array();
        $sql2= mysqli_query($conn, "SELECT * FROM ordenes WHERE  cli_id_cliente='$row[cli_id_cliente]'");
        while ($row2 = mysqli_fetch_assoc($sql2)) {
            $ordenes[]=$row2;
        }
        $row["ordenes"]=$ordenes;

    $output[] = $row;
}

echo json_encode($output);