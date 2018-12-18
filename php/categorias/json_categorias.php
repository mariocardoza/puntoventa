<?php 
@session_start();
require_once("../../Conexion/Validaciones.php");
require_once("../../Conexion/Categoria.php");
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
		$result=Categoria::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
}
?>