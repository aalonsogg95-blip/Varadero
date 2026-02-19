<?php
//INCLUIR ARCHIVO DE CONEXION
require '../../conexion.php';
//PASAR CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8");
///////////////////////////////////////////

///VARIABLE
$envio=$_POST['env'];

//MODIFICAR
mysqli_query($conexion, "UPDATE envio SET
                env_costo='$envio'");