<?php

include_once "../../../conexion1.php";

//DATOS PERSONALES
$idusuario=mysqli_real_escape_string($conn, $_POST['id_usuario']);
$sta=mysqli_real_escape_string($conn, $_POST['sta']);


$sql=mysqli_query($conn, "UPDATE usuarios SET estatus_usuarios=$sta WHERE id_usuario='${idusuario}'");
if($sql){
    $id=1;
}else{
    $id=0;
}

echo json_encode($id);

