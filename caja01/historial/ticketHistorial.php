<?php
//FECHA
date_default_timezone_set('America/Mexico_City');

     	//VARIABLE FECHA
    //  	$fechatic=date("d/m/Y");
    // $dia=date("d");
    // $mes=date("n");
    // $anual=date("Y");
    //** */
    // $f=date("Y-m-d");
    // $hora= date("g : i a");


///////////////////////////////////////////////
//VARIABLES
$venta=Json_decode($_GET['ven']);
$lugar=$venta->lugar;
$hora=$venta->hora;
$ordenes=$venta->ordenes;
$consumo=$venta->consumo;
$totalVenta=$venta->totalVenta;
$envio=$venta->envio;
$fecha=$venta->fecha;

    $dia=date("d", strtotime($fecha));
    $mes=date("n", strtotime($fecha));
    $anual=date("Y", strtotime($fecha));


    $meses = array("ninguno","Enero", "Febrero", "Marzo", 
     		"Abril", "Mayo", "Junio", "Julio","Agosto","Septiembre",
     		"Octubre","Noviembre","Diciembre");
             
$fecha=$dia." de ".$meses[$mes]." del ".$anual;


///////////////////////////////////////////////////////////////////////
//INCLUIR LIBRERIA(PDF)
require('../fpdf/fpdf.php');

class PDF extends FPDF{
   
}

$pdf = new PDF('P','mm',array(72,800)); // TAMAÑO TICKET 80MM x 150 MM (LARGO APROX)
header("Content-Type: text/html; charset=iso-8859-1 ");
$pdf->AddFont('Poppins-semibold','','Poppins-SemiBold.php');
$pdf->AddFont('Poppins-light','','Poppins-Light.php');
$pdf->AddFont('GreatVibes-Regular','','GreatVibes-Regular.php');
$pdf->SetMargins(0, 0 , 0);

$pdf->AddPage();
//CABECERA
$pdf->Image('../../img/varadero_logo.png',21,3,30,25);

$pdf->Ln(30);
$pdf->SetFont('Poppins-semibold','',8);
$pdf->Cell(70,4,utf8_decode('Ponce de León #35, Tecalitlán Jal.'),0,0,'C');;
$pdf->Cell(10,4, " ",0,1,'c');
$pdf->Cell(70,4,'Cel: 341 138 2883',0,0,'C');
$pdf->Cell(10,4, " ",0,1,'c');




//FECHA Y HORA
$pdf->SetFont('Poppins-light','',7);//FUENTE
$pdf->Cell(70,4,$fecha."  "."$hora",0,1,'C');



///LUGAR DE LA ENTREGA 
$pdf->Ln(2);
 $pdf->SetFont('Poppins-semibold','',10);//FUENTE
$pdf->Multicell(72,5,utf8_decode($lugar),0,'C',0);//TITULO
$pdf->Ln(2);



//DATOS DE LA VENTA
$pdf->SetFont('Poppins-semibold','',8);//FUENTE
//CABECERA DE TABLA
        $pdf->Cell(2, 5, '', 0, 0, 'C', 0);
        $pdf->Cell(8, 5, 'Cant', 0, 0, 'C', 0);
        $pdf->Cell(40, 5, 'Producto', 0, 0, 'C', 0);
        $pdf->Cell(10, 5, 'Cost', 0, 0, 'C', 0);
        $pdf->Cell(10, 5, 'Tot', 0, 0, 'C', 0);

        $pdf->Ln(4);
       $pdf->Cell(72, 0.5, " ", 0,1,'T',1);//LINEAR SEPARADORA DE
        $pdf->Ln(1);


        $pdf->SetFont('Poppins-light','',9);//FUENTE
     
    //MOSTRAR ORDENES
    for($o=0; $o<sizeof($ordenes); $o++){
            
         $pdf->cell(2,4,'',0,0,'C',0);
         $pdf->Cell(8, 4, $ordenes[$o]->cantidad, 0, 0, 'C');
         $pdf->Cell(40, 4, utf8_decode($ordenes[$o]->categoria), 0, 0, 'C');//MOSTRAR CATEGORIA
         $pdf->Cell(10, 4, "$".$ordenes[$o]->costo, 0, 0, 'C');
         $pdf->Cell(10, 4, "$".number_format($ordenes[$o]->total), 0, 1, 'C');
         $pdf->Cell(60, 3, utf8_decode($ordenes[$o]->producto), 0, 1, 'C'); //MOSTRAR PRODUCTO

    }


//////////////////////////
//COSTO DE ENVIO
if($envio!=0){
    $pdf->SetFont('Poppins-semibold','',10);//FUENTE
    $pdf->SetTextColor(0,0,0);
    $pdf->Ln(10);//SALTO DE LINEA
    $pdf->Cell(12,0,"Envio:",0,0,'L');
    $pdf->SetFont('Poppins-light','',10);
    $pdf->Cell(55,0,"$".$envio,0,1,'L');  
}else{
    $pdf->Ln(10);
}

/////////////////////////////////////////////////////
///TOTAL DE VENTA
$sum=$totalVenta;
$pdf->SetFont('Poppins-semibold','',10);//FUENTE
$pdf->SetTextColor(0,0,0);
$pdf->Ln(5);//SALTO DE LINEA
$pdf->Cell(55,0,"Total:",0,0,'R');
$pdf->SetFont('Poppins-light','',14);
//** */
$pdf->Cell(15,0,"$".number_format($sum),0,1,'L');

/////////////////////////////////////
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(72,4,utf8_decode('Ayudanos a seguir mejorando'),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(72,4,utf8_decode('¿Que te gustó más?'),0,1,'C');
$pdf->SetFont('Poppins-light','',9);//FUENTE
$pdf->Cell(72,4,utf8_decode('*Sabor              *Calidad            *Servicio'),0,1,'C');
$pdf->Cell(72,4,utf8_decode('*Precio             *Tiempo             *Porción'),0,1,'C');
$pdf->SetFont('Poppins-light','',8);//FUENTE
$pdf->Cell(72,4,utf8_decode('(Selecciona más de una opción)'),0,1,'C');


$pdf->Ln(5);
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(72,6,utf8_decode('¿Que te gustaría mejorar?'),0,1,'C');
$pdf->Cell(3,6,'',0,0,'C');
$pdf->Cell(66,6,'','B',0,'C');
$pdf->Cell(3,6,'',0,1,'C');

$pdf->Cell(3,6,'',0,0,'C');
$pdf->Cell(66,6,'','B',0,'C');
$pdf->Cell(3,6,'',0,1,'C');


///MENSAJE FINAL
//$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->SetTextColor(0,0,0);
$pdf->Ln(10);//SALTO DE LINEA
$pdf->SetFont('GreatVibes-Regular','',17);
$pdf->Cell(72,0,utf8_decode('¡Gracias por su preferencia!'),0,1,'C');
$pdf->Ln(5);//SALTO DE LINEA
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(72,0,utf8_decode('Vuelva pronto'),0,1,'C');


$pdf->Output('tickets.pdf','I');