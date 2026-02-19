<?php

include_once "../../conexion1.php";
$nombre=mysqli_real_escape_string($conn, $_POST['Gnombre']);
$destino=mysqli_real_escape_string($conn, $_POST['Gdestino']);
$total=mysqli_real_escape_string($conn, $_POST['Gtotal']);
$fecha=mysqli_real_escape_string($conn, $_POST['Gfecha']);

session_start();
$usuario= $_SESSION["datosUsuarioCaja"]["usuario"];

if(!empty($nombre) && !empty($destino) && !empty($total) && !empty($fecha)){

        $sql2=mysqli_query($conn, "INSERT INTO gastos (gas_concepto, gas_proveedor, gas_frecuencia, gas_costo, gas_fecha) VALUES ('{$nombre}','{$destino}', 'No especificar', '{$total}', '${fecha}')");
        if($sql2){
            echo "success";
        }else{
            echo "error";
        }
        
}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}

