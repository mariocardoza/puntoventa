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

			

			/*checklist.kilometraje,*/

			vehiculo.id AS id_vehiculo,

			vehiculo.anyo AS vehiculo_anyo,

			vehiculo.placa AS placa,

			vehiculo.motor AS motor,

			vehiculo.kilometraje,

			vehiculo.k_proxima,

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

			LEFT JOIN t_modelo AS modelo ON modelo.id = vehiculo.modelo

			LEFT JOIN t_marca AS marca ON marca.id = vehiculo.marca

			INNER JOIN t_clinete AS cl ON cl.id = ot.id_cliente

			INNER JOIN t_empleado AS em ON em.id = ot.id_empleado_r

			LEFT JOIN colores AS color ON color.id = vehiculo.color

		WHERE

			 ot.id = '$id_orden'";

    try {

        $comando="";

        $comando=Conexion::getInstance()->getDb()->prepare($sql);

        $comando->execute();

        $datos_ot=$comando->fetchAll();

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



$pdf->SetFont('helvetica', 'b', 10);

$txt = "NOMBRE DEL CLIENTE:";

$pdf->SetXY(14, 53); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'B', 14);

$txt = "".$datos_ot[0]['n_cliente'];

$pdf->SetXY(14, 58); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = "Dirección:";

$pdf->SetXY(14, 65); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 12);

$resultado = substr($datos_ot[0]['direccion'], 0,200);

$txt = $resultado;

$pdf->SetXY(14, 73); 

$pdf->Write(0, $txt); 

 

$pdf->SetFont('helvetica', 'b', 12);

$txt = "NIT:";

$pdf->SetXY(14, 78); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', '', 12);

$txt = $datos_ot[0]['nit'];

$pdf->SetXY(14, 83); 

$pdf->Write(0, $txt); 



$pdf->SetFont('helvetica', 'b', 12);

$txt = "Fecha:";

$pdf->SetXY(150, 60); 

$pdf->Write(0, $txt);



$pdf->SetFont('helvetica', '', 12);

$txt = $datos_ot[0]['fecha'];

$pdf->SetXY(150, 65); 

$pdf->Write(0, $txt); 



if($datos_ot[0]['imp_veh'] == "Si"){

	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Marca:";

	$pdf->SetXY(14, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', '', 12);

	$txt = $datos_ot[0]['marca'];

	$pdf->SetXY(30, 90); 

	$pdf->MultiCell(34,0, $txt,0,'L',false); 



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Año:";

	$pdf->SetXY(76, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = $datos_ot[0]['vehiculo_anyo'];

	$pdf->SetXY(89, 90); 

	$pdf->Write(0, $txt); 



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Modelo:";

	$pdf->SetXY(100, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', 'b', 10);

	$txt = $datos_ot[0]['modelo'];

	$pdf->SetXY(120, 90); 

	$pdf->MultiCell(34,0, $txt,0,'L',false);



	$pdf->SetFont('helvetica', 'b', 12);

	$txt = "Placa:";

	$pdf->SetXY(174, 90); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', 'b', 10);

	$txt = $datos_ot[0]['placa'];

	$pdf->SetXY(189, 90); 

	$pdf->Cell(50,0, $txt);

	//kilometraje

	$pdf->SetFont('helvetica', 'b', 10);

	$txt = "KM. RECEPCIÓN:";

	$pdf->SetXY(140, 30); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', 'b', 10);

	$txt = $datos_ot[0]['kilometraje'];

	$pdf->SetXY(170, 30); 

	$pdf->Cell(50,0, $txt);

	//proxima
	$pdf->SetFont('helvetica', 'b', 10);

	$txt = "KM. PRÓXIMA REVISIÓN:";

	$pdf->SetXY(140, 40); 

	$pdf->Write(0, $txt);



	$pdf->SetFont('helvetica', 'b', 10);

	$txt = $datos_ot[0]['k_proxima'];

	$pdf->SetXY(183, 40); 

	$pdf->Cell(50,0, $txt);

}



$i=115;

$j=1.0;



$k=0;

$filas1=0;

foreach ($datos_procesos2 as $lista) {

	$precio_t=($lista['precio']-$lista['descuento']);

	//$precio_t= $precio_t* (1+$p_iva);

	$total_pro+=$precio_t;



	$i+=4.5;

	$j++;

	if($k==0)$html_procesos.='<tr><td colspan="7" style="text-align:center;">SERVICIOS</td></tr>';

	$html_procesos.='<tr class="fila_p" id="fila1_'.($filas_g+1).'">

	  <td width="10%" style="text-align:center;">'.($filas_g+1).'</td>

	  <td width="10%" style="text-align:center;">'.$lista['codigo'].'</td>

	  <td width="40%" style="padding-right:20px;">'.$lista['trabajo'].'</td>

	  <td width="10%" style="text-align:right;">'.$lista['precio_r'].'</td>

	  <td width="10%" style="text-align:center;">1</td>

	  <td width="10%" style="text-align:right;">'.$lista['descuento_r'].'</td>

	  <td width="10%" style="text-align:right;">'.number_format(round($precio_t, 2), 2, '.', '').'</td>

	</tr>';

	$filas1++;

	$filas_g++;

	$k++;

}



$i+=4.5;

$filas2=$k=0;

foreach ($datos_repuestos2 as $lista) {

	$precio_t = ($lista['precio'] * $lista['cantidad']);

	$precio_t = $precio_t - $lista['descuento'];

	$total_repu+=$precio_t;



	$i+=4.5;

	$j++;	

	if($k==0)$html_repuestos.='<tr><td colspan="7" style="text-align:center;">REPUESTOS</td></tr>';

	$html_repuestos.='<tr class="fila_p" id="fila1_'.($filas_g+1).'">

	  <td width="10%" style="text-align:center;">'.($filas_g+1).'</td>

	  <td width="10%" style="text-align:center;">'.$lista['codigo'].'</td>

	  <td width="40%" style="padding-right:20px;">'.$lista['nombre'].'</td>

	  <td width="10%" style="text-align:right;">'.$lista['precio_r'].'</td>

	  <td width="10%" style="text-align:center;">'.$lista['cantidad'].'</td>

	  <td width="10%" style="text-align:right;">'.$lista['descuento_r'].'</td>

	  <td width="10%" style="text-align:right;">'.number_format(round($precio_t, 2), 2, '.', '').'</td>

	</tr>';

	//

	$filas2++;

	$filas_g++;$k++;

}



$pdf->SetFont('helvetica', '', 11);

$sumas = ($total_repu+$total_pro);

$iva = $sumas*($datos_porcentajes[0]['porcentaje']/100);

$p_gran_c = $datos_porcentajes[2]['porcentaje'];

$iva_r = 0.00;

$html_iva="";

$sub_total = $sumas;

$total_t = $sub_total;

//print($datos_ot[0]['n_cliente'])

if(($datos_ot[0]['clasificacion']=='si')){

      $iva = $sumas*($datos_porcentajes[0]['porcentaje']/100);

      $p_gran_c = $datos_porcentajes[2]['porcentaje'];

      $html_iva="";

      $sub_total = $sumas+$iva;

      if($datos_ot[0]['sector']=="Gran Contribuyente" && $sumas >= 100){

        $iva_r = (($p_gran_c/100) * $sumas);

      }

      $total_t = $sub_total - $iva_r ;

    	$html_iva='<tr>

              <th class="hidden-xs" colspan="6" style="text-align: right; padding-right: 10px;font-weight:bold;">Neto($)</th>

              <th style="text-align:right;"><span  id="total_general">'.number_format(round(($sumas), 2), 2, '.', '').'</span></th>

            </tr>

            <tr>

              <th class="hidden-xs"  colspan="6" style="text-align: right; padding-right: 10px;font-weight:bold;">IVA($)</th>

              <th style="text-align:right;"><span  id="total_iva">'.number_format(round($iva, 2), 2, '.', '').'</span></th>

            </tr>

            <tr>

              <th class="hidden-xs"  colspan="6" style="text-align: right; padding-right: 10px;font-weight:bold;">1% RET.($)</th>

              <th style="text-align:right;"><span  id="total_ret">-('.number_format(round($iva_r, 2), 2, '.', '').')</span></th>

            </tr>

            <tr>

              <th class="hidden-xs"  colspan="6" style="text-align: right; padding-right: 10px;font-weight:bold;">Subtotal($)</th>

              <th style="text-align:right;"><span  id="total_subt"></span></th>

            </tr>';

    }

    $html_foot='

       <tfoot>

            '.$html_iva.'

            <tr>

              <th class="hidden-xs"  colspan="6" style="text-align: right; padding-right: 10px;font-weight:bold;">Total($)</th>

              <th style="text-align:right;"><span  id="total_total">'.number_format(round($total_t, 2), 2, '.', '').'</span></th>

            </tr>

       </tfoot>

    ';

$tabla = ' <table cellspacing="0" cellpadding="1" border="0">

            <thead>

                <tr>

                  <th width="10%" style="text-align:center;font-weight:bold;">#</th>

                  <th width="10%" style="font-weight:bold;">Código</th>

                  <th width="40%" style="font-weight:bold;">Detalle</th>

                  <th width="10%" style="text-align:right;font-weight:bold;">Precio($)</th>

                  <th width="10%" style="font-weight:bold;">Cantidad</th>

                  <th width="10%" style="text-align:right;font-weight:bold;">DTO($)</th>

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

