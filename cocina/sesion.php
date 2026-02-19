<?php
//INCLUIR CONEXION 
require '../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////


//VARIABLES
$usuario=$_POST['usu'];
$contrasena=$_POST['con'];
//////////////////////////////////////////

if(preg_match('/^[a-zA-Z0-9ñáéíóúÁÉÍÓÚ ]+$/', $usuario) and preg_match('/^[a-zA-Z0-9ñáéíóúÁÉÍÓÚ ]+$/', $contrasena)){

    $usuar=strtolower($usuario);
//BUSCAR COINCIDENCIA BASE DE DATOS
$buscar_usuario = mysqli_query($conexion, "SELECT id_usuario FROM usuarios WHERE nombre_usuarios = '$usuar' and contrasena_usuarios='$contrasena' and area_usuarios='cocina' and estatus_usuarios=1 limit 1");
          $bus=mysqli_fetch_array($buscar_usuario);
    $bus=$bus['id_usuario'];

     ////////////////////////////////////////////
    //ACTUALIZAR FECHA DE INGRESO AL SISTEMA
    $sql3=mysqli_query($conexion, "UPDATE usuarios SET acceso_usuarios = CURRENT_TIMESTAMP WHERE id_usuario = '$bus'");
    

}else{
    $bus=0;
}

echo json_encode($bus);