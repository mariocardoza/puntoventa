<?php 
@session_start(); 
require_once("Conexion.php");

/**
 * 
 */
class Proveedor
{
	
	function __construct($argument)
	{
		# code...
	}
	public static function obtener_proveedores(){
		$sql="SELECT * FROM tb_proveedor WHERE estado=1";
		$proveedores="";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$proveedores=$comando->fetchAll(PDO::FETCH_ASSOC);

			return array(1,"exito",$proveedores,$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

    public static function busqueda($dato){
        $sql="SELECT * FROM tb_proveedor as p WHERE p.estado=1 AND p.nombre LIKE '%$dato%'";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
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
                                <td>Teléfono: '.$row[telefono].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_proveedor\',\'el proveedor\')" data-toggle="tooltip" title="Eliminar" class="btn btn-mio"><i class="fa fa-trash"></i></a></td>
                                <td>Dirección: '.$row[direccion].'</td>
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
		$sql="SELECT * FROM tb_proveedor WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$proveedor=$row;
			}
			$modal='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar proveedor</h4>
          </div>
          <div class="modal-body">
			<form action="#" method="post" name="fm_proveedor" id="fm_proveedor" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
                </div>
                <div class="row">
                    <div class="col-lg-6">
            <div class="form-group">
                <label class="col-md-3 control-label" for="nombre">Nombre</label>
                <div class="col-md-9">
                    <input type="hidden" name="data_id" value="editar_proveedor">
                    <input type="hidden" name="id" value="'.$proveedor[id].'">
                    <input required type="text" id="nombre" name="nombre" value="'.$proveedor[nombre].'" class="form-control" placeholder="Digite el nombre del proveedor">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="direccion">Dirección</label>
                <div class="col-md-9">
                    <textarea required id="direccion" name="direccion" class="form-control" rows="3">'.$proveedor[direccion].'</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="categoria">NIT</label>
                <div class="col-md-9">
                    <input type="text" value="'.$proveedor[nit].'" required name="nit" id="nit" class="form-control nit">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="telefono">Número de teléfono</label>
                <div class="col-md-9">
                    <input type="text" required name="telefono" value="'.$proveedor[telefono].'" id="telefono" class="form-control telefono">
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label class="col-md-3 control-label" for="email">Email</label>
                <div class="col-md-9">
                    <div class="form-group">
                        <input type="email" required id="email" value="'.$proveedor[email].'" name="email" class="form-control" >
                    </div>
                </div>
            </div>
              <div class="form-group">
                        <label for="" class="col-md-3 control-label">Número de registro</label>
                        <div class="col-md-9">
                            <input type="text" required name="nrc" value="'.$proveedor[nrc].'" id="nrc" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Giro</label>
                        <div class="col-md-9">
                            <input type="text" value="'.$proveedor[giro].'" name="giro" id="giro" class="form-control">
                        </div>
                    </div>
        </div>
        </div>
        </div>
        </div>
        
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Datos</strong> del representante legal</h2>
                </div>
                <div class="row">
                <div class="col-lg-6">
                  <div class="form-group">
                        <label for="" class="col-md-3 control-label">Nombre</label>
                        <div class="col-md-9">
                            <input type="text" id="nombre_r" name="nombre_r" value="'.$proveedor[nombre_r].'" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Teléfono</label>
                        <div class="col-md-9">
                            <input type="text" id="telefono_r" value="'.$proveedor[telefono_r].'" name="telefono_r" class="form-control telefono">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    
                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">Dirección</label>
                        <div class="col-md-9">
                            <textarea name="direccion_r" id="direccion_r"  rows="2" class="form-control">'.$proveedor[direccion_r].'</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-md-3 control-label">DUI</label>
                        <div class="col-md-9">
                            <input name="dui_r" value="'.$proveedor[dui_r].'" id="dui_r" rows="2" class="form-control dui">
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

            return array("1",$proveedor,$sql,$modal);
		}catch(Exception $e){
			return array(-1,$sql,$e->getMessage());
		}
	}
}
?>