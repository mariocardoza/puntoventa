<?php 
require_once('../../Conexion/Cliente.php');
require_once("../../Conexion/Validaciones.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='nuevo_cliente'){
		$result = Cliente::guardar($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_email'){
		$result = Validaciones::val_email($_POST['email'],'tb_cliente');
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_tel'){
		$result = Validaciones::val_tel($_POST['email'],'tb_cliente');
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_nrc'){
		$result = Validaciones::val_nrc($_POST['nrc'],'tb_cliente');
		echo json_encode($result);
		exit();
	}

	if($_POST['data_id']== 'val_nit'){
		$result = Validaciones::val_nit($_POST['nit'],'tb_cliente');
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'val_dui'){
		$result = Validaciones::val_dui($_POST['dui'],'tb_cliente');
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']== 'modal_natural'){
		$result = Cliente::modal_natural($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='modal_juridico'){
		$result=Cliente::modal_juridico($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='editar_cliente'){
		$result=Cliente::editar($_POST);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='eliminar_cliente'){
		$result=Cliente::eliminar($_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Cliente::busqueda($_POST['esto'],$_POST['tipo']);
		echo json_encode($result);exit();
	}
}
?>