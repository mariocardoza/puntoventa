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
    #submit{
          clear: both;
      }
      #barcodeTarget,
      #canvasTarget{
        margin-top: 20px;
      }  
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Mesa.php");
include_once("../../Conexion/Producto.php");
$mesas=Mesa::obtener_mesas();
$productos=Producto::obtener_productos();
?>

<div id="page-content">
    <form action="#" method="post" name="fm_orden" id="fm_orden" class="form-horizontal form-bordered">
        <div class="block">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="block">
                                <div class="block-title"><h4><strong>Productos</strong></h4></div>
                                <div class="hide">
                                    <div class="form-group">
                                    <label class="col-md-3 control-label" for="nombre">Tipo de orden</label>
                                    <div class="col-md-9">
                                       <select name="tipo_orden" id="tipo_orden" class="select-chosen">
                                           <option value="">Seleccione</option>
                                           <option value="1">Mesa</option>
                                           <option value="2">Llevar</option>
                                           <option value="1">Domicilio</option>
                                       </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-lg-3 control-label">Seleccione la mesa</label>
                                    <div class="col-lg-9">
                                        <button class="btn btn-primary" type="button" id="selec_mesa">Seleccionar mesa</button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-lg-3 control-label">Mesa seleccionada</label>
                                    <div class="col-lg-9">
                                        <label for="" id="nombre_mesa"></label>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <?php foreach ($productos[1] as $producto): ?>
                                    <div class="col-xs-6 col-sm-4 col-lg-3">
                                      <div class="widget">
                                          <div class="widget-simple">
                                              <a data-nombre="<?php echo $producto[nombre] ?>" data-codigo="<?php echo $producto[codigo_oculto] ?>" data-precio="<?php echo $producto[precio_unitario] ?>" data-existencia="<?php echo $producto[cantidad] ?>" href="#" id="agrega_img">
                                                  <img src="../../img/productos/<?php echo $producto[imagen] ?>" alt="avatar" class="widget-image img-circle pull-left">
                                              </a>
                                              <a data-nombre="<?php echo $producto[nombre] ?>" data-codigo="<?php echo $producto[codigo_oculto] ?>" data-precio="<?php echo $producto[precio_unitario] ?>" data-existencia="<?php echo $producto[cantidad] ?>" href="#" id="agrega_img1">
                                                    <strong><?php echo $producto[nombre] ?></strong>
                                                  </a>
                                          </div>
                                      </div>
                                    </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="block">
                                <div class="block-title"><h4><strong>Detalle de la orden</strong></h4></div>
                                <div class="form-group">
                                    <table class="table" id="orden_tb">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cuerpo">
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4">Total</th>
                                                <th id="total">$0.00</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default">Cancelar</button>
                                        <button type="button" class="btn btn-info" id="ordenar">Ordenar</button>
                                        <button type="button" class="btn btn-success" id="pagar">Pagar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--div class="col-lg-12">
                    <div class="form-group">
                        <div class="col-md-10">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>  
                            </center>
                        </div>
                    </div>
                </div-->
            </div>
        </div>
    </form>
    <!-- END Product Edit Content -->
<?php include 'modales.php'; ?>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>


<!-- Load and execute javascript code used only in this page -->
<script src="ordenes.js?cod=<?php echo date("Yidisus") ?>"></script>    
<?php include '../../inc/template_end.php'; ?>

