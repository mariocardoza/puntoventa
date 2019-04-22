<?php 
@session_start();
require_once("../../Conexion/Opcion.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_opcion'){
		$result = Opcion::guardar($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_categoria'){
		$result=Genericas2::actualizar_generica("tb_categoria",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Categoria::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Opcion::busqueda($_POST['esto']);
		echo json_encode($result);exit();
	}
}
?>