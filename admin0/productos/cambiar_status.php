<?php

//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////


$id=$_POST['id'];
$sta=$_POST['sta'];

if($sta==0){
    $sta=1;
}else{
    $sta=0;
}


 mysqli_query($conexion, "UPDATE productos SET
    pro_status=$sta WHERE pro_id_producto=$id LIMIT 1");