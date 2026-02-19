<?php

include_once "../../../conexion1.php";

//DVARIABLES
$idusuario=mysqli_real_escape_string($conn, $_POST['Eiditem']);
$usuario=mysqli_real_escape_string($conn, $_POST['item1']);
$contrasena=mysqli_real_escape_string($conn, $_POST['item2']);
$area=mysqli_real_escape_string($conn, $_POST['item3']);



if(!empty($usuario) and !empty($contrasena) and !empty($area)){

        $sqlusuario= mysqli_query($conn, "SELECT nombre_usuarios FROM usuarios WHERE  nombre_usuarios='$usuario' and contrasena_usuarios='$contrasena' and id_usuario!='$idusuario'");
        if(mysqli_num_rows($sqlusuario)>0){
            echo "<p><i class='fa-solid fa-circle-exclamation'></i>Usuario ya existe</p>";
        }else{
        
        $sql=mysqli_query($conn, "UPDATE usuarios SET nombre_usuarios='$usuario', contrasena_usuarios='$contrasena', area_usuarios='$area' WHERE id_usuario='${idusuario}'");
        if($sql){
            echo "success";
            
        }else{
            echo "error";
        }

    }

    }else{
        echo "<p><i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios</p>";
    }
    