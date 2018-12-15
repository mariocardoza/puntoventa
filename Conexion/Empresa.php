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
                                <a href="javascript:void(0)">
                                    <img src="data:image/jpeg;base64,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" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                </a>
                                <h3>
                                    <strong>'.$row[nombre].'</strong><br><small></small>
                                </h3>
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
                                        	<a onclick="editar('.$row[id].')" href="#" class="btn btn-warning"><i class="fa fa-edit"></i></a>
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
}
 ?>