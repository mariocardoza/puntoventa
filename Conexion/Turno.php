<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Turno
{
	
	function __construct()
	{
		# code...
	}

	public static function busqueda(){
		$sql="SELECT * FROM tb_turno";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<div class="col-sm-6 col-lg-6" style="height: 175px;" id="listado-card">
			                <div class="">
			                  <div class="">
			                    <table width="100%">
			                        <tbody>
			                            <tr>
			                                <td style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
			                                </td>
			                                <td style="font-size:18px"><b>Turno: </b>'.$row[nombre].'</td>
			                            </tr>
			                            <tr>
			                                <td style="padding: 5px 0px;"><a href="javascript:void(0)" onclick="ver(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Ver"><!--img src="../../img/iconos/ojo.svg" width="35px" height="35px"--></a></td>
			                                <td style="font-size:18px"></td>
			                            </tr>
			                            <tr>
			                                <td style="padding: 5px 0px;" width="15%"><a data-total="'.$row[total].'" href="javascript:void(0)"  data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td>
			                                <td style="font-size:18px">'.$row[inicio].' '.$row[fin].'</td>
			                            </tr>
			                        </tbody>
			                    </table>
			                  </div>
			              	</div>
	            		</div>';
			}
			return array(1,"exito",$html,$sql);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
		}
}
?>