<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
/**
 * 
 */
class Comanda
{
	
	function __construct()
	{
		
	}

	public static function nueva_comanda($data){
		try{
			$codigo=date("Yidisus");
			$comanda=Array(
				'data_id' => 'nueva_comanda',
				'mesa' => $data[id_mesa],
				'numero_clientes' => $data[numero_clientes],
				'tipo' => $data[tipo_pedido],
				'codigo_oculto' => $codigo,
				'mesero' => $_SESSION['usuario'],
				'total' => $data[total],
				'fecha' => date("Y-m-d H:i:s")
			);
			$result1=Genericas2::insertar_generica("tb_comanda",$comanda);
			foreach ($data[comanda] as $comandad) {
				$detalle=Array(
					'data_id' => 'nueva',
					'codigo_comanda' => $codigo,
					'codigo_producto' => $comandad[codigo],
					'notas' => $comandad[nota]
				);
				$result2=Genericas2::insertar_generica("tb_comanda_detalle",$detalle);
			}
			$sql="UPDATE tb_mesa SET ocupado = 1 WHERE codigo_oculto='$data[id_mesa]'";
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$result1,$result2,$sql);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$e->getLine());
		}
		
	}

	public static function cobrar($data){
		$array_update=array(
			'data_id' => 'update',
			'codigo_oculto' => $data[comanda],
			'propina' => $data[propina],
			'total_real' => $data[total],
			'fecha_despacho' => date("Y-m-d H:i:s"),
			'efectivo' => $data[efectivo],
			'cambio' => $data[cambio],
			'tipo_factura' => $data[tipo_factura],
			'forma_pago' => $data[forma_pago],
			'estado' => 2
		);
		$result=Genericas2::actualizar_generica("tb_comanda",$array_update);
		$array_cuenta=array(
			'data_id' => 'nueva_cuenta',
			'codigo_venta' => $data[comanda],
			'tipo_cuenta' => $data[forma_pago],
			'cliente' => $data[cliente_aqui],
			'cliente_debe' => $data[cliente_debe],
			'descripcion_debe' => $data[descripcion_debe],
			'monto' => $data[total],
			'fecha' => date("Y-m-d H:m:s"),
			'codigo_oculto' => date("Yidisus"),
			'eltipo' => 2
		);
		$result2=Genericas2::insertar_generica("tb_cuenta",$array_cuenta);
		$result3=Genericas2::actualizar_generica("tb_mesa",$array=array('data_id'=>'mesa','codigo_oculto'=>$data[mesa],'ocupado'=>0));
		return array(1,"exito",$result,$result2,$result3);
	}

	public static function busqueda($dato,$tipo){
		$el_tipo='';
		if($tipo!=0){
			$el_tipo="AND c.tipo=$tipo";
		}
		$sql="SELECT c.*,m.nombre as n_mesa FROM tb_comanda as c LEFT JOIN tb_mesa as m ON m.codigo_oculto=c.mesa  WHERE c.estado=1 $el_tipo ORDER BY id DESC";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$tipo_orden="";
				if($row[tipo]==1){
					$tipo_orden="Comer aqui";
				}
				if ($row[tipo]==2) 
				{
					$tipo_orden="Llevar";
				}
				if ($row[tipo]==3) 
				{
					$tipo_orden="Domicilio";
				}

				$html.='<div class="col-sm-6 col-lg-6" style="height: 175px;" id="listado-card">
			                <div class="">
			                  <div class="">
			                    <table width="100%">
			                        <tbody>
			                            <tr>
			                                <td style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
			                                </td>
			                                <td style="font-size:18px"><b>Orden: </b>'.$tipo_orden.'</td>
			                            </tr>
			                            <tr>
			                                <td style="padding: 5px 0px;"><a href="javascript:void(0)" onclick="ver(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Ver"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td>
			                                <td style="font-size:18px">'.$row[n_mesa].'</td>
			                            </tr>
			                            <tr>
			                                <td style="padding: 5px 0px;" width="15%"><a data-total="'.$row[total].'" class="btn btn-mio" href="javascript:void(0)" onclick="cobrar(\''.$row[codigo_oculto].'\',\''.$row[total].'\',\''.$row[mesa].'\')" data-toggle="tooltip" title="Eliminar"><i class="fa fa-usd"></i></a></td>
			                                <td style="font-size:18px">Clientes: '.$row[numero_clientes].'</td>
			                            </tr>
			                        </tbody>
			                    </table>
			                  </div>
			              	</div>
	            		</div>
	            		<!--div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <div class="widget-simple themed-background-dark">
                                        <a data-nombre="<?php echo $mesa[nombre] ?>" href="#">
                                            <img src="../../img/placeholders/mesa.png" alt="avatar" class="widget-image img-circle pull-left">
                                        </a>
                                        <h4 class="widget-content">
                                            <a href="#" >
                                                <strong>'.$row[n_mesa].'</strong>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                              </div-->';


			}
			return array(1,"exito",$html,$sql);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function productos($id){
		$sql="SELECT nombre,precio,codigo_oculto,descripcion
			FROM(
			SELECT
				p.nombre as nombre,
				ROUND((((p.ganancia/100)*p.precio_unitario)+p.precio_unitario),2) as precio,
				p.codigo_oculto as codigo_oculto,
				p.descripcion as descripcion
			FROM
				`tb_producto` AS p
			INNER JOIN tb_categoria AS c ON c.id = p.categoria
			WHERE
				c.id = $id
			UNION ALL
			SELECT r.nombre as nombre,r.precio as precio,r.codigo_oculto as codigo_oculto,r.descripcion as descripcion
			 FROM tb_receta as r
			WHERE r.categoria = $id) as t";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<div class="col-xs-12 col-lg-12">
	                        <div class="widget">
	                          <div class="widget-simple themed-background-dark-autumn">
	                            <h4 class="widget-content">
	                                <a id="producto_add" data-cantidad="1" data-nombre="'.$row[nombre].'" data-precio="'.$row[precio].'" data-id="'.$row[codigo_oculto].'" href="javascript:void(0)" >
	                                    <strong>'.$row[nombre].'</strong>
	                                    <h5>'.$row[descripcion].' </h5> 
	                                </a>
	                            </h4>
	                          </div>
	                        </div>
                      	</div>';
			}
			return array(1,"exito",$html);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage());
		}
	}

	public static function tipos(){
		$sql="SELECT tipo FROM tb_receta GROUP BY tipo";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$tipos[]=$row[tipo];
			}
			return array(1,"exito",$tipos);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage());
		}
	}

	public static function ver_comanda($comanda)
		{
			$sql_comanda="SELECT c.*,m.nombre as n_mesa, DATE_FORMAT(c.fecha,'%d/%m/%Y') as dia_comanda,DATE_FORMAT(fecha,'%H:%m:%s') as hora_comanda,per.nombre as n_mesero FROM tb_comanda as c LEFT JOIN tb_mesa as m ON m.codigo_oculto=c.mesa  LEFT JOIN tb_persona as per ON per.email=c.mesero WHERE c.codigo_oculto='$comanda'";

			$sql_detalle="SELECT
	notas,
	n_producto,
	precio_p,
	codigo_producto,
	descripcion
FROM
	(
		SELECT
			dc.notas AS notas,
			p.nombre AS n_producto,
			ROUND(
				(
					(
						(p.ganancia / 100) * p.precio_unitario
					) + p.precio_unitario
				),
				2
			) AS precio_p,
			p.codigo_oculto as codigo_producto,
			p.descripcion as descripcion
		FROM
			tb_producto AS p
		INNER JOIN tb_comanda_detalle AS dc ON dc.codigo_producto = p.codigo_oculto
		WHERE
			dc.codigo_comanda = '$comanda'
		UNION ALL
			SELECT
				dc.notas AS notas,
				r.nombre AS n_producto,
				r.precio AS precio_p,
				r.codigo_oculto as codigo_producto,
				r.descripcion as descripcion
			FROM
				tb_receta AS r
			INNER JOIN tb_comanda_detalle AS dc ON dc.codigo_producto = r.codigo_oculto
			WHERE
				dc.codigo_comanda = '$comanda'
	) AS t";
				try {
			$comando = Conexion::getInstance()->getDb()->prepare($sql_comanda);
			$comando2 = Conexion::getInstance()->getDb()->prepare($sql_detalle);
	        $comando->execute();
	        $comando2->execute();
	        $producto="";
	        //$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
	        while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	        	$comanda=$row;
	        }
	        while ($row2=$comando2->fetch(PDO::FETCH_ASSOC)) {
	        	$detalles[]=$row2;
	        }
	        $tipo="";
	        if($comanda[tipo]==1){
	        	$tipo="Comer aqui";
	        }
	        if($comanda[tipo]==2){
	        	$tipo="Llevar";
	        }
	        if($comanda[tipo]==3){
	        	$tipo="Domicilio";
	        }

	        $espera="";
	        $hoy=date("Y-m-d H:i:s");
	        $date1 = new DateTime($comanda[fecha]);
			$date2 = new DateTime($hoy);
			$diff = $date1->diff($date2);
			// will output 2 days
			//echo $diff->days . ' days ';

	        $modal='<div class="modal fade modal-side-fall" id="md_ver_comanda" aria-hidden="true"
	      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
	      <div class="modal-dialog modal-lg">
	        <div class="modal-content">
	          <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal">
	              <span aria-hidden="true">×</span>
	            </button>
	            <h4 class="modal-title">Detalle de la comanda</h4>
	          </div>
	          <div class="modal-body">
	            <div class="row">
	        		<div class="col-xs-3"></div>
	        		<div class="col-xs-6">
	        			<table class="table">
			                <tbody>
			                    <tr>
			                    	<td>'.$tipo.'</td>
			                    </tr>
			                    <tr>
			                    	<td>'.$comanda[n_mesa].'</td>
			                    </tr>
			                    <tr>
			                    	<td>Mesero (a): '.$comanda[n_mesero].'</td>
			                    </tr>
			                    <tr>
			                    	<td>Total: $'.number_format($comanda[total],2).'</td>
			                    </tr>
			                    <tr>
			                    	<td>Espera: '.$diff->format("%h horas %i minutos").'</td>
			                    </tr>
			                </tbody>
		            	</table>
	        		</div>
	        		<div class="col-xs-3"></div>
	            </div>
	            <div class="row">
	            	<div class="col-xs-2"></div>
	            	<div class="col-xs-8">
	            		<table class="table">
	            			<thead>
	            				<tr>
	            					<th>Descripción.</th>
	            					<th>Precio/u.</th>
	            				</tr>
	            			</thead>
	            			<tbody>';
	            			foreach ($detalles as $detalle):
	            				$modal.='<tr>
	            						
	            						<td>'.$detalle[n_producto].' '.$detalle[descripcion].'<br>- '.substr($detalle[notas],2).'</td>
	            						<td>$'.number_format($detalle[precio_p],2).'</td>
	            					</tr>';
	            			endforeach;
	            			$modal.='</tbody>
	            		</table>
	            	</div>
	            	<div class="col-xs-2"></div>
	            </div>
	          </div>
	          <div class="modal-footer">
	            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
	          </div>
	        </div>
	      </div>
	    </div>';

	            return array("1",$producto,$sql,$modal,$detalles);
			} catch (Exception $e) {
				return array("-1",$e->getMessage(),$e->getLine(),$sql);
				exit();
			}
	}
}
 ?>