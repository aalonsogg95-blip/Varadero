<?php

//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////


$idpro=$_POST['id'];

//ELIMINAR CLIENTE
mysqli_query($conexion, "DELETE productos FROM productos
                WHERE pro_id_producto='$idpro'"); 



//VALIDAR PRODUCTO ELIMINADO
$contPro = mysqli_query($conexion, "select count(*) from productos where pro_id_producto='$idpro' limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);

echo json_encode($coPro[0]);