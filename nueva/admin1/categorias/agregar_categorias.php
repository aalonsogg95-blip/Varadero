<?php

include_once "../../conexion1.php";
$nombre=mysqli_real_escape_string($conn, $_POST['Cnombre']);
$tipo=mysqli_real_escape_string($conn, $_POST['Ctipo']);
$color=mysqli_real_escape_string($conn, $_POST['Ccolor']);


if(!empty($nombre) and !empty($tipo)){

    $sql= mysqli_query($conn, "SELECT nombre_categorias FROM categorias WHERE nombre_categorias='{$nombre}' and tipo_categorias='{$tipo}'");
        if(mysqli_num_rows($sql)>0){//IF EMAIL ALREADY EXIST
            echo "$nombre - Categoría ya existe!";
        }else{
            $sql2=mysqli_query($conn, "INSERT INTO categorias (nombre_categorias, tipo_categorias, color_categorias) VALUES ('{$nombre}','{$tipo}','{$color}')");
            if($sql2){
                echo "success";
            }else{
                echo "error";
            }
        }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}

