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
$h= date("H:i:s");//HORA ACTUAL


//VARIABLES
$numConsumo=$_POST['num'];

switch($numConsumo){
    case 1: $lugar='Local'; break; case 2: $lugar='Domicilio'; break; case 3: $lugar='Llevar'; break;
}




//VALIDAR ORDENES EN COCINA
$contClientesOrde = mysqli_query($conexion, "SELECT COUNT(*) from clientes
where 
cli_fecha='$f' and cli_eliminado=0  and cli_consumo='$numConsumo'") or die ("Problemas en el select 2:".mysqli_error($conexion));
        $cliord = mysqli_fetch_array($contClientesOrde);




        //VALIDAR SI EXISTEN ORDENES
if($cliord[0]>0){
    //SI HAY ORDENES


    //MOSTRAR CLIENTES
    $clientesOrdenes = mysqli_query($conexion, "SELECT cli_lugar,cli_id_cliente from clientes
    where 
    cli_fecha='$f' and cli_eliminado=0  and cli_consumo='$numConsumo' order by cli_id_cliente asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
            while($clienOrde=mysqli_fetch_row($clientesOrdenes)){


                //TOTAL DE DIENERO EN PRODUCTOS
                $totalOrden = mysqli_query($conexion, "SELECT sum(ord_total) from ordenes o
                inner join clientes c on
                o.cli_id_cliente=c.cli_id_cliente
                where 
                cli_fecha='$f' and c.cli_id_cliente='$clienOrde[1]' and ord_status!=0 and ord_status!=4") or die ("Problemas en el select 2:".mysqli_error($conexion));
                        $totOrd = mysqli_fetch_array($totalOrden);

                if(empty($totOrd[0])) $totOrd[0]=0;


                
    //ENCABEZADO DE LA ORDEN
    echo "<div class='encabezado'>";
    // echo "<a href='#/' class='elimCliente' onclick='eliminarCliente($clienOrde[1])'></a>";
    echo "<h3 class='ord'>$clienOrde[0]</h3>";
    echo "<h4>Total: <spam>$$totOrd[0]</spam></h4>";
    echo "</div>";


            if(!empty($totOrd[0])){
                echo "<div class='detalles'>";
                echo "<table>
                        <tr>
                            <th> </th>
                            <th>Can</th>
                            <th>Pro</th>
                            <th>Cos</th>
                            <th class='tdHora'>Hor</th>
                            <th> </th>
                        </tr>";
            
            
                        //MOSTRAR ORDENES
                        $ordenes = mysqli_query($conexion, "SELECT ord_cantidad, ord_categoria, ord_producto, ord_total, ord_hora, ord_id_orden, ord_status from ordenes
                        where 
                        cli_id_cliente='$clienOrde[1]' and ord_status!=0 and ord_status!=4 order by ord_hora asc") or die ("Problemas en el select 2:".mysqli_error($conexion));
                                while($orde=mysqli_fetch_row($ordenes)){
            
                                    
                                    

                                    if($orde[6]==1){

                                        if($orde[1]=="Bebidas" or $orde[1]=="Licores"){
                                            echo "<tr class='bebColor'>";
                                        }else{
                                            echo "<tr class='pendiente'>";
                                        }
                                        echo "<td class='butElim'><a href='#/'><img src='img/menos1.png' class='elim' onclick='eliminarOrden($orde[5])'></a></td>";
                                        }else{
                                            echo "<tr>";
                                           echo "<td></td>";
                                        }
                                    
                                    $hor= date("h:i A", strtotime($orde[4]));

                                  echo "<td>$orde[0]</td>
                                    <td class='tdprodu'>$orde[1] $orde[2]</td>
                                    <td>$$orde[3]</td>
                                    <td class='tdHora'>$hor</td>";

                                    if($orde[6]==1){
                                        echo "<td><a href='#/'><img src='img/checkmark.png' class='check' onclick='statusEntregado($orde[5])'></a></td>";
                                    
                                    }else{
                                        echo "<td></td>";
                                    } 
                                    
                                    //OBSERVACIONES
                                    $observaciones = mysqli_query($conexion, "SELECT obs_observacion from observaciones
                                            where ord_id_orden='$orde[5]'") or die 
                                                ("Problemas en el select 2:".mysqli_error($conexion));
                                            $obs = mysqli_fetch_array($observaciones);

                                    if($obs[0]!=""){
                                        if($orde[6]==1){
                                        echo "<tr class='pendiente'>"; 
                                        }else{
                                        echo "<tr>";
                                        }
                                    echo "<td colspan='5'>$obs[0]</td>
                                            </tr>"; 
                                    }else{}
                                    //MOSTRAR HORA
                                    if($orde[6]==1){
                                        echo "<tr class='pendiente trHora'>";
                                    }else{
                                        echo "<tr class='trHora'>";
                                    }
                                    echo "<th colspan='4'>Hora <span>$hor<span></th></tr>";
                                
                                }
                                echo "</tr>";

                                
                echo "</table></div>";
            
            }else{

            }
        }

}else{
    //NO HAY ORDENES
    echo "<p class='nohay'>No hay ordenes registradas en la categoría $lugar</p>";
}




















