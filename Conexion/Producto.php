<?php 
include_once('Conexion.php');
include_once('Genericas2.php');
include_once('Proveedor.php');
include_once('Departamento.php');
include_once('Categoria.php');
include_once('Subcategoria.php');
 class Producto
 {
 	
 	function __construct($argument)
 	{
 		# code...
 	}

 	public static function obtener_productos(){
 		$sql = "SELECT
 			p.id,
			p.nombre,
			p.descripcion,
			p.sku,
			p.codigo_barra,
			p.cantidad,
			p.imagen,
			CASE
				WHEN p.fecha_vencimiento='' THEN 'Producto no perecedero'
				ELSE DATE_FORMAT(p.fecha_vencimiento,'%d/%m/%Y') 
			END AS vencimiento,
			p.precio_unitario,
			d.nombre AS departamento,
			c.nombre AS categoria,
			s.nombre AS sub,
			p.ganancia,
            p.codigo_oculto,
			(((p.ganancia/100)*p.precio_unitario)+p.precio_unitario) as precio_venta
		FROM
			tb_producto AS p
		INNER JOIN tb_departamento AS d ON d.id = p.departamento
		INNER JOIN tb_categoria AS c ON c.id = p.categoria
		INNER JOIN tb_subcategoria AS s ON s.id = p.subcategoria
		WHERE
			p.estado = 1
		ORDER BY
			p.nombre ASC";
		try {
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            $datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array("1",$datos,$sql);
		} catch (Exception $e) {
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
 	}

    public static function busqueda($dato,$departamento){
        $segun_depar="";
        if($departamento!=0){
            $segun_depar="AND p.departamento=$departamento";
        }
        $sql="SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.sku,
            p.codigo_barra,
            p.cantidad,
            p.imagen,
            CASE
        WHEN p.fecha_vencimiento = '' THEN
            'Producto no perecedero'
        ELSE
            DATE_FORMAT(
                p.fecha_vencimiento,
                '%d/%m/%Y'
            )
        END AS vencimiento,
         p.precio_unitario,
         d.nombre AS departamento,
         p.ganancia,
         p.codigo_oculto,
         (
            (
                (p.ganancia / 100) * p.precio_unitario
            ) + p.precio_unitario
        ) AS precio_venta
        FROM
            tb_producto AS p
        INNER JOIN tb_departamento AS d ON p.departamento = d.id
        WHERE
            p.nombre LIKE '%$dato%'
        
        $segun_depar
        AND p.estado=1";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
                $productos[]=$row;
            }
         foreach($productos as $producto) { 
            $modal.='<div class="col-sm-6 col-lg-6" style="border:solid 0.50px;">
                <div class="widget">
                  <div class="widget-simple">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="editar(\''.$producto[id].'\')" data-toggle="tooltip" title="Editar" class="btn btn-mio"><i class="fa fa-pencil"></i></a></td>
                                <td width="15%" rowspan="3"><center><img src="../../img/productos/'.$producto[imagen].'" id="cambiar_imagen" data-codigo="'.$producto[codigo_oculto].'" alt="avatar" class="widget-image img-circle"></center></td>
                                <td>'.$producto[nombre].'</td>
                            </tr>
                            <tr>
                                <td><a class="btn btn-mio" id="asignar_mas" data-id="'.$producto[id].'" data-nombre="'.$producto[nombre].'" href="javascript:void(0)"><i class="fa fa-plus"></i></a></td>
                                <td>En inventario: <b>'.$producto[cantidad].'</b></td>
                                
                            </tr>
                            <tr>
                                <td width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$producto[id].'\',\'tb_producto\',\'el producto\')" data-toggle="tooltip" title="Eliminar" class="btn btn-mio"><i class="fa fa-trash"></i></a></td>
                                <td>Precio $'.number_format($producto[precio_unitario],2).'</td>
                            </tr>
                        </tbody>
                    </table>
                  </div>
              </div>
            </div>';
         } 
            return array(1,"exito",$modal,$productos,$sql);
        }catch(Exception $e){
            return array(-1,"error",$e->getMessage(),$sql);
        }

        
    }

 	//obtener inventario
 	public static function obtener_inventario($id){
 		$sql = "SELECT
			p.nombre,
			 p.descripcion,
			 p.sku,
			i.tipo,
			i.cantidad,
			i.fecha,
			i.precio_unitario,
			p.precio_unitario as precio
			FROM
				tb_inventario AS i
			INNER JOIN tb_producto AS p ON i.producto = p.id
			WHERE
				p.estado = 1
			AND p.id=$id
			ORDER BY
				p.nombre ASC";
		try {
			$comando = Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            $datos = $comando->fetchAll(PDO::FETCH_ASSOC);
            return array("1",$datos,$sql);
		} catch (Exception $e) {
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
 	}

 	public static function guardar($data){
 		$oculto=date("Yidisus");
 		$codigo_barra = "0 ".date("Yidisus");
 		$sku = date("Yidisus").rand(1,100);
 		$last_insert = "";
 		if($data['fecha_vencimiento']==''){
 			$sql="INSERT INTO `tb_producto`(`nombre`, `departamento`, `categoria`, `subcategoria`, `descripcion`, `precio_unitario`, `cantidad`, `proveedor`, `sku`, `codigo_barra`, `ganancia`, `codigo_oculto`) VALUES ('$data[nombre]','$data[departamento]','$data[categoria]','$data[subcategoria]','$data[descripcion]','$data[precio]','$data[cantidad]','$data[proveedor]','$sku','$codigo_barra',0.4,'$oculto',$data[ganancia])";
 		}else{
 			$sql="INSERT INTO `tb_producto`(`nombre`, `departamento`, `categoria`, `subcategoria`, `descripcion`, `precio_unitario`, `cantidad`, `fecha_vencimiento`, `proveedor`, `sku`, `codigo_barra`, `porcentaje_ganancia`, `codigo_oculto`,lote,ganancia) VALUES ('$data[nombre]','$data[departamento]','$data[categoria]','$data[subcategoria]','$data[descripcion]','$data[precio]','$data[cantidad]','$data[fecha_vencimiento]','$data[proveedor]','$sku','$codigo_barra',0.4,'$oculto','$data[lote]',$data[ganancia])";
 		}
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql);
 			$comando->execute();
 			if($comando){
 				for($i=0;$i<$data['cantidad'];$i++){
 					$correlativo=Genericas2::retornar_correlativo("tb_producto_detalle",$oculto);
 					$sql2="INSERT INTO tb_producto_detalle (codigo,correlativo,lote) VALUES('$oculto','$correlativo',$data[lote])";

 					$comando3=Conexion::getInstance()->getDb()->prepare($sql2);
 					$comando3->execute();

 				}


 			}
 			return array("1",$oculto,$sql,$sql2);
 		}catch(Exception $e){
 			return array("-1","error",$e->getMessage(),$sql);
 		}
 	}

 	//actualizar inventario
 	public static function actualizar_inventario($producto,$cantidad,$precio){
 		$sql_producto="SELECT p.cantidad,p.precio_unitario,p.codigo_oculto FROM tb_producto as p WHERE p.id=$producto";
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql_producto);
 			$comando->execute();
 			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
 				$cantidad_base=$row['cantidad'];
 				$precio_base=$row['precio_unitario'];
 				$oculto=$row['codigo_oculto'];
 				$lote=$row['lote'];
 			}
 			$canti_aux=$cantidad_base+$cantidad;
 			$precio_aux=($precio_base+$precio)/2;
 			$sql_update="UPDATE tb_producto SET cantidad=$canti_aux, precio_unitario=$precio_aux WHERE id=$producto";
 			$comando_update=Conexion::getInstance()->getDb()->prepare($sql_update);
 			if($comando_update->execute()){
 				for($i=0;$i<$cantidad;$i++){
 					$correlativo=Genericas2::retornar_correlativo("tb_producto_detalle",$oculto);
 					$sql2="INSERT INTO tb_producto_detalle (codigo,correlativo,lote) VALUES('$oculto','$correlativo','$lote')";

 					$comando3=Conexion::getInstance()->getDb()->prepare($sql2);
 					$comando3->execute();

 				}
 			}

 	
 			return array("1",$sql_producto,$sql_update);
 		}catch(Exception $e){
 			return array("-1","error",$e->getMessage(),$sql_producto,$e->getLine());
 		}
 	}

 	public static function get_img_anterior($id){
		$sql="SELECT imagen FROM tb_producto WHERE codigo_oculto = '$id';";
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
		$sql="UPDATE `tb_producto` SET `imagen` = '$imagen' WHERE `codigo_oculto` = '$id';";
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

	public static function modal_ver($id){
		$sql="SELECT
 			p.id,
			p.nombre,
			p.descripcion,
			p.sku,
			p.codigo_barra,
			p.cantidad,
			p.imagen,
			p.precio_unitario,
			d.nombre AS departamento,
			c.nombre AS categoria,
			s.nombre AS sub
		FROM
			tb_producto AS p
		INNER JOIN tb_departamento AS d ON d.id = p.departamento
		INNER JOIN tb_categoria AS c ON c.id = p.categoria
		INNER JOIN tb_subcategoria AS s ON s.id = p.subcategoria
		WHERE
			p.estado = 1
		AND p.id=$id
		ORDER BY
			p.nombre ASC";
			try {
		$comando = Conexion::getInstance()->getDb()->prepare($sql);
        $comando->execute();
        $producto="";
        //$datos = $comando->fetchAll(PDO::FETCH_ASSOC);
        while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
        	$producto=$row;
        }

        $modal='<div class="modal fade modal-side-fall" id="md_ver_producto" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="row">
            	<div class="col-md-6">
            		<img src="../../img/productos/'.$producto[imagen].'" width="400" height="400">
            	</div>
            	<div class="col-md-6">
            		<table class="table">
                <tbody>
                    <tr>
                        <th>SKU</th>
                        <td>'.$producto[sku].'</td>
                    </tr>
                    <tr>
                        <th>Nombre del producto</th>
                        <td>'.$producto[nombre].'</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>'.$producto[descripcion].'</td>
                    </tr>
                    <tr>
                        <th>Precio</th>
                        <td>$'.number_format($producto[precio_unitario],2).'</td>
                    </tr>
                    <tr>
                        <th>Cantidad disponible</th>
                        <td>'.$producto[cantidad].'</td>
                    </tr>
                    <tr>
                        <th>Departamento</th>
                        <td>'.$producto[departamento].'</td>
                    </tr>
                    <tr>
                        <th>Categoría</th>
                        <td>'.$producto[categoria].'</td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>'.$producto[subcategoria].'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><img src="../../lib/Barcode/barcode.php?text='.$producto[codigo_barra].'&print=true" width="300" height="70"></td>
                    </tr>
                </tbody>
            </table>
            	</div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>';

            return array("1",$producto,$sql,$modal);
		} catch (Exception $e) {
			return array("-1",$e->getMessage(),$e->getLine(),$sql);
			exit();
		}
	}

	public function modal_editar($id){
		$proveedores=Proveedor::obtener_proveedores();
		$categorias=Categoria::obtener_categorias();
		$departamentos=Departamento::obtener_departamentos();
		$subcategorias=Subcategoria::obtener_subcategorias();
		$sql="SELECT
 			p.id,
			p.nombre,
			p.descripcion,
			p.sku,
			p.codigo_barra,
			p.cantidad,
			p.imagen,
			p.precio_unitario,
			p.ganancia,
			p.fecha_vencimiento,
			p.lote,
			d.id AS departamento,
			c.id AS categoria,
			s.id AS subcategoria,
			prov.id as proveedor
		FROM
			tb_producto AS p
		INNER JOIN tb_departamento AS d ON d.id = p.departamento
		INNER JOIN tb_proveedor as prov ON prov.id=p.proveedor
		INNER JOIN tb_categoria AS c ON c.id = p.categoria
		INNER JOIN tb_subcategoria AS s ON s.id = p.subcategoria
		WHERE
			p.estado = 1
		AND p.id=$id
		ORDER BY
			p.nombre ASC";

		try{
			$comando=Conexion::getInstance()->getDb()->prepare($sql);
			$comando->execute();
			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
				$producto=$row;
			}
		$modal.='<div class="modal fade modal-side-fall" id="md_editar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          	<div class="modal-body">
               <form action="#" method="post" name="form-producto" id="form-producto" class="form-horizontal form-bordered">
            <!-- Product Edit Content -->
        <div class="row">
            <div class="col-lg-6">
                <!-- General Data Block -->
                <div class="block">
                    <!-- General Data Title -->
                    <div class="block-title">
                        <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
                    </div>
                    <!-- END General Data Title -->

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Nombre</label>
                            <div class="col-md-9">
                                <input type="hidden" name="data_id" value="editar_producto">
                                <input type="hidden" name="id" value="'.$producto[id].'" >
                                <input type="text" id="nombre" name="nombre" value="'.$producto[nombre].'" class="form-control" placeholder="Digite el nombre del nombre">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="descripcion">Descripción</label>
                            <div class="col-md-9">
                                <textarea  id="descripcion" name="descripcion" class="form-control" rows="3">'.$producto[descripcion].'</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="departamento">Departamento</label>
                            <div class="col-md-9">
                                <!-- Chosen plugin (class is initialized in js/app.js -> uiInit()), for extra usage examples you can check out http://harvesthq.github.io/chosen/ -->
                                <select id="departamento" name="departamento" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                                    <option></option>';
                                    foreach ($departamentos[1] as $departamento){
                                    	if($departamento[id]==$producto[departamento]){
                                    		 $modal.='<option selected value="'.$departamento[id].'">'.$departamento[nombre].'</option>';
                                    	}else{
                                    		 $modal.='<option value="'.$departamento[id].'">'.$departamento[nombre].'</option>';
                                    	}
                                       
                                    } 
                                $modal.='</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="categoria">Categoría</label>
                            <div class="col-md-9">
                                <!-- Chosen plugin (class is initialized in js/app.js -> uiInit()), for extra usage examples you can check out http://harvesthq.github.io/chosen/ -->
                                <select id="categoria" name="categoria" class="select-chosen" data-placeholder="Seleccione un categoría" style="width: 250px;">
                                    <option></option>';
                                    foreach ($categorias[2] as $categoria){
                                    	if($categoria[id]==$producto[categoria]){
                                    		 $modal.='<option selected value="'.$categoria[id].'">'.$categoria[nombre].'</option>';
                                    	}else{
                                    		 $modal.='<option value="'.$categoria[id].'">'.$categoria[nombre].'</option>';
                                    	}
                                       
                                    } 
                                $modal.='</select>
                            </div>
                        </div>
                        
                        
                    <!-- END General Data Content -->
                </div>
                <!-- END General Data Block -->
            </div>
            <div class="col-lg-6">
                <!-- Meta Data Block -->
                <div class="block">
                    <!-- Meta Data Title -->
                    <div class="block-title">
                        <h2><i class="fa fa-google"></i> <strong>Información</strong> Adicional</h2>
                    </div>

                    <div class="form-group">
                            <label class="col-md-3 control-label" for="subcategoria">Subcategoría</label>
                            <div class="col-md-9">
                                <select name="subcategoria" id="subcategoria" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                                     <option></option>';
                                       foreach ($subcategorias[2] as $subcategoria){
                                    	if($subcategoria[id]==$producto[subcategoria]){
                                    		 $modal.='<option selected value="'.$subcategoria[id].'">'.$subcategoria[nombre].'</option>';
                                    	}else{
                                    		 $modal.='<option value="'.$subcategoria[id].'">'.$subcategoria[nombre].'</option>';
                                    	}
                                       
                                    } 
                                $modal.='</select>
                            </div>
                        </div>';     
                        $modal.='<div class="form-group">
                            <label class="col-md-3 control-label" for="product-meta-keywords">Proveedor</label>
                            <div class="col-md-9">
                                <select name="proveedor" id="proveedor" class="select-chosen" data-placeholder="Seleccione un proveedor" style="width: 250px;">
                                    <option></option>';
                                    foreach ($proveedores[2] as $proveedor){
                                    	if($proveedor[id]==$producto[proveedor]){
                                    		 $modal.='<option selected value="'.$proveedor[id].'">'.$proveedor[nombre].'</option>';
                                    	}else{
                                    		 $modal.='<option value="'.$proveedor[id].'">'.$proveedor[nombre].'</option>';
                                    	}
                                       
                                    } 
                                $modal.='</select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Porcentaje de ganancia</label>
                            <div class="col-md-9">
                                <input type="number" max="100" value="'.$producto[ganancia].'" id="ganancia" name="ganancia" class="form-control">
                            </div>
                        </div>
                    <!-- END Meta Data Content -->
                </div>
                <!-- END Meta Data Block -->
            </div>
            <div class="col-lg-12">
                <div class="block">
                    <div class="form-group">
                    <div class="col-md-10">
                        <center>
                            <button type="button" id="btn_guardar" class="btn btn-sm btn-mio"><i class="fa fa-floppy-o"></i> Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cerrar</button>
                        </center>
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

            return array("1",$producto,$sql,$modal);
		}catch(Exception $e){
			return array(-1,"error",$sql,$e->getMessage());
		}
	}
 } 
 ?>