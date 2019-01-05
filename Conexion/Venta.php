<?php 
include_once('Conexion.php');
/**
 * 
 */
class Venta
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function nueva_venta($data){



		$retorno_descuento=Venta::descontar_producto($data);
	}

	private static function actualizar_existencias($producto,$cantidad){
		$sql="SELECT cantidad FROM tb_producto WHERE codigo_oculto=$producto";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				
			}
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage,$sql);
		}
	}

	private static function descontar_producto($data){
		$cuantos=Count($data[venta]);
		foreach ($data[venta] as $venta) {
			$cuantitos=(int)$venta[cantidad];
			for($i=0;$i<$cuantitos;$i++){
				$sql="SELECT correlativo FROM tb_producto_detalle WHERE codigo='$venta[codigo]' AND estado=1 limit 1";
				try{
					$comando=Conexion::getInstance()->getDb()->prepare($sql);
					$comando->execute();
					while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
						$corr=$row[correlativo];
					}
					$sqlupdate="UPDATE tb_producto_detalle SET estado=2 WHERE correlativo='$corr'";
				}catch(Exception $e){
					return array(-1,"error",$e->getMessage());
				}
				try{
				$comandou=Conexion::getInstance()->getDb()->prepare($sqlupdate);
				$comandou->execute();
				}catch(Exception $e){
					return array(-1,"error2",$e->getMessage());
				}	
			}
		}
		return array(1,"exito");
	}
}
 ?>