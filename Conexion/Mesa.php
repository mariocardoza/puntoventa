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

	public static function modal_editar($id){
		$sql="SELECT * FROM tb_mesa WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$modal.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
           	<form action="#" method="post" name="fm_mesas" id="fm_mesas" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> de la mesa</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Nombre</label>
                            <div class="col-md-9">
                                <input type="hidden" name="data_id" value="editar_mesa">
                                <input type="hidden" name="id" value="'.$row[id].'">
                                <input required type="text" id="nombre" name="nombre" class="form-control" value="'.$row[nombre].'" placeholder="Digite el nombre del mesa">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="block">
                <div class="form-group">
                <div class="col-md-10">
                    <center>
                        <button type="button" id="btn_guardar" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cerrar</button>  
                    </center>
                </div>
            </div>
            </div>
        </div>
        </div>
    </form>
		</div>
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