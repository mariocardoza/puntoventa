<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Notificacion
{
	
	function __construct()
	{
	}

	public static function cuantos_vencidos(){
		$sql="SELECT COUNT(*) as cuantos FROM tb_notificacion_producto WHERE tipo=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$cuantos=$comando->fetchAll(PDO::FETCH_ASSOC);
			return $cuantos;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function cuantos_stock(){
		$sql="SELECT COUNT(*) as cuantos FROM tb_notificacion_producto WHERE tipo=2";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$cuantos=$comando->fetchAll(PDO::FETCH_ASSOC);
			return $cuantos;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function llenar_vencidos(){
		$sql="SELECT CONCAT(p.nombre,' ',p.descripcion) as elproducto, np.lote,DATE_FORMAT(np.fecha_vencimiento,'%d/%m/%Y') as vencimiento, CONCAT(np.dias_restantes,' días para su vencimiento') as losdias FROM tb_notificacion_producto as np INNER JOIN tb_producto as p ON p.codigo_oculto=np.codigo_producto WHERE np.tipo=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<li>
                            <a href="javascript:void(0)" id="veresto">
                                    <span class="badge pull-right"></span>
                                    <b>'.$row[elproducto].'</b>, lote N°: '.$row[lote].', '.$row[losdias].'
                            </a>
                        </li>';
			}
			return $html;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function busqueda(){
		$sql="SELECT CONCAT(p.nombre,' ',p.descripcion) as elproducto, np.lote,DATE_FORMAT(np.fecha_vencimiento,'%d/%m/%Y') as vencimiento, CONCAT(np.dias_restantes,' días para su vencimiento') as losdias FROM tb_notificacion_producto as np INNER JOIN tb_producto as p ON p.codigo_oculto=np.codigo_producto WHERE np.tipo=1";
		$sql2="SELECT CONCAT(p.nombre,' ',p.descripcion) as elproducto,pr.nombre as proveedor, np.cuanto_stock as elstock FROM tb_notificacion_producto as np INNER JOIN tb_producto as p ON p.codigo_oculto=np.codigo_producto INNER JOIN tb_proveedor as pr ON pr.id=p.proveedor WHERE np.tipo=2";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando2=Conexion::getInstance()->getDb()->prepare($sql2);
			$comando->execute();
			$comando2->execute();
			$i=1;$j=1;
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				
				$html.='<tr>
							<td>'.$i.'</td>
							<td>'.$row[elproducto].'</td>
							<td>Aviso de vencimiento</td>
							<td>N°: '.$row[lote].'</td>
							<td>'.$row[vencimiento].'</td>
							<td>'.$row[losdias].'</td>
						</tr>';
						$i++;
			}

			while ($row=$comando2->fetch(PDO::FETCH_ASSOC)) {
				
				$html2.='<tr>
							<td>'.$j.'</td>
							<td>'.$row[elproducto].'</td>
							<td>Aviso de stock</td>
							<td>'.$row[elstock].'</td>
							<td>'.$row[proveedor].'</td>
							<td><button class="btn btn-mio">Enviar mensaje</button></td>
						</tr>';
						$j++;
			}

			return array(1,"exito",$html,$html2);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function llenar_stock(){
		$sql="SELECT CONCAT(p.nombre,' ',p.descripcion) as elproducto, np.cuanto_stock as elstock FROM tb_notificacion_producto as np INNER JOIN tb_producto as p ON p.codigo_oculto=np.codigo_producto WHERE np.tipo=2";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<li>
                            <a href="javascript:void(0)" id="veresto">
                                    <span class="badge pull-right"></span>
                                    <b>'.$row[elproducto].'</b>, Actualmente hay '.$row[elstock].'
                            </a>
                        </li>';
			}
			return $html;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
}
 ?>