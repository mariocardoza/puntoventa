<?php 
@session_start();
require_once("../../Conexion/Validaciones.php");
require_once("../../Conexion/Subcategoria.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_subcategoria'){
		$result = Genericas2::insertar_generica("tb_subcategoria",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_subcategoria'){
		$result=Genericas2::actualizar_generica("tb_subcategoria",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Subcategoria::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Subcategoria::busqueda($_POST['esto']);
		echo json_encode($result);exit();
	}
}
?>