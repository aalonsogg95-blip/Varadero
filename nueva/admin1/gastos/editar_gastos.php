<?php

include_once "../../conexion1.php";

$idgastos=mysqli_real_escape_string($conn, $_POST['idgastos']);
$nombre=mysqli_real_escape_string($conn, $_POST['Gnombre']);
$destino=mysqli_real_escape_string($conn, $_POST['Gdestino']);
$total=mysqli_real_escape_string($conn, $_POST['Gtotal']);
$fecha=mysqli_real_escape_string($conn, $_POST['Gfecha']);
$tipo=mysqli_real_escape_string($conn, $_POST['Gtipo']);


if(!empty($nombre) && !empty($destino) && !empty($total) && !empty($fecha)){

    $sql=mysqli_query($conn, "UPDATE gastos SET gas_concepto='$nombre', gas_proveedor='$destino', gas_costo='$total', gas_fecha='$fecha', gas_tipo='$tipo' WHERE gas_id_gasto=${idgastos}");
        if($sql){
            echo "success";

        }else{
            echo "error";
        }

    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
    }
    