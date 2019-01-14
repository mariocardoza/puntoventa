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

$data=json_decode($_GET['datos']);


// set some text to print
$sql_empresa="SELECT * FROM tb_negocio LIMIT 1";
$comando_empresa=Conexion::getInstance()->getDb()->prepare($sql_empresa);
$comando_empresa->execute();
while ($row=$comando_empresa->fetch(PDO::FETCH_ASSOC)) {
	$empresa=$row;
}
$pdf->SetFont('helvetica','B',18);
$txt=$empresa[nombre];
$pdf->SetXY(30,20);
$pdf->Write(0,$txt);

$pdf->SetFont('helvetica','',14);
$txt="NIT: ".$empresa[nit];
$pdf->SetXY(20,30);
$pdf->Write(0,$txt);

$txt="NRC: ".$empresa[nrc];
$pdf->SetXY(30,40);
$pdf->Write(0,$txt);


$txt = "Dirección: ".$empresa[direccion];

$pdf->SetXY(6, 50); 

$pdf->MultiCell(80,0, $txt,0,'L',false);

//$pdf->Write(0, $txt); 

$txt = "Giro: ".$empresa[giro];

$pdf->SetXY(30, 70); 

$pdf->Write(0,$txt);

$txt="Cliente : 00000000";
$pdf->SetXY(6,80);
$pdf->Write(0,$txt);
$txt="Nombre : Cliente general";
$pdf->SetXY(6,85);
$pdf->Write(0,$txt);

$txt = "Fecha: ".date("d/m/Y");
$pdf->SetXY(6,90);
$pdf->Write(0,$txt);

$txt = "Hora: ".date("H:i:s");
$pdf->SetXY(70,90);
$pdf->Write(0,$txt);



//$pdf->MultiCell(80,0, $txt,0,'L',false);


$txt = 'Descrip.       Cant.   Dto.   Precio U.    Total';

$pdf->SetXY(6, 95); 

$pdf->Write(0, $txt);

$txt="--------------------------------------------------------------";
$pdf->SetXY(6,100);
$pdf->Write(0,$txt);


$pdf->SetFont('helvetica', '', 11);

$txt = $data['data_id'];


$pdf->SetXY(179, 216); 

$pdf->Cell(12,0, $txt, 0, false, 'R');


// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('ticketp.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

