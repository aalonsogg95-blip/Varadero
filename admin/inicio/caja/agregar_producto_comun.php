<?php
session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];

include_once "../../../conexion1.php";
$idcliente=mysqli_real_escape_string($conn, $_POST['Eiditem']);
$nombre=mysqli_real_escape_string($conn, $_POST['item1']);
$cantidad=mysqli_real_escape_string($conn, $_POST['item2']);
$costo=mysqli_real_escape_string($conn, $_POST['item3']);
$total=mysqli_real_escape_string($conn, $_POST['item4']);


if(!empty($nombre) && !empty($cantidad) && !empty($costo) && !empty($total)){


            $sql2=mysqli_query($conn, "INSERT INTO ordenes (ord_categoria, ord_producto, ord_cantidad, ord_costo, ord_total, ord_hora, ord_status, ord_horaEntrega, cli_id_cliente, ord_usuario, ord_eliminado) VALUES (
                'comun', '$nombre','$cantidad', '$costo','$total','00:00:00',2,'00:00:00','$idcliente','$usuario',0
            )");
            if($sql2){
                echo "success";
            }else{
                echo "error";
            }
        

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}

