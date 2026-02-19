<?php

include_once "../../conexion1.php";

$idproducto=mysqli_real_escape_string($conn, $_POST['idproducto']);
$nombre=mysqli_real_escape_string($conn, $_POST['Pnombre']);
$idcategoria=mysqli_real_escape_string($conn, $_POST['Pcategoria']);
$area=mysqli_real_escape_string($conn, $_POST['Parea']);
$costo=mysqli_real_escape_string($conn, $_POST['Pcosto']);


if(!empty($nombre) && !empty($idcategoria) && !empty($area)){

    $sql=mysqli_query($conn, "UPDATE productos1 SET nombre_productos='$nombre', id_categoria_productos='$idcategoria', area_productos='$area', costo_productos='$costo' WHERE id_producto_productos=${idproducto}");
        if($sql){
            echo "success";

        }else{
            echo "error";
        }

    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
    }
    