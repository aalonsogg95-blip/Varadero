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

     	//VARIABLES
     	$fecha=date("Y-m-d");
//////////////////////////////////////////7
$ordenes=array();


$mostrarOrd = mysqli_query($conexion, "SELECT c.cli_consumo, c.cli_lugar, ord_cantidad,ord_categoria, ord_producto,ord_hora, ord_id_orden, ord_status,ord_usuario from ordenes o inner join clientes c on
     o.cli_id_cliente = c.cli_id_cliente
     where
      c.cli_fecha='$fecha' and ord_status!=2 and (ord_categoria='Bebidas' or ord_categoria='Licores' or ord_categoria='Mixologia'  or ord_categoria='Cervezas') order by ord_hora asc") or die 
            ("Problemas en el select 4:".mysqli_error($conexion));
            while($mosord=mysqli_fetch_row($mostrarOrd)){

                switch($mosord[0]){
                        case 1: $con="Local"; break;
                        case 2: $con="Llevar"; break;
                        case 3: $con="Dom"; break;
                }

                $hor= date("h:i A", strtotime($mosord[5]));

                $orden=[
                    "consumo"=>$con,
                    "lugar"=>$mosord[1],
                    "cantidad"=>$mosord[2],
                    "categoria"=>$mosord[3],
                    "producto"=>$mosord[4],
                    "hora"=>$hor,
                    "status"=>$mosord[7],
                    "idorden"=>intval($mosord[6]),
                    "usuario"=>$mosord[8]
                ];

                $obsOrd = mysqli_query($conexion, "SELECT obs_observacion from observaciones where ord_id_orden='$mosord[6]' limit 1") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $obsOrd = mysqli_fetch_array($obsOrd);
                $orden["observaciones"]=$obsOrd[0];

        array_push($ordenes,$orden);
}
//  var_dump($ordenes);

 echo json_encode($ordenes);