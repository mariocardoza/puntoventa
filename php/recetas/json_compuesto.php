<?php 
@session_start();
require_once("../../Conexion/Compuesto.php");
if(isset($_POST)){
	if($_POST['data_id']=='traer_subcategorias'){
		$result=Compuesto::traer_subcategorias();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='guardar_componente'){
		$result=Compuesto::guardar_componente($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='prueba'){
		$result=Compuesto::llenar_compuestos($_POST[codigo]);
		echo json_encode($result);exit();
	}
}
?>
