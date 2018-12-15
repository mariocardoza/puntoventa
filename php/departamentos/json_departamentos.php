<?php 
@session_start();
require_once("../../Conexion/Validaciones.php");
require_once("../../Conexion/Departamento.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nuevo_departamento'){
		$result = Genericas2::insertar_generica("tb_departamento",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_departamento'){
		$result=Genericas2::actualizar_generica("tb_departamento",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Departamento::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
}
?>