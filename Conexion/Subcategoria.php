<?php 
@session_start();
require_once('Conexion.php');
require_once('Categoria.php');
/**
 * 
 */
class Subcategoria
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function obtener_subcategorias(){
		$sql="SELECT s.id as id,s.nombre as nombre,s.descripcion as descripcion,c.nombre as categoria FROM tb_subcategoria as s LEFT JOIN tb_categoria as c ON c.id=s.categoria";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$subcategorias[]=$row;
			}
			return array(1,"exito",$subcategorias);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

	public static function modal_editar($id){
		$sql="SELECT * FROM tb_subcategoria WHERE id='$id'";

		$categorias=Categoria::obtener_categorias();
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$subcategoria=$row;
			}
			$modal.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar departamento</h4>
          </div-->
          <div class="modal-body">
                    <form action="#" method="post" name="fm_subcategoria" id="fm_subcategoria" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> de la subcategoría</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Nombre</label>
                            <div class="col-md-9">
                                <input type="hidden" name="data_id" value="editar_subcategoria">
                                <input type="hidden" name="id" value="'.$subcategoria[id].'">
                                
                                <input required type="text" id="nombre" value="'.$subcategoria[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Categoría</label>
                            <div class="col-md-9">
                                <textarea required name="descripcion" id="descripcion" class="form-control" rows="2">'.$subcategoria[descripcion].'</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Departamento</label>
                            <div class="col-md-9">
                                 <select name="categoria" id="categoria" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 100%;">';
                                    foreach ($categorias[2] as $categoria){
                                    	if($categoria[id]==$subcategoria[categoria]){
                                    		$modal.='<option selected value="'.$categoria[id].'">'.$categoria[nombre].'</option>';
                                    	}else{
                                    		$modal.='<option value="'.$categoria[id].'">'.$categoria[nombre].'</option>';
                                    	}

                                        
                                    }
                                $modal.='</select>
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

            return array("1",$subcategoria,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
?>