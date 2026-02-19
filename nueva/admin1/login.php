<?php
session_start();
include_once "../conexion1.php";
$nombre=mysqli_real_escape_string($conn, $_POST['usuario']);
$password=mysqli_real_escape_string($conn, $_POST['password']);
if(!empty($nombre) && !empty($password)){
    //LET'S CHECK USERS ENTERED EMAIL & PASSWORD MATCHED TO DATABASE ANY TABLE ROW EMAIL AND PASSWORD
    $sql= mysqli_query($conn, "SELECT * FROM sesion WHERE ses_usuario ='{$nombre}' AND ses_contrasena = '{$password}' and ses_area='admin'");
    if(mysqli_num_rows($sql)>0){
         $row=mysqli_fetch_assoc($sql);

                $datos=[
                    "idusuario"=>"0",
                    "usuario"=>$row["nombre_usuarios"]
                ];
                 $_SESSION["datosUsuarioAdmin"]=$datos;
                 echo "success";
       
    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Usuario o contraseña incorrectos";
    }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}