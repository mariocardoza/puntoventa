<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Reserva
{
	
	function __construct()
	{
			
	}

	public static function guardar($data){

	}

	public static function editar($data){

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
                                <td style="font-size:18px">Día: '.$row[lafecha].' hora: 08:30 am</td>
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
				                    <form action="#" method="post" name="fm_turno" id="fm_turno" class="form-horizontal">
				            
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Servicio</label>
				                                <input type="hidden" name="data_id" value="editar_reserva">
				                                <input type="hidden" name="codigo_oculto" value="'.$row[codigo_oculto].'">   
				                                <select name="servicio" id="servicio" class="select-chosen">
				                                    <option value="">Seleccione..</option>
				                                    <?php foreach ($servicios as $servicio): ?>
				                                        <option value="<?php echo $servicio[codigo_oculto] ?>"><?php echo $servicio[nombre] ?></option>
				                                    <?php endforeach ?>
				                                </select>
				                        </div>
				                        <div class="form-group">
				                            <label for="" class="control-label">Cliente</label>
				                            <select name="cliente" id="cliente" class="select-chosen">
				                                <option value="">Seleccione..</option>
				                                <?php foreach ($clientes[1] as $cliente): ?>
				                                    <option value="<?php echo $cliente[codigo_oculto] ?>"><?php echo $cliente[nombre] ?></option>
				                                <?php endforeach ?>
				                            </select>
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
				                                <input type="text" name="dia" required class="form-control vecimi" id="dia">
				                        </div>
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Hora</label>
				                                <input type="time" name="hora" required class="form-control " id="hora">
				                        </div>
				                        <div class="form-group">
				                            <label class="control-label" for="nombre">Teléfono</label>
				                                <input type="text" value="'.$row[telefono].'" name="fin" required class="telefono form-control" id="fin">
				                        </div>
				                        <div class="form-group">
				                            <center>
				                                <button type="button" id="btn_guardar" class="btn btn-mio">Guardar</button>
				                                <button type="reset" data-dismiss="modal" class="btn btn-defaul"> Cerrar</button>
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