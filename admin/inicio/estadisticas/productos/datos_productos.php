<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];


$productos=array();
$cantidades=array();

$sqlproductos=mysqli_query($conn, "SELECT categoria, producto, SUM(cantidad) as cantidad_vendido
                            FROM his_clientes c
                            INNER JOIN his_ventas v ON v.hisc_id_histoClientes = c.hisc_id_histoClientes
                            WHERE month(c.fecha) = '$mes' 
                            AND year(c.fecha) = '$anual' 
                            AND (categoria='Bebidas' 
                                OR categoria='Licores' 
                                OR categoria='Mixología' 
                                OR categoria='Cervezas')
                            GROUP BY categoria, producto
                            ORDER BY cantidad_vendido DESC");
    while ($row = mysqli_fetch_assoc($sqlproductos)) {
        $productos[]=$row["categoria"]." ".$row["producto"];
        $cantidades[]=$row["cantidad_vendido"];
    }


 $output=array($productos, $cantidades);
echo json_encode($output);