<?php 
@session_start();
require_once("../../Conexion/Venta.php");
require_once("../../Conexion/Producto.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_venta'){
		$result=Venta::nueva_venta($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result = Producto::busqueda_venta($_POST['esto'],$_POST['departamento']);
		echo json_encode($result);exit();
	}
	
}
 ?>