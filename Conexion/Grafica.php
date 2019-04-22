<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Grafica
{
	
	function __construct()
	{
		# code...
	}

	public static function graficas_restaurante(){
		$sql_masvendidos="SELECT
					cuantas,
					n_producto
				FROM
					(
						SELECT
							COUNT(cd.codigo_producto) AS cuantas,
							r.nombre AS n_producto
						FROM
							tb_comanda AS c
						INNER JOIN tb_comanda_detalle AS cd ON c.codigo_oculto = cd.codigo_comanda
						INNER JOIN tb_receta AS r ON r.codigo_oculto = cd.codigo_producto
						WHERE
							c.estado = 2
						AND MONTH(c.fecha_despacho)=MONTH(NOW())
						GROUP BY
							cd.codigo_producto
						UNION ALL
							SELECT
								COUNT(cd.codigo_producto) AS cuantas,
								CONCAT(p.nombre, ' ', p.descripcion) AS n_producto
							FROM
								tb_comanda AS c
							INNER JOIN tb_comanda_detalle AS cd ON c.codigo_oculto = cd.codigo_comanda
							INNER JOIN tb_producto AS p ON p.codigo_oculto = cd.codigo_producto
							WHERE
								c.estado = 2
							AND MONTH(c.fecha_despacho)=MONTH(NOW())
							GROUP BY
								cd.codigo_producto
					) AS t
				ORDER BY
					cuantas DESC
				LIMIT 10";
				$sql_menosvendidos="SELECT
					cuantas,
					n_producto
				FROM
					(
						SELECT
							COUNT(cd.codigo_producto) AS cuantas,
							r.nombre AS n_producto
						FROM
							tb_comanda AS c
						INNER JOIN tb_comanda_detalle AS cd ON c.codigo_oculto = cd.codigo_comanda
						INNER JOIN tb_receta AS r ON r.codigo_oculto = cd.codigo_producto
						WHERE
							c.estado = 2
						AND MONTH(c.fecha_despacho)=MONTH(NOW())
						GROUP BY
							cd.codigo_producto
						UNION ALL
							SELECT
								COUNT(cd.codigo_producto) AS cuantas,
								CONCAT(p.nombre, ' ', p.descripcion) AS n_producto
							FROM
								tb_comanda AS c
							INNER JOIN tb_comanda_detalle AS cd ON c.codigo_oculto = cd.codigo_comanda
							INNER JOIN tb_producto AS p ON p.codigo_oculto = cd.codigo_producto
							WHERE
								c.estado = 2
							AND MONTH(c.fecha_despacho)=MONTH(NOW())
							GROUP BY
								cd.codigo_producto
					) AS t
				ORDER BY
					cuantas ASC
				LIMIT 10";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql_masvendidos);
			$comando2=Conexion::getInstance()->getDb()->prepare($sql_menosvendidos);
			$comando->execute();
			$comando2->execute();
			$mas=$comando->fetchAll(PDO::FETCH_ASSOC);
			$menos=$comando2->fetchAll(PDO::FETCH_ASSOC);
			return array(1,"exito",$mas,$menos);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql_masvendidos,$sql_menosvendidos);
		}
	}

	public static function grafica_mas_vendidos(){
		$sql="SELECT
				CONCAT(p.nombre,' ',p.descripcion) AS n_producto,
				count(vd.codigo_producto) AS cuantas
			FROM
				tb_venta AS v
			INNER JOIN tb_venta_detalle AS vd ON v.codigo_oculto = vd.codigo_venta
			INNER JOIN tb_producto AS p ON p.codigo_oculto = vd.codigo_producto
			WHERE
				MONTH (v.fecha) = MONTH (CURDATE())
			GROUP BY
				vd.codigo_producto
			ORDER BY cuantas DESC
			LIMIT 10";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$resultado=$comando->fetchAll(PDO::FETCH_ASSOC);
			return array(1,"exito",$resultado);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}
}
?>