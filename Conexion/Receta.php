<?php 
@session_start();
include_once("Conexion.php");
include_once("Genericas2.php");
include_once("Opcion.php");
/**
 * 
 */
class Receta
{
	
	function __construct($arg)
	{
		
	}

	public static function traer_compuestos(){
		$sql="SELECT * FROM tb_receta WHERE estado=1 and tipo_producto=2";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$recetas=$comando->fetchAll(PDO::FETCH_ASSOC);
			return $recetas;
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function productos($id)
	{
		$sql="SELECT p.codigo_oculto,p.nombre,p.descripcion, me.nombre as medida FROM tb_producto as p INNER JOIN tb_unidad_medida as me ON me.id=p.medida WHERE p.categoria=$id";
		try {
				$comando = Conexion::getInstance()->getDb()->prepare($sql);
	       		$comando->execute();
	       		while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
	       			$resultado[]=$row;
	       		}
	       		//$resultado = $comando->fetchAll(PDO::FETCH_ASSOC);
	       		return array("1",$resultado,$sql);
				//echo json_encode(array("exito" => $exito));
			} catch (Exception $e) {
				return array("0","error",$e->getMessage(),$e->getLine(),$sql);
	            //echo json_encode(array("error" => $error));
			}
	}

	public static function editar($data){
		$resultado=Genericas2::actualizar_generica("tb_receta",$data);
		if($resultado[0]=="1"){
			return array(1,"exito",$resultado);
		}else{
			return array(-1,"error",$resultado);
		}
		
	}

	public static function guardar_ingredientes($data){
		try{
			foreach ($data[ingredientes] as $ingrediente) {
			$detalle=Array(
				'data' => 'nueva',
				'codigo_receta' => $data[receta],
				'codigo_producto' => $ingrediente[codigo],
				'cantidad' => $ingrediente[cantidad]
			);
			$detalle_new=Genericas2::insertar_generica("tb_receta_detalle",$detalle);	
		}
			return array(1,"exito");
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage());
		}
	}

	public static function guardar_receta($data){
		$codigo=date("Yidisus");
		$receta=Array(
			'data_id' => 'nueva',
			'codigo_oculto' => $codigo,
			'opcion' => $data[tipo],
			'nombre' => $data[nombre],
			'descripcion' => $data[descripcion],
			'precio' => $data[precio]
		);
		$receta_new=Genericas2::insertar_generica("tb_receta",$receta);
		if($receta_new[0]=="1"){
			return array(1,"exito",$receta_new);
		}else{
			return array(-1,"error",$receta_new);
		}
	}

	public static function busqueda($dato,$estado){
		$elestado="";
		if($estado!=''){
			$elestado="AND estado=$estado";
		}
        $sql="SELECT * FROM tb_receta WHERE nombre LIKE '%$dato%' $elestado";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                $html.='<div class="col-xs-12 col-lg-6" id="listado-card">
                <div class="widget">
                  <div class="widget-simple">
                  	<br>
                  	<div class="col-xs-2">
                  		<div class="row">
                  			<div class="col-xs-12 pull-left">
                  				<a href="javascript:void(0)" onclick="editar(\''.$row[codigo_oculto].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
                  			</div>
                  			<br><br><br>
                  			<div class="col-xs-12"><a href="javascript:void(0)" onclick="ver(\''.$row[codigo_oculto].'\')"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></div>
                  			<br><br><br>
                  			<div class="col-xs-12">
                  				<a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_receta\',\'la receta\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a>
                  			</div>
                  		</div>
                  	</div>
                  	<div class="col-xs-3">
                  		<div class="row">
                  			<div class="col-xs-12">';
                  			if($row[imagen]!=''):
                            $html.='<img class="widget-image img-circle" src="../../img/productos/'.$row[imagen].'" style="width: 100px;height: 102px;" >';
                           else: 
                            $html.='<img class="widget-image img-circle" src="../../img/imagenes_subidas/image.svg" style="width: 100px;height: 102px;" >';
                          endif;
                  			$html.='</div>
                  		</div>
                  	</div>
                  	<div class="col-xs-7">
                  		<div class="row">
                  			<div style="font-size:18px" class="col-xs-12"><b>'.$row[nombre].'</b></div>
                  			<br><br><br>
                  			<div style="font-size:18px" class="col-xs-12">Precio: $'.$row[precio].'</div>
                  			<div class="col-xs-12"><a href="ingredientes.php?receta='.$row[codigo_oculto].'" class="btn btn-mio pull-right"><i class="fa fa-cutlery"></i><a/></div>
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

    public static function modal_editar($codigo){
    	$categorias=Opcion::obtener_opciones();
    	$sql="SELECT * FROM tb_receta WHERE codigo_oculto='$codigo'";
    	try{
    		$comando=Conexion::getInstance()->getDb()->prepare($sql);
    		$comando->execute();
    		while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
    			$html.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
				      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
				      <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				          <div class="modal-header">
				            <button type="button" class="close" data-dismiss="modal">
				              <span aria-hidden="true">×</span>
				            </button>
				            <h4 class="modal-title"><b>Editar receta</b></h4>
				          </div>
				          <div class="modal-body">
				            <form action="#" method="post" name="form_receta" id="form_receta" class="form-horizontal">
					          <div class="row" id="receta" style="display: block">
					            <div class="col-xs-8 col-lg-8" style="padding-left: 30px; padding-right: 16px;">
					              <div class="row">
					                <div class="col-xs-6 col-lg-6">
					                  <div class="form-group">
					                    <label class="control-label" for="nombre">Nombre</label>
					                    <input type="hidden" name="data_id" value="editar_receta">
					                    <input type="hidden" name="codigo_oculto" value="'.$row[codigo_oculto].'">
					                    <input type="text" required autocomplete="off" id="nombre" name="nombre" class="form-control" value="'.$row[nombre].'" placeholder="Digite el nombre del nombre">
					                  </div>
					                </div>
					                <div class="col-xs-6 col-lg-6">
					                  <div class="form-group">
					                    <label class="control-label" for="">Descripción</label>
					                    <textarea name="descripcion"  id="descripcion" rows="2" class="form-control">'.$row[descripcion].'</textarea>
					                  </div>
					                </div>
					              </div>
					              <div class="row">
					                <div class="col-xs-6 col-lg-6">
					                  <div class="form-group">
					                    <label class="control-label" for="">Categoría</label>
					                    <select name="opcion" required id="opcion" class="select-chosen">';
					                      	foreach ($categorias as $categoria){
		                                    	if($categoria[codigo_oculto]==$row[opcion]){
		                                    		 $html.='<option selected value="'.$categoria[codigo_oculto].'">'.$categoria[nombre].'</option>';
		                                    	}else{
		                                    		 $html.='<option value="'.$categoria[codigo_oculto].'">'.$categoria[nombre].'</option>';
		                                    	}
	                                    	} 
					                    $html.='</select>
					                  </div>
					                </div>
					                <div class="col-xs-6 col-lg-6">
					                  <div class="form-group">
					                      <label class="control-label" for="precio">Precio</label>
					                      <input type="number" value="'.$row[precio].'" required id="precio" name="precio" class="form-control" placeholder="Precio de venta">
					                  </div>
					                </div>  
					              </div>                 
					            </div>
					            <div class="col-xs-4 col-lg-4" style="padding-left: 30px; padding-right: 16px;">
					              <div class="row">
					                <div class="col-xs-6 col-lg-6">
					                   <div class="form-group">';
					                   if($row[imagen]!=""):
					                      $html.='<img src="../../img/recetas/'.$row[imagen].'" style="width: 100px;height: 102px;" id="img_file">
					                      <input type="file" class="archivos hidden" id="file_1" name="file_1" />';
					                  else:
					                  	$html.='<img src="../../img/imagenes_subidas/image.svg" style="width: 100px;height: 102px;" id="img_file">
					                  	<input type="file" class="archivos hidden" id="file_1" name="file_1" />';
					                  endif;
					                   $html.='</div>
					                </div>
					                <div class="col-xs-6 col-lg-6 ele_div_imagen">
					                    <div class="form-group">
					                          <h5>La imagen debe de ser formato png o jpg con un peso máximo de 3 MB</h5>
					                    </div><br><br>
					                    <div class="form-group">
					                      <button type="button" class="btn btn-sm btn-mio" id="btn_subir_img"><i class="icon md-upload" aria-hidden="true"></i> Seleccione Imagen</button>
					                    </div>
					                    <div class="form-group">
					                      <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
					                      </div>
					                    </div>
					                </div>
					              </div>
					            </div>
					            <div class="col-xs-12 col-lg-12">
					              <div class="form-group">
					                <center>
					                  <button type="button" class="btn btn-mio" id="btn_guardar">Guardar</button>
					                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					                </center>
					              </div>
					            </div>
					          </div>      
					        </form>
				          </div>
				        </div>
				      </div>
				</div>';
    		}
    		return array(1,"exito",$html,$categorias);
    	}catch(Exception $e){
    		return array(-1,"error",$e->getMessage(),$sql);
    	}
    }

    public static function modal_ver($codigo){
    	$sql="SELECT r.*,o.nombre as n_categoria FROM tb_receta as r INNER JOIN tb_opcion as o ON o.codigo_oculto=r.opcion WHERE r.codigo_oculto='$codigo'";
    	$sql2="SELECT rd.cantidad,p.nombre as n_producto, me.nombre as n_medida FROM tb_receta_detalle as rd INNER JOIN tb_producto as p ON p.codigo_oculto=rd.codigo_producto INNER JOIN tb_unidad_medida as me ON me.id=p.medida WHERE rd.codigo_receta='$codigo'";
    	try{
    		$comando=Conexion::getInstance()->getDb()->prepare($sql);
    		$comando->execute();
    		$comando1=Conexion::getInstance()->getDb()->prepare($sql2);
    		$comando1->execute();
    		$ingredientes=$comando1->fetchAll(PDO::FETCH_ASSOC);
    		while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
    			$modal.='<div class="modal fade modal-side-fall" id="md_ver_receta" aria-hidden="true"
				      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
				      <div class="modal-dialog modal-lg">
				        <div class="modal-content">
				          <div class="modal-header">
				            <button type="button" class="close" data-dismiss="modal">
				              <span aria-hidden="true">×</span>
				            </button>
				            <h4 class="modal-title">Ver receta</h4>
				          </div>
				          <div class="modal-body">
				            <div class="row">
				            	<div class="col-md-6">
				            		<img src="../../img/recetas/'.$row[imagen].'" width="400" height="400">
				            	</div>
				            	<div class="col-md-6">
				            		<table class="table">
				                <tbody>
				     
				                    <tr>
				                        <th>Nombre del la receta</th>
				                        <td>'.$row[nombre].'</td>
				                    </tr>
				                    <tr>
				                        <th>Descripción</th>
				                        <td>'.$row[descripcion].'</td>
				                    </tr>
				                    <tr>
				                        <th>Precio</th>
				                        <td>$'.number_format($row[precio],2).'</td>
				                    </tr>
				                    <tr>
				                        <th>Categoría</th>
				                        <td>'.$row[n_categoria].'</td>
				                    </tr>
				                </tbody>
				            </table>';
				            if(Count($ingredientes)>0):
				            $modal.='<table class="table">
				            	<thead>
				            		<tr>
				            			<th>Ingrediente</th>
				            			<th>Cantidad</th>
				            		</tr>
				            	</thead>
				            	<tbody>';
				            	foreach ($ingredientes as $ingrediente):
				            		$modal.='<tr>
												<td>'.$ingrediente[n_producto].'</td>
												<td>'.Receta::convertir_decimal_a_fraccion($ingrediente[cantidad]).' '.$ingrediente[n_medida].'</td>
				            		</tr>';
				            	endforeach;
				            	$modal.='</tbody>
				            </table>';
				        endif;
				            	$modal.='</div>
				            </div>
				          </div>
				          <div class="modal-footer">
				            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
				          </div>
				        </div>
				      </div>
				    </div>';
    		}
    		return array(1,"exito",$modal,$ingredientes);
    	}catch(Exception $e){
    		return array(-1,"error",$e->getMessage(),$sql);
    	}
    }

    public static function get_img_anterior($id){
		$sql="SELECT imagen FROM tb_receta WHERE codigo_oculto = '$id';";
		$html="";
    	$datos=null;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		    $datos = $comando->fetchAll();
		}catch (PDOException $e) {
	        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	    return array("1",$datos,$sql);
	    exit();
	}

	public static function set_img($id,$imagen){
		$sql="UPDATE `tb_receta` SET `imagen` = '$imagen' WHERE `codigo_oculto` = '$id';";
		$html="";
    	$datos=null;
	 	$datos_modelo=array();
	 	try {
		    $comando = "";
		    $comando = Conexion::getInstance()->getDb()->prepare($sql);
		    $comando->execute();
		}catch (PDOException $e) {
	        return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
	    }
	    return array("1","exito",$sql);
	    exit();
	}

	public static function convertir_decimal_a_fraccion($decimal){

	    $big_fraction = Receta::float2rat($decimal);
	    $num_array = explode('/', $big_fraction);
	    $numerator = $num_array[0];
	    $denominator = $num_array[1];
	    $whole_number = floor( $numerator / $denominator );
	    $numerator = $numerator % $denominator;

	    if($numerator == 0){
	        return $whole_number;
	    }else if ($whole_number == 0){
	        return $numerator . '/' . $denominator;
	    }else{
	        return $whole_number . ' ' . $numerator . '/' . $denominator;
	    }
	}

	private static function float2rat($n, $tolerance = 1.e-6) {
	    $h1=1; $h2=0;
	    $k1=0; $k2=1;
	    $b = 1/$n;
	    do {
	        $b = 1/$b;
	        $a = floor($b);
	        $aux = $h1; $h1 = $a*$h1+$h2; $h2 = $aux;
	        $aux = $k1; $k1 = $a*$k1+$k2; $k2 = $aux;
	        $b = $b-$a;
	    } while (abs($n-$h1/$k1) > $n*$tolerance);

	    return "$h1/$k1";
	}
}
 ?>