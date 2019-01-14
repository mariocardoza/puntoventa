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
//$result = Producto::obtener_productos();
$depart = Departamento::obtener_departamentos();
include_once("../../Conexion/Proveedor.php");
include_once("../../Conexion/Subcategoria.php");
$proveedores=Proveedor::obtener_proveedores();
$departamentos=Departamento::obtener_departamentos();
$unidades=Producto::obtener_unidades();
$subcategorias=Subcategoria::obtener_subcategorias();
?>

<!-- Page content -->
<div id="page-content">
    <div class="row" style="background-color: #fff;">
      <div class="card">
        <div class="row centrado">
          <div class="col-sm-3 col-lg-3">
            <div class="input-group">
                <input type="search" class="form-control" id="busqueda" placeholder="Buscar">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <select name="" id="depart" class="select-chosen">
                <option value="0">Todos</option>
                <?php foreach ($depart[1] as $departamento): ?>
                    <option value="<?php echo $departamento[id] ?>"><?php echo $departamento[nombre] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="col-sm 3 col-lg-3">
            <select name="" id="estados" class="select-chosen">
                <option value="1">Activos</option>
                <option value="2">Inactivos</option>
            </select>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div class="row">
              <div class="col-sm-2 col-lg-2"></div>
              <div class="col-sm-8 col-lg-8"><a id="modal_guarda" href="registro_producto.php" class="btn btn-mio btn-block">Nuevo producto</a></div>
              <div class="col-sm-2 col-lg-2"></div>
          </div>
        </div>
        </div>
      </div>
      <div class="" id="aqui_busqueda">
        </div>
      
    </div>
    <!-- END Quick Stats -->

    
    <!-- END All Products Block -->
    <div id="aqui_modal"></div>
    <?php include("modales.php") ?>
</div>

<!-- modales -->


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/pages/ecomProducts.js"></script>
<script src="producto.js?cod=<?php echo $cod ?>"></script>
<script>$(function(){ EcomProducts.init(); });$("#titulo_nav").text("Inventario");</script>
<?php include '../../inc/template_end.php'; ?>

