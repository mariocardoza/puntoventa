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

$pdf->SetTitle('comanda');

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

$comanda=$_GET['datos'];

$sql_comanda="SELECT c.*,m.nombre as n_mesa, DATE_FORMAT(c.fecha,'%d/%m/%Y') as dia_comanda,DATE_FORMAT(fecha,'%H:%m:%s') as hora_comanda FROM tb_comanda as c LEFT JOIN tb_mesa as m ON m.codigo_oculto=c.mesa WHERE c.codigo_oculto='$comanda'";
$comandov=Conexion::getInstance()->getDb()->prepare($sql_comanda);
$comandov->execute();
while ($row=$comandov->fetch(PDO::FETCH_ASSOC)) {
	$comanda_a=$row;
}
$tipo_comanda="";


$sql="SELECT
	notas,
	n_producto,
	precio_p,
	codigo_producto,
	descripcion
FROM
	(
		SELECT
			dc.notas AS notas,
			p.nombre AS n_producto,
			ROUND(
				(
					(
						(p.ganancia / 100) * p.precio_unitario
					) + p.precio_unitario
				),
				2
			) AS precio_p,
			p.codigo_oculto as codigo_producto,
			p.descripcion as descripcion
		FROM
			tb_producto AS p
		INNER JOIN tb_comanda_detalle AS dc ON dc.codigo_producto = p.codigo_oculto
		WHERE
			dc.codigo_comanda = '$comanda'
		UNION ALL
			SELECT
				dc.notas AS notas,
				r.nombre AS n_producto,
				r.precio AS precio_p,
				r.codigo_oculto as codigo_producto,
				r.descripcion as descripcion
			FROM
				tb_receta AS r
			INNER JOIN tb_comanda_detalle AS dc ON dc.codigo_producto = r.codigo_oculto
			WHERE
				dc.codigo_comanda = '$comanda'
	) AS t";
//print($sql);exit(

$comando=Conexion::getInstance()->getDb()->prepare($sql);
$comando->execute();
while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	$comandas[]=$row;
}

$pdf->SetFont('helvetica','B',12);
$txt="Comanda";
$pdf->SetXY(20,20);
$pdf->Write(0,$txt);

$pdf->SetFont('helvetica','',9);
if($comanda_a[tipo]==1){
$tipo_comanda="Tipo de orden: Mesas";
$txt=$tipo_comanda;
$pdf->SetXY(15,25);
$pdf->Write(0,$txt);

$txt="Número de clientes: ".$comanda_a[numero_clientes];
$pdf->SetXY(15,30);
$pdf->Write(0,$txt);
}else{
	if($comanda_a[tipo]==2){

	}else{
		if($comanda_a[tipo]==3){

		}
	}
}

$txt="Nombre del cliente: ";
$pdf->SetXY(6,35);
$pdf->Write(0,$txt);


$txt = "Fecha: ".$comanda_a[dia_comanda];
$pdf->SetXY(6,40);
$pdf->Write(0,$txt);

$txt = "Hora: ".$comanda_a[hora_comanda];
$pdf->SetXY(40,40);
$pdf->Write(0,$txt);



//$pdf->MultiCell(80,0, $txt,0,'L',false);


$txt = 'Ordenes.       ';

$pdf->SetXY(6, 50); 

$pdf->Write(0, $txt);

$txt="--------------------------------------------------------------";
$pdf->SetXY(6,55);
$pdf->Write(0,$txt);
$i=60;
$contador=0;
$total=0.0;
foreach ($comandas as $comanda) {
	$sql_pro="SELECT p.nombre as n_producto FROM `tb_receta_detalle` as rc INNER JOIN tb_producto as p ON p.codigo_oculto=rc.codigo_producto WHERE rc.codigo_receta='$comanda[codigo_producto]'";
	$comando2=Conexion::getInstance()->getDb()->prepare($sql_pro);
	$comando2->execute();
	$txt=$comanda[n_producto]." ".$comanda[descripcion];
	$pdf->SetXY(6,$i);
	//$pdf->Write(0,$txt);
	$pdf->MultiCell(30,0, $txt,0,'L',false);
	/*while ($row=$comando2->fetch(PDO::FETCH_ASSOC)) {
		$txt="- ".$row[n_producto];
		$pdf->SetXY(10,$i+10);
		$pdf->Write(0,$txt);
		$i=$i+3;
	}*/

	$txt="- ".substr($comanda[notas],2);;
	$pdf->SetXY(10,$i+10);
	$pdf->Write(0,$txt);

	$txt="$".number_format($comanda[precio_p],2);
	$pdf->SetXY(59,$i);
	$pdf->Write(0,$txt);
	$contador=$contador+1;

	$i=$i+16;
}
$txt="--------------------------------------------------------------";
$pdf->SetXY(6,$i);
$pdf->Write(0,$txt);

$txt="Cant. Artículos: ".$contador;
$pdf->SetXY(6,$i+3);
$pdf->Write(0,$txt);




$txt="Mesero (a):";
$pdf->SetXY(6,$i+8);
$pdf->Write(0,$txt);

$txt=($_SESSION['nombre']);
$pdf->SetXY(24,$i+8);
$pdf->Write(0,$txt);


$txt="*** Gracias por su compra ***";
$pdf->SetXY(11,$i+13);
$pdf->Write(0,$txt);


// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('comanda.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

