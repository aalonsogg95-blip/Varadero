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
//$hora= date("H:i:s");
$ho=date('H')-1;
$mi=date('i');
$se=date('s');


$hora=$ho.":".$mi.":".$se;
//////////////////////////////////////////////////

    //VARIABLE
    $idcliente=$_POST['idcliente'];
    $usuario=$_POST['usuario'];
    $cuenta=json_decode($_POST['cuentaSeleccionada']);
            $consumo=$cuenta[0]->consumo;
            $lugar=$cuenta[0]->lugar;
            $horapedido=$cuenta[0]->hora;
            $ordenes=$cuenta[0]->ordenes;
       


    //VALIDAR QUE USUARIO ELIMINO LA CUENTA
    if($usuario=="cajaadmin"){
        //DUEÑO, ELIMINAR VENTA

        //ELIMINAR OBSERVACIONES
        mysqli_query($conexion, "DELETE observaciones FROM observaciones
                    inner join ordenes on
                     observaciones.ord_id_orden = ordenes.ord_id_orden
                     inner join clientes on
                     clientes.cli_id_cliente=ordenes.cli_id_cliente
                     WHERE clientes.cli_id_cliente='$idcliente'"); 
        //ELIMINAR ORDENES 
        mysqli_query($conexion, "DELETE ordenes FROM ordenes WHERE cli_id_cliente='$idcliente'"); 

        //ELIMINAR CLIENTE
        mysqli_query($conexion, "DELETE clientes FROM clientes WHERE cli_id_cliente='$idcliente'");
        
        
    }else{
     
        //VALIDAR SI LA CUENTA TIENE ORDENES ASIGNADAS
        if(sizeof($ordenes)>0){
            //SI HAY ORDENES, REGISTRARLAS EN TABLA DE CLIENTES ELIMINADOS
            //EMPLEADO, GUARDAR LA VENTA ELIMINADA
            $conexion->query("insert into clientes_eliminados values ($idcliente, $consumo,'$lugar','$horapedido','$hora','$fecha')");
            //COBRAR INSERCCION DEL CLIENTE ELIMINADO
            $busEliminado = mysqli_query($conexion, "SELECT count(*) from clientes_eliminados where id_clienteeliminado='$idcliente'") or die   ("Problemas en el select 2:".mysqli_error($conexion));                 
            $idclienteeliminado = mysqli_fetch_array($busEliminado);

                if($idclienteeliminado>0){
                    for($o=0; $o<sizeof($ordenes); $o++){
                            $idorden=$ordenes[$o]->idorden;
                            mysqli_query($conexion, "UPDATE ordenes SET ord_status=0 WHERE ord_id_orden='$idorden'  LIMIT 1");
                    }
                    
                }
        }else{
            //SI NO HAY ORDENES ELIMINAR CLIENTE
            //ELIMINAR CLIENTE
            mysqli_query($conexion, "DELETE clientes FROM clientes WHERE cli_id_cliente='$idcliente'");
        }
            

    }



        //COMPROBAR QUE CLIENTE SE HAYAN ELIMINADO CORRECTAMENTE
        $busCliente = mysqli_query($conexion, "SELECT count(*) from clientes where cli_id_cliente='$idcliente'") or die ("Problemas en el select 2:".mysqli_error($conexion));
            $cli = mysqli_fetch_array($busCliente);

 echo JSON_encode($cli[0]);