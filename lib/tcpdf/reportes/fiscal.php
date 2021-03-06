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

		// get the current page break margin

        $bMargin = $this->getBreakMargin();

        // get current auto-page-break mode

        $auto_page_break = $this->AutoPageBreak;

        // disable auto-page-break

        $this->SetAutoPageBreak(false, 0);

        // set bacground image

        $img_file = K_PATH_IMAGES.'consumidor.jpg';

        $this->Image($img_file, 0, 0, 215.9, 279.4, '', '', '', false, 300, '', false, false, 0);

        // restore auto-page-break status

        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // set the starting point for the page content

        $this->setPageMark();

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

$pdf->SetTitle('Credito fiscal');

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
require_once ("../../../Conexion/Genericas2.php");


$venta=$_GET['datos'];

$sql_venta="SELECT 
	DATE_FORMAT(v.fecha, '%d/%m/%Y') AS fecha,
	v.total,
	c.nombre as cliente,
	c.direccion as direccion,
	per.nombre as empleado,
	c.nit as nit,
	c.nrc as nrc
FROM
	tb_venta AS v
LEFT JOIN tb_cliente AS c ON c.codigo_oculto = v.cliente
LEFT JOIN tb_persona as per ON per.email=v.cliente
WHERE
	v.codigo_oculto = '$venta'";

	$comandov=Conexion::getInstance()->getDb()->prepare($sql_venta);
	$comandov->execute();
	while ($row=$comandov->fetch(PDO::FETCH_ASSOC)) {
		$venta_aqui=$row;
	}

$sql="SELECT dv.cantidad,p.nombre,p.descripcion, ROUND(p.precio_unitario*(p.ganancia/100) + p.precio_unitario,2) as precio FROM tb_venta_detalle as dv INNER JOIN tb_producto as p ON p.codigo_oculto=dv.codigo_producto WHERE dv.codigo_venta='$venta'";
//print($sql);exit();

$comando=Conexion::getInstance()->getDb()->prepare($sql);
$comando->execute();
while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	$productos[]=$row;
}


$pdf->SetFont('helvetica','',10);
$txt=$venta_aqui[cliente];
$pdf->SetXY(28,52);
$pdf->Write(0,$txt);

$txt=$venta_aqui[direccion];
$pdf->SetXY(30,59);
$pdf->Write(0,$txt);

$txt=$venta_aqui[nit];
$pdf->SetXY(35,82);
$pdf->Write(0,$txt);

$txt=$venta_aqui[nrc];
$pdf->SetXY(127,82);
$pdf->Write(0,$txt);


$txt=$venta_aqui[fecha];
$pdf->SetXY(127,76);
$pdf->Write(0,$txt);

$pdf->SetFont('helvetica','',10);

$i=100;
$contador=0;
$total=0.0;
foreach ($productos as $producto) {
	$txt=$producto[nombre]." ".$producto[descripcion];
	$pdf->SetXY(30,$i);
	//$pdf->Write(0,$txt);
	$pdf->MultiCell(60,0, $txt,0,'L',false);

	$txt=$producto[cantidad];
	$pdf->SetXY(11,$i);
	$pdf->Write(0,$txt);

	$txt="$".$producto[precio];
	$pdf->SetXY(137,$i);
	$pdf->Write(0,$txt);

	$txt="$".number_format($producto[precio]*$producto[cantidad],2);
	$pdf->SetXY(178,$i);
	$pdf->Write(0,$txt);
	$contador=$contador+(int)$producto[cantidad];

	$total=$total+$producto[cantidad]*$producto[precio];

	$i=$i+5;
}

$txt=number_format($total,2);
$pdf->SetXY(178,223);
$pdf->Write(0,$txt);

$aux = $total*0.13;
$pdf->SetXY(178,238);
$pdf->Write(0,number_format($aux,2));
$total=$total+$aux;

$txt=number_format($total,2);
$pdf->SetXY(178,258);
$pdf->Write(0,$txt);

$letras = Genericas2::numaletras(number_format($total,2));
$txt=$letras;
$pdf->SetXY(21,223);
$pdf->MultiCell(100,0, $txt,0,'L',false);
// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('consumidor.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

