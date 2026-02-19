<?php
//INCLUIR CONEXION 
include_once "../../../conexion1.php";

/////////////////////////////////////////////////


// Campo a buscar
$campo = isset($_POST['input']) ? $conn->real_escape_string($_POST['input']) : null;

// Filtrado
$where = '';
if ($campo != null) {   
        $where = "WHERE ( pro_producto LIKE '%" . $campo . "%') ";
}else{
    
}





// Limites
$limit = isset($_POST['num_registros']) ? $conn->real_escape_string($_POST['num_registros']) : 10;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;

if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
   $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";



//TOTAL DE REGISTROS CON FILTROS
$sql0=mysqli_query($conn, "SELECT COUNT(*) as conta FROM productos");
$contadorfiltro = mysqli_fetch_assoc($sql0);
$totalFiltro=$contadorfiltro["conta"];




//BUSCAR REGISTROS
$sql=mysqli_query($conn, "SELECT * FROM productos
$where order by pro_id_producto desc $sLimit ");

$datos=array();
$paginacion=array();
$cont=0;

while ($row = mysqli_fetch_assoc($sql)) {

    $datos[]=$row;


}



// Paginación
if ($totalFiltro > 0) {
  $totalPaginas = ceil($totalFiltro / $limit);

    $paginacion[] .= '<nav>';
    $paginacion[] .= '<ul class="paginacion">';

    $numeroInicio = max(1, $pagina - 4);
    $numeroFin = min($totalPaginas, $numeroInicio + 9);

    for ($i = $numeroInicio; $i <= $numeroFin; $i++) {
        $paginacion[] .= '<li class="page-ite' . ($pagina == $i ? ' active' : '') . '">';
        $paginacion[] .= '<a class="page-lin" href="#" onclick="nextPageProductos(' . $i . ')">' . $i . '</a>';
        $paginacion[] .= '</li>';
    }

    $paginacion[] .= '</ul>';
    $paginacion[] .= '</nav>';
}


// var_dump($paginacion);
$output=array($datos, $paginacion, $totalFiltro, $cont);

echo json_encode($output, JSON_UNESCAPED_UNICODE);