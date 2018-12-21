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
    <form action="#" method="post" name="fm_mesa" id="fm_mesa" class="form-horizontal form-bordered">
        <div class="block">
            <div class="block-title">
                <h2><i class="fa fa-pencil"></i> <strong>Información</strong> de la mesa</h2>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="nombre">Nombre</label>
                        <div class="col-md-9">
                            <input type="hidden" name="data_id" value="nueva_mesa">
                            <input type="hidden" name="codigo_oculto" value="<?php echo date('Yidisus') ?>">
                            <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del mesa">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <div class="col-md-10">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-sm btn-primary"><i class="fa fa-floppy-o"></i> Guardar</button>
                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>  
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- END Product Edit Content -->
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>


<!-- Load and execute javascript code used only in this page -->
<script src="../../js/helpers/ckeditor/ckeditor.js"></script>

<script>
    $(document).ready(function(e){
        $(document).on("click","#btn_guardar", function(e){
            var valid=$("#fm_mesa").valid();
            if(valid){
                var datos=$("#fm_mesa").serialize();
                $.ajax({
                    url:'json_mesas.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito("mesas");
                        }else{
                            guardar_error();
                        }
                    }
                });
            }
        });
    });
</script>      
<?php include '../../inc/template_end.php'; ?>

