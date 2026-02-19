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
     
     $f=date("Y-m-d");//FECHA ACTUAL COMPLETA
     //$h= date("H:i:s");//HORA ACTUAL
     $ho=date('H');
         $mi=date('i');
         $se=date('s');

         
       $h=$ho.":".$mi.":".$se;

//VARIABLES
$con=$_POST['con']; //CONSUMO 0,1,2
$lug=$_POST['lugg'];//LUGAR DE CONSUMO
$pro=$_POST['pro'];//PRODUCTO
$can=$_POST['can'];//CANTIDAD
$cos=$_POST['cos'];//COSTO
$cat=$_POST['cat'];
$obserCelular=$_POST['obserCelular'];//obserCelular
$usuario=$_POST['usuario'];

//OBTENER TOTAL
$tot=($can*$cos);


//VALIDAR CLIENTE
$contCli = mysqli_query($conexion, "SELECT cli_id_cliente from clientes where cli_fecha='$f' and cli_consumo='$con' and cli_lugar='$lug'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $idCli = mysqli_fetch_array($contCli);
         $idCli=$idCli[0];
        //VALIDAR CLIENTE REGISTRADO

if(empty($idCli)){
    //*EL CLIENTE NO ESTA REGISTRADO

    //INSERTAR CLIENTE
    $conexion->query("insert into clientes(cli_consumo, cli_lugar,cli_observacion,cli_hora, cli_fecha) values ('$con','$lug','$obserCelular', '$h','$f')"); 
    $idCli=mysqli_insert_id($conexion);
}else{
    //*EL CLIENTE SI ESTA REGISTRADO

    //NOTA: SI EL CLIENTE ESTA EN ESTATUS ELIMINADO (0) Y SE AGREGA UN PRODUCTO A ESE MISMO CLIENTE, SE CAMBIA EL ESTATUS DE 0 A 1 PARA QUE SE PUEDAN AGREGAR ORDENES

    //VALIDAR QUE CLIENTE NO ESTE EN ESTATUS ELIMINADO
    // $contCliElim = mysqli_query($conexion, "SELECT count(*) from clientes 
    //     where cli_id_cliente='$idCli'") or die 
    //     ("Problemas en el select 2:".mysqli_error($conexion));
    //     $contCli = mysqli_fetch_array($contCliElim);

    //     //VALIDAR
    // if($contCli[0]>0){
    //     //EL CLIENTE EN ESTATUS ELIMINADO
    //     // mysqli_query($conexion, "UPDATE clientes SET
    //     //         cli_eliminado=1 WHERE cli_id_cliente='$idCli' LIMIT 1");
    // }else{
    //     //EL CLIENTE NO ESTA EN STATUS ELIMINADO

    // }
}


//VALIDAR ID DE CLIENTE REGISTRADO
if(!empty($idCli)){
    //INSERTAR ORDENES
$conexion->query("insert into ordenes(ord_categoria,ord_producto, ord_cantidad,ord_costo,ord_total,ord_hora,ord_status, ord_horaEntrega, cli_id_cliente,ord_usuario)  values ('$cat','$pro','$can','$cos','$tot','$h','1', '0', '$idCli','$usuario')"); 
    $idord=mysqli_insert_id($conexion);

    $obs=$_POST['obs'];
    //VALIDAD OBSERVACIONES
    if(!empty($obs)){
        //SI HAY OBSERVACIONES
                           //INSERTAR OBSERVACIONES
        $conexion->query("insert into observaciones(obs_observacion,ord_id_orden)  values ('$obs',$idord)"); 
    }
}



//RETORNAR ID DE ORDEN CREADA, HORA Y FECHA
$datos=array($idord,$h,$f);
echo json_encode($datos);