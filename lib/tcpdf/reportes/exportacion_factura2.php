<?php
$datos_tabla = file_get_contents("../../json/datos_tabla.json");
$json_tabla = json_decode($datos_tabla, true);
$procesos = $json_tabla['datos2']['obj_procesos'];
$repuestos = $json_tabla['datos2']['obj_repuestos'];
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

        $img_file = K_PATH_IMAGES.'exportacion.jpg';

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

$pdf->SetTitle('F. Exportacoión');

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

require_once ("../../conexion/Conexion.php");

$datos_ot=$datos_porcentajes=null;

$datos_procesos=null; $datos_repuestos=null;

$datos_procesos2=null; $datos_repuestos2=null;

$filas1=$filas2=$filas_g=0;

$html_obj="[";$html_procesos="";

$html_obj2="[";$html_repuestos="";

$fila_obj=0;$html_servicios="";$html_repuesto="";

$total_pro=$total_repu=0;

$total_pro_tiempo="";

$total_t=0;

$tipo_documento="";

$n_correlativo=0;

$id_ve = $_GET['cm_vehiculo'];

$sql_v="SELECT vh.id,vh.placa AS placa,m.nombre AS marca,mo.modelo AS modelo,vh.anyo AS anyo FROM t_vehiculo AS vh INNER JOIN t_marca AS m ON vh.marca=m.id LEFT JOIN t_modelo AS mo ON vh.modelo=mo.id WHERE vh.id=$id_ve";
try{
	$comandov=Conexion::getInstance()->getDb()->prepare($sql_v);
$comandov->execute();
while ($row = $comandov->fetch(PDO::FETCH_ASSOC)) {
	$vehiculo=$row;
}
}catch(Exception $e){
	echo $sql_v;
	echo $e->getMessage();exit();
}

       
$sql="SELECT * FROM t_porcentajes";

$comando="";

$comando=Conexion::getInstance()->getDb()->prepare($sql);

$comando->execute();

$datos_porcentajes=$comando->fetchAll();


// set some text to print

$txt = "".$_GET['n_cliente'];

$pdf->SetXY(30, 49); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 9);

$resultado = substr($_GET['direccion'], 0,100);

$txt = $resultado;

$pdf->SetXY(30, 58); 

$pdf->Write(0, $txt); 

 



$txt = $_GET['nit'];

$pdf->SetXY(32, 80); 

$pdf->Write(0, $txt); 



$txt = $_GET['p_fecha'];

$pdf->SetXY(127, 73); 

$pdf->Write(0, $txt); 



if($_GET['imp_veh'] == "Si"){

	$txt = $datos_ot[0]['marca'];

	$pdf->SetXY(150, 73); 

	$pdf->Write(0, $txt); 



	$txt = $_GET[0]['anyo'];

	$pdf->SetXY(168, 73); 

	$pdf->Write(0, $txt); 



	$pdf->SetFont('helvetica', '', 8);

	$txt = $_GET['modelo'];

	$pdf->SetXY(182, 73); 

	$pdf->MultiCell(15,0, $txt,0,'L',false);



	$pdf->SetFont('helvetica', '', 11);

	$txt = $_GET['placa'];

	$pdf->SetXY(127, 82); 

	$pdf->Cell(50,0, $txt);

}

$txt = '------------------------ Servicios ------------------------';

$pdf->SetXY(24, 100); 

$pdf->Write(0, $txt);



$i=104;

$j=1.0;

$pdf->SetFont('helvetica', '', 10);

foreach ($procesos as $lista) {

	$precio_t=($lista['precio']-$lista['descuento']);

	//$precio_t= $precio_t* (1+$p_iva);

	$total_pro+=$precio_t;



    $txt = $j;

	$pdf->SetXY(15, $i); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 9);

	$txt = substr(strtoupper($lista['proceso']), 0,80);

	$pdf->SetXY(24, $i); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 10);

	$txt = number_format($precio_t, 2, '.', '');

	$pdf->SetXY(182, $i); 

	$pdf->Cell(12,0, $txt, 0, false, 'R');

	$i+=4.5;

	$j++;

}

$txt = '------------------------ Repuestos ------------------------';

$pdf->SetXY(24, $i); 

$pdf->Write(0, $txt);

$i+=4.5;

foreach ($repuestos as $lista) {

	$precio_t = ($lista['precio'] * $lista['cantidad']);

	$precio_t = $precio_t - $lista['descuento'];

	$total_repu+=$precio_t;



	$txt = $j;

	$pdf->SetXY(15, $i); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 9);

	$txt = substr(strtoupper($lista['item']), 0,80);

	$pdf->SetXY(24, $i); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 10);

	$txt = number_format($precio_t, 2, '.', '');

	$pdf->SetXY(182, $i); 

	$pdf->Cell(12,0, $txt, 0, false, 'R');

	$i+=4.5;

	$j++;	

}

$pdf->SetFont('helvetica', '', 11);

$sumas = ($_GET['total']);

$aux = $sumas ;

$unidad = array  ('un','dos','tres','cuatro','cinco','seis','siete','ocho','nueve'); 

$decenas = array ('diez','once','doce', 'trece','catorce','quince'); 

$decena = array  ('dieci','veinti','treinta','cuarenta','cincuenta','sesenta','setenta','ochenta','noventa'); 

$centena = array  ('ciento','doscientos','trescientos','cuatrocientos','quinientos','seiscientos','setecientos','ochocientos','novecientos'); 

$millares= array  ('mill','millon');



$linea = ""; 

//$sumas = 1258;

$num = $sumas;

$mill = (int) ($num / 1000);

$cen = (int) ($num / 100);             //Cifra de las centenas 

$doble = $num - ($cen*100);             //Cifras de las decenas y unidades 

$dec = (int)($num / 10) - ($cen*10);    //Cifra de laa decenas 

$uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 

if($mill > 0){

	$num = $sumas - ($mill*1000);

	$linea = $millares[0]." ";

	$cen = (int) ($num / 100);             //Cifra de las centenas 

	$doble = $num - ($cen*100);             //Cifras de las decenas y unidades 

	$dec = (int)($num / 10) - ($cen*10);    //Cifra de laa decenas 

	$uni = $num - ($dec*10) - ($cen*100);   //Cifra de las unidades 

}

if ($cen > 0) { 

    if ($num == 100) $linea = "cien"; 

    else $linea .= $centena[$cen-1].' '; 

}//end if 

if ($doble>0) { 

    if ($doble == 20) { 

        $linea .= " veinte"; 

    }elseif (($doble < 16) and ($doble>9)) { 

        $linea .= $decenas[$doble-10]; 

    }else { 

        $linea .=' '. $decena[$dec-1]; 

    }//end if 

    if ($dec>2 and $uni<>0) $linea .=' y '; 

    if (($uni>0) and ($doble>15) or ($dec==0)) { 

        if ($uni == 1) $linea.="uno"; 

        else $linea.=$unidad[$uni-1]; 

    } 

 } 

$n=$sumas; 

$r=($n-intval($n))*100; 



$txt = $linea." <sup>".((int)$r)."</sup>"."/<sub>100</sub> dolares (US)";

$txt = ucfirst($txt);

$pdf->SetXY(30, 223); 

$pdf->writeHTML($txt , true, false, true, false, '');

//$pdf->Write(0, $txt);



$total = round($sumas, 2);

$txt = number_format($total, 2, '.', '');

$pdf->SetXY(183, 223); 

$pdf->Cell(12,0, $txt, 0, false, 'R');

//$iva = $sumas*($datos_porcentajes[0]['porcentaje']/100);

//$p_gran_c = $datos_porcentajes[2]['porcentaje'];





// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('Exportacoion.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

