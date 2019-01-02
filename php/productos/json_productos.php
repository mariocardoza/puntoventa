<?php 
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Genericas2.php");
if($_POST['data_id']=="nuevo_producto"){
	$resultado = Producto::guardar($_POST);
	echo json_encode($resultado);
	exit();
}
if($_GET['data_id']=='ver_producto'){
	$resultado=Producto::modal_ver($_GET['id']);
	echo json_encode($resultado);
	exit();
}
if($_POST['data_id']=='agregar_existencia'){
	$resultado=Producto::actualizar_inventario($_POST[id],$_POST[cantidad],$_POST[precio]);
	echo json_encode($resultado);
	exit();
}
if($_POST['data_id']=='modal_editar'){
	$resultado=Producto::modal_editar($_POST['id']);
	echo json_encode($resultado);
	exit();
}
if($_POST['data_id']=='editar_producto'){
	$result=Genericas2::actualizar_generica("tb_producto",$_POST);
	echo json_encode($result);
	exit();
}
if($_POST['data_id']=='busqueda'){
	$result=Producto::busqueda($_POST['esto'],$_POST['departamento']);
	echo json_encode($result);
	exit();
}
?>