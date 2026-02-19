<?php

include_once "../../conexion1.php";

$idproducto=mysqli_real_escape_string($conn, $_POST['id_producto_productos']);
$num=mysqli_real_escape_string($conn, $_POST['num']);







    $sql=mysqli_query($conn, "UPDATE productos1 SET status_productos=$num WHERE id_producto_productos=${idproducto}");
        

    