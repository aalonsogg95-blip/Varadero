<?php

include_once "../conexion1.php";

$sql=mysqli_query($conn, "SELECT * FROM productos1
where status_productos=1");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {
        $output[] = $row;

}

echo json_encode($output);