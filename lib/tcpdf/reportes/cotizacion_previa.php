<?php
$datos_tabla = file_get_contents("../../json/datos_cotizacion.json");
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

$pdf->SetTitle('Cotizacion');

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

require_once ("../../../inc/config.php");

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
	echo $e->getMessage();
	exit();
}

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



// set some text to print

$pdf->SetFont('helvetica', 'b', 40);

$txt = $template['titulo'];

$pdf->SetXY(14, 10); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 15);

$txt = $template['sub_titulo'];

$pdf->SetXY(14, 25); 

$pdf->MultiCell(68,0, $txt,0,'C',false); //Write(0, $txt);



$pdf->SetFont('helvetica', 'b', 12);

$txt = $template['sub_titulo2'];

$pdf->SetXY(14, 33); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = $template['direccion'];

$pdf->SetXY(14, 39); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = $template['telefonos'];

$pdf->SetXY(14, 45); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = "NOMBRE:";

$pdf->SetXY(14, 53); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 12);

$txt = "".$_GET['n_cliente'];

$pdf->SetXY(14, 58); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = "Dirección:";

$pdf->SetXY(14, 65); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 12);

$resultado = substr($_GET['direccion'], 0,200);

$txt = $resultado;

$pdf->SetXY(14, 73); 

$pdf->Write(0, $txt); 

 

$pdf->SetFont('helvetica', 'b', 12);

$txt = "NIT:";

$pdf->SetXY(14, 78); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 12);

$txt = $_GET['nit'];

$pdf->SetXY(14, 83); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = "Fecha:";

$pdf->SetXY(14, 90); 

$pdf->Write(0, $txt);



$pdf->SetFont('helvetica', '', 12);

$txt = $_GET['p_fecha'];

$pdf->SetXY(14, 96); 

$pdf->Write(0, $txt); 



if($_POST['imp_veh'] == "Si"){

	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Marca:";

	$pdf->SetXY(54, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 12);

	$txt = $vehiculo['marca'];

	$pdf->SetXY(54, 96); 

	$pdf->MultiCell(34,0, $txt,0,'L',false); 



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Año:";

	$pdf->SetXY(94, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 12);

	$txt = $vehiculo['anyo'];

	$pdf->SetXY(94, 96); 

	$pdf->Write(0, $txt); 



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Modelo:";

	$pdf->SetXY(134, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 10);

	$txt = $vehiculo['modelo'];

	$pdf->SetXY(134, 96); 

	$pdf->MultiCell(34,0, $txt,0,'L',false);



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Placa:";

	$pdf->SetXY(174, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 10);

	$txt = $vehiculo['placa'];

	$pdf->SetXY(174, 96); 

	$pdf->Cell(50,0, $txt);

}



$i=115;

$j=1.0;



$k=0;

$filas1=0;

if(isset($procesos)){
foreach ($procesos as $lista) {

	$precio_t=($lista['precio']-$lista['descuento']);

	//$precio_t= $precio_t* (1+$p_iva);

	$total_pro+=$precio_t;



	$i+=4.5;

	$j++;

	if($k==0)$html_procesos.='<tr><td colspan="6" style="text-align:center;">SERVICIOS</td></tr>';

	$html_procesos.='<tr class="fila_p" id="fila1_'.($filas_g+1).'">

	  <td width="10%" style="text-align:center;">'.($filas_g+1).'</td>

	  <td width="10%" style="text-align:center;">'.$lista['codigo'].'</td>

	  <td width="50%" style="padding-right:20px;">'.$lista['nombre'].'</td>

	  <td width="10%" style="text-align:right;">'.$lista['precio'].'</td>

	  <td width="10%" style="text-align:center;">1</td>

	  <td width="10%" style="text-align:right;">'.number_format(round($precio_t, 2), 2, '.', '').'</td>

	</tr>';

	$filas1++;

	$filas_g++;

	$k++;

}
}



$i+=4.5;

$filas2=$k=0;
if(isset($repuestos)){
foreach ($repuestos as $lista) {

	$precio_t = ($lista['precio'] * $lista['cantidad']);

	$precio_t = $precio_t - $lista['descuento'];

	$total_repu+=$precio_t;



	$i+=4.5;

	$j++;	

	if($k==0)$html_repuestos.='<tr><td colspan="6" style="text-align:center;">REPUESTOS</td></tr>';

	$html_repuestos.='<tr class="fila_p" id="fila1_'.($filas_g+1).'">

	  <td width="10%" style="text-align:center;">'.($filas_g+1).'</td>

	  <td width="10%" style="text-align:center;">'.$lista['codigo'].'</td>

	  <td width="50%" style="padding-right:20px;">'.$lista['nombre'].'</td>

	  <td width="10%" style="text-align:right;">'.$lista['precio'].'</td>

	  <td width="10%" style="text-align:center;">'.$lista['cantidad'].'</td>

	  <td width="10%" style="text-align:right;">'.number_format(round($precio_t, 2), 2, '.', '').'</td>

	</tr>';

	//

	$filas2++;

	$filas_g++;$k++;

}
}


$pdf->SetFont('helvetica', '', 11);

$sumas = ($total_repu+$total_pro);

$iva = $sumas*($datos_porcentajes[0]['porcentaje']/100);
//$iva = $sumas*(13/100);

$p_gran_c = $datos_porcentajes[2]['porcentaje'];
//$p_gran_c = 1;

$iva_r = 0.00;

$html_iva="";

$sub_total = $sumas;

$total_t = $sub_total;



if(($_GET['p_clasificacion']=='si')){

      $iva = $sumas*(13/100);

      $p_gran_c = 1;

      $html_iva="";

      $sub_total = $sumas+$iva;

      if($datos_ot[0]['sector']=="Gran Contribuyente" && $sumas >= 100){

        $iva_r = (($p_gran_c/100) * $sumas);

      }

      $total_t = $sub_total - $iva_r ;

    	$html_iva='<tr>

              <th class="hidden-xs" colspan="5" style="text-align: right; padding-right: 10px;font-weight:bold;">Neto($)</th>

              <th style="text-align:right;"><span  id="total_general">'.number_format(round(($sumas), 2), 2, '.', '').'</span></th>

            </tr>

            <tr>

              <th class="hidden-xs"  colspan="5" style="text-align: right; padding-right: 10px;font-weight:bold;">IVA($)</th>

              <th style="text-align:right;"><span  id="total_iva">'.number_format(round($iva, 2), 2, '.', '').'</span></th>

            </tr>

            <tr>

              <th class="hidden-xs"  colspan="5" style="text-align: right; padding-right: 10px;font-weight:bold;">1% RET.($)</th>

              <th style="text-align:right;"><span  id="total_ret">-('.number_format(round($iva_r, 2), 2, '.', '').')</span></th>

            </tr>

            <tr>

              <th class="hidden-xs"  colspan="5" style="text-align: right; padding-right: 10px;font-weight:bold;">Subtotal($)</th>

              <th style="text-align:right;"><span  id="total_subt"></span></th>

            </tr>';

    }

    $html_foot='

       <tfoot>

            '.$html_iva.'

            <tr>

              <th class="hidden-xs"  colspan="5" style="text-align: right; padding-right: 10px;font-weight:bold;">Total($)</th>

              <th style="text-align:right;"><span  id="total_total">'.number_format(round($total_t, 2), 2, '.', '').'</span></th>

            </tr>

       </tfoot>

    ';

$tabla = ' <table cellspacing="0" cellpadding="1" border="1">

            <thead>

                <tr>

                  <th width="10%" style="text-align:center;font-weight:bold;">#</th>

                  <th width="10%" style="font-weight:bold;">Código</th>

                  <th width="50%" style="font-weight:bold;">Detalle</th>

                  <th width="10%" style="text-align:right;font-weight:bold;">Precio($)</th>

                  <th width="10%" style="font-weight:bold;">Cantidad</th>

                  <th width="10%" style="text-align:right;font-weight:bold;">Total($)</th>

                </tr>

            </thead>

            <tbody id="tb_procesos">

              '.$html_procesos.'

              '.$html_repuestos.'

            </tbody>

            '.$html_foot.'

        </table>';

$pdf->SetXY(14, 103); 

$pdf->writeHTML($tabla, true, false, false, false, '');



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



// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('Exportacoion.pdf', 'I');



//============================================================+

// END OF FILE

//============================================================+

