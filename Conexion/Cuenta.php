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

	public static function busqueda($dato,$turno){
		$elturno="";
		if($turno!=""){
			$elturno="AND c.turno='$turno'";
		}
		$sql="SELECT c.*,m.nombre as n_mesa FROM tb_comanda as c LEFT JOIN tb_mesa as m ON m.codigo_oculto=c.mesa  WHERE c.estado=2 $elturno ORDER BY id DESC";

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
			                                <td style="padding: 5px 0px;" width="15%"><a data-total="'.$row[total].'" href="javascript:void(0)" onclick="cobrar(\''.$row[codigo_oculto].'\',\''.$row[total].'\',\''.$row[mesa].'\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td>
			                                <td style="font-size:18px">Total: $'.$row[total].'</td>
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
}
 ?>