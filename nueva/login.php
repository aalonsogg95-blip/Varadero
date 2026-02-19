<?php
session_start();
include_once "conexion1.php";
$nombre=mysqli_real_escape_string($conn, $_POST['usuario']);
$password=mysqli_real_escape_string($conn, $_POST['password']);
if(!empty($nombre) && !empty($password)){
    //LET'S CHECK USERS ENTERED EMAIL & PASSWORD MATCHED TO DATABASE ANY TABLE ROW EMAIL AND PASSWORD
    $sql= mysqli_query($conn, "SELECT * FROM sesion WHERE ses_usuario ='{$nombre}' AND ses_contrasena = '{$password}' and ses_area='ordenar'");
    if(mysqli_num_rows($sql)>0){
         $row=mysqli_fetch_assoc($sql);

                // $datos=[
                //     "idusuario"=>"0",
                //     "usuario"=>$row["nombre_usuarios"]
                // ];
                 $_SESSION["datosUsuarioOrdenar"]=$row["ses_usuario"];
                 echo "success";


                 /////////////////////////////////////////////////////////////
                 //REGISTRAR IP DEL USUARIO QUE INGRESA AL MENU
                 $ip = $_SERVER['REMOTE_ADDR'];

                 $sql2= mysqli_query($conn, "SELECT ip_dispositivo_actualizaciones FROM actualizaciones 
                    WHERE ip_dispositivo_actualizaciones='$ip';
                    ");
                        if(mysqli_num_rows($sql2)>0){//YA EXISTE
                            $sql3=mysqli_query($conn, "UPDATE actualizaciones SET status_actualizaciones=0 WHERE ip_dispositivo_actualizaciones='$ip'");
                        }else{
                            $sql3=mysqli_query($conn, "INSERT INTO actualizaciones (ip_dispositivo_actualizaciones, status_actualizaciones) VALUES ('{$ip}',0)");
                        }
       
    }else{
        echo "<i class='fa-solid fa-circle-exclamation'></i>Usuario o contraseña incorrectos";
    }

}else{
    echo "<i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios";
}