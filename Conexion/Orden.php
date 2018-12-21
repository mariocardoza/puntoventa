<?php 
@session_start();
require_once("Conexion.php");

class Orden
{
	
	function __construct()
	{
		# code...
	}

	public static function obtener_ordenes(){
		$sql="SELECT * FROM tb_orden WHERE estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$ordenes[]=$row;
			}
			return $ordenes;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}


}
 ?>