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
$empleados=Empleado::obtener_empleados();
?>

<div id="page-content">
    <form action="#" method="post" name="fm_servicios" id="fm_servicios" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="fa fa-pencil"></i> <strong>Información</strong> de los servicios</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nombre">Nombre del servicio</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="data_id" value="nuevo_servicio">
                                    <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">
                                    <input type="text" autocomplete="off" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del servicio">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Descripción</label>
                                <div class="col-md-9">
                                    <textarea name="descripcion" id="descripcion"  rows="2" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="direccion">Precio</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="precio" id="precio">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="categoria">Tiempo estimado de duración</label>
                                <div class="col-md-9">
                                    <input type="text" name="duracion" id="duracion" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Empleado</label>
                                <div class="col-md-9">
                                    <select class="select-chosen" name="empleado" id="empleado">
                                        <option value="0">ninguno..</option>
                                        <?php foreach ($empleados[1] as $empleado): ?>
                                            <option value="<?php echo $empleado[id] ?>"><?php echo $empleado[nombre] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="col-md-10">
                                <center>
                                    <button type="submit" id="btn_guardar" class="btn btn btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                                </center>
                            </div>
                        </div>
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
<script src="servicios.js?cod=<?=$cod?>"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>      
<?php include '../../inc/template_end.php'; ?>

