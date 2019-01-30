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
        INNER JOIN tb_unidad_medida as me ON me.id=p.medida
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

    public static function obtener_ingredientes(){
        $sql = "SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.sku,
            p.cantidad,
            p.imagen,
            CASE
                WHEN p.fecha_vencimiento='' THEN 'Producto no perecedero'
                ELSE DATE_FORMAT(p.fecha_vencimiento,'%d/%m/%Y') 
            END AS vencimiento,
            me.nombre as medida,
            p.precio_unitario,
            d.nombre AS departamento,
            c.nombre AS categoria,
            p.ganancia,
            p.codigo_oculto,
            (((p.ganancia/100)*p.precio_unitario)+p.precio_unitario) as precio_venta
        FROM
            tb_producto AS p
        INNER JOIN tb_departamento AS d ON d.id = p.departamento
        INNER JOIN tb_categoria AS c ON c.id = p.categoria
        INNER JOIN tb_unidad_medida as me ON me.id=p.medida
        WHERE
            p.estado = 1
        AND p.ingrediente=1
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

    public static function obtener_unidades(){
        $sql="SELECT * FROM tb_unidad_medida";
        try{
          $comando=Conexion::getInstance()->getDb()->prepare($sql);
          $comando->execute();
          while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
                $unidades[]=$row;
            }
            return $unidades;  
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public static function busqueda($dato,$departamento,$estado){
        $segun_depar="";
        if($departamento!=0){
            $segun_depar="AND p.departamento=$departamento";
        }
        $sql="SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.sku,
            p.cantidad,
            p.estado,
            p.imagen,
            um.abreviatura,
            p.contenido,
            p.presentacion,
            SUM(pd.contenido) / p.contenido as disponible,
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
        INNER JOIN tb_unidad_medida as um ON p.medida=um.id
        INNER JOIN tb_producto_detalle AS pd ON p.codigo_oculto = pd.codigo_producto
        WHERE
            (p.nombre LIKE '%$dato%'
        OR p.descripcion LIKE '%$dato%')
        AND pd.estado IN(1,2)
        $segun_depar
        AND p.estado = $estado 
        GROUP BY
            pd.codigo_producto";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
                $productos[]=$row;
            }
         foreach($productos as $producto) { 
            $modal.='<div class="col-sm-6 col-lg-6" id="listado-card">
                <div class="widget">
                  <div class="widget-simple">
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="editar(\''.$producto[id].'\')" data-toggle="tooltip" title="Editar"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a></td>
                                <td width="15%" rowspan="4"><center><img src="../../img/productos/'.$producto[imagen].'" id="cambiar_imagen" data-codigo="'.$producto[codigo_oculto].'" alt="avatar" class="widget-image img-circle"></center></td>
                                <td rowspan="2" style="font-size: 18px;"><b>'.$producto[nombre]. '</b> '.$producto[descripcion].' </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0px;"><a onclick="verproducto(\''.$producto[id].'\')" href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 0px;"><a id="asignar_mas" data-id="'.$producto[id].'" data-contenido="'.$producto[contenido].'" data-nombre="'.$producto[nombre].'" href="javascript:void(0)"><img src="../../img/iconos/mas.svg" width="35px" height="35px"></a></td>
                                <td style="font-size: 18px;">En inventario: <b>'.rtrim(rtrim((string)number_format($producto[disponible], 2, ".", ""),"0"),".").' '.$producto[presentacion].' de '.$producto[contenido].''.$producto[abreviatura].'</b></td>
                                
                            </tr>
                            <tr>';
                            if($producto[estado]==1):
                                $modal.='<td style="padding: 5px 0px;" width="15%"><a href="javascript:void(0)" onclick="darbaja(\''.$producto[id].'\',\'tb_producto\',\'el producto\')" data-toggle="tooltip" title="Eliminar"><img src="../../img/iconos/eliminar.svg" width="35px" height="35px"></a></td>';
                            else:
                                $modal.='<td style="padding: 5px 0px;" width="15%"><a class="btn btn-mio" href="javascript:void(0)" onclick="daralta(\''.$producto[id].'\',\'tb_producto\',\'el producto\')" data-toggle="tooltip" style="width:35px; height:35px;" title="Habilitar"><i class="fa fa-level-up"></i></a></td>';
                            endif;
                                $modal.='<td style="font-size: 18px;">Precio $'.number_format($producto[precio_venta],2).'</td>
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

    public static function busqueda_venta($dato,$departamento){
        $segun_depar="";
        if($departamento!=0){
            $segun_depar="AND p.departamento=$departamento";
        }
        $sql="SELECT
            p.id,
            p.nombre,
            p.descripcion,
            p.sku,
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
         SUM(pd.contenido) / p.contenido as disponible,
         ROUND(
            (
                (p.ganancia / 100) * p.precio_unitario
            ) + p.precio_unitario
        ,2) AS precio_venta
        FROM
            tb_producto AS p
        INNER JOIN tb_departamento AS d ON p.departamento = d.id
        INNER JOIN tb_producto_detalle AS pd ON p.codigo_oculto = pd.codigo_producto
        WHERE
            p.nombre LIKE '%$dato%'
        AND pd.estado IN(1,2)
        $segun_depar
        AND p.estado =1 
        GROUP BY
            pd.codigo_producto";
        try{
            $comando=Conexion::getInstance()->getDb()->prepare($sql);
            $comando->execute();
            while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
                $productos[]=$row;
            }
         foreach($productos as $producto) { 
            $modal.='<div class="col-xs-12 col-sm-12 col-lg-12" id="listado-card">
        <div class="widget">
          <div class="widget-simple">
            <table width="100%">
                <tbody>
                    <tr>
                        <td width="15%"></td>
                        <td width="15%" rowspan="3"><center><img src="../../img/productos/'.$producto[imagen].'" id="cambiar_imagen" data-codigo="'.$producto[codigo_oculto].'" alt="avatar" class="widget-image img-circle"></center></td>
                        <td style="font-size: 18px;"><b>'.$producto[nombre] .'</b> '.$producto[descripcion].'</td>
                    </tr>
                    <tr>
                        <td><a style="border-radius: 90px" class="btn btn-mio btn-lg" id="agrega_img" data-nombre="'.$producto[nombre].'" data-codigo="'. $producto[codigo_oculto].'" data-imagen="'. $producto[imagen].'" data-precio="'. $producto[precio_venta] .'" data-existencia="'.$producto[disponible].'" href="javascript:void(0)"><i class="fa fa-plus"></i></a></td>
                        <td style="font-size: 18px;">En inventario: <b>'.rtrim(rtrim((string)number_format($producto[disponible], 2, ".", ""),"0"),".") .'</b></td> 
                    </tr>
                    <tr>
                        <td width="15%"></td>
                        <td style="font-size: 18px;">Precio $'. number_format($producto[precio_venta],2).'
                        </td>
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
 		$sku = rand(1,100)."-".date("Yidisus");
 		if($data['fecha_vencimiento']==''){
            $fecha="";
        }else{
            $fecha_aux=explode("/",$data[fecha_vencimiento]);
            $fecha=$fecha_aux[2]."-".$fecha_aux[1]."-".$fecha_aux[0];
        }
        $canti=$data[cantidad]*$data[contenido];
 		$sql="INSERT INTO `tb_producto`(`nombre`, `departamento`, `categoria`, `subcategoria`, `descripcion`, `precio_unitario`, `cantidad`, `proveedor`, `sku`,`codigo_oculto`,`ganancia`,`medida`,`fecha_vencimiento`,`presentacion`,`contenido`,`ingrediente`) VALUES ('$data[nombre]','$data[departamento]','$data[categoria]','$data[subcategoria]','$data[descripcion]','$data[precio_unitario]','$canti','$data[proveedor]','$sku','$oculto',$data[ganancia],$data[medida],'$fecha','$data[presentacion]','$data[contenido]','$data[ingrediente]')";
 		
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql);
 			$comando->execute();
 			if($comando){
 				for($i=0;$i<$data['cantidad'];$i++){
 					$correlativo=Genericas2::retornar_correlativo("tb_producto_detalle",$oculto);
 					$sql2="INSERT INTO tb_producto_detalle (codigo_producto,correlativo,lote,contenido,fecha_vencimiento) VALUES('$oculto','$correlativo','$data[lote]',$data[contenido],'$fecha')";

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
 	public static function actualizar_inventario($producto,$cantidad,$precio,$lote,$venci,$contenido){
        if($venci==''){
            $fecha="";
        }else{
            $fecha_aux=explode("/",$venci);
            $fecha=$fecha_aux[2]."-".$fecha_aux[1]."-".$fecha_aux[0];
        }
 		$sql_producto="SELECT p.cantidad,p.precio_unitario,p.codigo_oculto FROM tb_producto as p WHERE p.id=$producto";
 		try{
 			$comando=Conexion::getInstance()->getDb()->prepare($sql_producto);
 			$comando->execute();
 			while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
 				$cantidad_base=$row['cantidad'];
 				$precio_base=$row['precio_unitario'];
 				$oculto=$row['codigo_oculto'];
 				//$lote=$row['lote'];
 			}
 			$canti_aux=$cantidad_base+$cantidad;
 			$precio_aux=($precio_base+$precio)/2;
 			$sql_update="UPDATE tb_producto SET cantidad=$canti_aux, precio_unitario=$precio_aux WHERE id=$producto";
 			$comando_update=Conexion::getInstance()->getDb()->prepare($sql_update);
 			if($comando_update->execute()){
 				for($i=0;$i<$cantidad;$i++){
 					$correlativo=Genericas2::retornar_correlativo("tb_producto_detalle",$oculto);
 					$sql2="INSERT INTO tb_producto_detalle (codigo_producto,correlativo,lote,fecha_vencimiento,contenido) VALUES('$oculto','$correlativo','$lote','$fecha','$contenido')";

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
            p.cantidad,
            p.imagen,
            um.abreviatura,
            p.contenido,
            p.presentacion,
            SUM(pd.contenido) / p.contenido as disponible,
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
        ) AS precio_venta,
			d.nombre AS departamento,
			c.nombre AS categoria,
			s.nombre AS sub
		FROM
			tb_producto AS p
		INNER JOIN tb_departamento AS d ON d.id = p.departamento
		INNER JOIN tb_categoria AS c ON c.id = p.categoria
		INNER JOIN tb_subcategoria AS s ON s.id = p.subcategoria
        INNER JOIN tb_unidad_medida as um ON p.medida=um.id
        INNER JOIN tb_producto_detalle AS pd ON p.codigo_oculto = pd.codigo_producto

		WHERE
			p.estado = 1
		AND p.id=$id
        GROUP BY
            pd.codigo_producto
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
                        <td>$'.number_format($producto[precio_venta],2).'</td>
                    </tr>
                    <tr>
                        <th>Cantidad disponible</th>
                        <td>'.rtrim(rtrim((string)number_format($producto[disponible], 2, ".", ""),"0"),".").' '.$producto[presentacion].'</td>
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
                        <th>Subcategoría</th>
                        <td>'.$producto[sub].'</td>
                    </tr>
                    <tr>
                        <td colspan="2"><img src="../../lib/Barcode/barcode.php?text='.$producto[sku].'&print=true" width="300" height="70"></td>
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
			p.cantidad,
			p.imagen,
			p.precio_unitario,
			p.ganancia,
			p.fecha_vencimiento,
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
            <h5 class="modal-title"><b>Editar información del producto</b></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
          	<div class="modal-body">
               <form action="#" method="post" name="form-producto" id="form-producto" class="form-horizontal">
            <!-- Product Edit Content -->
        <div class="row">
            <div class="col-lg-6">
                <div class="block">
                  
                       <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                                <input type="hidden" name="data_id" value="editar_producto">
                                <input type="hidden" name="id" value="'.$producto[id].'" >
                                <input type="text" id="nombre" name="nombre" value="'.$producto[nombre].'" class="form-control" placeholder="Digite el nombre del nombre">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="descripcion">Descripción</label>
                                <textarea  id="descripcion" name="descripcion" class="form-control" rows="3">'.$producto[descripcion].'</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="departamento">Departamento</label>
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
                        <div class="form-group">
                            <label class="control-label" for="categoria">Categoría</label>
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
                        
                        
                    <!-- END General Data Content -->
                </div>
                <!-- END General Data Block -->
            </div>
            <div class="col-lg-6">
                <!-- Meta Data Block -->
                <div class="block">
                    
                    <div class="form-group">
                            <label class="control-label" for="subcategoria">Subcategoría</label>
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
                        </div>';     
                        $modal.='<div class="form-group">
                            <label class="control-label" for="product-meta-keywords">Proveedor</label>
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
                        <div class="form-group">
                            <label for="" class="control-label">Porcentaje de ganancia</label>
                                <input type="number" value="'.$producto[ganancia].'" id="ganancia" name="ganancia" class="form-control">
                        </div>
                    <!-- END Meta Data Content -->
                </div>
                <!-- END Meta Data Block -->
            </div>
            <div class="col-lg-12">
                    <div class="form-group">
                        <center>
                            <button type="button" id="btn_guardar" class="btn btn-mio"> Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-default">Cerrar</button>
                        </center>
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