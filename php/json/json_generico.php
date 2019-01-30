<?php 
require_once("../../Conexion/Genericas2.php");
require_once("../../Conexion/Validaciones.php");
require_once("../../Conexion/administracion/Usuarios.php");
if(isset($_POST) || isset($_GET)){
	if($_POST['data_id']=='dar_baja'){
		$result=Genericas2::darbaja($_POST['tabla'],$_POST['id']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='dar_alta'){
		$result=Genericas2::daralta($_POST['tabla'],$_POST['id']);
		echo json_encode($result);
		exit();
	}

	if($_POST['data_id']=='val_nit'){
		$result = Validaciones::val_nit($_POST['nit'],$_POST['tabla']);
		echo json_encode($result);
		exit();
	}

	if($_POST['data_id']=='val_email'){
		$result = Validaciones::val_email($_POST['email'],$_POST['tabla']);
		echo json_encode($result);
		exit();
	}

	if($_POST['data_id']=='val_tel'){
		$result = Validaciones::val_tel($_POST['telefono'],$_POST['tabla']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='val_nrc'){
		$result = Validaciones::val_nrc($_POST['nrc'],$_POST['tabla']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='val_dui'){
		$result = Validaciones::val_dui($_POST['dui'],$_POST['tabla']);
		echo json_encode($result);
		exit();
	}
	if($_POST['data_id']=='cambiar_pass'){
		$result=Usuarios::cambiar_contra($_POST['pass'],$_POST['email_pass']);
		echo json_encode($result);
		exit();
	}
}
 ?>