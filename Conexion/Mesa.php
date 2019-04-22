<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Mesa
{
	
	function __construct()
	{
		# code...
	}

	public static function obtener_mesas(){
		$sql="SELECT m.id,m.nombre,m.ocupado,m.codigo_oculto, CASE WHEN m.ocupado=0 then 'Libre' ELSE 'Ocupado' end as disponibilidad FROM tb_mesa as m WHERE estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while($row=$comando->fetch(PDO::FETCH_ASSOC)){
				$mesas[]=$row;
			}
			return $mesas;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

    public static function busqueda(){
        $sql="SELECT m.id,m.nombre,m.ocupado,m.codigo_oculto, CASE WHEN m.ocupado=0 then 'Libre' ELSE 'Ocupado' end as disponibilidad FROM tb_mesa as m WHERE estado=1";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while($row=$comando->fetch(PDO::FETCH_ASSOC)){
                $html.='<div class="col-xs-6 col-lg-4">
                  <div class="draggable widget">
                      <div class="widget-simple '.(($row[ocupado] == 0) ? 'themed-background-dark' : 'themed-background-dark-fire').'">
                        <div class="row">
                            <div class="col-xs-8">
                                <a data-codigo="'.$row[codigo_oculto].'" data-nombre="'.$row[nombre].'" href="javascript:void(0)">
                                    <img src="../../img/placeholders/MESAS.svg" alt="avatar" class="widget-image img-circle pull-left">
                                </a>
                                <h4 class="widget-content">
                                    <a data-nombre="'.$row[nombre].'" data-codigo="'.$row[codigo_oculto].'" href="javascript:void(0)">
                                      <strong>'.$row[nombre].'</strong>
                                      <p>'.(($row[ocupado]==0)? 'Libre' : 'Ocupada').'</p>
                                    </a>
                                </h4>
                            </div>
                            <div class="col-xs-4">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <a class="pull-right" onclick="editar(\''.$row[id].'\')" href="javascript:void(0)"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>

                                    </div>
                                    <br> <br> <br>
                                    <div class="col-xs-12">
                                        <a class="pull-right" onclick="darbaja(\''.$row[id].'\',\'tb_mesa\',\'la mesa\')"  href="javascript:void(0)"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                  </div>
                </div> ';
            }
            return array(1,"exito",$html);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage());
        }
    }

	public static function modal_editar($id){
		$sql="SELECT * FROM tb_mesa WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$modal.='<div class="modal fade depa" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar mesa</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_mesas" id="fm_mesas" class="form-horizontal">
            
                        <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                                <input type="hidden" name="data_id" id="data_id" value="editar_mesa">
                                <input type="hidden" name="id" id="id" value="'.$row[id].'">   
                                <input type="hidden" name="codigo_oculto" id="codigo_oculto" value="'.date("Yidisus").'">
                                <input required type="text" id="nombre" name="nombre" class="form-control" autocomplete="off" value="'.$row[nombre].'" placeholder="Digite el nombre del departamento">
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-sm btn-mio">Guardar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-sm btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>';
			}
			return array(1,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}
}
?>