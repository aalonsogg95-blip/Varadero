<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////


//VARIABLES
$idpro=$_POST['id'];
$col1=$_POST['col1'];
$col2=$_POST['col2'];
$col3=$_POST['col3'];
$col4=$_POST['col4'];




if(preg_match('/^[a-zA-Z0-9ñáéíóúÁÉÍÓÚ() ]+$/', $col2) and preg_match('/^[a-zA-Z0-9ñáéíóúÁÉÍÓÚ() ]+$/', $col3)){

mysqli_query($conexion, "UPDATE productos SET
                pro_producto='$col1', pro_categoria='$col2', pro_costo='$col3', pro_fecha='$col4' WHERE pro_id_producto='$idpro' LIMIT 1"); 
    $idpro=1;
}else{
   $idpro=0; 
}
echo json_encode($idpro);