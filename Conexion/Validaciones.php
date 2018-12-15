<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Validaciones
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function val_email($email,$tabla){
		$sql="SELECT * FROM ".$tabla." AS c WHERE c.email = '$email';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}

	public static function val_tel($telefono,$tabla){
		$sql="SELECT * FROM ".$tabla." AS c WHERE c.telefono = '$telefono';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	public static function val_nrc($nrc,$tabla){
		//$tabla=base64_decode($tabla);
		$sql="SELECT * FROM ".$tabla." AS c WHERE c.nrc = '$nrc';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	public static function val_dui($dui,$tabla){
		$sql="SELECT * FROM ".$tabla." AS c WHERE c.dui = '$dui';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	public static function val_nit($nit,$tabla){
		$sql="SELECT * FROM ".$tabla." AS c WHERE c.nit = '$nit';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
}
?>