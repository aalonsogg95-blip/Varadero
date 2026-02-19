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
$buscar_usuario = mysqli_query($conexion, "SELECT count(*) FROM sesion WHERE ses_usuario = '$usuar' and ses_contrasena='$contrasena' and ses_area='admin' limit 1");
          $bus=mysqli_fetch_array($buscar_usuario);
    $bus=$bus[0];
        //CREAR COOKIE
    if($bus>0 and $usuar=='julissa'){
        session_start();
        $_SESSION['usuario'] = $usuar;
    }

}else{
    $bus=0;
}

echo json_encode($bus);