<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////

$id=$_POST['id'];

///BUSCAR ORDENES DEL CLIENTE SELECCIONADO
$contClienteOrd = mysqli_query($conexion, "SELECT count(*) from clientes c 
        inner join ordenes o on
        c.cli_id_cliente=o.cli_id_cliente
        where c.cli_id_cliente='$id' ") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coCliord = mysqli_fetch_array($contClienteOrd);

if($coCliord[0]>0){
        //ELIMINAR CLIENTE Y ORDENES
//     mysqli_query($conexion, "DELETE c, o
//     FROM clientes c 
//     inner join ordenes o on
//     o.cli_id_cliente=c.cli_id_cliente
//     WHERE c.cli_id_cliente='$id'");

        //ACTUALIZAR STATUS A 0 CANCELADO
        mysqli_query($conexion, "UPDATE ordenes o
                        inner join clientes c on
                        c.cli_id_cliente = o.cli_id_cliente
                        SET
                        ord_status=0 WHERE c.cli_id_cliente='$id'");

               //ACTUALIZAR CLIENTE ELIMINADO
        mysqli_query($conexion, "UPDATE clientes SET
        cli_eliminado=0 WHERE cli_id_cliente='$id'");

        //SI SE CUENTA CON OBSERVACIONES EN LAS ORDENES, ELIMINARLAS
        mysqli_query($conexion, "DELETE ob
                        FROM ordenes o
                        inner join clientes c on
                        c.cli_id_cliente = o.cli_id_cliente
                        inner join observaciones ob on
                        ob.ord_id_orden=o.ord_id_orden
                                 WHERE c.cli_id_cliente='$id'"); 

}else{
        //ELIMINAR CLIENTE
    mysqli_query($conexion, "DELETE clientes
    FROM clientes WHERE cli_id_cliente='$id'");
}





//VALIDAR CLIENTE ELIMINADO
$contCli = mysqli_query($conexion, "select count(*) from clientes where cli_id_cliente='$id' and cli_eliminado!=0 limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coCli = mysqli_fetch_array($contCli);

echo json_encode($coCli[0]);
