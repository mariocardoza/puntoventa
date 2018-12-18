<?php 
@session_start();
require_once("../../Conexion/Genericas2.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nueva_politica'){
		$result=Genericas2::insertar_generica("tb_politicas",$_POST);
		echo json_encode($result);
		exit();
	}
}

 ?>