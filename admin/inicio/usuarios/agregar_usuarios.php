<?php
include_once "../../../conexion1.php";



// Obtener fecha actual
date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');

//VARIABLES
$usuario=mysqli_real_escape_string($conn, $_POST['item1']);
$contrasena=mysqli_real_escape_string($conn, $_POST['item2']);
$area=mysqli_real_escape_string($conn, $_POST['item3']);


if(!empty($usuario) and !empty($contrasena) and !empty($area)){
    //BUSCAR USUARIO
    $sqlpro= mysqli_query($conn, "SELECT nombre_usuarios FROM usuarios WHERE  nombre_usuarios='$usuario' and contrasena_usuarios='$contrasena'");
    if(mysqli_num_rows($sqlpro)>0){
        echo "<p><i class='fa-solid fa-circle-exclamation'></i> Usuario ya existe</p>";
    }else{

        //AGREGAR PRODUCTO
        $sql2=mysqli_query($conn, "INSERT INTO usuarios (nombre_usuarios, contrasena_usuarios, area_usuarios, estatus_usuarios, acceso_usuarios) VALUES ('$usuario','$contrasena','$area',1, '0000-00-00 00:00:00')");
        if($sql2){
            echo "success";
        }else{
            echo "error";
        }
    }     
}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i> Todos los campos son obligatorios";
}