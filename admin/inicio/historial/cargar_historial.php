<?php
include_once "../../../conexion1.php";

$fecha=$_POST['campofechabuscar'];

session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];

$sql=mysqli_query($conn, "SELECT * FROM his_clientes where fecha='$fecha' and cortesia =0");
$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

    //CARGAR DETALLES DE FACTURA
    $sqlFact= mysqli_query($conn, "SELECT iva_facturas FROM facturas WHERE  id_histoClientes_facturas='$row[hisc_id_histoClientes]'");
    $factura = mysqli_fetch_assoc($sqlFact);
    $row["iva_facturas"] = $factura["iva_facturas"] ?? 0;


    //CARGAR DETALLES VENTAS
    $ordenes=array();
    $sql1= mysqli_query($conn, "SELECT * FROM his_ventas WHERE  hisc_id_histoClientes='$row[hisc_id_histoClientes]'");
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        $ordenes[]=$row1;
    }
    $row["ordenes"]=$ordenes;
    

    $output[] = $row;
}



///OBTENER EL TOTAL DEL GASTOS
$sqlGas= mysqli_query($conn, "SELECT sum(gas_costo) as total FROM gastos WHERE  gas_usuario='$usuario' and gas_fecha='$fecha'");
$gasto = mysqli_fetch_assoc($sqlGas);
$gastos = $gasto["total"] ?? 0;




$datos=[$output, $gastos];

echo json_encode($datos);