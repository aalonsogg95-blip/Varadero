<?php
//////////////////////////////////////////
//INLCUIR ARCHIVO A LA CONEXION
require '../conexion.php';
//PASAR FUNCION DE CONEXION A VARIABLE
$conexion = conectarDB();
$conexion->set_charset("utf8"); //ELIMINAR CARACTERES ESPECIALES
////////////////////////////////////////////////////

//CATEGORIAS

$proarray=array();//ARREGLO PRINCIPAL

$cama=array();//ARREGLO CAMARONES
$file=array();//ARREGLO filetes
$espc=array();//ARREGLO ESPECIALIDAD
$faji=array();//ARREGLO FAJITAS
$coct=array();//ARREGLO COCTELES
$agua=array();//ARREGLO AGUACHILE
$cevi=array();//ARREGLO ENTRADAS
$tost=array();//ARREGLO TOSTADAS
$taco=array();//ARREGLO TACOS
$espf=array();//ARREGLO ESPECIALIDAD FRIA
$mixo=array();//ARREGLO ENSALADA
$cort=array();//ARREGLO CORTES
$post=array();//ARREGLO POSTRES
$bebi=array();//ARREGLO BEBIDAS
$snac=array();//ARREGLO SNACKS
$inf=array();//ARREGLO INFANTILES
$lic=array();//ARREGLO LICORES
$mar=array();//ARREGLO MARISCADAS
$ext=array();//ARREGLO EXTRAS
$cerv=array();


$categorias=array('camarones','filetes','esp caliente','fajitas','cocteles',
                 'aguachiles','ceviche','tostadas','tacos','esp fria',
                 'mixologia','cortes','postre','bebidas','snacks', 'infantiles','licores', 'mariscadas', 'extras', "cervezas");

//CICLO PARA RECORRER ARREGLO DE CATEGORIAS
for($c=0; $c<sizeof($categorias); $c++){
    
    //MOSTRAR PRODUCTOS POR CATEGORIAS
    $buscar_pro = mysqli_query($conexion, "SELECT pro_producto,pro_costo from productos where pro_categoria='$categorias[$c]' and pro_status=1") or die 
                        ("Problemas en el select 2:".mysqli_error($conexion));
                       while($pro=mysqli_fetch_row($buscar_pro)){
                           $pro[0];//PRODUCTO
                           $pro[1];//ID_PRODUCTO
                          
                           
                            $produc=$pro[0]."-".$pro[1];//CONCATENAR CADENA
                           
                           //AGREGAR PRODUCTOS A ARREGLOS INDIVIDUALES DE CATEGORIAS
                        switch($categorias[$c]){
                            case 'camarones':array_push($cama,$produc);break;
                            case 'filetes': array_push($file,$produc);break;
                            case 'esp caliente': array_push($espc, $produc);break;
                            case 'fajitas': array_push($faji, $produc); break;
                            case 'cocteles': array_push($coct, $produc); break;
                            case 'aguachiles': array_push($agua, $produc); break;
                            case 'ceviche': array_push($cevi, $produc); break;
                            case 'tostadas': array_push($tost, $produc); break;
                            case 'tacos': array_push($taco, $produc); break;
                            case 'esp fria': array_push($espf, $produc); break;
                            case 'mixologia': array_push($mixo, $produc); break;
                            case 'cortes': array_push($cort, $produc); break;
                            case 'postre': array_push($post, $produc); break;   
                            case 'bebidas': array_push($bebi, $produc); break;
                            case 'snacks': array_push($snac, $produc); break;
                            case 'infantiles': array_push($inf, $produc); break;
                            case 'licores': array_push($lic, $produc); break;
                            case 'mariscadas': array_push($mar, $produc); break;
                            case 'extras': array_push($ext, $produc); break;
                            case 'cervezas': array_push($cerv, $produc); break;
                        }                              
            }
}



//AGREGAR ARREGLOS INDIVIDUALES A ARREGLO PRINCIPAL
array_push($proarray,$cama, $file,$espc,$faji,$coct,$agua,$cevi,$tost,$taco,$espf,$mixo,$cort,$post,$bebi,$snac, $inf, $lic, $mar, $ext, $cerv);

echo json_encode($proarray);//ENVIAR ARREGLO A VENTA.PHP     