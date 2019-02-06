<?php 
@session_start();
require_once("../../Conexion/Mesa.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_mesa'){
		$result=Genericas2::insertar_generica("tb_mesa",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Mesa::modal_editar($_POST[id]);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_mesa'){
		$result=Genericas2::actualizar_generica("tb_mesa",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']='busqueda'){
		$result=Mesa::busqueda();
		echo json_encode($result);exit();
	}
}
 ?>
