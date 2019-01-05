<?php 
@session_start();
require_once("Conexion.php");
require_once("Departamento.php");
/**
 * 
 */
class Categoria
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function obtener_categorias(){
		$sql="SELECT c.id as id,c.nombre as nombre,c.descripcion as descripcion,d.nombre as departamento FROM tb_categoria as c INNER JOIN tb_departamento as d ON d.id=c.departamento";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$categorias[]=$row;
			}
			return array(1,"exito",$categorias);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

    public static function busqueda($dato){
        $sql="SELECT c.id as id,c.nombre as nombre,c.descripcion as descripcion,d.nombre as departamento FROM tb_categoria as c INNER JOIN tb_departamento as d ON d.id=c.departamento WHERE c.nombre LIKE '%$dato%'";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                $html.='<div class="col-sm-6 col-lg-6" style="border:solid 0.50px;">
                <div class="widget">
                  <div class="widget-simple">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[id].'\')" data-toggle="tooltip" title="Editar" class="btn btn-mio"><i class="fa fa-pencil"></i></a></td>
                                <td><b>'.$row[nombre].'</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Descripción: '.$row[descripcion].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_categoria\',\'la categoría\')" data-toggle="tooltip" title="Eliminar" class="btn btn-mio"><i class="fa fa-trash"></i></a></td>
                                <td>Departamento: '.$row[departamento].'</td>
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

	public static function modal_editar($id){
		$sql="SELECT * FROM tb_categoria WHERE id='$id'";

		$departamentos=Departamento::obtener_departamentos();
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$categoria=$row;
			}
			$modal.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar categoría</h4>
          </div-->
          <div class="modal-body">
                    <form action="#" method="post" name="fm_categoria" id="fm_categoria" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> de la categorias</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Nombre</label>
                            <div class="col-md-9">
                                <input type="hidden" name="data_id" value="editar_categoria">
                                
                                <input required type="text" id="nombre" value="'.$categoria[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Categoría</label>
                            <div class="col-md-9">
                                <textarea required name="descripcion" id="descripcion" class="form-control" rows="2">'.$categoria[descripcion].'</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Departamento</label>
                            <div class="col-md-9">
                                 <select name="departamento" id="departamento" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 100%;">';
                                    foreach ($departamentos[1] as $departamento){
                                    	if($departamento[id]==$categoria[departamento]){
                                    		$modal.='<option selected value="'.$departamento[id].'">'.$departamento[nombre].'</option>';
                                    	}else{
                                    		$modal.='<option value="'.$departamento[id].'">'.$departamento[nombre].'</option>';
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
                        <button type="button" id="btn_guardar" class="btn btn-sm btn-mio"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-sm btn-warning"><i class="fa fa-times"></i> Cerrar</button>  
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