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

    public static function busqueda($dato){
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
            s.nombre LIKE '%$dato%'
            AND s.estado = 1";
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
                                <td><b>'.$row[nombre].'</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Precio: $'.number_format($row[precio],2).'</td>
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_servicio\',\'el servicio\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>
                                <td>Descripción: '.$row[descripcion].'</td>
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
            <h4 class="modal-title"><b>Editar servicio</b></h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="fm_servicios" id="fm_servicios" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <div class="">
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label" for="nombre">Nombre del servicio</label>
                                
                                    <input type="hidden" id="data_id" name="data_id" value="editar_servicio">
                                    <input type="hidden" name="id" value="'.$row[id].'">
                                    <input type="text" autocomplete="off" id="nombre" value="'.$row[nombre].'" name="nombre" class="form-control" placeholder="Digite el nombre del servicio">
                               
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Descripción</label>
                                
                                    <textarea name="descripcion" id="descripcion"  rows="2" class="form-control">'.$row[descripcion].'</textarea>
                                
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="direccion">Precio</label>
                                
                                    <input type="number" class="form-control" name="precio" value="'.$row[precio].'" id="precio">
                                
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="control-label" for="categoria">Tiempo estimado de duración</label>
                                
                                    <input type="text" name="duracion" id="duracion" value="'.$row[duracion].'" class="form-control">
                                
                            </div>
                             <div class="form-group">
                                <label class="control-label" for="email">Empleado</label>
                                
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
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="form-group">
                            
                                <center>
                                    <button type="button" id="btn_guardar" class="btn btn-mio"> Guardar</button>
                                    <button type="button" data-dismiss="modal" class="btn btn-default"> Cerrar</button>
                                </center>
                            
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