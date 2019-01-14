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
                                <td style="font-size: 18px;">Teléfono: '.$row[telefono].'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_proveedor\',\'el proveedor\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size: 18px;">Dirección: '.$row[direccion].'</td>
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
			     <form action="#" method="post" name="fm_proveedor" id="fm_proveedor" class="form-horizontal">
                    <fieldset>
                        <legend>Datos del proveedor</legend>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="nombre">Nombre</label>
                                    <input type="hidden" name="data_id" value="editar_proveedor">
                                    <input type="hidden" name="id" id="id" value="'.$proveedor[id].'">
                                    <input required type="text" id="nombre" name="nombre" value="'.$proveedor[nombre].'" class="form-control" placeholder="Digite el nombre del proveedor">
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="categoria">NIT</label>
                                    
                                    <input type="text" value="'.$proveedor[nit].'" required name="nit" id="nit" class="form-control nit">  
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="telefono">Número de teléfono</label>
                                    <input type="text" required name="telefono" value="'.$proveedor[telefono].'" id="telefono" class="form-control telefono"> 
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="direccion">Dirección</label>
                                    
                                    <textarea required id="direccion" name="direccion" class="form-control" rows="2">'.$proveedor[direccion].'</textarea>
                                    
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    <input type="email" required id="email" value="'.$proveedor[email].'" name="email" class="form-control" >  
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Número de registro</label>
                                    <input type="text" required name="nrc" value="'.$proveedor[nrc].'" id="nrc" class="form-control">  
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Giro</label>
                                    <input type="text" value="'.$proveedor[giro].'" name="giro" id="giro" class="form-control">  
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Datos del representante legal</legend>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="control-label">Nombre</label>
                                    
                                    <input type="text" id="nombre_r" name="nombre_r" value="'.$proveedor[nombre_r].'" class="form-control">
                                   
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Teléfono</label>
                                        <input type="text" id="telefono_r" value="'.$proveedor[telefono_r].'" name="telefono_r" class="form-control telefono">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="" class="control-label">DUI</label>
                                    <input name="dui_r" value="'.$proveedor[dui_r].'" id="dui_r" rows="2" class="form-control dui">  
                                </div>
                                <div class="form-group">
                                    <label for="" class="control-label">Dirección</label>
                                    <textarea name="direccion_r" id="direccion_r"  rows="2" class="form-control">'.$proveedor[direccion_r].'</textarea> 
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="row">
                        <div class="col-lg-12>
                            <div class="form-group">
                                <center>
                                    <button type="button" id="btn_guardar" class="btn btn-mio"> Guardar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default"> Cerrar</button>  
                                </center>
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