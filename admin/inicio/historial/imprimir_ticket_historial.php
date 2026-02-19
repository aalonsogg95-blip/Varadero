<?php

include_once "../../../conexion1.php";



/**
 * Genera fecha en formato español: "01 Noviembre del 2025"
 */

// Configurar zona horaria
date_default_timezone_set('America/Mexico_City');

// Meses en español (índice empieza en 1)
$meses = [
    1 => 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

// Obtener fecha actual
$dia = date('d');
$mes = (int) date('n');
$anio = date('Y');

// Formatear fecha
$fecha = sprintf('%s %s del %s', $dia, $meses[$mes], $anio);









/**
 * RECIBIR DATOS DESDE LA URL
 */
$datosEncriptados = $_GET['data'] ?? '';

if ($datosEncriptados) {
    // Decodificar Base64
    $datosJSON = base64_decode(urldecode($datosEncriptados));
    $datos = json_decode($datosJSON, true);


    
    // Extraer variables
    $cuenta = json_decode($datos['cli']) ?? '';
    $envio = $datos['env'] ?? '';
    $total = $datos['tot'] ?? '';
    $factura = $datos['fac'] ?? '';
    $hora = $datos['hor'] ?? '';
    $horaFormateada = convertirHora12($hora);
   
    $cliente=$cuenta->lugar;
    $consumo=$cuenta->consumo;
    $celular=$cuenta->observacion;
    $ordenes=$cuenta->ordenes;
    $iva=$cuenta->iva_facturas;




 /**
 * INICIAR PDF
 */
  require('../../../fpdf/fpdf.php');

  class PDF extends FPDF{
    
  }

  $pdf = new PDF('P','mm',array(72,280)); // TAMAÑO TICKET 80MM x 150 MM (LARGO APROX)
  header("Content-Type: text/html; charset=iso-8859-1 ");
  $pdf->AddFont('Poppins-semibold','','Poppins-SemiBold.php');
  $pdf->AddFont('Poppins-light','','Poppins-Light.php');
  $pdf->AddFont('GreatVibes-Regular','','GreatVibes-Regular.php');
  $pdf->SetMargins(0, 0 , 0);


  $pdf->AddPage();
  //CABECERA
  $pdf->Image('../../../img/varadero_logo.png',21,3,30,25);

  $pdf->Ln(30);
  $pdf->SetFont('Poppins-semibold','',8);
  $pdf->Cell(70,4,utf8_decode('Ponce de León #35, Tecalitlán Jal'),0,0,'C');;
  $pdf->Cell(10,4, " ",0,1,'c');
  $pdf->Cell(70,4,'Cel: 341 138 2883',0,0,'C');
  $pdf->Cell(10,4, " ",0,1,'c');


  $pdf->Ln(3);
  //FECHA Y HORA
  $pdf->SetFont('Poppins-light','',8);//FUENTE
  $pdf->Cell(70,4,$fecha."  ".$horaFormateada,0,1,'C');




  ///LUGAR DE LA ENTREGA 
  $pdf->Ln(2);
  $pdf->SetFont('Poppins-semibold','',10);//FUENTE
  $pdf->Multicell(72,5,utf8_decode($cliente),0,'C',0);//TITULO
  if($celular!="vacio"){
    $pdf->SetFont('Poppins-light','',8);//FUENTE
    $pdf->Cell(70,4,$celular,0,1,'C');
  }
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
         $cantidad = $ordenes[$o]->ord_cantidad;
          $unidad = ($cantidad == 1) ? 'pza' : 'pzas';

          $pdf->Cell(8, 4, "$cantidad $unidad", 0, 0, 'C');
         $pdf->Cell(40, 4, utf8_decode($ordenes[$o]->ord_categoria), 0, 0, 'C');//MOSTRAR CATEGORIA
         $pdf->Cell(10, 4, "$".$ordenes[$o]->ord_costo, 0, 0, 'C');
         $pdf->Cell(10, 4, "$".number_format($ordenes[$o]->ord_total), 0, 1, 'C');
         $pdf->Cell(60, 3, utf8_decode($ordenes[$o]->ord_producto), 0, 1, 'C'); //MOSTRAR PRODUCTO

    }




/////////////////////////////////////////////////////
//COSTO DE ENVIO, SOLO SI LA ORDEN SE ENTREGA EN EL DOMICILIO
if($consumo==3 and $envio!=0){
    $pdf->Ln(7);
    $pdf->SetFont('Poppins-semibold','',7);//FUENTE
    $pdf->SetTextColor(0,0,0);
    $pdf->Cell(5,0,"",0,0,'L');
    $pdf->Cell(10,0,"Envio:",0,0,'L');
    $pdf->SetFont('Poppins-light','',9);
    $pdf->Cell(29,0,"$".$envio,0,1,'L'); 
    $total+=$envio; 
}else{

}

///////////////////////////////////////////////////
//TOTAL DE VENTA
$pdf->SetFont('Poppins-semibold','',10);//FUENTE
$pdf->SetTextColor(0,0,0);
$pdf->Ln(8);//SALTO DE LINEA
$pdf->Cell(50,0,"Total:",0,0,'R');
$pdf->SetFont('Poppins-light','',10);
$pdf->Cell(15,0,"$".$total,0,1,'L');


///////////////////////////////////////////////////
//VALIDAR SI ESTA ACTIVA LA FACTURA
if($iva!=0){
    $iva=Intval($iva);
    $totalIva=$total+$iva;

    $pdf->Ln(4);
    $pdf->SetFont('Poppins-semibold','',10);//FUENTE
    $pdf->Cell(50,0,"IVA:",0,0,'R');
    $pdf->SetFont('Poppins-light','',10);
    $pdf->Cell(20,0,"$".number_format($iva, 0, '.', ','),0,1,'L');

    $grantotal=$totalIva;
    if($consumo==3 and $envio!=0){
          $grantotal+=$envio;
    }

    $pdf->Ln(4);
    $pdf->SetFont('Poppins-semibold','',10);//FUENTE
    $pdf->Cell(50,0,"Gran Total:",0,0,'R');
    $pdf->SetFont('Poppins-light','',10);
    $pdf->Cell(20,0,"$".number_format($grantotal, 0, '.', ','),0,1,'L');


    //INSTRUCCIONES PARA FACTURA
    $pdf->SetLeftMargin(2);
    $pdf->SetRightMargin(2);

    $pdf->Ln(8);
    $pdf->SetFont('Poppins-light','',8.5);
    $pdf->Cell(0,4,"***Instrucciones***",0,1,'C');
    $instruccion = utf8_decode('Para recibir tu factura, envía tu constancia de situación fiscal al 341 138 2883 con la foto de tu ticket.');
    $pdf->MultiCell(0, 4, $instruccion, 0, 'C');

}


/////////////////////////////////////
$pdf->Ln(10);
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(0,4,utf8_decode('Ayudanos a seguir mejorando'),0,1,'C');
$pdf->Ln(5);
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(0,4,utf8_decode('¿Que te gustó más?'),0,1,'C');
$pdf->SetFont('Poppins-light','',9);//FUENTE
$pdf->Cell(0,4,utf8_decode('*Sabor              *Calidad            *Servicio'),0,1,'C');
$pdf->Cell(0,4,utf8_decode('*Precio             *Tiempo             *Porción'),0,1,'C');
$pdf->SetFont('Poppins-light','',8);//FUENTE
$pdf->Cell(0,4,utf8_decode('(Selecciona más de una opción)'),0,1,'C');


$pdf->Ln(5);
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(0,6,utf8_decode('¿Que te gustaría mejorar?'),0,1,'C');

$pdf->Cell(0,6,'','B',1,'C');
$pdf->Cell(0,6,'','B',0,'C');





///MENSAJE FINAL
//$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->SetTextColor(0,0,0);
$pdf->Ln(10);//SALTO DE LINEA
$pdf->SetFont('GreatVibes-Regular','',17);
$pdf->Cell(0,0,utf8_decode('¡Gracias por su preferencia!'),0,1,'C');
$pdf->Ln(5);//SALTO DE LINEA
$pdf->SetFont('Poppins-semibold','',9);//FUENTE
$pdf->Cell(0,0,utf8_decode('Vuelva pronto'),0,1,'C');




$pdf->Output('tickets.pdf','I');
}











function convertirHora12($hora) {
    // Validar que la hora no esté vacía
    if (empty($hora)) {
        return '';
    }
    
    // Crear objeto DateTime desde la hora recibida
    $datetime = DateTime::createFromFormat('H:i:s', $hora);
    
    // Si el formato es inválido, intentar con H:i
    if (!$datetime) {
        $datetime = DateTime::createFromFormat('H:i', $hora);
    }
    
    // Si aún falla, retornar hora original
    if (!$datetime) {
        return $hora;
    }
    
    // Formatear a 12 horas con AM/PM
    return $datetime->format('h:i A');
}

