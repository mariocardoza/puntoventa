<?php 
include_once('Conexion.php');
/**
 * 
 */
class Venta
{
	/*
		estados:
		1 disponible para venta
		2 disponible para venta (fraccionado)
		3 vendido completo
		4 vencido
	*/
	
	function __construct($argument)
	{
		# code...
	}

	public static function nueva_venta($data){
		/*$retorno_descuento=Venta::descontar_producto($data);
		if($retorno_descuento[0]==1){
			return array(1,$data);
		}else{
			return array(-1,$retorno_descuento);
		}*/
		return array(1,$data);
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
			$cuantos_aux=explode(".",number_format($venta[cantidad],2));
			$cuantos_int=(int)$cuantos_aux[0];
			$cuantos_float=$cuantos_aux[1]/100;
			if($cuantos_int>0){
				for($i=0;$i<$cuantos_int;$i++){
					$conte=0.00;
					$sql="SELECT p.cantidad as cantidad, pd.correlativo as correlativo, pd.contenido as contenido FROM tb_producto as p INNER JOIN tb_producto_detalle as pd ON pd.codigo_producto=p.codigo_oculto WHERE p.codigo_oculto = '$venta[codigo]'	AND pd.estado=1 GROUP BY pd.codigo_producto";
					
					try{
						$comando=Conexion::getInstance()->getDb()->prepare($sql);
						$comando->execute();
						while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
							$corr=$row[correlativo];
							$conte=$row[contenido];
							$canti=$row[cantidad];
						}
						$sqlupdate="UPDATE tb_producto_detalle SET estado=3 WHERE correlativo='$corr'";
					}catch(Exception $e){
						return array(-1,"error",$e->getMessage());
					}
					try{
					$comandou=Conexion::getInstance()->getDb()->prepare($sqlupdate);
					$comandou->execute();
					}catch(Exception $e){
						return array(-1,"error2",$e->getMessage(),$sql);
					}
					$result=$canti-$conte;
					$sql3="UPDATE tb_producto SET cantidad=$result WHERE codigo_oculto='$venta[codigo]'";
					try{
						$comando3=Conexion::getInstance()->getDb()->prepare($sql3);
						$comando3->execute();
					}catch(Exception $e){
						return array(-1,"error3",$e->getMessage());
					}	
				}
			}
			if($cuantos_float>0){
				while ($cuantos_float>0) {
					$nuevo=0.0;
					$conteni=0.0;
					$sql_decimales="SELECT pd.correlativo as correlativo, pd.contenido as contenido,p.contenido as division,pd.disponible FROM tb_producto as p INNER JOIN tb_producto_detalle as pd ON pd.codigo_producto=p.codigo_oculto WHERE p.codigo_oculto = '$venta[codigo]' AND pd.estado IN(1,2) GROUP BY pd.codigo_producto";
					try{
						$comando_de1=Conexion::getInstance()->getDb()->prepare($sql_decimales);
						$comando_de1->execute();
						while($row=$comando_de1->fetch(PDO::FETCH_ASSOC)){$conteni=$row[contenido];$corre_aqui=$row[correlativo];$division=$row[division];$disponible=$row[disponible];}
					}catch(Exception $e){
						return array(1,$e->getMessage(),$e->getLine());
					}

				if($cuantos_float>=$disponible){//este if liquida el ultimo faltante de un item anterior
					$sql_de2="UPDATE tb_producto_detalle SET estado=3, contenido=0,disponible=0 WHERE correlativo='$corre_aqui'";
					try{
						$comando_de2=Conexion::getInstance()->getDb()->prepare($sql_de2);
						$comando_de2->execute();
					}catch(Exception $e){return array(-1,"error",$e->getMessage(),$e->getLine());}
					$cuantos_float=$cuantos_float-$conteni;
				}else{ // resta contenido al item seguiente en metodo PEPS
					if($division==1){$nuevo=$conteni-$cuantos_float;}
					else {
						$content=$division*$cuantos_float;
						$nuevo=$conteni-$content;
						}
						$otro=$disponible-$cuantos_float;
					$sql_de2="UPDATE tb_producto_detalle SET estado=2, contenido=$nuevo,disponible=$otro WHERE correlativo='$corre_aqui'";
					try{
						$comando_de2=Conexion::getInstance()->getDb()->prepare($sql_de2);
						$comando_de2->execute();
					}catch(Exception $e){return array(-1,"error",$e->getMessage(),$e->getLine());}
					$cuantos_float=0.0;
				}
				}
			}
		}
		return array(1,"exito",$cuantos_int,$cuantos_float);
	}
}
 ?>