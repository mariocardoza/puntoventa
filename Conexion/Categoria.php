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

    public static function consumibles(){
        $sql="SELECT c.id as id,c.nombre as nombre FROM tb_categoria as c WHERE c.departamento=2";
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
                $html.='<div class="col-sm-6 col-lg-6" id="listado-card">
                <div class="widget">
                  <div class="widget-simple">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[id].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size: 18px;"><b>'.$row[nombre].'</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td style="font-size: 18px;">Descripción: '.$row[descripcion].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_categoria\',\'la categoría\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size: 18px;">Departamento: '.$row[departamento].'</td>
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
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar categoría</h4>
          </div>
          <div class="modal-body">
                    <form action="#" method="post" name="fm_categoria" id="fm_categoria" class="form-horizontal">
                    <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                            <input type="hidden" name="data_id" value="editar_categoria">
                            <input type="hidden" name="id" id="id" value="'.$categoria[id].'" >    
                            <input required type="text" id="nombre" value="'.$categoria[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nombre">Categoría</label>
                            <textarea required name="descripcion" id="descripcion" class="form-control" rows="2">'.$categoria[descripcion].'</textarea>
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Departamento</label>
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
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-sm btn-mio">Guardar</button>
                            <button type="button" data-dismiss="modal" class="btn btn-sm btn-default">Cerrar</button>  
                            </center>
                        </div>
                    </form>
		        </div>
            </div>
        </div>
    </div>';

            return array("1",$departamento,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
 ?>