<?php 
@session_start();
require_once("../../Conexion/Validaciones.php");
require_once("../../Conexion/Venta.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_categoria'){
		$result = Genericas2::insertar_generica("tb_categoria",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_categoria'){
		$result=Genericas2::actualizar_generica("tb_categoria",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Venta::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Venta::busqueda($_POST['esto'],$_POST['tipo'],$_POST['mes']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='ver_venta'){
		$result=Genericas2::ver_venta($_POST['id']);
		echo json_encode($result);exit();
	}
}
?>