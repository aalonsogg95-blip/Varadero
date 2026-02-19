<?php

include_once "../../conexion1.php";
session_start();
$usuario= $_SESSION["datosUsuarioCaja"]["usuario"];



 ///////////////////////////////////////////////
//VARIABLES
$datos=json_decode($_GET['dat']);
// var_dump($datos);  
$encaja=$datos[0]->encaja;
$ingresos=$datos[0]->ingresos;


date_default_timezone_set('America/Mexico_City');
$Y = date('Y');
$m=intval(date("m"));
$d=date("d");

$fechanormal=date("Y-m-d");

$hora = date('h:i a');

  $meses = array("ninguno","Enero", "Febrero", "Marzo", 
  "Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre",
  "Octubre","Noviembre","Diciembre");

$fecha= $d." de ".$meses[$m]." del ".$Y;

///////////////////////////////////////////////////////////////////////
//INCLUIR LIBRERIA(PDF)
require('../fpdf/fpdf.php');

class PDF extends FPDF{
   
}

$pdf = new PDF('P','mm',array(72,200)); // TAMAÑO TICKET 80MM x 150 MM (LARGO APROX)
header("Content-Type: text/html; charset=iso-8859-1 ");
$pdf->AddFont('Poppins-semibold','','Poppins-SemiBold.php');
$pdf->AddFont('Poppins-light','','Poppins-Light.php');
$pdf->AddFont('GreatVibes-Regular','','GreatVibes-Regular.php');
$pdf->SetMargins(0, 0 , 0);

$pdf->AddPage();
//CABECERA
$pdf->Image('../../img/varadero_logo.png',20,3,30,30);

$pdf->Ln(33);
$pdf->SetFont('Poppins-semibold','',9);
$pdf->Cell(70,5,utf8_decode('Juarez 184, Tecalitlan Jal'),0,0,'C');
$pdf->Cell(10,5, " ",0,1,'c');
$pdf->Cell(70,5,'Cel: 3411382883',0,0,'C');
$pdf->Cell(10,5, " ",0,1,'c');


$pdf->Ln(3);
//FECHA Y HORA
$pdf->SetFont('Poppins-light','',8);//FUENTE
$pdf->Cell(70,5,$fecha."  ".$hora,0,1,'C');

//EN CAJA

$pdf->Ln(5);
$pdf->SetFont('Poppins-semibold','',8);
$pdf->Cell(72,5,utf8_decode('Dinero en Caja'),0,1,'C');
$pdf->SetFont('Poppins-light','',10);//FUENTE
$pdf->Cell(72,5,utf8_decode("$".$encaja),0,1,'C');


//INGRESOS

$pdf->Ln(4);
$pdf->SetFont('Poppins-semibold','',12);
$pdf->Cell(72,5,utf8_decode('Ingresos'),0,1,'C');
$pdf->SetFont('Poppins-light','',14);//FUENTE
$pdf->Cell(72,5,utf8_decode('$'.$ingresos),0,1,'C');

$total=$ingresos+$encaja;

$pdf->Ln(7);
$pdf->SetFont('Poppins-semibold','',12);
$pdf->Cell(72,5,utf8_decode('Total'),0,1,'C');
$pdf->SetFont('Poppins-light','',14);//FUENTE
$pdf->Cell(72,5,utf8_decode('$'.$total),0,1,'C');



//GASTOS
$sql=mysqli_query($conn, "SELECT sum(gas_costo) as totalgasto FROM gastos where gas_fecha='{$fechanormal}'");
if($sql){
  $fila = mysqli_fetch_assoc($sql);
    $gastos = ($fila['totalgasto'] !== null) ? $fila['totalgasto'] : 0;
}

$pdf->Ln(7);
$pdf->SetFont('Poppins-semibold','',12);
$pdf->Cell(72,5,utf8_decode('Gastos'),0,1,'C');
$pdf->SetFont('Poppins-light','',14);//FUENTE
$pdf->Cell(72,5,utf8_decode('$'.$gastos),0,1,'C');




///RESULTADO
$resultado=$total-$gastos;


$pdf->Ln(7);
$pdf->SetFont('Poppins-semibold','',12);
$pdf->Cell(72,7,utf8_decode('Resto'),0,1,'C');
$pdf->SetFont('Poppins-light','',16);//FUENTE
$pdf->Cell(72,7,utf8_decode('$'.$resultado),0,1,'C');








$pdf->Ln(10);//SALTO DE LINEA
 $pdf->SetFont('Poppins-semibold','',10);//FUENTE
$pdf->Cell(72,4,utf8_decode('¡Gracias por todo lo que haces!'),0,1,'C');
$pdf->Cell(72,4,utf8_decode($usuario),0,1,'C');
$pdf->Ln(3);//SALTO DE LINEA


$pdf->SetFont('Poppins-light','',9);





 $pdf->Output('tickets.pdf','I');