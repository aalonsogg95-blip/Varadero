<?php

include_once "../conexion1.php";
//ORDEN
$objproducto=json_decode($_POST['Oproducto']);
$producto=$objproducto->nombre_productos;
$cantidad=mysqli_real_escape_string($conn, $_POST['Ocantidad']);
$total=mysqli_real_escape_string($conn, $_POST['Ototal']);
$costo=mysqli_real_escape_string($conn, $_POST['Ocosto']);
$categoria=mysqli_real_escape_string($conn, $_POST['Ocategoria']);


//CLIENTE
$consumo=mysqli_real_escape_string($conn, $_POST['consumo']);
$lugar=mysqli_real_escape_string($conn, $_POST['lugar']);
$obser=mysqli_real_escape_string($conn, $_POST['obser']);
$mesero=mysqli_real_escape_string($conn, $_POST['mesero']);

date_default_timezone_set('America/Mexico_City');
     $f=date("Y-m-d");
     $h= date("H:i:s");


if(!empty($producto) && !empty($categoria) && !empty($cantidad) && !empty($costo) && !empty($total)){

    $sql= mysqli_query($conn, "SELECT cli_id_cliente FROM clientes 
     WHERE cli_fecha='$f' and cli_consumo='$consumo' and cli_lugar='$lugar'");
        if(mysqli_num_rows($sql)>0){
            ///CLIENTE YA EXISTE
            $fila = mysqli_fetch_assoc($sql);
            $idcliente = $fila['cli_id_cliente'];

            $sql3=mysqli_query($conn, "INSERT INTO ordenes (ord_categoria, ord_producto, ord_cantidad, ord_costo, ord_total, ord_hora, ord_status, ord_horaEntrega, cli_id_cliente, ord_usuario) VALUES ('{$categoria}','{$producto}', '$cantidad', '$costo','${total}', '$h','1','00:00:00', '$idcliente', '$mesero')");
                if($sql3){
                    echo "success";
                }else{
                    echo "error";
                }

        }else{
            //EL CLIENTE NO EXISTE
            $sql2=mysqli_query($conn, "INSERT INTO clientes (cli_consumo, cli_lugar, cli_observacion, cli_hora, cli_fecha, cli_mesero) VALUES ('{$consumo}','{$lugar}', '$obser', '$h','$f', '$mesero')");
            if($sql2){
                // echo "success sql2";
              $idcliente = mysqli_insert_id($conn);
                $sql3=mysqli_query($conn, "INSERT INTO ordenes (ord_categoria, ord_producto, ord_cantidad, ord_costo, ord_total, ord_hora, ord_status, ord_horaEntrega, cli_id_cliente, ord_usuario) VALUES ('{$categoria}','{$producto}', '$cantidad', '$costo','${total}', '$h','1','00:00:00', '$idcliente', '$mesero')");
                if($sql3){
                    echo "success";
                }else{
                    echo "error";
                }
            }else{
                 echo "error";
            }
            
        }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}

