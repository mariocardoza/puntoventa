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
$pdf->SetTitle('FCF');
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
$id_orden=(isset($_GET['id'])) ? $_GET['id'] : "";

if($id_orden!="") {
    /* CONSULTA DE LOS DATOS GENERALES DE UNA ORDEN DE TRABAJO */
    $sql="
    	SELECT
			ot.id,
			ot.fecha AS fecha_o,
			ot.version,
			ot.tipo as tipo_docu,
			ot.n_factura,
			ot.condicion,
			ot.dias,
			ot.clasificacion,
			ot.id_doc,
			ot.imp_veh,
			DATE_FORMAT( ot.fecha, '%d/%m/%Y' ) AS fecha,
			DATE_FORMAT( ot.fecha, '%r' ) AS hora,
			em.id AS id_empleado_r,
			em.nombre AS n_empleado,
			cl.id AS id_cliente,
			cl.tipo,
			cl.nombre AS n_cliente,
			cl.dui,
			cl.t_doc,
			cl.n_doc,
			cl.nit,
			cl.pasaporte,
			cl.direccion,
			cl.telefono,
			cl.correo,
			cl.tipo AS cl_tipo,
			cl.nombre_contacto,
			cl.telefono_contacto,
			cl.email_contacto,
			cl.nrc,
			cl.sector,
			cl.fcf,
			cl.ccf,
			pr.kilometraje,
			pr.k_proxima,
			/*checklist.kilometraje,*/
			vehiculo.id AS id_vehiculo,
			vehiculo.anyo AS vehiculo_anyo,
			vehiculo.placa AS placa,
			vehiculo.motor AS motor,
			/*vehiculo.kilometraje,
			vehiculo.k_proxima,*/
			color.nombre AS color,
			modelo.id AS id_modelo,
			modelo.familia,
			modelo.cilindraje,
			modelo.modelo AS modelo,
			marca.id AS id_marca,
			marca.nombre AS marca 
		FROM
			t_orden_trabajo AS ot
			INNER JOIN t_vehiculo AS vehiculo ON ot.id_moto = vehiculo.id
			INNER JOIN t_modelo AS modelo ON modelo.id = vehiculo.modelo
			INNER JOIN t_marca AS marca ON marca.id = modelo.id_marca
			INNER JOIN t_clinete AS cl ON cl.id = ot.id_cliente
			INNER JOIN t_empleado AS em ON em.id = ot.id_empleado_r
			LEFT JOIN colores AS color ON color.id = vehiculo.color
			INNER JOIN t_primera_revicion as pr on pr.id_orden_t = ot.id
		WHERE ot.id = '$id_orden'";
    try {
        $comando="";
        $comando=Conexion::getInstance()->getDb()->prepare($sql);
        $comando->execute();
        $datos_ot=$comando->fetchAll();
        //echo "$sql";
        //print_r($datos_ot);exit();
        $version = $datos_ot[0]['version'];

        $fecha_r = "$dia/$mes/$anyo";
        if($datos_ot[0]['fecha']){$fecha_r=$datos_ot[0]['fecha'];}

        $sql="SELECT * FROM `t_documentos` ";
    	$comando=Conexion::getInstance()->getDb()->prepare($sql);
        $comando->execute();
        $datos_AUX=$comando->fetchAll();


        /*----------inicio: inicializar servicios guardados------------*/
	        $sql = "
	        	SELECT
					dtp.id_trabajo as id,
					trab.trabajo,
					trab.codigo,
					dtp.descuento,
					dtp.porcentaje,
					dtp.precio,
					ROUND( dtp.precio, 2 ) AS precio_r ,
					ROUND( dtp.descuento, 2 ) AS descuento_r 
				FROM
					t_detalle_procesos AS dtp
					INNER JOIN t_trabajos AS trab ON trab.id = dtp.id_trabajo 
				WHERE
					dtp.id_orden = $id_orden";
			$comando="";
	        $comando=Conexion::getInstance()->getDb()->prepare($sql);
	        $comando->execute();
	        $datos_procesos2=$comando->fetchAll();
	        //print_r($datos_procesos2);exit();
	        $filas1=0;
	        
        /*----------fin: inicializar servicios guardados------------*/

        /*----------inicio: inicializar repuestos guardados------------*/
	        $sql = "
	        	SELECT
					dtr.id_repuesto as id,
					dtr.cantidad,
					dtr.descuento,
					dtr.precio,
					dtr.porcentaje,
					dtr.ganancia,
					repu.nombre,
					repu.codigo,
					ROUND( dtr.precio, 2 ) AS precio_r ,
					ROUND( dtr.descuento, 2 ) AS descuento_r ,
					ROUND( ((dtr.precio*dtr.cantidad)-(dtr.descuento)), 2 ) AS sub_total 
				FROM
					t_detalle_repuestos AS dtr
					INNER JOIN t_repuesto AS repu ON repu.id = dtr.id_repuesto 
				WHERE
					dtr.id_orden = $id_orden";
			$comando="";
	        $comando=Conexion::getInstance()->getDb()->prepare($sql);
	        $comando->execute();
	        $datos_repuestos2=$comando->fetchAll();

	        $sql="SELECT * FROM t_porcentajes";
	        $comando="";
	        $comando=Conexion::getInstance()->getDb()->prepare($sql);
	        $comando->execute();
	        $datos_porcentajes=$comando->fetchAll();
	        //$filas1=0;
	        
	    /*----------fin: inicializar repuestos guardados------------*/
    }
    catch(PDOException $e) {
        echo $sql." ERROR " . $e->getMessage();
        exit();
    }
}
// set some text to print

$txt = "".$datos_ot[0]['n_cliente'];
$pdf->SetXY(30, 52); 
$pdf->Write(0, $txt); 

$pdf->SetFont('helvetica', '', 9);
$resultado = substr($datos_ot[0]['direccion'], 0,100);
$txt = $resultado;
$pdf->SetXY(30, 59); 
$pdf->Write(0, $txt); 
 

$txt = $datos_ot[0]['nit'];
$pdf->SetXY(32, 82); 
$pdf->Write(0, $txt); 
 

$txt = $datos_ot[0]['fecha'];
$pdf->SetXY(127, 74); 
$pdf->Write(0, $txt); 

if($datos_ot[0]['imp_veh'] == "Si"){
	$txt = $datos_ot[0]['marca'];
	$pdf->SetXY(150, 74); 
	$pdf->Write(0, $txt); 

	$txt = $datos_ot[0]['vehiculo_anyo'];
	$pdf->SetXY(168, 74); 
	$pdf->Write(0, $txt); 

	$pdf->SetFont('helvetica', '', 8);
	$txt = $datos_ot[0]['modelo'];
	$pdf->SetXY(182, 73); 
	$pdf->MultiCell(15,0, $txt,0,'L',false);

	$pdf->SetFont('helvetica', '', 11);
	$txt = $datos_ot[0]['placa'];
	$pdf->SetXY(127, 85); 
	$pdf->Cell(50,0, $txt);
}

$txt = '------------------------ Servicios ------------------------';
$pdf->SetXY(24, 100); 
$pdf->Write(0, $txt);

$i=104;
$j=1.0;
$pdf->SetFont('helvetica', '', 10);
$p_iva = $datos_porcentajes[0]['porcentaje']/100;

foreach ($datos_procesos2 as $lista) {
	$precio_t=($lista['precio_r']-$lista['descuento']);
	$precio_t= $precio_t* (1+$p_iva);
	$total_pro+=$precio_t;

    $txt = $j;
	$pdf->SetXY(15, $i); 
	$pdf->Write(0, $txt);

	$pdf->SetFont('helvetica', '', 8);
	$txt = substr(strtoupper($lista['trabajo']), 0,65);
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
foreach ($datos_repuestos2 as $lista) {
	//$precio_t = $lista['sub_total'];
	//$precio_t = round($precio_t, 2);
	$precio_t = ($lista['precio'] * $lista['cantidad']);
	$precio_t = $precio_t - $lista['descuento'];
	$precio_t = $precio_t* (1+$p_iva);
	$total_repu+=$precio_t;

	$txt = $j;
	$pdf->SetXY(15, $i); 
	$pdf->Write(0, $txt);

	$pdf->SetFont('helvetica', '', 8);
	$txt = substr(strtoupper($lista['nombre']), 0,65);
	$pdf->SetXY(24, $i); 
	$pdf->Write(0, $txt);

	$pdf->SetFont('helvetica', '', 10);	
	$txt = number_format(($precio_t), 2, '.', '');
	$pdf->SetXY(182, $i); 
	$pdf->Cell(12,0, $txt, 0, false, 'R');
	$i+=4.5;
	$j++;	
}
$pdf->SetFont('helvetica', '', 11);
$sumas = ($total_repu+$total_pro);
//$iva = $sumas*($datos_porcentajes[0]['porcentaje']/100);
//$p_gran_c = $datos_porcentajes[2]['porcentaje'];
$iva_r = 0.00;
$sub_total = $sumas+$iva;
if($datos_ot[0]['sector']=="Gran Contribuyente"){
	$iva_r = (($p_gran_c/100) * $sumas);
}
$total_t = $sub_total - $iva_r ;

$total = round($sub_total, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 223); 
$pdf->Cell(12,0, $txt, 0, false, 'R');

/*$total = round($iva, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 223); 
$pdf->Cell(12,0, $txt, 0, false, 'R');*/

$total = round($sub_total, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 230); 
$pdf->Cell(12,0, $txt, 0, false, 'R');

$total = round($iva_r, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 237); 
$pdf->Cell(12,0, $txt, 0, false, 'R');

$total = round(0, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 244); 
$pdf->Cell(12,0, $txt, 0, false, 'R');

$total = round(0, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 251); 
$pdf->Cell(12,0, $txt, 0, false, 'R');

$total = round($total_t, 2);
$txt = number_format($total, 2, '.', '');
$pdf->SetXY(183, 258); 
$pdf->Cell(12,0, $txt, 0, false, 'R');


// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('FCF.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
