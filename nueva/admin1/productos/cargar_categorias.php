<?php

include_once "../../conexion1.php";

$sql=mysqli_query($conn, "SELECT * FROM categorias order by id_categoria_categorias desc");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {
   
    $output[] = $row;
}

echo json_encode($output);