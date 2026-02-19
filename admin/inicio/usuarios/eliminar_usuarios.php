<?php
//INCLUIR CONEXION 
include_once '../../../conexion1.php';


 $idusuario=$_POST['id_usuario'];

    //ELIMINAR PRODUCTOS
    mysqli_query($conn, "DELETE usuarios FROM usuarios
                    WHERE id_usuario='$idusuario'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

 echo json_encode($numFilasAfectadas);