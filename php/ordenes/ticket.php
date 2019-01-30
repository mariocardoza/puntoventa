<?php
@session_start();

require_once ("../../Conexion/Conexion.php");

require '../../lib/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


/*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

$nombre_impresora = "POS"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
#Mando un numero de respuesta para saber que se conecto correctamente.
echo 1;
/*
	Vamos a imprimir un logotipo
	opcional. Recuerda que esto
	no funcionará en todas las
	impresoras

	Pequeña nota: Es recomendable que la imagen no sea
	transparente (aunque sea png hay que quitar el canal alfa)
	y que tenga una resolución baja. En mi caso
	la imagen que uso es de 250 x 250
*/

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

/*
	Intentaremos cargar e imprimir
	el logo
*/
/*try{
	$logo = EscposImage::load("geek.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*///}
$venta=$_POST['datos'];
$sql="SELECT dv.cantidad,p.nombre,p.descripcion, ROUND(p.precio_unitario*(p.ganancia/100) + p.precio_unitario,2) as precio FROM tb_venta_detalle as dv INNER JOIN tb_producto as p ON p.codigo_oculto=dv.codigo_producto WHERE dv.codigo_venta='$venta'";
//print($sql);exit();

$comando=Conexion::getInstance()->getDb()->prepare($sql);
$comando->execute();
while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	$productos[]=$row;
}
/*
	Ahora vamos a imprimir un encabezado
*/
// set some text to print
$sql_empresa="SELECT * FROM tb_negocio LIMIT 1";
$comando_empresa=Conexion::getInstance()->getDb()->prepare($sql_empresa);
$comando_empresa->execute();
while ($row=$comando_empresa->fetch(PDO::FETCH_ASSOC)) {
	$empresa=$row;
}

$printer->text("\n".$empresa[nombre] . "\n");
$printer->text("Giro: " .$empresa[giro]. "\n");
#La fecha también
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("NIT: " .$empresa[nit]. "\n");
$printer->text("NRC: " .$empresa[nrc]. "\n");
$printer->text($empresa[direccion]. "\n");
date_default_timezone_set("America/El_Salvador");
$printer->text(date("d/m/Y H:i:s") . "\n");
$printer->text("-----------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANT  DESCRIPCION    P.U   IMP.\n");
$printer->text("-----------------------------"."\n");
/*
	Ahora vamos a imprimir los
	productos
*/
$printer->setJustification(Printer::JUSTIFY_LEFT);
	$total=0.0;
foreach ($productos as $producto) {
	
	$printer->text($producto[nombre]."\n");
    $printer->text( $producto[cantidad]." pieza    ".$producto[precio]." ". number_format($producto[precio]*$producto[cantidad],2) ."  \n");
	$total=$total+$producto[cantidad]*$producto[precio];

	$i=$i+14;
}
	/*Alinear a la izquierda para la cantidad y el nombre*/
	
    
/*
	Terminamos de imprimir
	los productos, ahora va el total
*/
$printer->text("-----------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("SUBTOTAL: " .number_format($total,2)."\n");
$printer->text("IVA: $16.00\n");
$printer->text("TOTAL: $116.00\n");


/*
	Podemos poner también un pie de página
*/
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("** Muchas gracias por su compra **\n");



/*Alimentamos el papel 3 veces*/
$printer->feed(3);

/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
$printer->cut();

/*
	Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
$printer->pulse();

/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();

?>