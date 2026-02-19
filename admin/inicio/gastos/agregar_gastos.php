<?php
include_once "../../../conexion1.php";
// var_dump($conn);

session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];

if(!empty($usuario)){
    //VARIABLES
    $nombregasto=mysqli_real_escape_string($conn, trim($_POST['item1']));
    $proveedor=mysqli_real_escape_string($conn, trim($_POST['item2']));
    $costo=mysqli_real_escape_string($conn, trim($_POST['item3']));
    $tipogasto=mysqli_real_escape_string($conn, $_POST['item4']);
    $frecuencia=mysqli_real_escape_string($conn, trim($_POST['item5']));
    $fecha=mysqli_real_escape_string($conn, trim($_POST['item6']));
    

if(!empty($nombregasto) and !empty($proveedor) and !empty($frecuencia) and !empty($costo) and !empty($fecha) and !empty($tipogasto)){
    $sqlbuscargasto= mysqli_query($conn, "SELECT gas_concepto FROM gastos WHERE  gas_concepto='$nombregasto' and gas_proveedor='$proveedor' and gas_tipo='$tipogasto' and gas_costo='$costo' and gas_fecha='$fecha'");
    if(mysqli_num_rows($sqlbuscargasto)>0){
        echo "<p><i class='fa-solid fa-circle-exclamation'></i> Gasto ya existe</p>";
    }else{

        //AGREGAR GASTO
        $sql=mysqli_query($conn, "INSERT INTO gastos(gas_concepto, gas_proveedor, gas_frecuencia, gas_costo, gas_fecha, gas_tipo, gas_usuario) VALUES ('$nombregasto','$proveedor','$frecuencia','$costo','$fecha','$tipogasto','$usuario')");
        if($sql){
            echo "success";
        }else{
            echo "error";
        }
    }
}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i> Todos los campos son obligatorios";
}
}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i> Usuario no encontrado, inicia sesión";
}


    

