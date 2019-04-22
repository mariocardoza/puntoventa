<?php 	
@session_start();
require_once("Conexion.php");
/**
 * 	
 */
class Cuenta	
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function obtener_turnos(){
		$sql="SELECT p.nombre,p.email FROM tb_turno as t INNER JOIN tb_persona as p ON p.email=t.empleado GROUP BY p.email";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$turnos=$comando->fetchAll(PDO::FETCH_ASSOC);
			return $turnos;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function busqueda($dato,$turno){
		$elturno="";
		if($turno!=""){
			$elturno="AND p.email='$turno'";
		}
		$sql="SELECT c.*,m.nombre as n_mesa FROM tb_comanda as c LEFT JOIN tb_mesa as m ON m.codigo_oculto=c.mesa INNER JOIN tb_turno as t ON t.codigo_oculto=c.turno INNER JOIN tb_persona as p ON p.email=t.empleado WHERE c.estado=2 $elturno ORDER BY id DESC";

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
			                <div class="widget">
			                  <div class="widget-simple">
			                  	<div class="row">
			                  		<div class="col-xs-2">
			                  			<br><br>
			                  			<a href="javascript:void(0)" onclick="ver(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Ver"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
			                  		</div>
			                  		<div class="col-xs-10">
			                  			<div class="row">
			                  				<div style="font-size:18px" class="col-xs-12"><b>Orden: </b>'.$tipo_orden.'</div><br><br>
			                  				<div style="font-size:18px" class="col-xs-12">'.$row[n_mesa].'</div><br><br>
			                  				<div style="font-size:18px" class="col-xs-12">Total: $'.$row[total].'</div>
			                  			</div>
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
			return array(1,"exito",$html,$sql);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}
}
 ?>