<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
/**
  * 
  */
 class Politica
 {
 	
 	function __construct()
 	{
 		# code...
 	}

 	public static function guardar($data){
 		$result=Genericas2::insertar_generica("tb_politicas",$data);
 		if($result[0]=="1"){
 			return array(1,"exito",$result);
 		}else{
 			return array(-1,"error",$result);
 		}
 	}

 	public static function busqueda(){
 		$sql="SELECT * FROM tb_politicas";
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql);
 			$comando->execute();
 			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
 				$html.='<div class="col-sm-6 col-lg-6" style="height: 175px;" id="listado-card">
		                <div class="widget">
		                  	<div class="widget-simple">
								<div class="row">
									<div class="col-xs-3">
										<a href="javascript:void(0)" onclick="editar(\''.$row[id].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
										<br><br><br>
										<a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_politicas\',\'la política\')" data-toggle="tooltip" title="Eliminar"><img width="35px" height="35px" src="../../img/iconos/eliminar.svg"></a>
									</div>
									<div style="font-size: 18px;" class="col-xs-9">
										Tipo: '.$row[tipo].'
									</div>
									<div style="font-size: 18px;" class="col-xs-9">
										Descripción: '.$row[descripcion].'
									</div>';
									if($row[tipo]=='stock'):
										$html.='<div style="font-size: 18px" class="col-xs-9">
											Stock mínimo: '.$row[minimo].'
										</div>';
									endif;
								$html.='</div>
		                  	</div>
		                </div>
		            </div>';
 			}

 			return array(1,"exito",$html);
 		}catch(Exception $e){
 			return array(-1,"error",$e->getMessage(),$sql);
 		}
 	}
 } 
?>