<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
/////////////////////////////////////////////////

//VARIABLE
$mes=$_POST["mes"];
$anual=$_POST['anual'];

$cantDias= array('0',32,29,32,31,32,31,32,32,31,32,31,32);

//DIAS
    $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');


    //CABECERA DE LA TABLA
echo "<table>
            <thead>
                   <tr>
                       <th>Día semana</th>
                       <th>Día num</th>
                       <th>Clientes</th>
                       <th>Total productos</th>
                       <th>Ingresos</th>
                       <th>Gastos</th>
                       <th>Utilidad</th>
                   </tr>
            </thead>";


//CICLO PARA RECORRER LOS DIAS DEL MES
for($i = 1; $i <$cantDias[$mes]; $i++){
        //FECHA PARA SELECCIONAR EL DIA DE LA SEMANA
            $fecha = $anual."-".$mes."-".$i;
            //OBTENER EL DIA DE LA SEMANA
        	$no = date("N", strtotime($fecha));




//CLIENTES POR DIA
$contCli = mysqli_query($conexion, "select count(*) from his_clientes where year(fecha)='$anual' and MONTH(fecha)='$mes' and day(fecha)='$i'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coCli = mysqli_fetch_array($contCli);
        $coCli=number_format($coCli[0]);


//PRODUCTOS VENDIDOS POR DÍA
$contPro = mysqli_query($conexion, "select sum(cantidad) from his_ventas where year(fecha)='$anual' and MONTH(fecha)='$mes' and day(fecha)='$i'") or die ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);
        $coPro=number_format($coPro[0]);


//INGRESOS POR DÍA
$contIng = mysqli_query($conexion, "select sum(total) from his_clientes where year(fecha)='$anual' and MONTH(fecha)='$mes' and day(fecha)='$i'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coIng = mysqli_fetch_array($contIng);
        

//GASTOS POR DÍA
$contGas = mysqli_query($conexion, "select sum(gas_costo) from gastos where year(gas_fecha)='$anual' and MONTH(gas_fecha)='$mes' and day(gas_fecha)='$i'") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coGas = mysqli_fetch_array($contGas);

        $utilidad = number_format($coIng[0]-$coGas[0]);

        $coIng=number_format($coIng[0]);
        $coGas=number_format($coGas[0]);



echo "<tbody>
        <tr>
            <td>$dias[$no]</td>
            <td>$i</td>";

        if($coCli==0){
            echo  "<td class='red' data-titulo='Clientes'>$coCli</td>";
            echo  "<td class='red' data-titulo='Total productos'>$coPro</td>";
            echo  "<td class='red' data-titulo='Ingresos'>$$coIng</td>";
            echo  "<td data-titulo='Gastos'>$$coGas</td>";
            echo  "<td class='red' data-titulo='Utilidad'>$$utilidad</td>";
        }else{
            echo  "<td data-titulo='Clientes'>$coCli</td>";
            echo  "<td data-titulo='Total productos'>$coPro</td>";
            echo  "<td data-titulo='Ingresos'>$$coIng</td>";
            echo  "<td class='red' data-titulo='Gastos'>$$coGas</td>";
            echo  "<td data-titulo='Utilidad'>$$utilidad</td>";
        }
      

    }

echo "</tr>
        </tbody>
        </table>";

         