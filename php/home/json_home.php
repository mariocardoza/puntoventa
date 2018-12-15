<?php 
require_once("../../Conexion/Perfil.php");
require_once("../../Conexion/Genericas2.php");
@session_start();
if(isset($_POST)){
	if($_POST['data_id']=='seleccionar_todo'){
		$result = Perfil::obtener_perfil($_POST[id]);
		echo json_encode($result);
		exit();
	}
}
?>