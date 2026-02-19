<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLE
$anual=$_POST['ano'];

///////////////////////////////////////////////////////////
//ARREGLOS 
    $clientesXmes = array();
    $productosXmes = array();
    $ingresosXmes = array();

///CICLO PARA RECORRER LOS DIAS DEL MES
for($i=1;$i<13; $i++){
    
    //CLIENTES NUEVOS POR MES
    $contClientes = mysqli_query($conexion, "select count(*) from his_clientes where MONTH(fecha)='$i' and year(fecha)='$anual'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coCli = mysqli_fetch_array($contClientes);
    
    array_push($clientesXmes,$coCli[0]);
    
    //PRODUCTOS POR MES
    $contProductos = mysqli_query($conexion, "select sum(cantidad) from his_ventas where MONTH(fecha)='$i' and year(fecha)='$anual'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coGar = mysqli_fetch_array($contProductos);
    
    array_push($productosXmes,number_format($coGar[0]));
    
    //INGRESOS POR MES
    $contIngresos = mysqli_query($conexion, "select sum(total) from his_clientes where MONTH(fecha)='$i' and year(fecha)='$anual'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coVen = mysqli_fetch_array($contIngresos);

    array_push($ingresosXmes,$coVen[0]);
}


$datos=array($clientesXmes, $productosXmes, $ingresosXmes);
echo json_encode($datos);