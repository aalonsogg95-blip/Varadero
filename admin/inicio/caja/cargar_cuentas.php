<?php
include_once "../../../conexion1.php";



// Limites
$limit =  30;
$pagina = isset($_POST['pagina']) ? $conn->real_escape_string($_POST['pagina']) : 0;


if (!$pagina) {
    $inicio = 0;
    $pagina = 1;
} else {
   $inicio = ($pagina - 1) * $limit;
}

$sLimit = "LIMIT $inicio , $limit";



//TOTAL DE REGISTROS CON FILTROS
$sql0=mysqli_query($conn, "SELECT COUNT(*) as conta FROM clientes where cli_eliminado=0");
$contadorfiltro = mysqli_fetch_assoc($sql0);
$totalFiltro=$contadorfiltro["conta"];



//TOTAL DE DINERO EN VENTAS
$sqlsumatotal=mysqli_query($conn, "SELECT sum(ord_total) as sumaTotal FROM clientes inner join ordenes on
clientes.cli_id_cliente=ordenes.cli_id_cliente where cli_eliminado=0");
$sumarTotal = mysqli_fetch_assoc($sqlsumatotal);
$sumaTotalventas=$sumarTotal["sumaTotal"];


$sql= mysqli_query($conn, "SELECT * FROM clientes where cli_eliminado=0 order by cli_id_cliente desc $sLimit ");
$datos=array();
$paginacion=array();
$cont=0;
while ($row = mysqli_fetch_assoc($sql)) {

    $ordenes=array();
    $sql1= mysqli_query($conn, "SELECT * FROM ordenes WHERE  cli_id_cliente='$row[cli_id_cliente]' and ord_eliminado=0");
    while ($row1 = mysqli_fetch_assoc($sql1)) {
        $ordenes[]=$row1;
    }
     $row["ordenes"]=$ordenes;
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
        $paginacion[] .= '<a class="page-lin" href="#" onclick="nextPageCaja(' . $i . ')">' . $i . '</a>';
        $paginacion[] .= '</li>';
    }

    $paginacion[] .= '</ul>';
    $paginacion[] .= '</nav>';
}


// var_dump($paginacion);
$output=array($datos, $paginacion, $totalFiltro, $cont, $sumaTotalventas);

echo json_encode($output, JSON_UNESCAPED_UNICODE);