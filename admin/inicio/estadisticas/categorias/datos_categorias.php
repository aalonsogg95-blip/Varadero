<?php
//INCLUIR CONEXION 
include_once "../../../../conexion1.php";

//VARIABLES
$mes=$_POST["mes"];
$anual=$_POST['anual'];



$categorias=array();
$cantidades=array();

$sqlclientes=mysqli_query($conn, "SELECT categoria, COUNT(*) as cantidad
                FROM his_clientes c
                INNER JOIN his_ventas v ON v.hisc_id_histoClientes = c.hisc_id_histoClientes
                WHERE  month(c.fecha) = '$mes' 
                AND year(c.fecha) = '$anual'
                GROUP BY categoria
                ORDER BY cantidad DESC");
    while ($row = mysqli_fetch_assoc($sqlclientes)) {
        $categorias[]=$row["categoria"];
        $cantidades[]=$row["cantidad"];
    }


 $output=array($categorias, $cantidades);
echo json_encode($output);