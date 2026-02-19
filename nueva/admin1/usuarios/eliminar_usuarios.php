<?php
//INCLUIR CONEXION 
include_once '../../conexion1.php';


 $idusuario=$_POST['ses_id_sesion'];

    //ELIMINAR USUARIOS
    mysqli_query($conn, "DELETE sesion FROM sesion
                    WHERE ses_id_sesion='$idusuario'"); 
    $numFilasAfectadas = mysqli_affected_rows($conn);

   


 echo json_encode($numFilasAfectadas);