<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
/**
 * 
 */
class Caja
{
	
	function __construct()
	{
		# code...
	}

	public static function cajas_libres(){
		$sql="SELECT * FROM tb_caja WHERE abierta=0";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$cajas=$comando->fetchAll(PDO::FETCH_ASSOC);
			return $cajas;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function cargar_cajas(){
		$sql="SELECT nombre,DATE_FORMAT(fecha_registro,'%d/%m/%Y') as fecha,codigo_oculto,id FROM tb_caja WHERE estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$i=1;
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<tr>
					<td>'.$i.'</td>
					<td>'.$row[nombre].'</td>
					<td>'.$row[fecha].'</td>
					<td><a class="btn btn-warning btn-xs" onclick="editar(\''.$row[codigo_oculto].'\')" href="javascript:void(0)"><i class="fa fa-edit"></i></a>
					<a class="btn btn-danger btn-xs" onclick="darbaja(\''.$row[id].'\',\'tb_caja\',\'la caja\')" href="javascript:void(0)"><i class="fa fa-remove"></i></a>
					</td>
				</tr>';
				$i++;
			}
			return array(1,"exito",$html);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage());
		}
	}

	public static function movimientos(){
		$sql="SELECT DATE_FORMAT(mc.fecha_movimiento,'%d/%m/%Y %H:%i:%s') as fecha, c.nombre as lacaja,mc.monto as monto, CASE mc.tipo WHEN 1 THEN 'Entrada' ELSE 'Salida' END AS eltipo FROM tb_movimiento_caja as mc INNER JOIN tb_caja AS c ON c.codigo_oculto=mc.codigo_caja";
	}

	public static function guardar_caja($data){
		$array = array(
			'data_id' => 'nueva',
			'nombre' => $data[nombre],
			'codigo_oculto' => $data[codigo_oculto],
			'fecha_registro' => date("Y-m-d")
		);
		$result=Genericas2::insertar_generica("tb_caja",$array);
		if($result[0]=="1"){
			return array(1,"exito",$result);
		}else{
			return array(-1,"error",$result);			
		}
	}
}
 ?>