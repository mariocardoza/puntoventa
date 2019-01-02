<?php 
require_once("../../Conexion/Validaciones.php");
require_once("../../Conexion/Proveedor.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nuevo_proveedor'){
		$result = Genericas2::insertar_generica("tb_proveedor",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_proveedor'){
		$result=Genericas2::actualizar_generica("tb_proveedor",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Proveedor::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Proveedor::busqueda($_POST['esto']);
		echo json_encode($result);
		exit();
	}
}
?>