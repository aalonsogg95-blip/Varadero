<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////

//VARIABLE
    $idclienteeliminado=$_POST['idclienteeliminado'];
    $tipo=$_POST['tipo'];


    if($tipo=="Completa"){
             //ELIMINAR OBSERVACIONES
             mysqli_query($conexion, "DELETE observaciones FROM observaciones
             inner join ordenes on
              observaciones.ord_id_orden = ordenes.ord_id_orden
              inner join clientes_eliminados on
              clientes_eliminados.id_clienteeliminado=ordenes.cli_id_cliente
              WHERE clientes_eliminados.id_clienteeliminado='$idclienteeliminado'"); 

         //ELIMINAR CLIENTE
         mysqli_query($conexion, "DELETE clientes_eliminados FROM clientes_eliminados WHERE id_clienteeliminado='$idclienteeliminado'");

         //ELIMINAR ORDENES_HISELIMINADAS 
        mysqli_query($conexion, "DELETE ordenes_hiseliminadas FROM ordenes_hiseliminadas WHERE hisc_id_histoClientes='$idclienteeliminado'");

         $busCuenta = mysqli_query($conexion, "SELECT count(*) FROM clientes_eliminados WHERE id_clienteeliminado='$idclienteeliminado'") or die 
            ("Problemas en el select 2:".mysqli_error($conexion));
            $resultado = mysqli_fetch_array($busCuenta);

    }else{

        //ELIMINAR OBSERVACIONES
        // mysqli_query($conexion, "DELETE observaciones FROM observaciones
        // inner join ordenes on
        //  observaciones.ord_id_orden = ordenes.ord_id_orden
        //  inner join clientes_eliminados on
        //  clientes_ordeliminadas.id_clienteOrdEliminada=ordenes.cli_id_cliente
        //  WHERE clientes_ordeliminadas.id_clienteOrdEliminada='$idclienteeliminado'"); 


        //ELIMINAR CLIENTE
         mysqli_query($conexion, "DELETE clientes_ordeliminadas FROM clientes_ordeliminadas WHERE id_clienteOrdEliminada='$idclienteeliminado'");

         $busCuenta = mysqli_query($conexion, "SELECT count(*) FROM clientes_ordeliminadas WHERE id_clienteOrdEliminada='$idclienteeliminado'") or die ("Problemas en el select 2:".mysqli_error($conexion));
            $resultado = mysqli_fetch_array($busCuenta);
    }


//ELIMINAR ORDENES 
mysqli_query($conexion, "DELETE ordenes FROM ordenes WHERE cli_id_cliente='$idclienteeliminado'"); 




echo JSON_encode($resultado[0]);

