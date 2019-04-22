<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");

/**
 * 
 */
class Paquete
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function guardar($data){
		$codigo=date("Yidisus");
		$array_guardar=array(
			'data'=>'nuevo',
			'nombre' => $data[nombre],
			'descripcion' => $data[descripcion],
			'precio' => $data[precio],
			'codigo_oculto' => $codigo
		);
		$retorno=Genericas2::insertar_generica("tb_paquete",$array_guardar);
		if($retorno[0]=="1"){
			return array(1,"exito",$retorno);
		}else{
			return array(-1,"error",$retorno);
		}
	}

	public static function busqueda($esto){
		$sql="SELECT * FROM tb_paquete WHERE estado=1 AND nombre LIKE '%$esto%'";
		try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                $html.='<div class="col-sm-6 col-lg-6" style="height:230px;" id="listado-card">
                <div class="widget">
                  <div class="widget-simple">
                  	<div class="row">
                  		<div class="col-xs-3">
                  			<a href="javascript:void(0)" onclick="editar(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
                  			<br><br>
                  			<a onclick="verpaquete(\''.$row[codigo_oculto].'\')" href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
                  			<br><br>
                        <a href="javascript:void(0)" id="agregar_productos" data-nombre="'.$row[nombre].'" data-codigo="'.$row[codigo_oculto].'"><img src="../../img/iconos/mas.svg" width="35px" height="35px"></a>
                        <br><br>';
                  			if($row[estado]==1):
                                $html.='<a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_paquete\',\'el paquete\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a>';
                            else:
                                $html.='<a class="btn btn-mio" href="javascript:void(0)" onclick="daralta(\''.$row[id].'\',\'tb_paquete\',\'el paquete\')" data-toggle="tooltip" style="width:35px; height:35px;" title="Habilitar"><i class="fa fa-level-up"></i></a>';
                            endif;
                  		$html.='</div>
                  		<div class="col-xs-9">
                  			<div class="row">
                  				<div class="col-xs-12" style="font-size: 18px;"><b>'.$row[nombre].'</b></div>
                          <br><br>
               					<div class="col-xs-12" style="font-size: 18px;">Descripción: '.$row[descripcion].'</div>
                        <br><br><br>
               					<div class="col-xs-12" style="font-size: 18px;">Precio: $'.$row[precio].'</div>
                  			</div>
                  		</div>
                  	</div>
                  </div>
              </div>
            </div>';
            }
            return array(1,"exito",$html);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage(),$sql);
        }
	}

  public static function cargar_productos($codigo){
    $sql="SELECT p.* FROM tb_producto AS p WHERE codigo_oculto NOT IN (SELECT pd.codigo_producto FROM tb_paquete_detalle AS pd WHERE pd.codigo_paquete = '$codigo')";
    $sql2="SELECT p.* FROM tb_producto AS p WHERE codigo_oculto IN (SELECT pd.codigo_producto FROM tb_paquete_detalle AS pd WHERE pd.codigo_paquete = '$codigo')";
    $select.='<option value="">Seleccione...<option>';
    try{
      $comando=Conexion::getInstance()->getDb()->prepare($sql);
      $comando2=Conexion::getInstance()->getDb()->prepare($sql2);
      $comando->execute();
      $comando2->execute();
      while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
        $select.='<option value="'.$row[codigo_oculto].'">'.$row[nombre].' '.$row[descripcion].'</option>';
      }
      while ($row2=$comando2->fetch(PDO::FETCH_ASSOC)) {
        $tbody.='<tr>
                  <td>'.$row2[nombre].' '.$row2[descripcion].'</td>
                  <td><a href="javascript:void(0)" id="quita_base" data-paquete="'.$codigo.'" data-codigo="'.$row2[codigo_oculto].'"><img src="../../img/iconos/eliminar.svg" height="22px" width="22px" alt=""/></a></td>
                </tr>';
      }
      return array(1,"exito",$select,$tbody);
    }catch(Exception $e){
      return array(-1,"error",$e->getMessage(),$sql);
    }
  }

  public static function guardarle_productos($data){
      $array=array(
        'data_id'=>'guardar',
        'codigo_paquete' => $data[paquete],
        'codigo_producto' => $data[codigo],
        'cantidad' => 1
      );
      $result=Genericas2::insertar_generica("tb_paquete_detalle",$array);
    
    if($result[0] == 1){
      return array(1,"exito",$result);
    }else{
      return array(-1,"error",$result);
    }
  }

  public static function modal_ver($codigo){
    $sql="SELECT * FROM tb_paquete WHERE codigo_oculto='$codigo'";
    $sql2="SELECT p.nombre as n_producto,pd.cantidad as cantidad FROM tb_paquete_detalle as pd INNER JOIN tb_producto as p ON p.codigo_oculto=pd.codigo_producto WHERE pd.codigo_paquete='$codigo'";
    try{
      $comando=Conexion::getInstance()->getDb()->prepare($sql);
      $comando2=Conexion::getInstance()->getDb()->prepare($sql2);
      $comando->execute();
      $comando2->execute();
      $detalles=$comando2->fetchAll(PDO::FETCH_ASSOC);
      while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
        $modal.='<div class="modal fade modal-side-fall" id="md_ver" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">×</span>
                      </button>
                      <h4 class="modal-title"><b>Ver información del paquete</b></h4>
                  </div>
                  <div class="modal-body">
                      <table class="table">
                        <tr>
                          <th>Nombre</th>
                          <td>'.$row[nombre].'</td>
                        </tr>
                        <tr>
                          <th>Descripción</th>
                          <td>'.$row[descripcion].'</td>
                        </tr>
                        <tr>
                          <th>Precio</th>
                          <td>$'.$row[precio].'</td>
                        </tr>
                      </table>';
                      if($detalles):
                      $count=0;
                        $modal.='<table class="table">
                            <thead>
                              <tr>
                                <th>N°</th>
                                <th>Nombre</th>
                                <th>Cantidad</th>
                              </tr>
                            </thead>
                            <tbody>';
                        foreach($detalles as $detalle):
                          $count++;
                          $modal.='<tr>
                            <td>'.$count.'</td>
                            <td>'.$detalle[n_producto].'</td>
                            <td>'.$detalle[cantidad].'</td>
                          </tr>';
                        endforeach;
                        $modal.='</tbody>
                          </table>';
                      endif;
                  $modal.='</div>
                  <div class="modal-footer">
                    <div class="form-group">
                      <center>
                        <button class="btn btn-default" type="button" data-dismiss="modal">Cerrar</button>
                      </center>
                    </div>
                  </div>
                </div>
            </div>
        </div>';
      }
      return array(1,"exito",$modal);
    }catch(Exception $e){
      return array(-1,"error",$e->getMessage(),$sql);
    }
  }

  public static function eliminar_item($codigo,$paquete){
    $array_eliminar=array(
      'table' => 'tb_paquete_detalle',
      'codigo_producto' => $codigo,
      'codigo_paquete' => $paquete
    );

    $result=Genericas2::eliminar_generica($array_eliminar);

    return array(1,"exito",$result);
  }

  public static function modal_editar($codigo){
    $sql="SELECT * FROM tb_paquete WHERE codigo_oculto='$codigo'";
    try{
      $comando=Conexion::getInstance()->getDb()->prepare($sql);
      $comando->execute();
      while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
        $modal.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                          <span aria-hidden="true">×</span>
                        </button>
                        <h4 class="modal-title"><b>Editar paquete</b></h4>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post" name="fm_paquete" id="fm_paquete" class="form-horizontal">
                            <div class="form-group">
                                <label class="control-label" for="nombre">Nombre</label>
                                <input type="hidden" name="data_id" value="editar_paquete">
                                <input type="hidden" name="codigo_oculto" value="'.$row[codigo_oculto].'">
                                <input autocomplete="off" type="text" id="nombre" name="nombre" value="'.$row[nombre].'" class="form-control" placeholder="Digite el nombre del paquete">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="nombre">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control" rows="2" placeholder="Digite una descripción">'.$row[descripcion].'</textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label">Precio</label>
                                <input type="number" value="'.$row[precio].'" name="precio" id="precio" class="form-control">
                            </div>
                            <div class="form-group">
                                <center>
                                    <button type="button" id="btn_editar" class="btn btn-mio">Guardar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>  
                                </center>
                            </div>
                        </form>
                </div>
                </div>
            </div>
        </div>';
      }
      return array(1,"exito",$modal);
    }catch(Exception $e){
      return array(-1,"error",$e->getMessage(),$sql);
    }
  }

  public static function editar($data){
    $array_editar=array(
      'data_id'=>'editar',
      'codigo_oculto' => $data[codigo_oculto],
      'nombre' => $data[nombre],
      'descripcion' => $data[descripcion],
      'precio' => $data[precio]
    );
    $resultado=Genericas2::actualizar_generica("tb_paquete",$array_editar);
    if($resultado[0]=="1"){
      return array(1,"exito",$resultado);
    }else{
      return array(-1,"error",$resultado);
    }
  }
}
?>