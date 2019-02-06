<?php 
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Genericas2.php");
include_once("../../Conexion/Receta.php");
if($_GET['data_id']=='ver_producto'){
	$resultado=Producto::modal_ver($_GET['id']);
	echo json_encode($resultado);
	exit();
}
if($_POST['data_id']=='busqueda'){
	$result=Receta::busqueda($_POST['esto']);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='buscar_productos'){
	$result=Receta::productos($_POST['id']);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='modal_editar'){
	$result=Receta::modal_editar($_POST['id']);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='modal_ver'){
	$result=Receta::modal_ver($_POST['id']);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='editar_receta'){
	$result=Receta::editar($_POST);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='categoria'){
	$result=Genericas2::buscar_por_id("tb_categoria","departamento",$_POST['id']);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='nueva_receta'){
	$result=Receta::guardar_receta($_POST);
	echo json_encode($result);exit();
}
if($_POST['data_id']=='guardar_ingredientes'){
	$result=Receta::guardar_ingredientes($_POST);
	echo json_encode($result);exit();
}
?>