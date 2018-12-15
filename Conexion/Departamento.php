<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Departamento
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function obtener_departamentos(){
		$sql="SELECT * FROM tb_departamento WHERE estado=1";
		try{
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
			$departamentos=$comando->fetchAll(PDO::FETCH_ASSOC);
			return array(1,$departamentos,$sql);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function modal_editar($id){
		$sql="SELECT * FROM tb_departamento WHERE id='$id'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$departamento=$row;
			}
			$modal='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar departamento</h4>
          </div>
          <div class="modal-body">
                    <form action="#" method="post" name="fm_departamento" id="fm_departamento" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> del departamento</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Nombre</label>
                            <div class="col-md-9">
                                <input type="hidden" name="data_id" value="editar_departamento">
                                
                                <input required type="text" id="nombre" value="'.$departamento[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Categoría</label>
                            <div class="col-md-9">
                                <textarea required name="descripcion" id="descripcion" class="form-control" rows="2">'.$departamento[descripcion].'</textarea>
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
                    <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>  
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

            return array("1",$departamento,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
?>