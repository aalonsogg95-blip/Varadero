<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES

//CONTAR ORDENES
$envio = mysqli_query($conexion, "SELECT env_costo from envio") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $env= mysqli_fetch_array($envio);

echo json_encode($env[0]);