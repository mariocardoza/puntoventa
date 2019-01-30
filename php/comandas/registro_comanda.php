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
include_once("../../Conexion/Cliente.php");
include_once("../../Conexion/Categoria.php");
include_once("../../Conexion/Comanda.php");
$mesas=Mesa::obtener_mesas();
$productos=Producto::obtener_productos();
$naturales=Cliente::obtener_naturales();
$juridicos=Cliente::obtener_juridicos();
$clientes=Cliente::obtener_todos();
$categorias=Categoria::consumibles();
$tipos=Comanda::tipos();
//print_r($juridicos);
?>

<div id="page-content" style="background-color: #F2F2F2;">
    <form action="#" method="post" name="fm_orden" id="fm_orden" class="form-horizontal">
        <div class="col-lg-12">
            <div class="row" style="background-color: #F2F2F2;">
                <div class="col-lg-12" style="background-color: #F2F2F2;">
                    <div class="block " id="selmesa">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Tipo de orden</label>
                            <div class="col-md-9">
                               <select name="tipo_orden" id="tipo_orden" class="select-chosen">
                                   <option value="">Seleccione</option>
                                   <option value="1">Mesa</option>
                                   <option value="2">Llevar</option>
                                   <option value="3">Domicilio</option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 control-label">Mesa seleccionada</label>
                            <div class="col-lg-9">
                              <label for="" id="nombre_mesa"></label>
                            </div>
                        </div>    
                    </div> 
                    <div class="block " id="mesas" style="display: none;">
                        <label for="">Seleccione la mesa</label>
                        <div class="row">
                          <?php foreach ($mesas as $mesa): ?>
                              <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <div class="widget-simple <?php echo ($mesa[ocupado] == 0) ? 'themed-background-dark' : 'themed-background-dark-fire' ?>">
                                        <a data-codigo="<?php echo $mesa[codigo_oculto] ?>" data-nombre="<?php echo $mesa[nombre] ?>" href="#" id="<?php echo ($mesa[ocupado]==0)? 'libre' : 'ocupado' ?>" >
                                            <img src="../../img/placeholders/mesa.png" alt="avatar" class="widget-image img-circle pull-left">
                                        </a>
                                        <h4 class="widget-content">
                                            <a data-nombre="<?php echo $mesa[nombre] ?>" data-codigo="<?php echo $mesa[codigo_oculto] ?>" href="#" id="<?php echo ($mesa[ocupado]==0)? 'libre1' : 'ocupado1' ?>">
                                                <strong><?php echo $mesa[nombre] ?></strong>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                              </div> 
                          <?php endforeach ?>
                        </div>
                    </div>
                    <div class="block" id="orden" style="display: none;">
                      <div class="row">
                        <div class="widget">
                                    <div class="widget-simple themed-background-dark-fire">
                                        <img id="img_tipo" src="../../img/placeholders/mesa.png" alt="avatar" class="widget-image img-circle pull-left">
                                        <h4 class="widget-content">                         <a href="javascript:void(0)" >
                                            <p id="tipo_ordenes"></p>
                                            <strong id="num_mesa"></strong>
                                            <p id="para_cuantos"></p>
                                            <p id="nome_cliente"></p>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                                <input type="hidden" id="id_mesa">
                                <input type="hidden" id="numero_clientes">
                                <input type="hidden" id="tipo_pedido">
                                <input type="hidden" id="total_comanda"> 
                                <input type="hidden" id="nom_cliente">
                                <input type="hidden" id="direccion">
                        <div class="col-xs-3 col-lg-3" style="height: 840px;overflow-y: auto;">
                          <h2>Categorías</h2>
                          <div class="row" style="height: 700px;">
                            <?php foreach ($categorias[2] as $categoria): ?>
                              <div class="col-xs-12 col-lg-12">
                                <div class="widget">
                                  <div class="widget-simple themed-background-dark-amethyst">
                                    <h4 class="widget-content">
                                        <a id="esto" data-tipo="<?php echo $categoria[id] ?>" href="javascript:void(0)" >
                                            <strong><?php echo $categoria[nombre] ?></strong>
                                        </a>
                                    </h4>
                                  </div>
                                </div>
                              </div>
                          <?php endforeach ?>
                          </div>
                        </div>
                        <div class="col-xs-3 col-lg-3" style="height: 840px;overflow-y: auto;">
                          <h2>Productos</h2>
                          <div class="row" id="aqui">
                            
                          </div>
                        </div>
                        <div class="col-xs-6 col-lg-6" style="height: 840px;overflow-y: auto;">
                          <h2>Comanda</h2>
                          <div class="row" id="comandi">
                            
                          </div>
                          <h2 class="pull-right" id="totalpone">Total: $0.00</h2>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-lg-12">
          <div class="form-group">
            <center>
              <button class="btn btn-mio" type="button" id="comandar">Aceptar</button>
              <button class="btn btn-default" id="btn_cancelar_comanda">Cancelar</button>
            </center>
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
<script src="comandas.js?cod=<?php echo date("Yidisus") ?>"></script>    
<?php include '../../inc/template_end.php'; ?>

