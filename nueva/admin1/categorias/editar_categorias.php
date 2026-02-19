<?php

include_once "../../conexion1.php";

$idcategoria=mysqli_real_escape_string($conn, $_POST['idcategoria']);
$nombre=mysqli_real_escape_string($conn, $_POST['Cnombre']);
$tipo=mysqli_real_escape_string($conn, $_POST['Ctipo']);
$color=mysqli_real_escape_string($conn, $_POST['Ccolor']);



if(!empty($nombre)){

    $sql=mysqli_query($conn, "UPDATE categorias SET nombre_categorias='$nombre', tipo_categorias='$tipo', color_categorias='$color' WHERE id_categoria_categorias=${idcategoria}");
        if($sql){
            echo "success";

        }else{
            echo "error";
        }

    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
    }
    