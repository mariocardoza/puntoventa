<?php 
@session_start();
require_once("Conexion.php");
require_once("Empleado.php");
/**
 * 
 */
class Servicio
{
	
	function __construct()
	{
					
	}

	public static function obtener_servicios(){
		$sql="SELECT
			s.id,
			s.nombre AS nombre,
			s.descripcion AS descripcion,
			s.precio AS precio,
			s.duracion AS duracion,
			CASE
		WHEN s.empleado = 0 THEN
			'Sin empleado asignado'
		ELSE
			p.nombre
		END AS empleado
		FROM
			tb_servicio AS s
		LEFT JOIN tb_persona AS p ON s.empleado = p.id
		WHERE
			s.estado = 1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$servicios[]=$row;
			}

			return $servicios;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function modal_editar($id)
	{
		$empleados=Empleado::obtener_empleados();
		$sql="SELECT * FROM tb_servicio WHERE id=$id";
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
            <form action="#" method="post" name="fm_servicios" id="fm_servicios" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="fa fa-pencil"></i> <strong>Editar información</strong> de los servicios</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nombre">Nombre del servicio</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="data_id" value="editar_servicio">
                                    <input type="hidden" name="id" value="'.$row[id].'">
                                    <input type="text" autocomplete="off" id="nombre" value="'.$row[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del servicio">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Descripción</label>
                                <div class="col-md-9">
                                    <textarea name="descripcion" id="descripcion"  rows="2" class="form-control">'.$row[descripcion].'</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="direccion">Precio</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="precio" value="'.$row[precio].'" id="precio">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="categoria">Tiempo estimado de duración</label>
                                <div class="col-md-9">
                                    <input type="text" name="duracion" id="duracion" value="'.$row[duracion].'" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Empleado</label>
                                <div class="col-md-9">
                                    <select class="select-chosen" name="empleado" id="empleado">
                                    <option value="0">Ninguno</option>';
                                    foreach($empleados[1] as $empleado){
                                    		if($row[empleado]==$empleado[id]){
                                    		$modal.='<option selected value="'.$empleado[id].'">'.$empleado[nombre].'</option>';
                                    	}else{
											$modal.='<option value="'.$empleado[id].'">'.$empleado[nombre].'</option>';
                                    	}	
                                    }
                                    $modal.='</select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-10">
                                <center>
                                    <button type="button" id="btn_guardar" class="btn btn btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                                </center>
                            </div>
                        </div>
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

			return array(1,"exito",$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
 ?>