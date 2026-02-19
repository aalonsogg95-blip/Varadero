<?php

include_once "../../conexion1.php";

$sql=mysqli_query($conn, "SELECT * FROM sesion where ses_usuario!='admin' order by ses_id_sesion desc");

$output = array();

while ($row = mysqli_fetch_assoc($sql)) {

     $output[] = $row;
}

echo json_encode($output);