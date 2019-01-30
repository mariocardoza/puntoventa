<?php 
    @session_start();
    //echo $_SESSION['autentica']." STO TRAE"; exit();
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
    
      
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Departamento.php");
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Categoria.php");
$departamentos=Departamento::obtener_departamentos();
$productos=Producto::obtener_ingredientes();
$categorias=Categoria::consumibles();
?>
<div id="page-content">    
  <div class="row">
    <div class="col-xs-12">
      <div class="block full">
        <form action="#" method="post" name="form_receta" id="form_receta" class="form-horizontal">
          
          <div class="row" style="display: block;" id="ingredientes">
              <div class="col-xs-3 col-lg-3">
                <div class="form-group">
                  <label class="control-label" for="">Ingredientes</label>
                  <input type="hidden" id="cod_receta" value="<?php echo $_GET[receta] ?>">
                  <select name="producto" id="producto" class="select-chosen">
                    <option value="">Seleccione</option>
                      <?php foreach ($productos[1] as $producto): ?>
                        <option data-unidad="<?php echo $producto[medida] ?>" value="<?php echo $producto[codigo_oculto] ?>"><?php echo $producto[nombre] ?></option>
                      <?php endforeach ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-3 col-lg-3">
                <div class="form-group">
                  <label class="control-label" for="cantidad">Cantidad</label>
                  <input type="text" pattern="(1[0-2]|0[1-9])\/(1[5-9]|2\d)" id="cantidad" name="cantidad" class="form-control masked" placeholder="Cantidad a adquirir">
                </div>
              </div>
              <div class="col-xs-1 col-lg-1"></div>
              <div class="col-xs-2 col-lg-2">
                <div class="form-group">
                  <button type="button" id="btn_agregar" class="btn btn-mio" style="margin-top: 30px;">Agregar</button>
                </div>
              </div>
              <div class="col-xs-12 col-lg-12">
                <table class="table">
                  <thead>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                  </thead>
                  <tbody id="cuerpo"></tbody>
                </table>
              </div>
              <div class="col-xs-12 col-lg-12">
                  <div class="form-group">
                      <center>
                          <button type="button" class="btn btn-mio" id="btn_guardar_ingredientes">Guardar ingredientes</button>
                      </center>
                  </div>
              </div>
          </div>       
        </form>
      </div>
    </div>
  </div>
  <?php include 'modal.php'; ?>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>   
<script type="text/javascript" src="../../js/jquery-barcode.js"></script>  
<script src="recetas.js?cod=<?=$cod?>"></script> 
<?php include '../../inc/template_end.php'; ?>

