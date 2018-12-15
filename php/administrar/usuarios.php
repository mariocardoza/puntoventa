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
?>

<?php include '../../inc/config.php'; ?>
<?php include '../../inc/template_start.php'; ?>
<style type="text/css" media="screen">
    .block-title h2 {
        font-size: 23px;
    }
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/administracion/Usuarios.php");
include_once("../../Conexion/Empleado.php");
$datos = null;
$result = Usuarios::get_usuario_personas();
$result2 = Empleado::obtener_empleados_guardar();
//print_r($empleados[1]);
$empleados=$result2[1];
if($result[0] == 1)$datos = $result[1];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row">
      <div class="col-xs-12">
        <div class="block full">
          <div class="block-title">
            <h2> <strong> Usuarios (<?=count($datos)?>)</strong></h2>
          </div>
          <div class="">
            <table id="exampleTableSearch" class="table table-vcenter table-condensed table-bordered" >
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Nivel</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Email</th>
                  <th>Nivel</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php $n=1; foreach ($datos as $row) { ?>
                <tr id="tr_<?=$n?>">
                  <td ><?=$n?></td>
                  <td class="nombre"><?=($row['nombre'])?></td>
                  <td nowrap class="email"><?=($row['email'])?></td>
                  <td class="nivel"><?=($row['n_nivel'])?></td>
                  <td nowrap class="text-center actions">
                    <div class="btn-group">
                      <a class="btn btn-warning" data-id="<?php echo $row[email] ?>" href="#" id="nuevo_pass" title="Generar nueva contraseña"><span class="fa fa-key"></span></a>
                      <a class="btn btn-primary" title="Cambiar contraseña" data-nombre="<?php echo $row[nombre] ?>" data-correo="<?php echo $row[email] ?>" id="cambiar_pass" href="#"><i class="fa fa-key"></i></a>
                    </div>
                  </td>
                </tr>
                <?php 
                  $n++;}
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade modal-side-fall" id="md_nuevo_pass" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Cambiar contraseña a <b><span id="nombre_pass"></span></b></h4>
          </div>
          <div class="modal-body">
          <form method="post" accept-charset="utf-8" id="fm_cambiar_pass">
            <input type="hidden" name="data_id" value="cambiar_pass">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="pass">Contraseña(*)</label>
                      <input type="hidden" name="email_pass" id="email_pass">
                      <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingrese el contraseña">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label" for="repass">Repetir contraseña(*):</label>
                        <input type="password" name="repass" id="repass" placeholder="Repetir contraseña" class="form-control">
                    </div> 
                </div>
            </div>
            <div class="col-md-12">
                <center>
                    <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
                    <button type="sutmit" class="btn btn-primary" id="btn_cambiar_pass">Guardar</button>
                </center>
            </div> 
          </form>
          </div>
          <div class="modal-footer"></div>
        </div>
      </div>
    </div>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>

<script type="text/javascript">
    var correo_g = "";
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla
    $(function() {
       
        //generar nueva contraseña
        $(document).on("click","#nuevo_pass", function(e){
          var valor = $(this).attr('data-id');
            //var estado = $(this).attr('data-estado');
            
            console.log(valor);
            NProgress.start();
            var get = { elcorreo:valor,des:"1"};
            console.log(get);
            $.ajax({
                dataType: "json",
                method: "POST",
                url:'../json/generar_pass.php',
                data : get,
            }).done(function(msg) {
                console.log("esto trae",msg);
                
                if(msg.exito[0]=='1'){
                        $.bootstrapGrowl('<h4>Excelente !</h4> <p>Se ha enviado un correo con la nueva contraseña al usuario!</p>', {
                        type: "success",
                        delay: 2500,
                        allow_dismiss: true
                    });

                    NProgress.done();
                    var timer=setInterval(function(){
                        location.reload();
                        clearTimeout(timer);
                    },2500);
                    
                }
                else {
                    NProgress.done();
                    $.bootstrapGrowl('<h4>Error!</h4> <p>no se generó la nueva contraseña !</p>', {
                        type: "danger",
                        delay: 2500,
                        allow_dismiss: true
                    });
                }

            });
        });

        //lanzar modal para cambiar contraseña
        $(document).on("click","#cambiar_pass", function(e){
            var correo=$(this).attr("data-correo");
            var nombre=$(this).attr("data-nombre");
            $("#nombre_pass").text(nombre);
            $("#email_pass").val(correo);
            $("#md_nuevo_pass").modal("show");
        });

        //establecer contraseña manualmente
        $("#fm_cambiar_pass").validate({
            ignore: ":hidden:not(select)",
            rules: {
                pass: "required",
                repass:{
                    required:true,
                    equalTo:"#pass"
                }
            },
            
            messages: {
                pass: "Por favor digite la contraseña",
                repass:{
                    required:"Por favor repita la contraseña",
                    equalTo:"La contraseña no coincide"
                }
            },
            submitHandler: function(form) {
              //form.submit();
              guardar();
            }
        });
        
       
        $(document).on("click", "#img_file", function (e) {
            $("#file_1").click();
        });
        $(document).on("click", "#btn_subir_img", function (e) {
            $("#file_1").click();
        });
        $("#file_1").change(function(event) {
            validar_archivo($(this));
        });
    });
   function guardar(){
        var datos=$("#fm_cambiar_pass").serialize();
        console.log(datos);
        $.ajax({
            url:'../json/json_generico.php',
            type:'POST',
            dataType:'json',
            data:datos,
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    iziToast.success({
                        title: EXITO,
                        message: EXITO_MENSAJE,
                        timeout: 3000,
                    });
                    timer=setInterval(function(){
                        location.reload();                        
                        clearTimeout(timer);
                    },2000);
                     NProgress.done();
                }else{
                    swal.close();
                    iziToast.error({
                      title: 'Error',
                      message: 'Hubo un problema al procesar al cambiar la contraseña, contante al administrador',
                      timeout: 3000,
                    });
                }
            }
        });
    }
</script>