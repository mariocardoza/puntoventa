<?php 
@session_start(); 
require_once("Conexion.php");

/**
 * 
 */
class Proveedor
{
	
	function __construct($argument)
	{
		# code...
	}
	public static function obtener_proveedores(){
		$sql="SELECT * FROM tb_proveedor WHERE estado=1";
		$proveedores="";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$proveedores=$comando->fetchAll(PDO::FETCH_ASSOC);

			return array(1,"exito",$proveedores,$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
?>