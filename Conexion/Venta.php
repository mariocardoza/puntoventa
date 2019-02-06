<?php 
@session_start();
include_once('Conexion.php');
include_once('Genericas2.php');
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

	public static function correlativo_venta($tipo){
		$comando=Conexion::getInstance()->getDb()->prepare("SELECT COUNT(*) as suma FROM tb_venta WHERE tipo='$tipo'");
			$comando->execute();
			while($row=$comando->fetch(PDO::FETCH_ASSOC)){
				$resultado=$row['suma'];
			}
			return $resultado+1;
	}

	public static function busqueda($dato,$tipo,$mes){
		$segun_tipo="";
		$segun_mes="";
		if($tipo!=''){
			$segun_tipo="AND v.tipo='$tipo'";
		}
		if($mes!=''){
			$segun_mes="AND MONTH(v.fecha) = '$mes'";
		}
        $sql="SELECT v.*,per.nombre as n_empleado,c.nombre as n_cliente, DATE_FORMAT(v.fecha, '%d/%m/%Y') as lafecha, v.codigo_oculto as codigo_venta FROM tb_venta as v INNER JOIN tb_persona as per ON v.empleado=per.email LEFT JOIN tb_cliente as c ON c.codigo_oculto=v.cliente WHERE v.estado=1 AND (c.nombre LIKE '%$dato%' OR per.nombre LIKE '%$dato%') $segun_tipo $segun_mes";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
                $ventas[]=$row;
            }
         foreach($ventas as $venta) { 
         	$eltipo="";
         	if($venta[tipo]==1){
         		$eltipo = "Crédito fiscal";
         	}
         	if($venta[tipo]==2){
         		$eltipo="Consumidor final";
         	}
         	if($venta[tipo]==3){
         		$eltipo="Ticket";
         	}
            $modal.='<div class="col-sm-6 col-lg-6" style="
    					height: 175px;" id="listado-card">
                <div class="widget">
                  <div class="widget-simple">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td rowspan="4" style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="ver(\''.$venta[codigo_venta].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
                                </td>
                                <td style="font-size: 18px;"><b> '.$eltipo.' N° '.$venta[correlativo]. '</b>
                                </td>
                                <td style="font-size: 18px;" rowspan="4">
                                	'.$venta[lafecha].'
                                </td>
                            </tr>
                            <tr>  
                                <td style="font-size: 18px; padding: 5px 0px;">
                                	cliente: '.$venta[n_cliente].'
                                </td>  
                            </tr>
                            <tr>  
                                <td style="font-size: 18px; padding: 5px 0px;">
                                	cajero: '.$venta[n_empleado].'
                                </td>  
                            </tr> 
                            <tr>  
                                <td style="font-size: 18px; padding: 5px 0px;">
                                	$'.number_format($venta[total],2).'
                                </td>  
                            </tr>  
                        </tbody>
                    </table>
                  </div>
              </div>
            </div>';
         } 
            return array(1,"exito",$modal,$productos,$sql);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage(),$sql);
        }

        
    }

	public static function nueva_venta($data){
		$codigo = date("Yidisus");
		$codigo_cuenta = date("Yidisus");
		$correlativo_venta=Venta::correlativo_venta($data[tipo_factura]);
		$array =array( // array para guardar la venta
			'data_id' => 'nueva_venta',
		    'empleado' => $_SESSION[usuario],
		    'fecha' => date("Y-m-d"),
		    'total' => $data[total],
		    'tipo' => $data[tipo_factura],
		    'cliente' => $data[cliente],
		    'tipo_venta' => $data[tipo_pago],
		    'codigo_oculto' => $codigo,
		    'correlativo' => $correlativo_venta,
		    'efectivo' => $data[efectivo],
		    'cambio' => $data[cambio]
		    );

		$cuenta=array(
			'data_id' => 'nueva_cuenta',
			'codigo_venta' => $codigo,
			'tipo_cuenta' => $data[tipo_pago],
			'cliente' => $data[cliente],
			'cliente_debe' => $data[cliente_debe],
			'monto' => $data[total],
			'fecha' => date("Y-m-d H:m:s"),
			'codigo_oculto' => $codigo_cuenta,
			'eltipo' => 1
		);
		$stm=Conexion::getInstance()->getDb();
		//$codigo=date("Yidisus");
		try{
			$stm->beginTransaction();
			$generic1=Genericas2::insertar_generica("tb_venta",$array);
			$generic2=Genericas2::insertar_generica("tb_cuenta",$cuenta);
			foreach ($data[venta] as $venta) {
				$array_i=array(
                'data_id'=> 'nuevo',
                'fecha' => date("Y-m-d"),
                'producto' => $venta[codigo],
                'detalle' => 'Venta N° '.$correlativo_venta.' al '.date("d/m/Y"),
                'precio_unitario' => $venta[precio],
                'cantidad' => $venta[cantidad],
                'tipo' => 2
            );
				Genericas2::insertar_generica("tb_inventario",$array_i);
				Genericas2::insertar_generica("tb_venta_detalle",array('data_id'=>'nueva','codigo_venta'=>$codigo,'codigo_producto'=>$venta[codigo],'cantidad'=>$venta[cantidad]));
			}
			$retorno_descuento=Venta::descontar_producto($data);
			$stm->commit();
			return array(1,$codigo,$data[tipo_factura],$generic1,$generic2);
		}catch(Exception $e){
			$stm->rollBack();
			return array(-1,$e->getMessage());
		}
		/*$retorno_descuento=Venta::descontar_producto($data);
		if($retorno_descuento[0]==1){
			return array(1,$data);
		}else{
			return array(-1,$retorno_descuento);
		}*/
		
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