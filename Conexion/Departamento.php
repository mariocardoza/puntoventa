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

    public static function busqueda($dato){
        $sql="SELECT * FROM tb_departamento WHERE nombre LIKE '%$dato%'";
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
                                <td style="font-size:18px"><b>'.$row[nombre].'</b></td>
                            </tr>
                            <tr>
                                <td height="18px"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_departamento\',\'el departamento\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size:18px">Descripción: '.$row[descripcion].'</td>
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
		$sql="SELECT * FROM tb_departamento WHERE id='$id'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$departamento=$row;
			}
			$modal='<div class="modal fade depa" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Editar departamento</h4>
            </div>
          <div class="modal-body">
                <form action="#" method="post" name="fm_departamento" id="fm_departamento" class="form-horizontal">
        
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre</label>
                            <input type="hidden" name="data_id" value="editar_departamento">
                            <input required type="hidden" value="'.$departamento[id].'" name="id" class="form-control" placeholder="Digite el nombre del departamento">  
                            <input required type="text" id="nombre" value="'.$departamento[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">

                    </div>
                
                    <div class="form-group">
                        <label class="control-label" for="nombre">Categoría</label>
                            <textarea required name="descripcion" id="descripcion" class="form-control" rows="2">'.$departamento[descripcion].'</textarea>
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

            return array("1",$departamento,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
?>