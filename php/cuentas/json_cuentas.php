<?php 
require_once('../../Conexion/Cliente.php');
require_once('../../Conexion/Genericas2.php');
require_once("../../Conexion/Cuenta.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='busqueda'){
		$result=Cuenta::busqueda($_POST['esto'],$_POST['turno']);
		echo json_encode($result);exit();
	}
}
?>