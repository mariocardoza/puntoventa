<?php 
@session_start();
require_once("../../Conexion/Notificacion.php");
if(isset($_POST)){
	if($_POST['data_id']=='busqueda'){
		$result=Notificacion::busqueda();
		echo json_encode($result);exit();
	}
}
?>