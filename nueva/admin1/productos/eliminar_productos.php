<?php
//INCLUIR CONEXION 
include_once '../../conexion1.php';


 $idproducto=$_POST['id_producto_productos'];

    //ELIMINAR CATEGORIA
    mysqli_query($conn, "DELETE productos FROM productos
                    WHERE id_producto_productos='$idproducto'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

   


 echo json_encode($numFilasAfectadas);