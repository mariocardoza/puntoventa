<?php 
@session_start();
require_once("../../Conexion/Venta.php");
require_once("../../Conexion/Cliente.php");
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
	if($_POST['data_id']=='buscar_natural'){
		$result = Genericas2::buscar_por_id("tb_cliente","nombre",$_POST['dato']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='traer_clientes'){
		$result = Cliente::obtener_todos();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='nuevo_cliente'){
		$codigo=date("Yidisus");
		$array = array(
			'data_id' =>'nuevo',
			'nombre' => $_POST[nombre],
			'direccion' => $_POST[direccion],
			'nrc' => $_POST[nrc],
			'nit' => $_POST[nit],
			'codigo_oculto' => $codigo,
			'tipo' => $_POST[tipo]
		);
		$result=Genericas2::insertar_generica("tb_cliente",$array);
		echo json_encode($result);exit();
	}
	
}
 ?>
