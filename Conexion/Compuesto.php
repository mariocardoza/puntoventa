<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
/**
 * 
 */
class Compuesto 
{
	
	function __construct()
	{
		# code...
	}

	public static function traer_subcategorias(){
		$select="";
		$sql="SELECT * FROM tb_producto WHERE estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$select.='<option value="">Seleccione..</option>';
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$select.='<option value="'.$row[codigo_oculto].'">'.$row[nombre].' '.$row[descripcion].'</option>';
			}
			return array(1,"exito",$select);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function llenar_compuestos($codigo_receta){
		$sql="SELECT * FROM tb_compuesto where codigo_receta='$codigo_receta'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$i=0;
			$scripts.="<script> $(document).ready(function(e){";
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$scripts.="telementos=telementos+$row[limite];";
				$i++;
				$html.='<div class="panel panel-primary">
                <div class="panel-heading">
                  <h5>'.$row[nombre].'</h5><span class="pull-right">Max: '.$row[limite].'</span>
                </div>
                <div class="panel-body">
                  <div class="row">
                  	<div class="col-xs-12">
                  		<div class="row">';
                  			$sql="SELECT p.nombre as n_prod,p.codigo_oculto as cod_pro,p.descripcion as p_desc,cd.cantidad as lacanti FROM tb_compuesto_detalle as cd INNER JOIN tb_producto as p ON p.codigo_oculto=cd.codigo_producto WHERE codigo_compuesto='$row[codigo_oculto]'";
                  			try{
								$comando2=Conexion::getInstance()->getDb()->prepare($sql);
								$comando2->execute();
								while ($row2=$comando2->fetch(PDO::FETCH_ASSOC)) {
									if($row[limite]==1):
										$html.='<div class="col-xs-3">
			                  				<div class="widget">
							                  	<div class="widget-simple">
							                  		<div class="icheck-turquoise icheck-inline">
						                                <input data-canti="'.$row2[lacanti].'" type="radio" value="'.$row2[cod_pro].'" name="'.$row[codigo_oculto].'"  id="'.$row2[cod_pro].'" />
						                                <label for="'.$row2[cod_pro].'">'.$row2[n_prod].' '.$row2[p_desc].'</label>
						                            </div>
							                  	</div>
						                	</div>
			                  			</div>';

		                  			else:
		                  				$html.='<div class="col-xs-3">
			                  				<div class="widget">
							                  	<div class="widget-simple">
							                  		<div class="icheck-turquoise icheck-inline">
						                                <input data-canti="'.$row2[lacanti].'" type="checkbox" value="'.$row2[cod_pro].'" name="'.$row[codigo_oculto].'"  id="'.$row2[cod_pro].'" />
						                                <label for="'.$row2[cod_pro].'">'.$row2[n_prod].' '.$row2[p_desc].'</label>
						                            </div>
							                  	</div>
						                	</div>
			                  			</div>';
		                  			endif;
		                  			
								}
                  			}catch(Exception $e){

                  			}			
                $html.='</div>
                  	</div>
                  </div>
                </div>
              </div>';
              $scripts.="$(document).on('change','[name=$row[codigo_oculto]]',function(e){
              var elemento$row[codigo_oculto]=this;
              var max$row[codigo_oculto]=$row[limite];
              var aa$row[codigo_oculto]=0;
              
              	$('input[type=checkbox][name=$row[codigo_oculto]]').each(function(){
					if($(this).is(':checked'))
						aa$row[codigo_oculto]++;
				});
				if(aa$row[codigo_oculto]>max$row[codigo_oculto])
				{
					//alert('Has seleccionado mas checkbox que los indicados');
		 
					// Desmarcamos el ultimo elemento
					$(elemento$row[codigo_oculto]).prop('checked', false);
					aa$row[codigo_oculto]--;
				}
          	});";
			}
			$scripts.="});</script>";
			return array(1,"exito",$html,$scripts);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage(),$sql);
		}
	}

	public static function guardar_componente($data){
		$codigo=date("Yidisus");
		$array_compuesto=array(
			'data_id' => 'guarda',
			'nombre' => mb_strtoupper($data[nombre], 'UTF-8'),
			'descripcion' => $data[descripcion],
			'codigo_receta' => '20195823584400000044',
			'codigo_oculto' => $codigo,
			'limite' => $data[limite]
		);

		$result=Genericas2::insertar_generica("tb_compuesto",$array_compuesto);

		if($result[0]=="1"){
			foreach ($data[lasopciones] as $opcion) {
				$detalle_compuesto=array(
					'data_id'=>'nueva',
					'codigo_compuesto' => $codigo,
					'codigo_producto' => $opcion,
					'cantidad' => 1
				);
				$result2=Genericas2::insertar_generica("tb_compuesto_detalle",$detalle_compuesto);
			}
		}
		if($result[0]=="1" && $result2[0]=="1"){
			return array(1,"exito",$result,$result2);
		}else{
			return array(-1,"error",$result,$result2);
		}
	}
}

?>