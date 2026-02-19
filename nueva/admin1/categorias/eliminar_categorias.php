<?php
//INCLUIR CONEXION 
include_once '../../conexion1.php';


 $idcategoria=$_POST['id_categoria_categorias'];

    //ELIMINAR CATEGORIA
    mysqli_query($conn, "DELETE categorias FROM categorias
                    WHERE id_categoria_categorias='$idcategoria'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

   


 echo json_encode($numFilasAfectadas);