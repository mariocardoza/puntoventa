<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
/**
 * 
 */
class Turno
{
	
	function __construct()
	{
		# code...
	}

	public static function obtener_mi_turno(){
		$sql="SELECT * FROM tb_turno WHERE empleado='$_SESSION[usuario]' AND estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$turno=$comando->fetchAll();
			return $turno;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function tiene_turno($email){
		$sql="SELECT codigo_oculto FROM tb_turno WHERE empleado='$email' AND estado=1";
		$codigo="";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$codigo=$row[codigo_oculto];
			}
			return $codigo;
		}catch(Exception $e){
			return 2;
		}
	}

	public static function busqueda(){
		$sql="SELECT p.nombre as n_empleado, DATE_FORMAT(t.inicio,'%d/%m/%Y %H:%i:%s') as ingreso, DATE_FORMAT(t.fin,'%d/%m/%Y %H:%i:%s') as salida ,t.estado,t.codigo_oculto FROM tb_turno as t INNER JOIN tb_persona as p ON t.empleado=p.email ORDER BY t.estado,t.inicio DESC";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<div class="col-sm-6 col-lg-6" style="height: 175px;" id="listado-card">
			                <div class="widget">
			                  <div class="widget-simple">
			                  	<div class="row">
			                  		<div class="col-xs-2">
			                  			<br><br>
			                  			<a onclick="ver_resumen(\''.$row[codigo_oculto].'\')" href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
                            			<br><br>
			                  		</div>
			                  		<div class="col-xs-10">
			                  			<div class="row">
			                  				<div class="col-xs-12" style="font-size:18px"><b>Turno: '.$row[n_empleado].'</b></div>
			                  				<div class="col-xs-12" style="font-size:18px">Ingreso: '.$row[ingreso].'</div>';
											if($row[estado]==1):
											$html.='<div class="col-xs-12" style="font-size: 18px">Activo</div>';
											else:
			                  				$html.='<div class="col-xs-12" style="font-size:18px">Salida: '.$row[salida].'</div>';
			                  				endif;
			                  			$html.='</div>
			                  		</div>
			                  	</div>
			                  </div>
			              	</div>
	            		</div>';
			}
			return array(1,"exito",$html,$sql);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function nuevo_turno($data){
		$codigo=date("Yidisus");
		$array=array(
			'nuevo' => 'nuevo',
			'caja' => $data[caja],
			'empleado' => $_SESSION[usuario],
			'inicio' => date("Y-m-d H:i:s"),
			'codigo_oculto' => $codigo
		);
		$array_caja=array('nueva'=>'nueva','codigo_oculto'=>$data[caja],'abierta'=>1);
		$result=Genericas2::insertar_generica("tb_turno",$array);
		$result2=Genericas2::actualizar_generica("tb_caja",$array_caja);
		if($result[0]=="1" && $result2[0]=="1"){
			return array(1,"exito",$result,$result2);
			$_SESSION['turno']=$codigo;
		}else{
			return array(-1,"error",$result,$result2);
		}
		
	}

	public static function terminar_turno(){
		$caja=Turno::liberar_caja($_SESSION[turno]);
		$ahorita=date('Y-m-d H:i:s');
		$sql="UPDATE tb_turno SET fin='$ahorita', estado=2 WHERE codigo_oculto='$_SESSION[turno]' AND estado=1;
			UPDATE tb_caja SET abierta=0 WHERE codigo_oculto='$caja'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$caja);
			unset($_SESSION['turno']);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage());
		}
	}

	private static function liberar_caja($turno){
		$sql="SELECT caja FROM tb_turno WHERE codigo_oculto='$turno'";
		$caja="";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$caja=$row[caja];
			}
			return $caja;
		}catch(Exception $e){
			return -1;
		}
	}

	public static function ver_resumen($turno){
		$sql="SELECT SUM(mc.monto) as total,COUNT(*) as cuantos,CASE WHEN t.estado=1 THEN 'Turno abierto' ELSE 'Turno cerrado' END AS elturno,DATE_FORMAT(t.inicio,'%d/%m/%Y %H:%i:%s') as elinicio, CASE WHEN t.fin !='' THEN DATE_FORMAT(t.fin,'%d/%m/%Y %H:%i:%s') ELSE '-' END AS elfin,p.nombre as n_cajero FROM tb_movimiento_caja as mc INNER JOIN tb_turno as t ON t.codigo_oculto=mc.turno INNER JOIN tb_persona as p ON p.email=t.empleado WHERE mc.turno='$turno'";
		$sql2="SELECT c.nombre as lacaja, DATE_FORMAT(mc.fecha_movimiento,'%d/%m/%Y %H:%i:%s') as lafecha, CASE WHEN mc.tipo=1 THEN 'Ingreso de dinero' ELSE 'Salidad de dinero' END AS elmovimiento,mc.concepto,mc.monto FROM tb_movimiento_caja as mc INNER JOIN tb_turno as t ON t.codigo_oculto=mc.turno INNER JOIN tb_caja as c ON c.codigo_oculto=t.caja WHERE mc.turno='$turno'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando2=Conexion::getInstance()->getDb()->prepare($sql2);
			$comando->execute();
			$comando2->execute();
			$detalles=$comando2->fetchAll(PDO::FETCH_ASSOC);
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$modal.='<div class="modal fade modal-side-fall" id="md_ver_resumen" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
		      <div class="modal-dialog modal-lg">
		        <div class="modal-content">
		          <div class="modal-header">
		            <button type="button" class="close" data-dismiss="modal">
		              <span aria-hidden="true">×</span>
		            </button>
		            <h4 class="modal-title">Ver resumen del turno</h4>
		          </div>
		          <div class="modal-body">
		            <div class="row">
		            	<div class="col-xs-12">
		            		<table class="table">
				                <tbody>
				                	<tr>
				                		<th>Status</th>
				                		<td>'.$row[elturno].'</td>
				                	</tr>
				                	<tr>
				                		<th>Cajero(a):</th>
				                		<td>'.$row[n_cajero].'</td>
				                	</tr>
				                	<tr>
				                		<th>Inicio del turno</th>
				                		<td>'.$row[elinicio].'</td>
				                	</tr>
				                	<tr>
				                		<th>Finalización del turno</th>
				                		<td>'.$row[elfin].'</td>
				                	</tr>
				                	<tr>
				                        <th>N° de transacciones</th>
				                        <td>'.$row[cuantos].'</td>
				                    </tr>
				                    <tr>
				                        <th>Total</th>
				                        <td>$'.$row[total].'</td>
				                    </tr>
				                </tbody>
		            		</table>
		            	</div>';
		            	$modal.='<div class="col-xs-12">
		            		<table class="table" id="tabla_resumen">
		            			<thead>
		            				<th>N°</th>
		            				<th>Caja</th>
		            				<th>Concepto</th>
		            				<th>Monto</th>
		            				<th>Fecha y hora</th>
		            			</thead>
		            			<tbody>';
		            				foreach($detalles as $key => $detalle):
		            					//$key = $key+1;
		            					$modal.='<tr>
											<td>'.((int)$key+1).'</td>
											<td>'.$detalle[lacaja].'</td>
											<td>'.$detalle[concepto].'</td>
											<td>$'.$detalle[monto].'</td>
											<td>'.$detalle[lafecha].'</td>
										</tr>';
		            				endforeach;
		            			$modal.='</tbody>
		            		</table>
		            	</div>
		            </div>
		          </div>
		          <div class="modal-footer">
		            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
		          </div>
		        </div>
		      </div>
		    </div>';
			}
			return array(1,"exito",$modal);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function mis_movimientos(){
		$sql="SELECT c.nombre as lacaja, DATE_FORMAT(mc.fecha_movimiento,'%d/%m/%Y %H:%i:%s') as lafecha, CASE WHEN mc.tipo=1 THEN 'Ingreso de dinero' ELSE 'Salidad de dinero' END AS elmovimiento,mc.monto FROM `tb_movimiento_caja` as mc INNER JOIN tb_turno as t ON t.codigo_oculto=mc.turno INNER JOIN tb_caja as c ON c.codigo_oculto=t.caja WHERE mc.turno='$_SESSION[turno]' AND t.estado=1";
		$i=1;
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<tr>
					<td>'.$i.'</td>
					<td>'.$row[lacaja].'</td>
					<td>'.$row[elmovimiento].'</td>
					<td>$'.$row[monto].'</td>
					<td>'.$row[lafecha].'</td>
				</tr>';
				$i++;
			}
			return array(1,"exito",$html);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function movimientos_dia(){
		$sql="SELECT c.nombre as lacaja,p.nombre as n_cajero, DATE_FORMAT(mc.fecha_movimiento,'%d/%m/%Y %H:%i:%s') as lafecha, CASE WHEN mc.tipo=1 THEN 'Ingreso de dinero' ELSE 'Salidad de dinero' END AS elmovimiento,mc.monto,mc.concepto FROM `tb_movimiento_caja` as mc INNER JOIN tb_turno as t ON t.codigo_oculto=mc.turno INNER JOIN tb_caja as c ON c.codigo_oculto=t.caja INNER JOIN tb_persona as p ON p.email=t.empleado WHERE DAY(mc.fecha_movimiento)=DAY(NOW())";
		$i=1;
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<tr>
					<td>'.$i.'</td>
					<td>'.$row[lacaja].'</td>
					<td>'.$row[n_cajero].'</td>
					<td>$'.$row[monto].'</td>
					<td>'.$row[lafecha].'</td>
					<td>'.$row[concepto].'</td>	
				</tr>';
				$i++;
			}
			return array(1,"exito",$html);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}
}
?>