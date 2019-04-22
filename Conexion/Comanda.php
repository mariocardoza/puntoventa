<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
require_once("Receta.php");
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
			foreach ($data[comanda_new] as $comandad) {
				$detalle=Array(
					'data_id' => 'nueva',
					'codigo_comanda' => $codigo,
					'codigo_producto' => $comandad[codigo],
					'notas' => $comandad[nota],
					'familia'=>$comandad[familia]
				);
				$result2=Genericas2::insertar_generica("tb_comanda_detalle",$detalle);
			}

			foreach ($data[detalle_new] as $detalle) {
				$detalle2=Array(
					'data_id' => 'nueva',
					'codigo_producto' => $detalle[codigo_producto],
					'pertenece_a' => $detalle[pertenece],
					'cantidad'=>$detalle[cantidad],
					'codigo_comanda' => $codigo
				);
				$result3=Genericas2::insertar_generica("tb_ingrediente_comanda",$detalle2);
			}

			//$retorno_descuento=Comanda::descontar_producto($data);
			$sql="UPDATE tb_mesa SET ocupado = 1 WHERE codigo_oculto='$data[id_mesa]'";
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$result1,$result2,$sql,$retorno_descuento);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$e->getLine());
		}
		
	}

	private static function descontar_ingredientes($data){
		$cuantos=Count($data);
		//foreach ($data[comanda] as $venta) {
			$cuantos_aux=explode(".",number_format($data[cantidad],2));
			$cuantos_int=(int)$cuantos_aux[0];
			$cuantos_float=$cuantos_aux[1]/100;
			if($cuantos_int>0){
				for($i=0;$i<$cuantos_int;$i++){
					$conte=0.00;
					$sql="SELECT p.cantidad as cantidad, pd.correlativo as correlativo, pd.contenido as contenido FROM tb_producto as p INNER JOIN tb_producto_detalle as pd ON pd.codigo_producto=p.codigo_oculto WHERE p.codigo_oculto = '$data[codigo_producto]'	AND pd.estado=1 GROUP BY pd.codigo_producto";
					
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
					$sql3="UPDATE tb_producto SET cantidad=$result WHERE codigo_oculto='$data[codigo_producto]'";
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
					$sql_decimales="SELECT pd.correlativo as correlativo, pd.contenido as contenido,p.contenido as division,pd.disponible FROM tb_producto as p INNER JOIN tb_producto_detalle as pd ON pd.codigo_producto=p.codigo_oculto WHERE p.codigo_oculto = '$data[codigo_producto]' AND pd.estado IN(1,2) GROUP BY pd.codigo_producto";
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
		//}
		return array(1,"exito",$cuantos_int,$cuantos_float);
	}

	private static function descontar_productos($data){
		$cuantos=Count($data);
		//foreach ($data[comanda] as $venta) {
			//$cuantos_aux=explode(".",number_format($data[cantidad],2));
			$cuantos_int=1;
			//$cuantos_float=$cuantos_aux[1]/100;
			if($cuantos_int>0){
				for($i=0;$i<$cuantos_int;$i++){
					$conte=0.00;
					$sql="SELECT p.cantidad as cantidad, pd.correlativo as correlativo, pd.contenido as contenido FROM tb_producto as p INNER JOIN tb_producto_detalle as pd ON pd.codigo_producto=p.codigo_oculto WHERE p.codigo_oculto = '$data[codigo_producto]'	AND pd.estado=1 GROUP BY pd.codigo_producto";
					
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
					$sql3="UPDATE tb_producto SET cantidad=$result WHERE codigo_oculto='$data[codigo_producto]'";
					try{
						$comando3=Conexion::getInstance()->getDb()->prepare($sql3);
						$comando3->execute();
					}catch(Exception $e){
						return array(-1,"error3",$e->getMessage());
					}	
				}
			}
		//}
		return array(1,"exito",$cuantos_int);
	}

	public static function actualizar_comanda($data){
		$update=Array(
				'data_id' => 'editar_comanda',
				'codigo_oculto' => $data[codigo_oculto],
				'mesa' => $data[id_mesa],
				'numero_clientes' => $data[numero_clientes],
				'tipo' => $data[tipo_pedido],
				'mesero' => $_SESSION['usuario'],
				'total' => $data[total],
				'nombre_cliente' => $data[nombre_cliente],
				'direccion' => $data[direccion]
			);
		$result=Genericas2::actualizar_generica("tb_comanda",$update);
		if(Count($data[comanda_new]) > 0){
			foreach ($data[comanda_new] as $comandad) {
				$detalle=Array(
					'data_id' => 'nueva',
					'codigo_comanda' => $data[codigo_oculto],
					'codigo_producto' => $comandad[codigo],
					'familia' => $comandad[familia],
					'notas' => $comandad[nota]
				);
				$result2=Genericas2::insertar_generica("tb_comanda_detalle",$detalle);
			}
		}

		if(Count($data[detalle_new]) > 0){
			foreach ($data[detalle_new] as $detalle) {
				$detalle2=Array(
					'data_id' => 'nueva',
					'codigo_producto' => $detalle[codigo_producto],
					'pertenece_a' => $detalle[pertenece],
					'cantidad'=>$detalle[cantidad],
					'codigo_comanda' => $data[codigo_oculto]
				);
				$result3=Genericas2::insertar_generica("tb_ingrediente_comanda",$detalle2);
			}
		}
		return array(1,"exito",$result,$result2,$result3);
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
			'cliente' => $data[cliente_aqui],
			'turno' => $_SESSION[turno],
			'n_cupon' => $data[n_cupon],
			'estado' => 2
		);
		$array_caja=array(
			'nueva' => 'nueva',
			'turno' => $_SESSION['turno'],
			'fecha_movimiento' => date("Y-m-d H:i:s"),
			'tipo' => 1,
			'concepto' => 'Cobro de comanda',
			'monto' => $data[total]
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
		$result4=Genericas2::insertar_generica("tb_movimiento_caja",$array_caja);
		$result2=Genericas2::insertar_generica("tb_cuenta",$array_cuenta);
		$result3=Genericas2::actualizar_generica("tb_mesa",$array=array('data_id'=>'mesa','codigo_oculto'=>$data[mesa],'ocupado'=>0));

		$sql="SELECT * FROM tb_ingrediente_comanda WHERE codigo_comanda='$data[comanda]'";
		$sql2="SELECT codigo_producto FROM tb_comanda_detalle WHERE codigo_comanda='$data[comanda]'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando2=Conexion::getInstance()->getDb()->prepare($sql2);
			$comando->execute();
			$comando2->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$descuento[]=Comanda::descontar_ingredientes($row);
			}
			while ($row2=$comando2->fetch(PDO::FETCH_ASSOC)) {
				$descuento2[]=Comanda::descontar_productos($row2);
			}
			return array(1,"exito",$result,$result2,$result3,$descuento,$descuento2);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
		
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
					$tipo_orden="Mesa";
				}
				if ($row[tipo]==2) 
				{
					$tipo_orden="Llevar";
				}
				if ($row[tipo]==3) 
				{
					$tipo_orden="Domicilio";
				}

				$html.='<div class="col-sm-6 col-lg-6" style="height: 227px;"  id="listado-card">
			                <div class="widget">
			                  <div class="widget-simple">
			                  	<div class="row">
			                  		<div class="col-xs-2">
			                  			<a href="editar_comanda.php?comanda='.$row[codigo_oculto].'" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
			                  			<br><br>
			                  			<a href="javascript:void(0)" onclick="ver(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Ver"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
			                  			<br><br>';
			                  			if($_SESSION[level]==1):
			                  			$html.='<a data-total="'.$row[total].'" class="btn btn-mio" href="javascript:void(0)" onclick="cobrar(\''.$row[codigo_oculto].'\',\''.$row[total].'\',\''.$row[mesa].'\')" data-toggle="tooltip" title="Cobrar"><i class="fa fa-usd"></i></a>
			                  			<br><br>';
			                  		elseif($_SESSION[level]==2):
			                  			$html.='<a href="javascript:void(0)" onclick="anular(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a>';
			                  		endif;
			                  		$html.='</div>
			                  		<div class="col-xs-10">
			                  			<p style="font-size: 18px;"><b>Orden: </b>'.$tipo_orden.'</p>
			                  		</div>
			                  		<div class="col-xs-10">
			                  			<p style="font-size: 18px;">'.$row[n_mesa].'</p>
			                  		</div>
			                  		<div class="col-xs-10">
			                  			<p style="font-size: 18px;">Clientes: '.$row[numero_clientes].'</p>
			                  		</div>
			                  	</div>
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
			return array(1,"exito",$html);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function productos($opcion){
		$sql="SELECT nombre,precio,codigo_oculto,descripcion,imagen
			FROM(
			SELECT
				p.nombre as nombre,
				ROUND((((p.ganancia/100)*p.precio_unitario)+p.precio_unitario),2) as precio,
				p.codigo_oculto as codigo_oculto,
				p.descripcion as descripcion,
				p.imagen
			FROM
				tb_producto AS p
			WHERE
				p.opcion = '$opcion'
			UNION ALL
			SELECT r.nombre as nombre,r.precio as precio,r.codigo_oculto as codigo_oculto,r.descripcion as descripcion,r.imagen
			 FROM tb_receta as r
			WHERE r.opcion = '$opcion') as t";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$sql_pro="SELECT rc.codigo_producto as codiguito, p.nombre as n_producto,rc.cantidad,me.abreviatura FROM `tb_receta_detalle` as rc INNER JOIN tb_producto as p ON p.codigo_oculto=rc.codigo_producto INNER JOIN tb_unidad_medida as me ON me.id=p.medida WHERE rc.codigo_receta='$row[codigo_oculto]'";
				$comando2=Conexion::getInstance()->getDb()->prepare($sql_pro);
				$comando2->execute();
				$txt='';
				while ($row2=$comando2->fetch(PDO::FETCH_ASSOC)) {
					$txt.='<li class="list-group-item" data-elproducto="'.$row2[codiguito].'" data-cantireceta="'.$row2[cantidad].'">'.$row2[n_producto].' '.Receta::convertir_decimal_a_fraccion($row2[cantidad]).' '.$row2[abreviatura].' <button id="quitar_ingrediente" class="btn btn-mio btn-xs pull-right" type="button"><i class="fa fa-remove"></i></button></li>';
				}
				$html.='<div class="col-xs-12 col-lg-12">
	                        <div class="widget">
	                          <div class="widget-simple">
                            	<div class="row">
                            		<div class="col-xs-5">
                            			<img height="70px" width="70px" src="../../img/productos/'.$row[imagen].'" alt="">
                            		</div>
                            		<div class="col-xs-5">
                            			<p style="font-size: 18px;" id="" data-cantidad="1" data-nombre="'.$row[nombre].'" data-precio="'.$row[precio].'" data-id="'.$row[codigo_oculto].'">'.$row[nombre].'</p>
                            			<p style="font-size: 18px;">'.$row[descripcion].'</p>
                            			<div class="'.$row[codigo_oculto].'" style="display: none;">'
                            			.$txt.
                            			'</div>
                            		</div>
                            		<div class="col-xs-2">
                            			<a style="border-radius: 90px" class="btn btn-mio btn-lg" id="producto_add" data-cantidad="1" data-nombre="'.$row[nombre].'" data-precio="'.$row[precio].'" data-id="'.$row[codigo_oculto].'" href="javascript:void(0)"><i class="fa fa-plus"></i></a>
                            		</div>
                            	</div>
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
			                    <!--tr>
			                    	<td>Espera: '.$diff->format("%h horas %i minutos").'</td>
			                    </tr-->
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
	            						
	            						<td>'.$detalle[n_producto].' '.$detalle[descripcion].'<br>- '.$detalle[notas].'</td>
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

	public static function eliminar($data){
		$sql="SELECT mesa FROM tb_comanda WHERE codigo_oculto='$data[codigo]'";
		$comando=Conexion::getInstance()->getDb()->prepare($sql);
		$comando->execute();
		$idmesa=$comando->fetchAll(PDO::FETCH_ASSOC);
		$array_mesa=array('data_id'=>'liberar_mesa','codigo_oculto' => $idmesa[0][mesa],'ocupado'=>0);
		$array=array(
			'table' => 'tb_comanda',
			'codigo_oculto' => $data[codigo]
		);
		$array2=array(
			'table' => 'tb_comanda_detalle',
			'codigo_comanda' => $data[codigo]
		);
		$result=Genericas2::eliminar_generica($array);
		if($result[0]=="1"){
			$result2=Genericas2::eliminar_generica($array2);
			if($result2[0]=="1"){
				$result3=Genericas2::actualizar_generica("tb_mesa",$array_mesa);
				return array(1,"exito",$result,$result2,$result3);
			}else{
				return array(-1,"error",$result,$result2);
			}
		}else{
			return array(-1,"error",$result);
		}
		
	}

	public static function eliminar_item($familia){
		$array=array(
			'table' => 'tb_comanda_detalle',
			'familia' => $familia
		);
		$result=Genericas2::eliminar_generica($array);
		if($result[0]=="1"){
			return array(1,"exito",$result);
		}else{
			return array(-1,"error",$result);
		}
	}
}
 ?>