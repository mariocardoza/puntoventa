<?php 
@session_start();
require_once("../../Conexion/Politica.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_politica'){
		$result=Politica::guardar($_POST);
		echo json_encode($result);
	}
	if($_POST['data_id']=='busqueda'){
		$result=Politica::busqueda();
		echo json_encode($result);exit();
	}
}

 ?>