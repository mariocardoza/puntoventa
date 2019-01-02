<?php 
    @session_start();
    //echo $_SESSION['autentica']."STO TRAE"; exit();
    if(!isset($_SESSION['loggedin']) && $_SESSION['autentica'] != "simon"){
        if($_SESSION['autentica'] != "simon" )
        {
             header("Location: ../../php/home/destruir.php");  
            exit(); 
        }else{
          
             header("Location: ../../php/home/destruir.php");  
            exit(); 

        }
    }else{
        
    }//prueba

    $cod=date("Yidisus");
?>

<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start.php'; ?>
<style type="text/css" media="screen">
    .block-title h2 {
        font-size: 23px;
    }
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Departamento.php");
$result = Producto::obtener_productos();
$depart = Departamento::obtener_departamentos();
?>

<!-- Page content -->
<div id="page-content">
    <!-- Quick Stats -->
    <div class="row">
        <div class="col-sm-4 col-lg-4">
            <div class="input-group">
                <input type="search" class="form-control" id="busqueda" placeholder="Buscar producto">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4">
            <select name="" id="depart" class="select-chosen">
                <option value="0">Todos</option>
                <?php foreach ($depart[1] as $departamento): ?>
                    <option value="<?php echo $departamento[id] ?>"><?php echo $departamento[nombre] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm-4 col-lg-4">
            <a href="registro_producto.php" class="btn btn-mio btn-block">Nuevo producto</a>
        </div>
    </div>
    <!-- END Quick Stats -->

    <!-- All Products Block -->
    <div class="block full">
        <div class="row"  style='overflow:scroll;overflow-x:hidden;max-height:700px;' id="aqui_busqueda">
            
        </div>

        <!-- All Products Content -->
        <!--table id="productos_table" class="table table-bordered table-striped table-vcenter">
            <thead>
                <tr>
                    <th class="text-center">SKU</th>
                    <th>Nombre del producto</th>
                    <th class="text-right">Precio</th>
                    <th>Estado</th>
                    <th>Porcentaje de ganancia</th>
                    <th>Departamento</th>
                    <th class="text-right">Precio de venta</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $labels['0']['class']   = "label-success";
                $labels['0']['text']    = "Disponible";
                $labels['1']['class']   = "label-warning";
                $labels['1']['text']    = "Pocas disponibles";
                $labels['2']['class']   = "label-danger";
                $labels['2']['text']    = "Fuera de inventario";
                ?>
                <?php foreach($result[1] as $producto) { ?>
                <tr>
                    <td class="text-center"><a onclick="<?php echo "verproducto(".$producto[id].")" ?>" href="javascript:void(0)"><strong><?php echo $producto[sku]; ?></strong></a></td>
                    <td><a onclick="<?php echo "verproducto(".$producto[id].")" ?>" href="javascript:void(0)"><?php echo $producto[nombre]; ?></a></td>
                    <td class="text-right"><strong>$<?php echo number_format($producto[precio_unitario],2) ?></strong></td>
                    <td>
                        <?php if($producto[cantidad]>10){ $rand=0;

                        }else if($producto[cantidad]<10 && $producto[cantidad]>4) $rand=1; 
                        else{
                            $rand=2;
                        }?>
                        <span class="label<?php echo ($labels[$rand]['class']) ? " " . $labels[$rand]['class'] : ""; ?>">
                            <?php
                            echo $labels[$rand]['text'] ." ( ". $producto[cantidad]. " )" ?>
                                
                        </span>
                    </td>
                    <td><?php echo $producto['ganancia'] ?>%</td>
                    <td><?php echo $producto['departamento'] ?></td>
                    <td class="text-right">$<?php echo number_format($producto['precio_venta'],2) ?></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-xs">
                            <a data-id="<?php echo $producto[id] ?>" data-nombre="<?php echo $producto[nombre] ?>" id="asignar_mas" href="javascript:void(0)" data-toggle="tooltip" title="Más existencias" class="btn btn-xs btn-success"><i class="fa fa-plus"></i></a>
                            <a href="javascript:void(0)" onclick="<?php echo "editar(".$producto['id'].")" ?>" data-toggle="tooltip" title="Edit" class="btn btn-default"><i class="fa fa-pencil"></i></a>
                            <a href="javascript:void(0)" id="cambiar_imagen" data-codigo="<?php echo $producto[codigo_oculto] ?>" class="btn btn-info btn-sx"><i class="fa fa-image"></i></a>
                            <a href="javascript:void(0)" onclick="<?php echo "darbaja(".$producto['id'].",'tb_producto','el producto')" ?>" data-toggle="tooltip" title="Delete" class="btn btn-xs btn-danger"><i class="fa fa-times"></i></a>
                        </div>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table-->
        <!-- END All Products Content -->
    </div>
    <!-- END All Products Block -->
    <div id="aqui_modal"></div>
    <?php include("modales.html") ?>
</div>

<!-- modales -->


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/pages/ecomProducts.js"></script>
<script src="producto.js?cod=<?php echo $cod ?>"></script>
<script>$(function(){ EcomProducts.init(); });</script>
<?php include '../../inc/template_end.php'; ?>

