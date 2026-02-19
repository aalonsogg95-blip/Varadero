<?php
//INCLUIR CONEXION 
require '../../conexion.php';
//PASAR FUNCION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8");
/////////////////////////////////////////////////

//VARIABLE
$pro=$_POST["producto"];

/////////////////////////////////////////////////
//MESES
$meses=array(" ","Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");



if(!empty($pro)){
    
      //CONTAR CLIENTES CON LA PALABRA SELECCIONADA
$contPro = mysqli_query($conexion, "select count(*) from productos where (pro_producto like '%$pro%') or (pro_categoria like '%$pro%')") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);
    
    if($coPro[0]>0){
    
     echo "<table class='container_tabla_mostrar'>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Costo</th>
                            <th>Fecha</th>
                            <th>Status</th>
                        </tr>
                    </thead>";
    
    
    $mostPro = mysqli_query($conexion, "select pro_producto, pro_categoria, pro_costo, pro_fecha,pro_id_producto, pro_status from productos where (pro_producto like '%$pro%') or (pro_categoria like '%$pro%')") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        while($mospro=mysqli_fetch_row($mostPro)){
            
            
            
            //FECHA
            $format=$mospro[3];
            $anual=substr($format, 0,4);
            $mes=intval(substr($format, 5,2));
            $dia=substr($format, 8,2);
            
           echo "<tbody>
                    <tr id='$mospro[4]'>
                      <td data-titulo='Producto'>$mospro[0]</td>  
                      <td data-titulo='Categoría'>$mospro[1]</td>  
                      <td data-titulo='Costo'>$$mospro[2]</td>  
                      <td data-titulo='Fecha registro'>$dia/$meses[$mes]/$anual</td>";
            
                    //STATUS
                        if($mospro[5]==0){
                            echo "<td data-titulo='Status' class='stat'><a href='#/' onclick='status($mospro[4],0)' class='ago'>Agotado</a></td>";
                        }else{
                            echo "<td data-titulo='Status' class='stat'><a href='#/' onclick='status($mospro[4],1)' class='dis'>Disponible</a></td>";
                        }
                     
                echo  "<td data-titulo='' class='btn-productos btnE' id='Ed$mospro[4]'>
                        <a href='#/'onclick='editarPro($mospro[4],\"$mospro[3]\")' class='edi'></a>
                        <a href='#/'onclick='eliminarPro($mospro[4],\"$mospro[3]\")' class='eli'>
                        </td>
                        <td class='btn-productos btnG' id='Gua$mospro[4]'><a href='#/'onclick='actualizarPro($mospro[4])' class='gua'></a></td>
                        
                    </tr>
                </tbody>";
        }
    echo "</table>";
    
    }else{
    echo "<p class='container_mensaje'>No se encontraron productos</p>";
    } 
    
}else{
    
   //CONTAR CLIENTES
$contPro = mysqli_query($conexion, "select count(*) from productos") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        $coPro = mysqli_fetch_array($contPro);

if($coPro[0]>0){
    
     echo "<table class='container_tabla_mostrar'>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Categoría</th>
                            <th>Costo</th>
                            <th>Fecha</th>
                            <th>Status</th>
                        </tr>
                    </thead>";
    
    
    $mostPro = mysqli_query($conexion, "select pro_producto, pro_categoria, pro_costo,pro_fecha,pro_id_producto,pro_status from productos ") or die 
        ("Problemas en el select 2:".mysqli_error($conexion));
        while($mospro=mysqli_fetch_row($mostPro)){
            
            
            
            //FECHA
            $format=$mospro[3];
            $anual=substr($format, 0,4);
            $mes=intval(substr($format, 5,2));
            $dia=substr($format, 8,2);
            
            
           echo "<tbody>
                    <tr id='$mospro[4]'>
                      <td data-titulo='Producto'>$mospro[0]</td>  
                      <td data-titulo='Categoría'>$mospro[1]</td>  
                      <td data-titulo='Costo'>$$mospro[2]</td>  
                      <td data-titulo='Fecha registro'>$dia/$meses[$mes]/$anual</td> ";
                        //STATUS
                        if($mospro[5]==0){
                            echo "<td data-titulo='Status' class='stat'><a href='#/' onclick='status($mospro[4],0)' class='ago'>Agotado</a></td>";
                        }else{
                            echo "<td data-titulo='Status' class='stat'><a href='#/' onclick='status($mospro[4],1)' class='dis'>Disponible</a></td>";
                        }
            
                      
                echo  "<td data-titulo='' class='btn-productos btnE' id='Ed$mospro[4]'>
                        <a href='#/'onclick='editarPro($mospro[4],\"$mospro[3]\")' class='edi'></a>
                        <a href='#/'onclick='eliminarPro($mospro[4],\"$mospro[3]\")' class='eli'>
                        </td>
                        <td class='btn-productos btnG' id='Gua$mospro[4]'><a href='#/'onclick='actualizarPro($mospro[4])' class='gua'></a></td>
                        
                    </tr>
                </tbody>";
        }
    echo "</table>";
    
    }else{
    echo "<p class='container_mensaje'>No hay productos registrados</p>";
    } 
    
    
}
