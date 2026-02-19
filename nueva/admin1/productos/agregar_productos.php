<?php

include_once "../../conexion1.php";
$nombre=mysqli_real_escape_string($conn, $_POST['Pnombre']);
$categoria=mysqli_real_escape_string($conn, $_POST['Pcategoria']);
$area=mysqli_real_escape_string($conn, $_POST['Parea']);
$costo=mysqli_real_escape_string($conn, $_POST['Pcosto']);




if(!empty($nombre) && !empty($categoria) && !empty($area) && !empty($costo)){

    $sql= mysqli_query($conn, "SELECT nombre_productos FROM productos1 
    WHERE nombre_productos='{$nombre}' and id_categoria_productos='{$categoria}'
    ");
        if(mysqli_num_rows($sql)>0){//IF EMAIL ALREADY EXIST
            echo "$nombre - Este producto ya existe!";
        }else{
            $sql2=mysqli_query($conn, "INSERT INTO productos1 (nombre_productos, id_categoria_productos, costo_productos, status_productos, area_productos) VALUES ('{$nombre}','{$categoria}', '$costo', 1,'${area}')");
            if($sql2){
                echo "success";
            }else{
                echo "error";
            }
        }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}

