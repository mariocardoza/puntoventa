<?php 
@session_start();
require_once("../../Conexion/Reserva.php");
if(isset($_POST)){
	if($_POST['data_id']=='nueva_reserva'){
		$result=Reserva::guardar($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Reserva::busqueda($_POST['dato']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Reserva::modal_editar($_POST[codigo]);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='editar_reserva'){
		$result=Reserva::editar($_POST);
		echo json_encode($result);exit();
	}
}
?>

