<?php

include_once "../../conexion1.php";

$sql=mysqli_query($conn, "SELECT * FROM categorias");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

    $sql2=mysqli_query($conn, "SELECT count(*) as contador FROM productos1 where id_categoria_productos='$row[id_categoria_categorias]'");
    $contador = mysqli_fetch_assoc($sql2);
    $row["contador"]=$contador["contador"];
     $output[] = $row;
}

echo json_encode($output);