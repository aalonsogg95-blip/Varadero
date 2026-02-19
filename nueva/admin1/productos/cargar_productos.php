<?php

include_once "../../conexion1.php";

$sql=mysqli_query($conn, "SELECT id_producto_productos, nombre_productos, nombre_categorias, status_productos, area_productos, costo_productos FROM productos1 
inner join categorias on 
id_categoria_productos=id_categoria_categorias order by id_producto_productos desc");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {
    $output[] = $row;
}

echo json_encode($output);