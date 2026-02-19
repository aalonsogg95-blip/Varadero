<?php

//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////


$categorias = mysqli_query($conexion, "SELECT ord_id_orden from ordenes
    where ord_categoria='Especialidades';
    ") or die ("Problemas en el select 2:".mysqli_error($conexion));
            while($cat=mysqli_fetch_row($categorias)){

                mysqli_query($conexion, "UPDATE ordenes SET
                        ord_categoria='Esp caliente' WHERE ord_id_orden='$cat[0]'");
            }