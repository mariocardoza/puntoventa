<?php
@session_start();
//============================================================+

// File name   : ticketp.php

// Begin       : 05-06-2018

// Last Update : 05-06-2018

//

// Description : reporte de fcc

//              }

//

// Author: oskrgl

//

// (c) Copyright:

//               oskrgl

//============================================================+



/**

 * Creates an example PDF TEST document using TCPDF

 * @package com.taller.php.tcpdf

 * @abstract TCPDF - Example: Custom Header and Footer

 * @author oskrgl

 * @since 05-06-2018

 */



// Include the main TCPDF library (search for installation path).

require_once('tcpdf_include.php');





// Extend the TCPDF class to create custom Header and Footer

class MYPDF extends TCPDF {



	//Page header

	public function Header() {

		// Logo

		// Set font

		$this->SetFont('helvetica', 'B', 20);

		// Title

		$this->Cell(0, 15, '', 0, false, 'C', 0, '', 0, false, 'M', 'M');

	}



	// Page footer

	public function Footer() {

		// Position at 15 mm from bottom

		$this->SetY(-15);

		// Set font

		$this->SetFont('helvetica', 'I', 8);

		// Page number

		//$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

	}

}



// create new PDF document

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LETTER', true, 'UTF-8', false);



// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Estudio A');

$pdf->SetTitle('ticket');

$pdf->SetSubject('');

$pdf->SetKeywords('');



// set default header data

$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);



// set header and footer fonts

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(0);

$pdf->SetFooterMargin(0);



// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, 0);



// set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

	require_once(dirname(__FILE__).'/lang/eng.php');

	$pdf->setLanguageArray($l);

}



// ---------------------------------------------------------



// set font

$pdf->SetFont('helvetica', '', 11);



// add a page

$pdf->AddPage();

$dia=date("d") ;

$mes=date("m");

$anyo=date("Y");

$hora=date("H:i:s");

require_once ("../../../Conexion/Conexion.php");

$venta=$_GET['datos'];

$sql_venta="SELECT v.*,c.nombre as n_cliente, c.nit as c_nit FROM tb_venta as v LEFT JOIN tb_cliente as c ON c.codigo_oculto=v.cliente  WHERE v.codigo_oculto='$venta'";
$comandov=Conexion::getInstance()->getDb()->prepare($sql_venta);
$comandov->execute();
while ($row=$comandov->fetch(PDO::FETCH_ASSOC)) {
	$venta_a=$row;
}



$sql="SELECT dv.cantidad,p.nombre,p.descripcion, ROUND(p.precio_unitario*(p.ganancia/100) + p.precio_unitario,2) as precio FROM tb_venta_detalle as dv INNER JOIN tb_producto as p ON p.codigo_oculto=dv.codigo_producto WHERE dv.codigo_venta='$venta'";
//print($sql);exit();

$comando=Conexion::getInstance()->getDb()->prepare($sql);
$comando->execute();
while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	$productos[]=$row;
}

// set some text to print
$sql_empresa="SELECT * FROM tb_negocio LIMIT 1";
$comando_empresa=Conexion::getInstance()->getDb()->prepare($sql_empresa);
$comando_empresa->execute();
while ($row=$comando_empresa->fetch(PDO::FETCH_ASSOC)) {
	$empresa=$row;
}
$pdf->SetFont('helvetica','B',12);
$txt=$empresa[nombre];
$pdf->SetXY(20,20);
$pdf->Write(0,$txt);

$pdf->SetFont('helvetica','',9);
$txt="NIT: ".$empresa[nit];
$pdf->SetXY(20,25);
$pdf->Write(0,$txt);

$txt="NRC: ".$empresa[nrc];
$pdf->SetXY(30,30);
$pdf->Write(0,$txt);


$txt = "Dirección: ".$empresa[direccion];

$pdf->SetXY(6, 35); 

$pdf->MultiCell(60,0, $txt,0,'L',false);

//$pdf->Write(0, $txt); 

$txt = "Giro: ".$empresa[giro];

$pdf->SetXY(15, 50); 

$pdf->Write(0,$txt);

if($venta_a[cliente]==''){
	$txt="Cliente: 0000000";
	$pdf->SetXY(6,60);
	$pdf->Write(0,$txt);
	$txt="Nombre : Cliente general";
	$pdf->SetXY(6,65);
	$pdf->Write(0,$txt);
}else{
	$txt="Cliente: ".$venta_a[c_nit];
	$pdf->SetXY(6,60);
	$pdf->Write(0,$txt);
	$txt="Nombre: ".$venta_a[n_cliente];
	$pdf->SetXY(6,65);
	$pdf->Write(0,$txt);
}


$txt = "Fecha: ".date("d/m/Y");
$pdf->SetXY(6,70);
$pdf->Write(0,$txt);

$txt = "Hora: ".date("H:i:s");
$pdf->SetXY(40,70);
$pdf->Write(0,$txt);



//$pdf->MultiCell(80,0, $txt,0,'L',false);


$txt = 'Descrip.       Cant.   Dto.   Precio U.    Total';

$pdf->SetXY(6, 75); 

$pdf->Write(0, $txt);

$txt="--------------------------------------------------------------";
$pdf->SetXY(6,80);
$pdf->Write(0,$txt);
$i=85;
$contador=0;
$total=0.0;
foreach ($productos as $producto) {
	$txt=$producto[nombre]." ".$producto[descripcion];
	$pdf->SetXY(6,$i);
	//$pdf->Write(0,$txt);
	$pdf->MultiCell(20,0, $txt,0,'L',false);

	$txt=$producto[cantidad];
	$pdf->SetXY(24,$i);
	$pdf->Write(0,$txt);

	$txt='0.00';
	$pdf->SetXY(37,$i);
	$pdf->Write(0,$txt);

	$txt="$".$producto[precio];
	$pdf->SetXY(47,$i);
	$pdf->Write(0,$txt);

	$txt="$".number_format($producto[precio]*$producto[cantidad],2);
	$pdf->SetXY(59,$i);
	$pdf->Write(0,$txt);
	$contador=$contador+(int)$producto[cantidad];

	$total=$total+$producto[cantidad]*$producto[precio];

	$i=$i+16;
}
$txt="--------------------------------------------------------------";
$pdf->SetXY(6,$i-7);
$pdf->Write(0,$txt);

$txt="Cant. Artículos: ".$contador;
$pdf->SetXY(6,$i-2);
$pdf->Write(0,$txt);

$txt="Subtotal Gravado:";
$pdf->SetXY(15,$i+3);
$pdf->Write(0,$txt);

$txt="$".number_format($total,2);
$pdf->SetXY(59,$i+3);
$pdf->Write(0,$txt);

$txt="Subtotal Exento:";
$pdf->SetXY(15,$i+8);
$pdf->Write(0,$txt);

$txt="$0.00";
$pdf->SetXY(59,$i+8);
$pdf->Write(0,$txt);

$txt="No sujetas:";
$pdf->SetXY(15,$i+13);
$pdf->Write(0,$txt);

$txt="$0.00";
$pdf->SetXY(59,$i+13);
$pdf->Write(0,$txt);

$txt="Total a pagar:";
$pdf->SetXY(15,$i+18);
$pdf->Write(0,$txt);

$txt="$".number_format($total,2);
$pdf->SetXY(59,$i+18);
$pdf->Write(0,$txt);

$txt="Paga con:";
$pdf->SetXY(15,$i+23);
$pdf->Write(0,$txt);

if($venta_a[tipo_venta]==1){
	$txt="$".number_format($venta_a[efectivo],2);
	$pdf->SetXY(59,$i+23);
	$pdf->Write(0,$txt);

	$txt="$".number_format($venta_a[cambio],2);
	$pdf->SetXY(59,$i+28);
	$pdf->Write(0,$txt);

	$txt="Efectivo:";
	$pdf->SetXY(6,$i+58);
	$pdf->Write(0,$txt);

	$txt="$".number_format($venta_a[efectivo],2);
	$pdf->SetXY(50,$i+58);
	$pdf->Write(0,$txt);
}
if($venta_a[tipo_venta]==2){
	$txt="$".number_format($total,2);
	$pdf->SetXY(59,$i+23);
	$pdf->Write(0,$txt);

	$txt="$".number_format(0,2);
	$pdf->SetXY(59,$i+28);
	$pdf->Write(0,$txt);

	$txt="Crédito:";
	$pdf->SetXY(6,$i+58);
	$pdf->Write(0,$txt);

	$txt="$".number_format($total,2);
	$pdf->SetXY(50,$i+58);
	$pdf->Write(0,$txt);
}
if($venta_a[tipo_venta]==3){
	$txt="$".number_format($total,2);
	$pdf->SetXY(59,$i+23);
	$pdf->Write(0,$txt);

	$txt="$".number_format(0,2);
	$pdf->SetXY(59,$i+28);
	$pdf->Write(0,$txt);

	$txt="Tarjeta (Crédito/Débito):";
	$pdf->SetXY(6,$i+58);
	$pdf->Write(0,$txt);

	$txt="$".number_format($total,2);
	$pdf->SetXY(50,$i+58);
	$pdf->Write(0,$txt);
}


$txt="Cambio:";
$pdf->SetXY(15,$i+28);
$pdf->Write(0,$txt);

//$cambio=5.00-$total;


$txt="Cajero (a):";
$pdf->SetXY(6,$i+33);
$pdf->Write(0,$txt);

$txt=($_SESSION['nombre']);
$pdf->SetXY(24,$i+33);
$pdf->Write(0,$txt);

$txt="Autorizacion No: 5748-RES-CS-78778-978";
$pdf->SetXY(6,$i+43);
$pdf->Write(0,$txt);
$txt="Fecha de autorización: 14/01/2019";
$pdf->SetXY(6,$i+48);
$pdf->Write(0,$txt);

$txt="Forma de pago:";
$pdf->SetXY(6,$i+53);
$pdf->Write(0,$txt);

$txt="*** Gracias por su compra ***";
$pdf->SetXY(11,$i+73);
$pdf->Write(0,$txt);


// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('ticketp.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

