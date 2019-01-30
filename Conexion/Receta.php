<?php 
@session_start();
include_once("Conexion.php");
include_once("Genericas2.php");
/**
 * 
 */
class Receta
{
	
	function __construct($arg)
	{
		
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
			'categoria' => $data[tipo],
			'nombre' => $data[nombre],
			'descripcion' => $data[descripcion],
			'precio' => $data[precio]
		);
		try{
			$receta_new=Genericas2::insertar_generica("tb_receta",$receta);
			/*if($receta_new[0]==1){
				foreach ($data[productos] as $producto) {
					$detalle=Array(
						'data' => 'nueva',
						'codigo_receta' => $codigo,
						'codigo_producto' => $producto[codigo],
						'cantidad' => $producto[cantidad]
					);

					$detalle_new=Genericas2::insertar_generica("tb_receta_detalle",$detalle);
				}
			}*/
			return array(1,"exito",$receta_new);
		}catch(Exception $e){
			return array(-1,"error",$e->getMessage());
		}
		
	}

	public static function busqueda($dato){
        $sql="SELECT * FROM tb_receta WHERE nombre LIKE '%$dato%'";
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
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_receta\',\'la receta\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>
                                <td style="font-size:18px">Precio: $'.$row[precio].'</td>
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
}
 ?>