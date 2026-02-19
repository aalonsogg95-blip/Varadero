<?php
//INCLUIR CONEXION 
include_once '../../../conexion1.php';


 $idproducto=$_POST['id_producto'];

    //ELIMINAR PRODUCTOS
    mysqli_query($conn, "DELETE productos FROM productos
                    WHERE pro_id_producto='$idproducto'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

 echo json_encode($numFilasAfectadas);