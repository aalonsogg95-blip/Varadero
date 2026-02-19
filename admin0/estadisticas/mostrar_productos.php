<?php

///////////////////////////////////////////
//Incluir archivo de conexion
require '../../conexion.php';
//Pasar funcion de conexion a variable
$conexion = conectarDB();
$conexion->set_charset("utf8");

$mes=$_POST['mes'];
$anual=$_POST['anual'];

// $meses = array("ninguno","Enero", "Febrero", "Marzo", 
//      		"Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre",
//      		"Octubre","Noviembre","Diciembre");

echo "<nav><h2>Productos vendidos</h2></nav>";



 $valProd = mysqli_query($conexion, "SELECT count(total) from (SELECT count(*) as total FROM his_ventas hv
 where  MONTH(fecha)='$mes' and YEAR(fecha)='$anual' GROUP BY hv.producto) as total") or die 
                        ("Problemas en el select 2:".mysqli_error($conexion));
                        $valpr= mysqli_fetch_array($valProd);

if($valpr[0]>0){
    echo "<table class='cantpro'>";
echo "<tr>";
$i=1;
 ///MOSTRAR CANTIDAD DE PRODUCTOS VENDIDOS
        $mostrarprodu = mysqli_query($conexion, "SELECT CONCAT(hv.categoria,'/',hv.producto), sum(hv.cantidad) AS total FROM his_ventas hv
        where  MONTH(fecha)='$mes' and YEAR(fecha)='$anual' GROUP BY hv.producto
        ORDER BY total desc") or die 
                        ("Problemas en el select 2:".mysqli_error($conexion));
                            while($mospro=mysqli_fetch_row($mostrarprodu)){
                                if(empty($mospro[0])){
                                    
                                }else{
                                   echo "<td>$mospro[0] (<span>$mospro[1]</span>)</td>";   
                
                                    $numero=4;//MULTIPLO DE 4 (4 COLUMNAS X FILA)
                                        if($i%$numero==0){
                                            echo "</tr>";
                                        }
                                        $i++;
                                } 
                                
                            }       
echo "</table>";
}else{
      echo "<p class='no'>No hay productos vendidos en el mes registrado</p>";
}


