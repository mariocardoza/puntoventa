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
include_once("../../Conexion/Conexion.php");
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Categoria.php");
include_once("../../Conexion/Receta.php");
$departamentos=Departamento::obtener_departamentos();
$productos=Producto::obtener_ingredientes();
$categorias=Categoria::consumibles();
$receta=$_GET['receta'];
$ingredientes="";
$sql="SELECT rd.cantidad,p.nombre as n_producto, me.nombre as n_medida FROM tb_receta_detalle as rd INNER JOIN tb_producto as p ON p.codigo_oculto=rd.codigo_producto INNER JOIN tb_unidad_medida as me ON me.id=p.medida WHERE rd.codigo_receta='$receta'";
  $comando=Conexion::getInstance()->getDb()->prepare($sql);
  $comando->execute();
  while ($row=$comando->fetch(PDO::FETCH_ASSOC)) {
    $ingredientes.='<tr><td>'.$row[n_producto].'</td><td>'.Receta::convertir_decimal_a_fraccion($row[cantidad]).' '.$row[n_medida].'</td><td><button class="btn btn-mio btn-xs" type="button" id="quitabase"><i class="fa fa-remove"></i></button></td></tr>';
  }
?>
<div id="page-content">    
  <div class="row">
    <div class="col-xs-12">
      <div class="block full">
        <form action="#" method="post" name="fm_compuesto" id="fm_compuesto" class="">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <label for="" class="control-label">Nombre del modificador</label>
                <input type="text" id="nombre" autocomplete="off" class="form-control">
              </div>
              <div class="form-group">
                <label for="" class="control-label">Descripcion: (Opcional)</label>
                <textarea name="" id="descripcion" rows="2" class="form-control"></textarea>
              </div>
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="" class="control-label">Opciones</label>
                  <select name="" id="laopcion" class="select-chosen" multiple>
                  </select>
              </div>
              <!--div class="row">
                <div class="col-xs-12">
                  <div class="form-group">
                    <label for="" class="control-label">Busqueda según..</label>
                    <select name="" id="segun" class="select-chosen">
                      <option selected value="">Seleccione..</option>
                      <option value="1">Productos</option>
                      <option value="2">Categorías</option>
                    </select>
                  </div-->
                  <!--div class="form-group">
                    <label for="" class="control-label">Seleccione la categoría</label>
                    <select name="" id="lacate" class="select-chosen">
                      <option value="">Seleccione</option>
                      <?php foreach ($categorias[2] as $categoria): ?>
                        <option value="<?php echo $categoria[id] ?>"><?php echo $categoria[nombre] ?></option>
                      <?php endforeach ?>
                    </select>
                  </div>
                </div>
              </div-->
            </div>
            <div class="col-xs-6">
              <div class="form-group">
                <label for="" class="control-label">Cantidad mínima</label>
                <div class="btn-group">
                  <center><span><button type="button" id="plus" class="btn btn-default btn-sm" data-quantity="plus" data-field="limite"><i class="fa fa-plus"></i></button></span></center>
                  <input type="number" name="limite" id="limite" readonly step="1" min="1" value="1" class="form-control">
                  <center><span><button type="button" id="minus" class="btn btn-default btn-sm" data-quantity="minus" data-field="limite"><i class="fa fa-minus"></i></button></span></center>
                </div>  
              </div>
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <center>
                  <button class="btn btn-mio" id="btn_obtener" type="button">Aceptar</button>
                  <button class="btn btn-defaul" type="button">Cancelar</button>
                </center>
              </div>
            </div>
          </div>      
        </form>
      </div>
    </div>
  </div>
  <?php //include 'modal.php'; ?>
</div>
<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<!-- Load and execute javascript code used only in this page -->
<script src="compuesto.js?cod=<?=$cod?>"></script>
<script>
  $("#titulo_nav").text("Producto compuesto");
</script> 
<?php include '../../inc/template_end.php'; ?>

