<?php 
@session_start();
require_once("../../Conexion/Paquete.php");
if(isset($_POST)){
	if($_POST['data_id']=='nuevo_paquete'){
		$result=Paquete::guardar($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Paquete::busqueda($_POST['esto']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='modal_editar'){
		$result=Paquete::modal_editar($_POST['id']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='editar_paquete'){
		$result=Paquete::editar($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='cargar_productos'){
		$result=Paquete::cargar_productos($_POST['codigo']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='guardarle_productos'){
		$result=Paquete::guardarle_productos($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='eliminar_item'){
		$result=Paquete::eliminar_item($_POST[codigo],$_POST[paquete]);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='modal_ver'){
		$result=Paquete::modal_ver($_POST['codigo']);
		echo json_encode($result);exit();
	}
}
?>