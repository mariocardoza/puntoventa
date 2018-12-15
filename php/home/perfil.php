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
include_once("../../Conexion/Perfil.php");

?>

<!-- Page content -->
<div id="page-content">

    <!-- Customer Content -->
    <div class="row">
        <div class="col-lg-4">
            <!-- Customer Info Block -->
                <?php echo Perfil::construir_perfil($_SESSION['usuario']) ?>
            <!-- END Customer Info Block -->
        </div>
        <div class="col-lg-8">
            <!-- Orders Block -->
            <div class="block">
                <!-- Orders Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <span class="label label-success"><strong>$ 2125,00</strong></span>
                    </div>
                    <h2><i class="fa fa-truck"></i> <strong>Ventas</strong> (4)</h2>
                </div>
                <!-- END Orders Title -->

                <!-- Orders Content -->
                <table class="table table-bordered table-striped table-vcenter">
                    <tbody>
                        <tr>
                            <td class="text-center" style="width: 100px;"><a href="page_ecom_order_view.php"><strong>ORD.685199</strong></a></td>
                            <td class="hidden-xs" style="width: 15%;"><a href="javascript:void(0)">5 Productos</a></td>
                            <td class="text-right hidden-xs" style="width: 10%;"><strong>$585,00</strong></td>
                            <td><span class="label label-warning">Processing</span></td>
                            <td class="hidden-xs">Paypal</td>
                            <td class="hidden-xs text-center">16/11/2014</td>
                            <td class="text-center" style="width: 70px;">
                                <div class="btn-group btn-group-xs">
                                    <a href="page_ecom_order_view.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><a href="page_ecom_order_view.php"><strong>ORD.685198</strong></a></td>
                            <td class="hidden-xs"><a href="javascript:void(0)">2 Productos</a></td>
                            <td class="text-right hidden-xs"><strong>$958,00</strong></td>
                            <td><span class="label label-info">For delivery</span></td>
                            <td class="hidden-xs">Credit Card</td>
                            <td class="hidden-xs text-center">03/10/2014</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="page_ecom_order_view.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><a href="page_ecom_order_view.php"><strong>ORD.685197</strong></a></td>
                            <td class="hidden-xs"><a href="javascript:void(0)">3 Products</a></td>
                            <td class="text-right hidden-xs"><strong>$318,00</strong></td>
                            <td><span class="label label-success">Delivered</span></td>
                            <td class="hidden-xs">Bank Wire</td>
                            <td class="hidden-xs text-center">17/06/2014</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="page_ecom_order_view.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><a href="page_ecom_order_view.php"><strong>ORD.685196</strong></a></td>
                            <td class="hidden-xs"><a href="javascript:void(0)">6 Products</a></td>
                            <td class="text-right hidden-xs"><strong>$264,00</strong></td>
                            <td><span class="label label-success">Delivered</span></td>
                            <td class="hidden-xs">Paypal</td>
                            <td class="hidden-xs text-center">27/01/2014</td>
                            <td class="text-center">
                                <div class="btn-group btn-group-xs">
                                    <a href="page_ecom_order_view.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="View"><i class="fa fa-eye"></i></a>
                                    <a href="javascript:void(0)" data-toggle="tooltip" title="" class="btn btn-xs btn-danger" data-original-title="Delete"><i class="fa fa-times"></i></a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Orders Content -->
            </div>
            <!-- END Orders Block -->

            <!-- Products in Cart Block -->
            <div class="block">
                <!-- Products in Cart Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <span class="label label-success"><strong>$ 517,00</strong></span>
                    </div>
                    <h2><i class="fa fa-shopping-cart"></i> <strong>Productos</strong> registrados (3)</h2>
                </div>
                <!-- END Products in Cart Title -->

                <!-- Products in Cart Content -->
                <table class="table table-bordered table-striped table-vcenter">
                    <tbody>
                        <tr>
                            <td class="text-center" style="width: 100px;"><a href="page_ecom_product_edit.php"><strong>PID.8715</strong></a></td>
                            <td class="hidden-xs" style="width: 15%;"><a href="page_ecom_product_edit.php">Product #98</a></td>
                            <td class="text-right hidden-xs" style="width: 10%;"><strong>$399,00</strong></td>
                            <td><span class="label label-success">Available (479)</span></td>
                            <td class="text-center" style="width: 70px;">
                                <a href="page_ecom_product_edit.php" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><a href="page_ecom_product_edit.php"><strong>PID.8725</strong></a></td>
                            <td class="hidden-xs"><a href="page_ecom_product_edit.php">Product #98</a></td>
                            <td class="text-right hidden-xs"><strong>$59,00</strong></td>
                            <td><span class="label label-success">Available (163)</span></td>
                            <td class="text-center">
                                <a href="page_ecom_product_edit.php" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center"><a href="page_ecom_product_edit.php"><strong>PID.8798</strong></a></td>
                            <td class="hidden-xs"><a href="page_ecom_product_edit.php">Product #98</a></td>
                            <td class="text-right hidden-xs"><strong>$59,00</strong></td>
                            <td><span class="label label-danger">Out of Stock</span></td>
                            <td class="text-center">
                                <a href="page_ecom_product_edit.php" data-toggle="tooltip" title="" class="btn btn-xs btn-default" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <!-- END Products in Cart Content -->
            </div>
            <!-- END Products in Cart Block -->
        </div>
    </div>
    <!-- END Customer Content -->
    <div class="modal" id="md_nuevo_pass" aria-hidden="true"
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
                      <input type="password" class="form-control" id="pass" name="pass" placeholder="Ingrese la contraseña">
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

<div class="modal" id="md_editar_perfil" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title">Editar perfil</h4>
          </div>
          <div class="modal-body">
            <form method="post" accept-charset="utf-8" name="fm_editar_perfil" id="fm_editar_perfil">
            <input type="hidden" name="data_id" value="editar_perfil">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Nombre(*)</label>
                      <input type="text" class="form-control" id="nombre" name="nombre" required="" placeholder="Ingrese el nombre" >
                      <input type="hidden" class="form-control" id="id_perfil" name="id" placeholder="Ingrese el nombre" >
                    </div>
                    <div class="form-group">
                      <label for="n_precio">Email(*)</label>
                      <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese el email" required="">
                    </div>
                    <div class="form-group">
                      <label for="np_nombre">Teléfono(*)</label>
                      <input type="text" required class="form-control telefono" id="telefono" name="telefono" aria-describedby="nombrelHelp" placeholder="Ingrese el teléfono">
                      <!--small id="nombrelHelp" class="form-text text-muted">Este campo es requerido no olvide completarlo</small-->
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Dirección(*):</label>
                        <textarea name="direccion" required class="form-control" id="direccion" cols="30" rows="4"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group"> 
                        <label class="control-label" for="rol">DUI(*):</label>
                        <input type="text" required name="dui" id="dui" class="form-control dui">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">NIT(*):</label>
                        <input type="text" required name="nit" id="nit" class="form-control nit">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Fecha de nacimiento(*):</label>
                        <input type="text" required name="fecha_nacimiento" id="fecha_nacimiento" autocomplete="off" class="form-control nacimiento">
                    </div>
                    <div class="form-group"> 
                        <label class="control-label" for="rol">Género(*):</label>
                        <select id="genero" required name="genero" class="form-control select_piker2" data-plugin="selectpicker" data-live-search="true" data-placeholder="Seleccione el Municipio" readonly="" style="width: 250px;">
                            <option value="" disabled="" selected="">seleccione..</option>
                            <option id="fem" value="Femenino">Femenino</option>
                            <option id="masc" value="Másculino">Másculino</option>
                            <!--option value="2">Cliente</option--> 
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <center>
                    <button type="button" class="btn btn-default btn-pure" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btn_guardar">Guardar</button>
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
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla
    $(function() {

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
       
        $(document).on("click", "#img_file", function (e) {
            $("#file_1").click();
        });
        $(document).on("click", "#btn_subir_img", function (e) {
            $("#file_1").click();
        });
        $("#file_1").change(function(event) {
            validar_archivo($(this));
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
        
    });
   function editar(id){
    $.ajax({
        url:'json_home.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'seleccionar_todo',id:id},
        success:function(json){
            console.log(json);
            $("#fecha_nacimiento").val(json[1].fecha);
            $("#nombre").val(json[1].nombre);
            $("#direccion").val(json[1].direccion);
            $("#dui").val(json[1].dui);
            $("#nit").val(json[1].nit);
            $("#email").val(json[1].email);
            $("#telefono").val(json[1].telefono);
            $("#id_perfil").val(json[1].id);
            if(json[1].genero=="Femenino"){
                $("#fem").attr("selected","selected");
                $(".select_piker2").selectpicker('refresh');
            }else{
                $("#masc").attr("selected","selected");
                $(".select_piker2").selectpicker('refresh');
            }
           
            $("#md_editar_perfil").modal("show");
        }
    })
    //
   }

   function cambiar_pass(id){
        $("#nombre_pass").text('<?php echo $_SESSION[nombre] ?>')
        $("#email_pass").val('<?php echo $_SESSION[usuario] ?>')
        $("#md_nuevo_pass").modal("show");
   }

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
                        title: "Excelente",
                        message: "La contraseña fue actualizada, inicie sesión con la nueva contraseña",
                        timeout: 6000,
                    });
                    timer=setInterval(function(){
                        location.href="destruir.php";                        
                        clearTimeout(timer);
                    },6000);
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