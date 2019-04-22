<?php 
@session_start();
require_once("Conexion.php");
require_once("Genericas2.php");
/**
 * 
 */
class Opcion 
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function obtener_opciones(){
		$sql="SELECT * FROM tb_opcion WHERE estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return $opciones=$comando->fetchAll(PDO::FETCH_ASSOC);
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public static function guardar($data){
		$result=Genericas2::insertar_generica("tb_opcion",$data);
		if($result[0]=="1"){
			return array(1,"exito",$result);
		}else{
			return array(-1,"error",$result);
		}
	}

	public static function busqueda($dato){
        $sql="SELECT * FROM tb_opcion WHERE estado=1 AND nombre LIKE '%$dato%'";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                $html.='<div class="col-sm-6 col-lg-6" style="height:120px;" id="listado-card">
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
                                <td style="font-size: 18px;">Descripción: '.$row[descripcion].'</td>
                            </tr>
                        </tbody>
                    </table>
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