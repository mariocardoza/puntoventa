<?php

//============================================================+

// File name   : FCC.php

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

// set some text to print

$txt = "Mario";

$pdf->SetXY(30, 52); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 8);

$txt = "Apastepeque";

$pdf->SetXY(30, 65); 

$pdf->MultiCell(80,0, $txt,0,'L',false);



$pdf->SetFont('helvetica', '', 11);

$txt = "NRC";

$pdf->SetXY(146, 48); 

$pdf->Write(0, $txt); 



$txt = "NIT";

$pdf->SetXY(146, 54); 

$pdf->Write(0, $txt); 

$txt = '------------------------ Productos ------------------------';

$pdf->SetXY(24, 100); 

$pdf->Write(0, $txt);

// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('ticket.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

