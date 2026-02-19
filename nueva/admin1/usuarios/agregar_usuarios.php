<?php

include_once "../../conexion1.php";
$nombre=mysqli_real_escape_string($conn, $_POST['Unombre']);
$contrasena=mysqli_real_escape_string($conn, $_POST['Ucontrasena']);
$area=mysqli_real_escape_string($conn, $_POST['Uarea']);


if(!empty($nombre) && !empty($contrasena) && !empty($area)){

    $sql= mysqli_query($conn, "SELECT ses_usuario FROM sesion WHERE ses_usuario='{$nombre}' and ses_area='$area'");
        if(mysqli_num_rows($sql)>0){//IF EMAIL ALREADY EXIST
            echo "$nombre - Usuario ya existe!";
        }else{
            $sql2=mysqli_query($conn, "INSERT INTO sesion (ses_usuario, ses_contrasena, ses_area) VALUES ('{$nombre}', '${contrasena}', '${area}')");
            if($sql2){
                echo "success";
            }else{
                echo "error";
            }
        }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}

