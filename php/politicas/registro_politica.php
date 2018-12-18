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
include_once("../../Conexion/Empleado.php");
?>

<div id="page-content">
    <!-- eCommerce Product Edit Header -->
    <div class="content-header">
        <ul class="nav-horizontal text-center">
            <li>
                <a href="../../php/home.index.php"><i class="fa fa-bar-chart"></i> Dashboard</a>
            </li>
            <li class="active">
                <a href="#"><i class="gi gi-pencil"></i> Registro de proveedor</a>
            </li>
            <li >
                <a href="proveedores.php"><i class="gi gi-user"></i> Proveedores</a>
            </li>
        </ul>
    </div>
    <!-- END eCommerce Product Edit Header -->

    <!-- Product Edit Content -->
        <!-- General Data Content -->
        <form action="#" method="post" name="fm_politicas" id="fm_politicas" class="form-horizontal form-bordered">
            <div class="row">
        <div class="col-lg-12">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-pencil"></i> <strong>Registro de</strong> política de inventario</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Tipo de política</label>
                            <div class="col-md-9">
                                <input type="hidden" name="data_id" value="nueva_politica">
                                <input id="tipo" checked type="radio" name="tipo" value="vencimiento">Vencimiento
                                <input id="tipo2" type="radio" name="tipo" value="stock">Stock de inventario
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">¿Quienen verán la notificacion?</label>
                            <div class="col-md-9">
                                <select required name="niveles" id="niveles" class="select-chosen" data-placeholder="Seleccione un usuario" style="width: 100%;">
                                    <option value="0">Todos</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Vendedores</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-md-3 control-label">Descripción</label>
                            <div class="col-md-9">
                                <textarea required name="descripcion" id="descripcion" rows="3" class="form-control"></textarea>        
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">¿Cúantas veces al día?</label>
                            <div class="col-md-9">
                                <input required name="frecuencia" id="frecuencia" class="form-control" placeholder="digite cuantas veces al día enviara la notificacion">
                            </div>
                        </div>
                        <div class="form-group" id="minimo_fm_group" style="display: none;">
                            <label class="col-md-3 control-label" for="nombre">¿Cúanto es el mínimo?</label>
                            <div class="col-md-9">
                                <input name="minimo" id="minimo" class="form-control" disabled placeholder="digite cuanto el mínimo de inventario permitido">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-12">
            <div class="block">
                <div class="form-group">
                <div class="col-md-10">
                    <center>
                        <button type="button" id="btn_guardar" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                    </center>
                </div>
            </div>
            </div>
        </div>
        </div>
    </form>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<script src="politicas.js?cod=<?=$cod?>"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>    
<?php include '../../inc/template_end.php'; ?>

