<?php
//INCLUIR CONEXION 
include_once '../conexion1.php';

$ip = $_SERVER['REMOTE_ADDR'];


session_start();
    $usuario= $_SESSION["datosUsuarioOrdenar"]["usuario"];

    if($usuario==""){
         header("location: ../index.php");
    }


$sql= mysqli_query($conn, "SELECT count(*) as total  from actualizaciones where ip_dispositivo_actualizaciones='$ip' and status_actualizaciones=1 ");
if($sql){
    $fila = mysqli_fetch_assoc($sql);
    $contador = $fila['total'];
}
            
echo json_encode($contador);
            