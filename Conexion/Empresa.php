<?php 
@session_start();
require_once("Conexion.php");
/**
 * 
 */
class Empresa
{
	
	function __construct($argument)
	{
		# code...
	}

    public static function datos_empresa(){
        $sql="SELECT * FROM tb_negocio";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
                $empresa=$row;
            }
            return $empresa;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

	public static function guardar($data){
		$sql="INSERT INTO tb_negocio (nombre,direccion,nit,nrc,giro,email,codigo_oculto,tipo_negocio) values('$data[nombre]','$data[direccion]','$data[nit]','$data[nrc]','$data[giro]','$data[email]','$data[codigo_oculto]',$data[tipo_empresa])";
		$count=Count($data[telefono]);


		for ($i=0;$i<$count;$i++) {
			$sql2.="INSERT INTO tb_telefono_negocio (codigo,tipo,telefono) VALUES('$data[codigo_oculto]','".$data[tipo][$i]."','".$data[telefono][$i]."');";
		}

		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();

			try{
				$comando2=Conexion::getInstance()->getDb()->prepare($sql2);
				$comando2->execute();
			return array(1,"exito",$sql);

			}catch(Exception $ex){
			return array(-1,"error2",$sql,$ex->getMessage());

			}
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

	 public static function construir_perfil($email){
          $codigo_oculto="";
          $html ="";
          $sql = "SELECT * FROM tb_negocio FIRST";
          try {
                
                $elec1 = Conexion::getInstance()->getDb()->prepare($sql);
                $elec1->execute();
                while ($row = $elec1->fetch(PDO::FETCH_ASSOC)) {

                  $html.='<div class="block">
                
                            <div class="block-title">
                                <h2><i class="gi gi-user"></i> <strong>Información del</strong> negocio</h2>
                            </div>
                            <div class="block-section text-center">
                                <a href="javascript:void(0)" onclick="cambiar_foto()">
                                    <img src="http://estudioagil.com/sys/puntoventa/img/empresa/'.$row[imagen].'" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                </a>
                                <h3>
                                    <strong>'.$row[nombre].'</strong><br><small></small>
                                </h3>
                                <input type="hidden" id="codiguito" value="'.$row[codigo_oculto].'">
                            </div>
                            <table class="table table-borderless table-striped table-vcenter">
                                <tbody>
                                    <tr>
                                        <td class="text-right"><strong>NIT</strong></td>
                                        <td>'.$row[nit].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Correo electrónico</strong></td>
                                        <td>'.$row[email].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Dirección</strong></td>
                                        <td>'.$row[direccion].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right">
                                        	<a href="registro_empresa.php" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
               
                        </div>';


                }
                return $html;
          } catch (Exception $e) {
                return array($e->getMessage(),$sql);
          }

          
        }

        public static function obtener_empleados(){
        	$sql="SELECT * FROM tb_persona WHERE estado=1";
        	try{
        		$comando = Conexion::getInstance()->getDb()->prepare($sql);
                $comando->execute();
                while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                		$html.='<tr>
                        <td>'.$row[nombre].'</td>
                        <td>'.$row[dui].'</td>
                        <td>'.$row[email].'</td>
                        <td>'.$row[telefono].'</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="page_ecom_order_view.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                    </tr>';	
                	}	

                return $html;
        	}catch(Exception $e){
        		return array("error",$e->getMessage(),$sql);
        	}

        	
            
        }

        public static function obtener_sucursales(){
            $sql="SELECT * FROM tb_sucursal";
            try{
                $comando = Conexion::getInstance()->getDb()->prepare($sql);
                $comando->execute();
                while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                        $html.='<tr>
                        <td>'.$row[nombre].'</td>
                        <td>'.$row[direccion].'</td>
                        <td>'.$row[telefono].'</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="page_ecom_order_view.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                <a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>
                            </div>
                        </td>
                    </tr>'; 
                    }   

                return $html;
            }catch(Exception $e){
                return array("error",$e->getMessage(),$sql);
            }

            
            
        }

        public static function get_img_anterior($id){
        $sql="SELECT imagen FROM tb_negocio WHERE codigo_oculto = '$id';";
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
        $sql="UPDATE `tb_negocio` SET `imagen` = '$imagen' WHERE `codigo_oculto` = '$id';";
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