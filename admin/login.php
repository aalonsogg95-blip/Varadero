<?php

session_start();
include_once "../conexion1.php";

$nombre=mysqli_real_escape_string($conn, $_POST['nombre']);
$password=mysqli_real_escape_string($conn, $_POST['password']);
if(!empty($nombre) && !empty($password)){
    //LET'S CHECK USERS ENTERED EMAIL & PASSWORD MATCHED TO DATABASE ANY TABLE ROW EMAIL AND PASSWORD
    $sql= mysqli_query($conn, "SELECT * FROM usuarios WHERE nombre_usuarios ='{$nombre}' AND contrasena_usuarios = '{$password}' and (area_usuarios='admin' or area_usuarios='caja') and estatus_usuarios=1");

    if(mysqli_num_rows($sql)>0){
         $row=mysqli_fetch_assoc($sql);
   
                 $datos=[
                    "usuario"=>$row["nombre_usuarios"],
                    "role"=>$row["area_usuarios"]
                  
                ];
                 $_SESSION["datosUsuarioVaradero"]=$datos;
                
                 ////////////////////////////////////////////
                 //ACTUALIZAR FECHA DE INGRESO AL SISTEMA
                 $sql3=mysqli_query($conn, "UPDATE usuarios SET acceso_usuarios = CURRENT_TIMESTAMP WHERE id_usuario = '$row[id_usuario]'");
                    if($sql3){
                        echo "success";
                    }else{
                        echo "error";
                    }

       
    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Usuario o contraseña incorrectos";
    }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}