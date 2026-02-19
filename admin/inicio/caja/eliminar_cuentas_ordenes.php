<?php
//INCLUIR CONEXION 
include_once '../../../conexion1.php';



session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];

//SI EL USUARIO ES ADMIN, ELIMINARLA POR DEFINITIVAMENTE
//SI EL USUARIO ES DIFERENTE A ADMIN, SOLO CAMBIARLA DE ESTATUS DE 0 A 1 EN cli_eliminado


$tipo=$_POST['tipo'];

if($tipo=="cuenta"){
    $idcliente=$_POST['idcliente'];

    if($usuario=="admin"){
         //ELIMINAR CUENTA
        mysqli_query($conn, "DELETE clientes FROM clientes
                        WHERE cli_id_cliente='$idcliente'"); 
        $numFilasAfectadas = mysqli_affected_rows($conn);
    }else{
        //ACTUALIZAR ESTATUS DE ELIMINADO A 1
        $sql=mysqli_query($conn, "UPDATE clientes SET cli_eliminado=1 WHERE cli_id_cliente='${idcliente}'");
        if($sql){
            $numFilasAfectadas=1;
        }
    }
   

}else if($tipo=="orden"){
    $idorden=$_POST['ord_id_orden'];

   
    if($usuario=="admin"){
          //ELIMINAR ORDEN
        mysqli_query($conn, "DELETE ordenes FROM ordenes
                        WHERE ord_id_orden='$idorden'"); 
        $numFilasAfectadas = mysqli_affected_rows($conn);
    }else{
        //ACTUALIZAR ESTATUS DE ELIMINADO A 1
        $sql=mysqli_query($conn, "UPDATE ordenes SET ord_eliminado=1 WHERE ord_id_orden='$idorden'");
        if($sql){
            $numFilasAfectadas=1;
        }
    }
}


 echo json_encode($numFilasAfectadas);