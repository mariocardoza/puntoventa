<?php
@session_start(); 
require_once("Conexion.php");
/**
 * 
 */
class Cliente
{
	
	function __construct($argument)
	{
		# code...
	}

	public static function guardar($data){
		if($data['fecha_nacimiento']!=''){
			$var=explode('/',$data['fecha_nacimiento']);
			$fecha=$var[2]."-".$var[1]."-".$var[0];
		}else{
			$fecha=date("Y-m-d");
		}
		if(isset($data['tipocliente']))$tipo=2;
		else $tipo=1;
		$codigo_oculto=date("Yidisus");
		$sql="INSERT INTO `tb_cliente`(`nombre`, `dui`, `direccion`, `telefono`, `email`, `fecha_nacimiento`, `nit`, `nrc`, `razon_social`, `giro`, `retiene`, `tipo`, `codigo_oculto`,`nombre_r`, `telefono_r`, `direccion_r`,`tipocontribuyente`) VALUES ('$data[nombre]','$data[dui]','$data[direccion]','$data[telefono]','$data[email]','$fecha','$data[nit]','$data[nrc]','$data[razon_social]','$data[giro]',$data[retiene],$tipo,'$codigo_oculto','$data[nombre_r]','$data[telefono_r]','$data[direccion_r]','$data[tipocontribuyente]')";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

	public static function busqueda($dato,$tipo){
		$el_tipo='';
		if($tipo!=0){
			$el_tipo="AND c.tipo=$tipo";
		}
		$sql="SELECT * FROM tb_cliente as c WHERE c.estado=1 AND c.nombre LIKE '%$dato%' $el_tipo";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$html.='<div class="col-sm-6 col-lg-6" style="height: 175px;" id="listado-card">
                <div class="">
                  <div class="">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="editar(\''.$row[id].'\',\''.$row[tipo].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
                                </td>
                                <td style="font-size:18px"><b>'.$row[nombre].'</b></td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0px;"><a href="perfil.php?cliente='.$row[codigo_oculto].'" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td>
                                <td style="font-size:18px">Teléfono: '.$row[telefono].'</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$row[id].'\',\'tb_cliente\',\'el cliente\')" data-toggle="tooltip" title="Eliminar"><img width="35px" height="35px" src="../../img/iconos/eliminar.svg"></a></td>
                                <td style="font-size:18px">Dirección: '.$row[direccion].'</td>
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

	public static function construir_perfil($id){
          $codigo_oculto="";
          $html ="";
          $sql = "SELECT * FROM tb_cliente WHERE codigo_oculto='$id'";
          try {
                
                $elec1 = Conexion::getInstance()->getDb()->prepare($sql);
                $elec1->execute();
                while ($row = $elec1->fetch(PDO::FETCH_ASSOC)) {

                  $html.='<div class="block">
                
                            <div class="block-title">
                                <h2><i class="gi gi-user"></i> <strong>Información del</strong> cliente</h2>
                            </div>
                            <div class="block-section text-center">
                                <!--a href="javascript:void(0)" onclick="cambiar_foto()">
                                    <img src="http://estudioagil.com/sys/puntoventa/img/empresa/'.$row[imagen].'" style="width: 128px;height: 128px;" alt="avatar" class="img-circle">
                                </a-->
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
                                        <td class="text-right"><strong>DUI</strong></td>
                                        <td>'.$row[dui].'</td>
                                    </tr>
                                    <tr>
                                        <td class="text-right"><strong>Teléfono</strong></td>
                                        <td>'.$row[telefono].'</td>
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

    

    public static function obtener_compras($codigo_oculto){
        	$sql="SELECT
                v.tipo AS tipo_factura,
                v.tipo_venta AS tipo_venta,
                v.total AS total,
                c.nombre AS cliente,
                per.nombre AS empleado,
                v.codigo_oculto as codigo_venta,
                CASE
            WHEN v.tipo = 1 THEN
                'Crédito fiscal'
            WHEN v.tipo= 2 THEN
                'Consumidor final'
            ELSE
                'Ticket'
            END AS lafactura,
            CASE
            WHEN v.tipo_venta = 1 THEN
                'Efectivo'
            WHEN v.tipo_venta= 2 THEN
                'Crédito'
            ELSE
                'Tarjeta (crédito o débito)'
            END AS laventa
            FROM
                `tb_venta` AS v
            INNER JOIN tb_persona AS per ON per.email = v.empleado
            LEFT JOIN tb_cliente AS c ON c.codigo_oculto = v.cliente
            WHERE v.cliente='$codigo_oculto'";
        	try{
        		$comando = Conexion::getInstance()->getDb()->prepare($sql);
                $comando->execute();
                while ($row = $comando->fetch(PDO::FETCH_ASSOC)) {
                		$html.='<tr>
                        <td>'.$row[empleado].'</td>
                        <td>$'.$row[total].'</td>
                        <td>'.$row[lafactura].'</td>
                        <td>'.$row[laventa].'</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-xs">
                                <a href="javascript:void(0)" onclick="ver(\''.$row[codigo_venta].'\')" data-original-title="Ver"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
                            </div>
                        </td>
                    </tr>';	
                	}	

                return $html;
        	}catch(Exception $e){
        		return array("error",$e->getMessage(),$sql);
        	}

        	
            
        }

	public static function obtener_naturales(){
		$sql="SELECT c.*,CASE WHEN c.tipo=1 THEN 'Persona Natural' else '' end as eltipo FROM tb_cliente as c WHERE c.tipo=1 AND c.estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array(1,$datos,$sql);
            exit();
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
	}

	public static function obtener_juridicos(){
		$sql="SELECT c.*,CASE WHEN c.tipo=2 THEN 'Persona Jurídica' else '' end as eltipo,case WHEN c.tipocontribuyente=1 THEN 'Pequeño contribuyente' WHEN c.tipocontribuyente=2 THEN 'Mediano contribuyente' ELSE 'Gran contribuyente' end as contri FROM tb_cliente as c WHERE c.tipo=2 AND c.estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array(1,$datos,$sql);
            exit();
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
			exit();
		}

	}

	public static function obtener_todos(){
		$sql="SELECT * FROM tb_cliente WHERE estado=1";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array(1,$datos,$sql);
            exit();
		}catch(Exception $e){
			return array(-1,$e->getMessage(),$e->getLine(),$sql);
			exit();
		}

	}

	public static function val_email($email){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.email = '$email';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}

	public static function val_tel($telefono){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.telefono = '$telefono';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	public static function val_nrc($nrc){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.nrc = '$nrc';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	public static function val_dui($dui){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.dui = '$dui';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}
	public static function val_nit($nit){
		$sql="SELECT * FROM tb_cliente AS c WHERE c.nit = '$nit';"; 
	    	$html="";
	    	$datos=null;
	    	$bandera=false;
		 	$datos_modelo=array();
		 	try {
			    $comando = "";
			    $comando = Conexion::getInstance()->getDb()->prepare($sql);
			    $comando->execute();
			    $datos = $comando->fetchAll();
			    foreach ($datos as $lista) {
			    	$bandera=true;
			    }
			}catch (PDOException $e) {
		        return array("-1",$bandera,$e->getMessage(),$e->getLine(),$sql);
				exit();
		    }
		    return array("1",$bandera,$datos,$sql);
		    exit();
	}

	public static function editar($data){
		$sql="UPDATE `tb_cliente` SET `nombre`='$data[nombre]',`dui`='$data[dui]',`direccion`='$data[direccion]',`telefono`='$data[telefono]',`email`='$data[email]',`fecha_nacimiento`='$data[fecha_nacimiento]',`nit`='$data[nit]',`nrc`='$data[nrc]',`razon_social`='$data[razon_social]',`giro`='$data[giro]',`retiene`=$data[retiene],`nombre_r`='$data[nombre_r]',`telefono_r`='$data[telefono_r]',`direccion_r`='$data[direccion_r]' WHERE id=$data[id]";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}

		
	}

	public static function eliminar($id){
		$sql="UPDATE `tb_cliente` SET `estado`=2 WHERE id=$id";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			return array(1,"exito",$sql);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}

		
	}

	public static function modal_natural($id){
		$sql="SELECT * FROM tb_cliente WHERE id='$id'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$cliente=$row;
			}
			$modal='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"><b>Editar cliente</b></h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="fm_cliente" id="fm_cliente" class="form-horizontal">
            <div class="row">
		        <div class="col-lg-12">
		            <div class="">
		                <div class="row">
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="control-label" for="nombre">Nombre</label>
			                
			                    <input type="hidden" id="data_id" name="data_id" value="editar_cliente">
			                    <input type="hidden" name="id" value="'.$cliente[id].'">
			                    <input type="hidden" name="retiene" value="0">
			                    <input required value="'.$cliente[nombre].'" type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
			                
			            </div>
			            
			            <div class="form-group" id="fdui">
			                <label class="control-label" for="departamento">DUI</label>
			                
			                    <input type="text" value="'.$cliente[dui].'" name="dui"id="dui" class="form-control dui">
			               
			            </div>
			            <div class="form-group">
			                <label class="control-label" for="categoria">NIT</label>
			                
			                    <input type="text" value="'.$cliente[nit].'" name="nit" id="nit" class="form-control nit">
			                
			            </div>
			            <div class="form-group">
			                <label class="control-label" for="direccion">Dirección</label>
			                
			                    <textarea required id="direccion" name="direccion" class="form-control" rows="3">'.$cliente[direccion].'</textarea>
			                
			            </div>
			        </div>
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="control-label" for="telefono">Número de teléfono</label>
			                
			                    <input type="text" name="telefono" id="telefono" value="'.$cliente[telefono].'" class="form-control telefono">
			                
			            </div>

			            <div class="form-group">
			                <label class="control-label" for="email">Email</label>
			                
			                    
			                        <input type="email" id="email" name="email" value="'.$cliente[email].'"class="form-control" >
			                    
			                
			            </div>

			            <div class="form-group" id="nacimiento">
			                <label for="" class="control-label">Fecha de nacimiento</label>
			                
			                    <input type="text" class="form-control nacimiento" value="'.$cliente[fecha_nacimiento].'" name="fecha_nacimiento" id="fecha_nacimiento">
			                
			            </div>
			        </div>
		        </div>
        	</div>
       
        	<div class="col-lg-12">
            <div class="">
                <div class="form-group">
                	
                    <center>
                        <button type="button" id="btn_editar" class="btn btn-mio"> Guardar</button>
                    <button type="button" class="btn btn-defaul" data-dismiss="modal"> Cerrar</button>  
                    </center>
                	
            	</div>
            </div>
        	</div>
    		</form>          
		</div>
        </div>
      </div>
    </div>';

            return array("1",$cliente,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}

	public static function modal_juridico($id){
		$sql="SELECT * FROM tb_cliente WHERE id='$id'";
		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$cliente=$row;
			}
			$modal='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar cliente</h4>
          </div>
          <div class="modal-body">
            <form action="#" method="post" name="fm_cliente" id="fm_cliente" class="form-horizontal">
            <div class="row">
		        <div class="col-lg-12">
		            <div class="">
		                
		                <div class="row">
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="control-label" for="nombre">Nombre</label>
			                
			                    <input type="hidden" id="data_id" name="data_id" value="editar_cliente">
			                    <input type="hidden" name="id" id="id" value="'.$cliente[id].'">
			                    <input required value="'.$cliente[nombre].'" type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
			                
			            </div>
			            <div class="form-group">
			                <label class="control-label" for="direccion">Dirección</label>
			                
			                    <textarea required id="direccion" name="direccion" class="form-control" rows="3">'.$cliente[direccion].'</textarea>
			                
			            </div>
			            <div class="form-group">
			                <label class="control-label" for="categoria">NIT</label>
			                
			                    <input type="text" value="'.$cliente[nit].'" name="nit" id="nit" class="form-control nit">
			                
			            </div>
			        </div>
			        <div class="col-lg-6">
			            <div class="form-group">
			                <label class="control-label" for="telefono">Número de teléfono</label>
			                
			                    <input type="text" name="telefono" id="telefono" value="'.$cliente[telefono].'" class="form-control telefono">
			                
			            </div>

			            <div class="form-group">
			                <label class="control-label" for="email">Email</label>
			                
			                        <input type="email" id="email" name="email" value="'.$cliente[email].'"class="form-control" >
			                  
			            </div>
			        </div>
		        </div>
        	</div>

        	 <div class="col-lg-12">
            <div class="">
                
                <div class="row">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="control-label">Número de registro</label>
                        
                            <input type="text" value="'.$cliente[nrc].'" name="nrc" id="nrc" class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Giro</label>
                        
                            <input type="text" name="giro" id="giro" value="'.$cliente[giro].'"class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Razón social</label>
                        
                            <input type="text" value="'.$cliente[razon_social].'"id="razon_social" name="razon_social" class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Tipo contribuyente</label>
                        
                            <select name="tipocontribuyente" id="tipocontribuyente" style="width:auto;" class="select-chosen">
                                <option value="">Seleccione...</option>
                                <option value="1">Pequeño</option>
                                <option value="2">Mediano</option>
                                <option value="3">Grande</option>
                            </select>
                        
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="" class="control-label">Nombre del representante legal</label>
                        
                            <input type="text" id="nombre_r" value="'.$cliente[nombre_r].'" name="nombre_r" class="form-control">
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Teléfono del representante legal</label>
                        
                            <input type="text" id="telefono_r" value="'.$cliente[telefono_r].'"name="telefono_r" class="form-control telefono">
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Dirección del representante legal</label>
                        
                            <textarea name="direccion_r" id="direccion_r" rows="2" class="form-control">'.$cliente[direccion_r].'</textarea>
                        
                    </div>
                    <div class="form-group">
                        <label for="" class="control-label">Retiene 1%</label>
                        
                            <input type="radio" checked name="retiene" value="0">No
                            <input type="radio" name="retiene" value="1">Si
                        
                    </div>
                </div>
            </div>
            </div>
        </div>
       
        	<div class="col-lg-12">
            <div class="">
                <div class="form-group">
                	
                    <center>
                        <button type="button" id="btn_editar" class="btn btn-mio">Guardar</button>
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

            return array("1",$cliente,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
}
?>