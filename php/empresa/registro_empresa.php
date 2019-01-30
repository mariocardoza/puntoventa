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
include_once("../../Conexion/Empresa.php");
$empresa=Empresa::datos_empresa();
?>

<div id="page-content">
    <?php if($empresa): ?>
        <form action="#" method="post" name="fm_negocio" id="fm_negocio" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <label for="" class="col-lg-3 control-label">Seleccione el tipo de empresa</label>
                    <input type="hidden" name="data_id" value="editar_empresa">
                    <input type="hidden" name="id" value="<?php echo $empresa[id] ?>">
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="1" name="tipo_negocio" checked id="sala_belleza" />
                        <label for="sala_belleza">Sala de Belleza</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="2" name="tipo_negocio" id="mini_super" />
                        <label for="mini_super">Mini súper</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="3" name="tipo_negocio" id="tienda" />
                        <label for="tienda">Tienda</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="4" name="tipo_negocio" id="restaurante" />
                        <label for="restaurante">Restaurante</label>
                    </div>          
                </div>
            </div>
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nombre">Nombre del negocio</label>
                                <div class="col-md-9">              
                                    <input type="text" autocomplete="off" id="nombre" name="nombre" class="form-control" value="<?php echo $empresa[nombre] ?>" placeholder="Digite el nombre del proveedor">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="direccion">Dirección</label>
                                <div class="col-md-9">
                                    <textarea id="direccion" name="direccion" class="form-control" rows="3"><?php echo $empresa[direccion] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="categoria">NIT</label>
                                <div class="col-md-9">
                                    <input type="text" value="<?php echo $empresa[nit] ?>" name="nit" id="nit" class="form-control nit">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Email</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="email" value="<?php echo $empresa[email] ?>" autocomplete="off" id="email" name="email" class="form-control" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Número de registro</label>
                                <div class="col-md-9">
                                    <input type="text" value="<?php echo $empresa[nrc] ?>" name="nrc" id="nrc" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Giro</label>
                                <div class="col-md-9">
                                    <input type="text" name="giro" value="<?php echo $empresa[giro] ?>" id="giro" class="form-control">
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
        <?php else: ?>
        <form action="#" method="post" name="fm_negocio" id="fm_negocio" class="form-horizontal form-bordered">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <input type="hidden" name="data_id" value="nueva_empresa">
                    <label for="" class="col-lg-3 control-label">Seleccione el tipo de empresa</label>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="1" name="tipo_empresa" checked id="sala_belleza" />
                        <label for="sala_belleza">Sala de Belleza</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="2" name="tipo_empresa" id="mini_super" />
                        <label for="mini_super">Mini súper</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="3" name="tipo_empresa" id="tienda" />
                        <label for="tienda">Tienda</label>
                    </div>
                    <div class="icheck-turquoise icheck-inline">
                        <input type="radio" value="4" name="tipo_empresa" id="restaurante" />
                        <label for="restaurante">Restaurante</label>
                    </div>          
                </div>
            </div>
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-title">
                        <h2><i class="fa fa-pencil"></i> <strong>Información</strong> general</h2>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nombre">Nombre del negocio</label>
                                <div class="col-md-9">
                                    <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">
                                    <input type="text" autocomplete="off" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del proveedor">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="direccion">Dirección</label>
                                <div class="col-md-9">
                                    <textarea id="direccion" name="direccion" class="form-control" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="categoria">NIT</label>
                                <div class="col-md-9">
                                    <input type="text" name="nit" id="nit" class="form-control nit">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="email">Email</label>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="email" autocomplete="off" id="email" name="email" class="form-control" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Número de registro</label>
                                <div class="col-md-9">
                                    <input type="text" name="nrc" id="nrc" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Giro</label>
                                <div class="col-md-9">
                                    <input type="text" name="giro" id="giro" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-md-3 control-label">Agregar número de teléfono</label>
                                <div class="col-md-9">
                                    <button type="button" class="btn btn-primary" id="btn_agregar_telefono">Agregar</button>
                                </div>
                            </div>
                            <div class="form-group">
                                <table id="tels_aqui" class="table"></table>
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
    <?php endif ?>
    <!-- modal -->
    <div class="modal fade modal-side-fall" id="md_agregar_telefono" aria-hidden="true"
          aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                      <span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title">Agregar número de teléfono</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#" class="form-horizontal form-bordered">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="col-md-4 col-md-offset-2">Tipo</label>
                                    <div class="col-md-6">
                                        <select id="tipo_tel" class="form-control" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione el Municipio" readonly="" style="width: 100%;">
                                            <option value="">Seleccione</option>
                                            <option value="Teléfono">Teléfono</option>
                                            <option value="Móvil">Móvil</option>
                                            <option value="FAX">FAX</option>
                                            <option value="PBX">PBX</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-md-4 col-md-offset-2">Número</label>
                                    <div class="col-md-6">
                                        <input type="text" id="tel"  class="form-control telefono">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn_agre_tel" class="btn btn-primary btn-pure" style="display: none;">Agregar</button>
                    <button type="button" class="btn btn-primary btn-pure validar">Validar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<script src="empresa.js?cod=<?=$cod?>"></script>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>      
<?php include '../../inc/template_end.php'; ?>

