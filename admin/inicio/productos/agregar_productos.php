<?php
include_once "../../../conexion1.php";



// Obtener fecha actual
date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');

//DVARIABLES
$nombre=mysqli_real_escape_string($conn, $_POST['item1']);
$categoria=mysqli_real_escape_string($conn, $_POST['item2']);
$costoventa=mysqli_real_escape_string($conn, $_POST['item3']);


if(!empty($nombre) and !empty($costoventa) and !empty($categoria)){
    //BUSCAR PRODUCTO
    $sqlpro= mysqli_query($conn, "SELECT pro_producto FROM productos WHERE  pro_producto='$nombre' and pro_categoria='$categoria'");
    if(mysqli_num_rows($sqlpro)>0){
        echo "<p><i class='fa-solid fa-circle-exclamation'></i> Producto ya existe</p>";
    }else{

        //AGREGAR PRODUCTO
        $sql2=mysqli_query($conn, "INSERT INTO productos (pro_producto, pro_categoria, pro_costo, pro_fecha, pro_status) VALUES ('$nombre','$categoria','$costoventa','$fecha',1)");
        if($sql2){
            echo "success";
        }else{
            echo "error";
        }
    }     
}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i> Todos los campos son obligatorios";
}