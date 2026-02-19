<?php

//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLES
$pro=$_POST['pro'];
$cat=$_POST['cat'];
$cos=$_POST['cos'];
$sta=$_POST['sta'];
$fec=$_POST['fec'];



if( preg_match('/^[a-zA-Z0-9ñáéíóúÁÉÍÓÚ ]+$/', $cat) and preg_match('/^[a-zA-Z0-9ñáéíóúÁÉÍÓÚ ]+$/', $sta)){

 //INSERTAR DATOS DEL CLIENTE
    $conexion->query("insert into productos(pro_producto, pro_categoria, pro_costo, pro_fecha,pro_status) 
                  values ('$pro','$cat','$cos','$fec','$sta')"); 
    $idpro=mysqli_insert_id($conexion);

}else{
    $idpro=0;
    
}


echo json_encode($idpro);