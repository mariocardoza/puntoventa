<?php 
require_once("../../Conexion/Perfil.php");
require_once("../../Conexion/Turno.php");
require_once("../../Conexion/Genericas2.php");
require_once("../../Conexion/Grafica.php");
@session_start();
if(isset($_POST)){
	if($_POST['data_id']=='seleccionar_todo'){
		$result = Perfil::obtener_perfil($_POST[id]);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='nuevo_turno'){
		$result=Turno::nuevo_turno($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='terminar_turno'){
		$result=Turno::terminar_turno();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='mis_movimientos'){
		$result=Turno::mis_movimientos();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='movimientos_dia'){
		$result=Turno::movimientos_dia();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='ver_resumen'){
		$result=Turno::ver_resumen($_POST[turno]);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='ver_graficas'){
		$result=Grafica::graficas_restaurante();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='menos_vendidos'){
		$result=Grafica::grafica_menos_vendidos_r();
		echo json_encode($result);exit();
	}
}
?>