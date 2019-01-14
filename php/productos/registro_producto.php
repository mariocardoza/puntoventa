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
    
      
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Proveedor.php");
include_once("../../Conexion/Departamento.php");
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Subcategoria.php");
$proveedores=Proveedor::obtener_proveedores();
$departamentos=Departamento::obtener_departamentos();
$unidades=Producto::obtener_unidades();
$subcategorias=Subcategoria::obtener_subcategorias();
?>

<div id="page-content">    
    <div class="row">
        <div class="col-xs-12">
            <div class="block full">
                <form action="#" method="post" name="form-producto" id="form-producto" class="form-horizontal">
            <!-- Product Edit Content -->
            <div class="row">
                <div class="col-sm-6 col-lg-6" style="padding-left: 30px; padding-right: 16px;">
                    <div class="form-group">
                        <label class="control-label" for="nombre">Nombre</label>
                        <input type="hidden" name="data_id" value="nuevo_producto">
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del nombre">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="descripcion">Descripción</label>
                        <textarea  id="descripcion" placeholder="Descripción" name="descripcion" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="row">
                      <div class="col-sm-4 col-lg-4">
                        <div class="form-group">
                          <label class="control-label" for="departamento">Departamento</label>
                          <select id="departamento" name="departamento" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                              <option></option>
                              <?php foreach ($departamentos[1] as $departamento): ?>
                              <option value="<?php echo $departamento[id] ?>"><?php echo $departamento[nombre] ?></option>
                              <?php endforeach ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4 col-lg-4">
                        <div class="form-group">
                          <label class="control-label" for="categoria">Categoría</label>
                          <select id="categoria" name="categoria" class="select-chosen" data-placeholder="Seleccione un categoría" style="width: 250px;">
                              <option></option>
                          </select>
                        </div>
                      </div>
                      <div class="col-sm-4 col-lg-4">
                        <div class="form-group">
                          <label class="control-label" for="subcategoria">Subcategoría</label>
                          <select name="subcategoria" id="subcategoria" class="select-chosen" data-placeholder="Seleccione un departamento" style="width: 250px;">
                              <option></option>
                          </select>
                        </div> 
                    </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <div class="form-group">
                                  <label for="" class="control-label">Unidad de medida</label>
                                  <select name="medida" id="medida" class="select-chosen" data-placeholder="Seleccione una unidad de medida">
                                      <option></option>
                                      <?php foreach ($unidades as $unidad): ?>
                                          <option value="<?php echo $unidad[id] ?>"><?php echo $unidad[abreviatura]; ?></option>
                                      <?php endforeach ?>
                                  </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label for="" class="control-label">Contenido</label>
                                <input type="text" id="contenido" name="contenido" class="form-control" placeholder="Ej. 600">
                            </div>
                        </div>
                        <div class="col-sm-4 col-lg-4">
                            <div class="form-group">
                              <label class="control-label" for="cantidad">Cantidad</label>
                              <input type="number" id="cantidad" name="cantidad" class="form-control" placeholder="Cantidad a adquirir">
                            </div>
                        </div>
                    </div>                  
                    <div class="row">
                        <div class="col-sm-4 col-lg-4">
                            <div class="form-group">
                                <label class="control-label" for="precio_unitario">Precio unitario</label>
                                <input type="number" id="precio_unitario" name="precio_unitario" class="form-control" placeholder="Precio unitario de venta">
                            </div>
                        </div>
                        <div class="col-xs-4 col-lg-4">
                            <div class="form-group">
                                <label for="" class="control-label">Porcentaje de ganancia</label>
                                <input type="number" placeholder="Porcentaje de ganancia" id="ganancia" name="ganancia" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-4 col-lg-4">
                            <div class="form-group">
                                <label for="" class="control-label">Presentación</label>
                                <input type="text" name="presentacion" id="presentacion" class="form-control" placeholder="Ej. lata o libra">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" style="padding-left: 30px; padding-right: 16px;">
                    <div class="form-group">
                        <label class="control-label" for="">¿Producto perecedero?</label>
                            No
                        <label class="switch switch-success">
                        <input name="perecedero" id="perecedero" value="si" type="checkbox"><span></span></label>
                            Si
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-lg-6">
                            <div class="form-group" style="display: none;" id="venci">
                                <label for="" class="control-label">Fecha de vencimiento</label>
                                <input type="text" required disabled name="fecha_vencimiento" id="vencimiento" class="form-control vecimi">
                            </div>
                        </div>
                        <div class="col-xs-6 col-lg-6">
                            <div class="form-group" style="display: none;" id="lotito">
                                <label for="" class="control-label">Lote N°</label>
                                <input type="text" id="lote" disabled name="lote" class="form-control">
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <label class="control-label" for="">Proveedor</label>
                        <select name="proveedor" id="proveedor" class="select-chosen" data-placeholder="Seleccione un proveedor" style="width: 100%;">
                            <option></option>
                            <?php foreach ($proveedores[2] as $proveedor): ?>
                                <option value="<?php echo $proveedor[id] ?>"><?php echo $proveedor[nombre] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                           <!--label for="firma1">Imagen(*):</label-->
                           <div class="form-group " >
                              <img src="../../img/imagenes_subidas/image.svg" style="width: 200px;height: 202px;" id="img_file">
                              <input type="file" class="archivos hidden" id="file_1" name="file_1" />
                           </div>
                        </div>
                        <div class="col-md-6 col-xs-6 ele_div_imagen">
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
                <div class="col-lg-12">
                    <div class="form-group">
                        <center>
                            <button type="button" class="btn btn-mio" id="btn_guardar">Guardar</button>
                        </center>
                    </div>
                </div>
            </div>            
        </form>
            </div>
        </div>
    </div>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>   
<script type="text/javascript" src="../../js/jquery-barcode.js"></script>   
<?php include '../../inc/template_end.php'; ?>

<script src="producto.js?cod=<?=$cod?>"></script>




