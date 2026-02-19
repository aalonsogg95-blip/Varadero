<?php
include_once "../../../conexion1.php";



$sql=mysqli_query($conn, "SELECT * FROM facturas 
inner join his_clientes on 
his_clientes.hisc_id_histoClientes=facturas.id_histoClientes_facturas
where  status_facturas=0 and cortesia =0");
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