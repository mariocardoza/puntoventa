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
include_once("../../Conexion/Conexion.php");
$result = Producto::obtener_inventario($_GET[id]);
$sql="SELECT nombre,ganancia FROM tb_producto WHERE codigo_oculto='$_GET[id]'";
$comando=Conexion::getInstance()->getDb()->prepare($sql);
$comando->execute();
$producto=$comando->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Page content -->
<div id="page-content">
    <!-- All Products Block -->
    <div class="block full">
        <!-- All Products Title -->
        <div class="block-title">
            <div class="block-options pull-right">
                <a href="javascript:void(0)" class="btn btn-alt btn-sm btn-default" data-toggle="tooltip" title="Settings"><i class="fa fa-cog"></i></a>
            </div>
            <h2><strong>Kardex para el producto: </strong><b><?php echo $producto[0][nombre] ?></b> al <?php echo $producto[0][ganancia] ?>% de ganancia</h2>
        </div>
        <!-- END All Products Title -->

        <!-- All Products Content -->
        <table id="productos_tables" class="table table-bordered table-striped table-vcenter">
            <thead>
                <tr>
                <th colspan="2">Detalles</th>
                <th colspan="3">Entrada</th>
                <th colspan="3">Salida</th>
                <th colspan="3">saldos</th>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Descripción</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Total</th>
                </tr>
                </tr>
            </thead>
            <tbody>
                <?php
                $subcantidad=0;
                $precioanterior=0.0;
                ?>
                <?php foreach($result[1] as $key => $producto) { 
                    //guardo el precio anterior
                    $veamos = round(($producto[cantidad]*$producto[precio_unitario]),3);
                    if($key==0){
                        $primer_precio=$producto[precio_unitario];
                        $precio_anterior=$producto[precio_unitario];
                    }else{
                        if($producto[tipo]==1){
                            $precio_actual=$producto[precio_unitario];
                            $precio_anterior_aux=$precio_anterior;
                            $precio_actual=($precio_actual+$precio_anterior_aux)/2;
                            $precio_anterior=$producto[precio_unitario];  
                        }else{
                            $precio_actual=$producto[precio_salida];
                        }
                        
                    }

                    $preciopromedio=0.0;
                    $precioanterior = $producto[precio_unitario];
                    if($producto[tipo]==1){
                        $subcantidad=$subcantidad+$producto[cantidad];
                        
                    }else{
                        $subcantidad=$subcantidad-$producto[cantidad];
                    }

                  
                    ?>
                <tr>
                   <td><?php echo $producto[fecha] ?></td>
                   <td><?php echo $producto[detalle] ?></td>
                   <?php if($producto[tipo]==1): ?>
                   <td class="text-right">$<?php echo number_format($producto[precio_unitario],2) ?></td>
                   <td><?php echo $producto[cantidad] ?></td>
                   <td class="text-right">$<?php echo bcdiv(($producto[cantidad]*$producto[precio_unitario]),1,2) ?></td>
                   <td> - </td>
                   <td> - </td>
                   <td> - </td>
                   <?php else: ?>
                    <td> - </td>
                    <td> - </td>
                    <td> - </td>
                    <td class="text-right">$<?php echo number_format($producto[precio_salida],2) ?></td>
                    <td><?php echo $producto[cantidad] ?></td>
                    <td class="text-right">$<?php echo number_format(($producto[cantidad]*$producto[precio_salida]),2) ?></td>
                <?php endif; ?>
                    <?php if($key==0): ?>
                        <td class="text-right">$<?php echo number_format($producto[precio_unitario] ,2) ?></td>
                        <td><?php echo $producto[cantidad] ?></td>
                        <td class="text-right">$<?php echo number_format($producto[cantidad]*$producto[precio_unitario],2) ?></td>
                    <?php else: ?>
                        <td class="text-right">$<?php echo number_format($precio_actual,2)  ?></td>
                        <td><?php echo $subcantidad ?></td>
                        <td class="text-right">$<?php echo number_format($precio_actual*$subcantidad,2) ?></td>
                    <?php endif; ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

<div id="aqui_modal"></div>
<!-- modales -->
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="producto.js?cod=<?php echo $cod ?>"></script>

<?php include '../../inc/template_end.php'; ?>

