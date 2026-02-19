<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////
//ZONA HORARIA
date_default_timezone_set('America/Mexico_City');


//FECHA
$fecha=date("Y-m-d");
// $hora= date("H:i:s");
     $ho=date('H')-1;
         $mi=date('i');
         $se=date('s');

         
       $h=$ho.":".$mi.":".$se;
///////////////////////////////////////////////////////



//VARIABLES
$idcliente=$_POST['idcliente'];
$cantidad=$_POST['fieldCantidadComun'];
$producto=$_POST['fieldProductoComun'];
$costo=$_POST['fieldCostoComun'];
$total=$_POST['fieldTotalComun'];


$conexion->query("insert into ordenes(ord_categoria, ord_producto, ord_cantidad, ord_costo,ord_total, ord_hora, ord_status,ord_horaEntrega,cli_id_cliente,ord_usuario) 
                  values ('comun','$producto','$cantidad','$costo','$total','$h',2,'$h',$idcliente,'caja')");
    
     $idpro=mysqli_insert_id($conexion);
// $datos=array($idpro, $hora);
    
echo JSON_encode($idpro);