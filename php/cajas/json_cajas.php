<?php 
@session_start();
require_once("../../Conexion/Caja.php");
if(isset($_POST)){
	if($_POST['data_id']=='cargar_cajas'){
		$result=Caja::cargar_cajas();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']='nueva_caja'){
		$result=Caja::guardar_caja($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='movimiento_caja'){

	}
}else{
	echo json_encode("no entro a ningun if");
}
 
?>