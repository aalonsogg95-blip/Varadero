<?php
include_once "../../../conexion1.php";

//VARIABLES
$mes=$_POST['mes'];
$anual=$_POST['anual'];

$sql=mysqli_query($conn, "SELECT * FROM his_clientes where cortesia=1 and MONTH(fecha)='$mes' and YEAR(fecha)='$anual'");
$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

        //CARGAR DETALLES VENTAS
        $ordenes=array();
        $sql2= mysqli_query($conn, "SELECT * FROM his_ventas WHERE  hisc_id_histoClientes='$row[hisc_id_histoClientes]'");
        while ($row2 = mysqli_fetch_assoc($sql2)) {
            $ordenes[]=$row2;
        }
        $row["ordenes"]=$ordenes;

    $output[] = $row;
}

echo json_encode($output);