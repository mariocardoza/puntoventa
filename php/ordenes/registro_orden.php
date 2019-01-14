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
    <form action="#" method="post" name="fm_orden" id="fm_orden" class="form-horizontal">
        <div class="block" style="background-color: #F2F2F2;">
            <div class="row" style="background-color: #F2F2F2;">
                <div class="col-lg-12">
                    <div class="row" style="background-color: #F2F2F2;">
                        <div class="col-lg-6" style="background-color: #F2F2F2;">
                            <div class="block">
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
                                <div class="card-venta">
                                    <div class="col-sm-6 col-lg-6">
                                        <div class="input-group">
                                            <input type="search" class="form-control" id="busqueda" placeholder="Buscar producto" autocomplete="off">
                                            <span class="input-group-addon"><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-6">
                                        <select name="" id="tipos" class="select-chosen">
                                            <option value="0">Todos</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="aqui_busqueda_venta">
                                    <?php //foreach ($productos[1] as $producto): ?>
                                        
                                    
                                    <?php //endforeach ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="block">
                                
                                <div class="form-group">
                                    <div id="orden_tb" style="overflow:auto;overflow-x:hidden;max-height:350px; height: 350px;"></div>
                                </div>
                            </div>
                            <div class="block" style="height: 250px;">
                                <p><center><h1>Total:</h1></center></p>
                                <p><center><h1 id="total">$0.00</h1></center></p>
                                <p><center><button type="button" id="btn_tipofactura" class="btn btn-lg btn-mio">Cobrar</button></center></p>
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

