<?php

include_once "../../../conexion1.php";

//DVARIABLES
$idproducto=mysqli_real_escape_string($conn, $_POST['Eiditem']);
$nombre=mysqli_real_escape_string($conn, $_POST['item1']);
$categoria=mysqli_real_escape_string($conn, $_POST['item2']);
$costoventa=mysqli_real_escape_string($conn, $_POST['item3']);



if(!empty($nombre) and !empty($costoventa) and !empty($categoria)){

        $sqlproducto= mysqli_query($conn, "SELECT pro_producto FROM productos WHERE  pro_producto='$nombre' and pro_categoria='$categoria' and pro_id_producto!='$idproducto'");
        if(mysqli_num_rows($sqlproducto)>0){
            echo "<p><i class='fa-solid fa-circle-exclamation'></i>Producto ya existe</p>";
        }else{
        
        $sql=mysqli_query($conn, "UPDATE productos SET pro_producto='$nombre', pro_categoria='$categoria', pro_costo='$costoventa' WHERE pro_id_producto='${idproducto}'");
        if($sql){
            echo "success";
            
        }else{
            echo "error";
        }

    }

    }else{
        echo "<p><i class='fa-solid fa-circle-exclamation'></i>Todos los campos son obligatorios</p>";
    }
    