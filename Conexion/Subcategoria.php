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

    public static function busqueda($dato){
        $sql="SELECT s.id as id,s.nombre as nombre,s.descripcion as descripcion,c.nombre as categoria FROM tb_subcategoria as s LEFT JOIN tb_categoria as c ON c.id=s.categoria WHERE s.nombre LIKE '%$dato%'";
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
                                <td width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[id].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a></a></td>
                                <td><b>'.$row[nombre].'</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Descripción: '.$row[descripcion].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_subcategoria\',\'la subcategoría\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></a></td>
                                <td>Categoría: '.$row[categoria].'</td>
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
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"><b>Editar subcategoría</b></h4>
          </div>
          <div class="modal-body">
                    <form action="#" method="post" name="fm_subcategoria" id="fm_subcategoria" class="form-horizontal">
                    <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                            
                                <input type="hidden" name="data_id" value="editar_subcategoria">
                                <input type="hidden" name="id" id="id" value="'.$subcategoria[id].'">
                                
                                <input required type="text" id="nombre" value="'.$subcategoria[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                            
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="nombre">Categoría</label>
                            
                                <textarea required name="descripcion" id="descripcion" class="form-control" rows="2">'.$subcategoria[descripcion].'</textarea>
                           
                        </div>
                        <div class="form-group">
                            <label for="" class="control-label">Categoría</label>
                            
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
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn btn-mio">Guardar</button>
                            <button type="button" data-dismiss="modal" class="btn btn btn-default">Cerrar</button>  
                            </center>
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