<?php 
require_once("../../Conexion/Empresa.php");
require_once("../../Conexion/Genericas2.php");
if(isset($_POST)){
	if($_POST['data_id']=='nueva_empresa'){
		$result = Empresa::guardar($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_empresa'){
		$result = Genericas2::actualizar_generica("tb_negocio",$_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='nueva_sucursal'){
		$result = Genericas2::insertar_generica('tb_sucursal',$_POST);
		echo json_encode($result);exit();
	}
}
?>