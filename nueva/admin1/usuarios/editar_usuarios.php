<?php

include_once "../../conexion1.php";

$idusuario=mysqli_real_escape_string($conn, $_POST['idusuario']);
$nombre=mysqli_real_escape_string($conn, $_POST['Unombre']);
$contrasena=mysqli_real_escape_string($conn, $_POST['Ucontrasena']);
$area=mysqli_real_escape_string($conn, $_POST['Uarea']);



if(!empty($nombre) && !empty($contrasena) && !empty($area)){

    $sql=mysqli_query($conn, "UPDATE sesion SET ses_usuario='$nombre', ses_contrasena='{$contrasena}', ses_area='{$area}' WHERE ses_id_sesion=${idusuario}");
        if($sql){
            echo "success";

        }else{
            echo "error";
        }

    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
    }
    