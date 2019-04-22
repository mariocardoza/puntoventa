<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
require_once("Servicio.php");
require_once("Cliente.php");
/**
 * 
 */
class Reserva
{
	
	function __construct()
	{
			
	}

	public static function guardar($data){
		$codigo=date("Yidisus");
		$fecha_a=explode("/",$data[fecha]);
		$fecha=$fecha_a[2]."-".$fecha_a[1]."-".$fecha_a[0];
		$array_guardar=array(
			'data_id'=>'mueva',
			'servicio' => $data[servicio],
			'cliente' => $data[cliente],
			'empleado' => $data[empleado],
			'fecha' => $fecha,
			'hora' => $data[hora],
			'telefono' => $data[telefono],
			'codigo_oculto' => $codigo
		);

		$result=Genericas2::insertar_generica("tb_reserva",$array_guardar);
		if($result[0]=="1"){
			return array(1,"exito",$result);
		}else{
			return array(-1,"error",$result);
		}
	}

	public static function editar($data){
		$array_editar=array(
			'data_id'=>'mueva',
			'codigo_oculto' => $data[codigo_oculto],
			'servicio' => $data[servicio],
			'cliente' => $data[cliente],
			'empleado' => $data[empleado],
			'fecha' => $data[fecha],
			'hora' => $data[hora],
			'telefono' => $data[telefono]
		);
		$result=Genericas2::actualizar_generica("tb_reserva",$array_editar);
		if($result[0]=="1"){
			return array(1,"exito",$result);
		}else{
			return array(-1,"error",$result);
		}
		
	}

	public static function busqueda($dato){
        $sql="SELECT r.*,c.nombre as n_cliente,s.nombre as n_servicio, DATE_FORMAT(r.fecha,'%d/%m/%Y') as lafecha FROM tb_reserva as r INNER JOIN tb_cliente as c ON c.codigo_oculto=r.cliente INNER JOIN tb_servicio as s ON s.codigo_oculto=r.servicio WHERE r.estado=1";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                $html.='<div class="col-sm-6 col-lg-6" id="listado-card">
                <div class="widget">
                  <div class="widget-simple">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size:18px"><b>'.$row[n_servicio].'</b></td>
                            </tr>
                            <tr>
                                <td height="18px"></td>
                                <td>'.$row[n_cliente].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_departamento\',\'el departamento\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size:18px">Día: '.$row[lafecha].' hora: '.$row[hora].'</td>
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

    public static function modal_editar($codigo){
    	$servicios=Servicio::obtener_servicios();
    	$clientes=Cliente::obtener_todos();
    	$sql="SELECT * FROM tb_reserva WHERE codigo_oculto='$codigo'";
    	try{
    		$comando=Conexion::getInstance()->getdb()->prepare($sql);
    		$comando->execute();
    		while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
    			$modal.='<div class="modal fade depa" id="md_editar" aria-hidden="true"
				      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
				      <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                <button type="button" class="close" data-dismiss="modal">
				                  <span aria-hidden="true">×</span>
				                </button>
				                <h4 class="modal-title">Registrar reserva</h4>
				            </div>
				            <div class="modal-body">
				                    <form action="#" method="post" name="fm_reserva" id="fm_reserva" class="form-horizontal">
				            
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Servicio</label>
				                                <input type="hidden" name="data_id" value="editar_reserva">
				                                <input type="hidden" name="codigo_oculto" value="'.$row[codigo_oculto].'">   
				                                <select name="servicio" id="servicio" class="select-chosen">
				                                    <option value="">Seleccione..</option>';
				                                    foreach ($servicios as $servicio): 
				                                    	if($servicio[codigo_oculto]==$row[servicio]):
				                                        	$modal.='<option selected value="'.$servicio[codigo_oculto].'">'.$servicio[nombre].'</option>';
					                                    else:
					                                    	$modal.='<option value="'.$servicio[codigo_oculto].'">'.$servicio[nombre].'</option>';
					                                    endif;
				                                    endforeach; 
				                                $modal.='</select>
				                        </div>
				                        <div class="form-group">
				                            <label for="" class="control-label">Cliente</label>
				                            <select name="cliente" id="cliente" class="select-chosen">
				                                <option value="">Seleccione..</option>';
				                                foreach ($clientes[1] as $cliente):
				                                	if($cliente[codigo_oculto]==$row[cliente]): 
				                                    $modal.='<option selected value="'.$cliente[codigo_oculto].'">'.$cliente[nombre].'</option>';
				                                else:
				                                	$modal.='<option value="'.$cliente[codigo_oculto].'">'.$cliente[nombre].'</option>';
				                                endif;
				                                endforeach; 
				                            $modal.='</select>
				                        </div>
				                        <div class="form-group">
				                            <label for="" class="control-label">Empleado</label>
				                            <select name="empleado" id="empleado" class="select-chosen">
				                                <option value="">Seleccione...</option>
				                                <option value="">Cualquier empleado</option>
				                            </select>
				                        </div>
				                    
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Día</label>
				                                <input type="text" value="'.$row[fecha].'" name="dia" required class="form-control vecimi" id="dia">
				                        </div>
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Hora</label>
				                                <input type="time" value="'.$row[hora].'" name="hora" required class="form-control " id="hora">
				                        </div>
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Teléfono</label>
				                                <input type="text" value="'.$row[telefono].'" name="fin" required class="telefono form-control" id="fin">
				                        </div>
				                        <div class="form-group">
				                            <center>
				                                <button type="button" id="btn_editar" class="btn btn-mio">Guardar</button>
				                                <button type="button" data-dismiss="modal" class="btn btn-defaul"> Cerrar</button>
				                            </center>
				                        </div>
				                    </form>
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
}
 ?>