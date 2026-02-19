<?php

 include_once "../../../conexion1.php";


// Decodificar Base64
$datosEncriptados = $_GET['data'] ?? '';
$datosJSON = base64_decode(urldecode($datosEncriptados));
$datos = json_decode($datosJSON, true);


$ventas = $datos['ventas'] ?? '';
$efectivo = $datos['efectivo'] ?? '';
$tarjeta = $datos['tarjeta'] ?? '';
$transferencia = $datos['transferencia'] ?? '';
$dineroencaja = $datos['dineroencaja'] ?? '';
$fecha = $datos['fecha'] ?? '';
// var_dump($dineroencaja);


/*===========================
USUARIO
===========================*/

session_start();
$usuario= $_SESSION["datosUsuarioVaradero"]["usuario"];
$role= $_SESSION["datosUsuarioVaradero"]["role"];



/*===========================
FECHA Y HORA DE CORTE
===========================*/
date_default_timezone_set('America/Mexico_City'); // Establece la zona horaria
$date = new DateTime($fecha);
$meses = array("ninguno","Ene", "Feb", "Mar", 
            "Abr", "May", "Jun", "Jul","Ago","Sep",
            "Oct","Nov","Dic");

$fechaActual = $date->format('d') . " " . $meses[$date->format('n')] . " del " . $date->format('Y');
$horaActual = date('h:i a'); 
$fechaconsulta=date('Y-m-d');


/*===========================
INICIO PDF
===========================*/
require('../../../fpdf/fpdf.php');

class PDF extends FPDF{
   
}

$pdf = new PDF('P','mm',array(72,300)); // TAMAÑO TICKET 80MM x 150 MM (LARGO APROX)
header("Content-Type: text/html; charset=iso-8859-1 ");
$pdf->AddFont('Poppins-semibold','','Poppins-SemiBold.php');
$pdf->AddFont('Poppins-light','','Poppins-Light.php');
$pdf->SetMargins(2, 0 , 2);


$pdf->AddPage();


//TITULO
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('CORTE DEL TURNO'),0,1,'C');
$pdf->Cell(0,4,utf8_decode('VARADERO'),0,1,'C');

//DETALLES
$pdf->SetFont('Poppins-light','',10);
$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('FECHA'),0,1,'L');
$pdf->SetFont('Poppins-light','',9);
$pdf->Cell(0,0,utf8_decode($fechaActual."  ".$horaActual),0,0,'R');

$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('CAJERO'),0,1,'L');
$pdf->SetFont('Poppins-light','',9);
$pdf->Cell(0,0,utf8_decode($usuario),0,0,'R');


$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('EFECTIVO EN CAJA'),0,1,'L');
$pdf->SetFont('Poppins-light','',9);
$pdf->Cell(0,0,'$'.utf8_decode(number_format($dineroencaja, 0, '.', ',')),0,0,'R');



$pdf->Ln(7);
$pdf->SetFont('Poppins-light','',9);
$pdf->Cell(0,0,utf8_decode($ventas." Ventas realizadas en el turno"),0,0,'C');


/*=========
 ENTRADAS EN EFECTIVO
==*/
//TITULO
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('== ENTRADAS EN EFECTIVO =='),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Poppins-light','',9);


$pdf->Cell(0,4,utf8_decode('--------------------------------------'),0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,0,utf8_decode('Total en Efectivo'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
// $pdf->Cell(0,0,utf8_decode("$".number_format($efectivo, 0, '.', ',')),0,1,'R');
$efectivo_limpio = str_replace(['.', ','], '', $efectivo);
$pdf->Cell(0,0,"$".formatear_numero($efectivo_limpio),0,1,'R');

// // Prueba 1: Texto hardcodeado
// $pdf->Cell(0, 5, "$12,345", 0, 1, 'R');

// // Prueba 2: Variable simple
// $texto = "$12,345";
// $pdf->Cell(0, 5, $texto, 0, 1, 'R');

// // Prueba 3: Concatenación
// $pdf->Cell(0, 5, "$" . "12,345", 0, 1, 'R');



/*=========
 ENTRADAS EN TARJETA
==*/
//TITULO
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('== ENTRADAS EN TARJETA =='),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Poppins-light','',9);


$pdf->Cell(0,4,utf8_decode('--------------------------------------'),0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,0,utf8_decode('Total en Tarjeta'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
// $pdf->Cell(0,0,utf8_decode("$".number_format($tarjeta, 0, '.', ',')),0,1,'R');
$tarjeta_limpio = str_replace(['.', ','], '', $tarjeta);
$pdf->Cell(0,0,"$".formatear_numero($tarjeta_limpio),0,1,'R');


//TITULO
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('== ENTRADAS EN TRANSFERENCIA =='),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Poppins-light','',9);


$pdf->Cell(0,4,utf8_decode('--------------------------------------'),0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,0,utf8_decode('Total en Transferencia'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
// $pdf->Cell(0,0,utf8_decode("$".number_format($transferencia, 0, '.', ',')),0,1,'R');
$transferencia_limpio = str_replace(['.', ','], '', $transferencia);
$pdf->Cell(0,0,"$".formatear_numero($transferencia_limpio),0,1,'R');


/*=========
 SALIDAS
==*/
//TITULO
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('** GASTOS **'),0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Poppins-light','',9);

$totalSalidas=0;

//GASTO
$sql4=mysqli_query($conn, "SELECT gas_id_gasto, gas_costo, gas_concepto FROM gastos where gas_fecha='$fecha' and gas_usuario='$usuario'");
while ($row4 = mysqli_fetch_assoc($sql4)) {
    $gasto=$row4["gas_costo"];
    $totalSalidas+=$gasto;
    $pdf->Cell(0,0,utf8_decode("N: ".$row4["gas_concepto"]),0,1,'L');
    $pdf->Cell(0,0,utf8_decode("$".$gasto),0,1,'R');
    $pdf->Ln(4);

}




$pdf->Cell(0,4,utf8_decode('--------------------------------------'),0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,0,utf8_decode('Total en Gastos'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
// $pdf->Cell(0,0,utf8_decode("$".number_format($totalSalidas, 0, '.', ',')),0,1,'R');
$totalSalidas_limpio = str_replace(['.', ','], '', $totalSalidas);
$pdf->Cell(0,0,"$".formatear_numero($totalSalidas_limpio),0,1,'R');




/*=========
 VENTA GENERAL
==*/
//TITULO
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('=== VENTAS ==='),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Poppins-light','',9);

$pdf->Cell(0,0,utf8_decode('EN EFECTIVO'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
$pdf->Cell(0,0,utf8_decode("$".formatear_numero($efectivo_limpio)),0,1,'R');
$pdf->SetFont('Poppins-light','',9);

$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('EN TARJETA'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
$pdf->Cell(0,0,utf8_decode("$".formatear_numero($tarjeta_limpio)),0,1,'R');
$pdf->SetFont('Poppins-light','',9);

$pdf->Ln(4);
$pdf->Cell(0,0,utf8_decode('EN TRANSFERENCIA'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
$pdf->Cell(0,0,utf8_decode("$".formatear_numero($transferencia_limpio)),0,1,'R');
$pdf->SetFont('Poppins-light','',9);

$pdf->Ln(4);
$pdf->Cell(0,4,utf8_decode('--------------------------------------'),0,1,'C');
$pdf->Ln(2);
$pdf->Cell(0,0,utf8_decode('TOTAL VENTAS'),0,1,'L');
$total=$efectivo_limpio+$tarjeta_limpio+$transferencia_limpio;
$pdf->SetFont('Poppins-semibold','',10);
// $total_limpio = str_replace(['.', ','], '', $total);
$pdf->Cell(0,0,utf8_decode("$".formatear_numero($total)),0,1,'R');



//TOTAL DINERO A ENTREGAR
$pdf->Ln(6);
$resto=($efectivo_limpio+$dineroencaja)-$totalSalidas_limpio;
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(0,4,utf8_decode('TOTAL A ENTREGAR'),0,1,'L');
$pdf->Cell(0,4,utf8_decode('(EFECTIVO - GASTOS)'),0,1,'L');
$pdf->SetFont('Poppins-semibold','',10);
// $resto_limpio = str_replace(['.', ','], '', $resto);
$pdf->Cell(0,4,utf8_decode("$".formatear_numero($resto)),0,1,'R');
// $pdf->Cell(0,4,utf8_decode("$".number_format($resto, 0, '.', ',')),0,1,'R');
$pdf->SetFont('Poppins-light','',9);


//FIRMA DEL RESPONSABLE
$pdf->Ln(12);
$pdf->Cell(0,4,utf8_decode('_______________________'),0,1,'C');
$pdf->Cell(0,4,utf8_decode('Firma de responsable'),0,1,'C');

$pdf->Output('ticket_corte.pdf','I');





// Función personalizada para formatear números sin decimales
function formatear_numero($numero) {
    $entero = number_format($numero, 0, '', ''); // Sin decimales ni separadores
    
    // Agregar comas manualmente cada 3 dígitos
    $entero_formateado = strrev(implode(',', str_split(strrev($entero), 3)));
    
    return $entero_formateado;
}