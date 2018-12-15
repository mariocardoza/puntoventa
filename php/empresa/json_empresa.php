<?php 
require_once("../../Conexion/Empresa.php");
if(isset($_POST)){
	if($_POST['data_id']=='nueva_empresa'){
		$result = Empresa::guardar($_POST);
		echo json_encode($result);
		exit();
	}
}
?>