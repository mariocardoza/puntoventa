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
include_once("../../Conexion/Opcion.php");
$departamentos=Departamento::obtener_departamentos();
$productos=Producto::obtener_ingredientes();
$categorias=Opcion::obtener_opciones();
?>
<div id="page-content">    
  <div class="row">
    <div class="col-xs-12">
      <div class="block full">
        <form action="#" method="post" name="form_receta" id="form_receta" class="">
          <div class="row" id="receta" style="display: block">
            <div class="col-xs-8 col-lg-8" style="padding-left: 30px; padding-right: 16px;">
              <div class="col-xs-12 col-lg-12">
                <div class="form-group">
                  <div class="icheck-turquoise icheck-inline">
                      <input type="radio" value="1" name="tipo_producto"  id="sala_belleza" />
                      <label for="sala_belleza">Producto predefinido</label>
                  </div>
                  <div class="icheck-turquoise icheck-inline">
                      <input type="radio" value="2" name="tipo_producto" id="mini_super" />
                      <label for="mini_super">Producto variable</label>
                  </div>
              </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-lg-6">
                  <div class="form-group">
                    <label class="control-label" for="nombre">Nombre</label>
                    <input type="text" required autocomplete="off" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
                  </div>
                </div>
                <div class="col-xs-6 col-lg-6">
                  <div class="form-group">
                    <label class="control-label" for="">Descripción</label>
                    <textarea name="descripcion"  id="descripcion" rows="2" class="form-control"></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-6 col-lg-6">
                  <div class="form-group">
                    <label class="control-label" for="">Categoría</label>
                    <select name="tipo" required id="tipo" class="select-chosen">
                      <?php foreach ($categorias as $categoria): ?>
                        <option value="<?php echo $categoria[codigo_oculto] ?>"><?php echo $categoria[nombre] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
                <div class="col-xs-6 col-lg-6">
                  <div class="form-group">
                      <label class="control-label" for="precio">Precio</label>
                      <input type="number" required id="precio" name="precio" class="form-control" placeholder="Precio de venta">
                  </div>
                </div>  
              </div>                 
            </div>
            <div class="col-xs-4 col-lg-4" style="padding-left: 30px; padding-right: 16px;">
              <div class="row">
                <div class="col-xs-6 col-lg-6">
                   <div class="form-group " >
                      <img src="../../img/imagenes_subidas/image.svg" style="width: 100px;height: 102px;" id="img_file">
                      <input type="file" class="archivos hidden" id="file_1" name="file_1" />
                   </div>
                </div>
                <div class="col-xs-6 col-lg-6 ele_div_imagen">
                    <div class="form-group">
                          <h5>La imagen debe de ser formato png o jpg con un peso máximo de 3 MB</h5>
                    </div><br><br>
                    <div class="form-group">
                      <button type="button" class="btn btn-sm btn-mio" id="btn_subir_img"><i class="icon md-upload" aria-hidden="true"></i> Seleccione Imagen</button>
                    </div>
                    <div class="form-group">
                      <div id="error_formato1" class="hidden"><span style="color: red;">Formato de archivo invalido. Solo se permiten los formatos JPG y PNG.</span>
                      </div>
                    </div>
                </div>
              </div>
            </div>
            <div class="col-xs-12 col-lg-12">
              <div class="form-group">
                <center>
                  <button type="button" class="btn btn-mio" id="btn_guardar">Guardar</button>
                </center>
              </div>
            </div>
          </div>
          <div class="row" style="display: none;" id="ingredientes">
              <div class="col-xs-3 col-lg-3">
                <div class="form-group">
                  <label class="control-label" for="">Ingredientes</label>
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
<script src="recetas.js?cod=<?=$cod?>"></script> 
<?php include '../../inc/template_end.php'; ?>

