<?php 
require_once('../../Conexion/Cliente.php');
require_once('../../Conexion/Genericas2.php');
require_once("../../Conexion/Comanda.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='buscar_productos'){
		$result = Comanda::productos($_POST['tipo']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='nueva_comanda'){
		$result = Comanda::nueva_comanda($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='actualizar_comanda'){
		$result=Comanda::actualizar_comanda($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='busqueda'){
		$result=Comanda::busqueda($_POST['esto'],$_POST['tipo']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='buscar_natural'){
		$result = Genericas2::buscar_por_id("tb_cliente","nombre",$_POST['dato']);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='traer_clientes'){
		$result = Cliente::obtener_todos();
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='ver_comanda'){
		$result = Comanda::ver_comanda($_POST[id]);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='cobrar'){
		$result=Comanda::cobrar($_POST);
		echo json_encode($result);exit();
	}
	if($_POST['data_id']=='anular'){
		$result=Comanda::eliminar($_POST);
		echo json_encode($result);exit();
	}
}
?>