<?php 
@session_start();
include_once '../../Conexion/Genericas2.php';
include_once '../../Conexion/Turno.php';
if(isset($_POST)){
	if($_POST['data_id']=='nuevo_turno'){
		$result=Genericas2::insertar_generica("tb_turno",$_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Turno::busqueda();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='ver_resumen'){
		$result=Turno::ver_resumen($_POST[turno]);
		echo json_encode($result);exit();
	}
}
?>