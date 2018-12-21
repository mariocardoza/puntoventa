<?php 
@session_start();
require_once("../../Conexion/Genericas2.php");
require_once("../../Conexion/Servicio.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=="nuevo_servicio"){
		$result=Genericas2::insertar_generica("tb_servicio",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Servicio::modal_editar($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_servicio'){
	$result=Genericas2::actualizar_generica("tb_servicio",$_POST);
	echo json_encode($result);
	exit();
	}
}
?>