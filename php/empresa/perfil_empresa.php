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
include_once("../../Conexion/Empresa.php");
$empresa = Empresa::datos_empresa();
$datos = Empresa::totales();
?>

<!-- Page content -->
<div id="page-content">

    <!-- Customer Content -->
    <div class="row">
        <div class="col-lg-4">
            <!-- Customer Info Block -->
                <?php echo Empresa::construir_perfil($_SESSION['usuario']) ?>
            <!-- END Customer Info Block -->
        </div>
        <div class="col-lg-8">
            <div class="block">
                <div class="block-title">
                    <h2><i class="fa fa-home"></i> <strong>Efectivo por ventas mensuales</strong></h2>
                </div>
                <div class="row">
                    <table class="table">

                        <tr>
                           <th><h1>Ventas en efectivo:</h1></th>
                           <td><h1>$<?php echo number_format($datos[0],2); ?></h1></td>
                           <td><a href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td> 
                        </tr>
                        <tr>
                           <th><h1>Ventas por cobrar:</h1></th>
                           <td><h1>$<?php echo number_format($datos[1],2); ?></h1></td>
                           <td><a href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td>  
                        </tr>
                        <tr>
                            <th><h1>Venta con tarjeta:</h1></th>
                            <td><h1>$<?php echo number_format($datos[2],2); ?></h1></td>
                            <td><a href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td> 
                        </tr>
                        <tr>
                           <th><h1>Todas por ventas:</h1></th>
                           <td><h1><b>$<?php echo number_format($datos[3],2); ?></b></h1></td> 
                           <td><a href="javascript:void(0)"><img src="../../img/iconos/ojo.svg" width="35px" height="35px"></a></td> 
                        </tr>
                    </table>
                </div>              
            </div>
        </div>
        <div class="col-lg-8">
           

            <!--div class="block">
               
                <div class="block-title">
                    <h2><i class="fa fa-home"></i> <strong>Sucursales</strong>  </h2>
                    <button class="btn btn-mio pull-right" type="button" data-codigo="<?php echo $empresa[codigo_oculto] ?>" id="nueva_sucur">Nueva</button>
                </div>
             
               
                <table class="table table-bordered table-striped table-vcenter" id="tb_">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php print_r(Empresa::obtener_sucursales()); ?>
                    </tbody>
                </table>
               
            </div-->
            <div class="block">
                <!-- Orders Title -->
                <div class="block-title">
                    <h2><i class="fa fa-user"></i> <strong>Ventas</strong></h2>
                </div>
                <!-- END Orders Title -->

                <!-- Orders Content -->
                <table class="table table-bordered table-striped table-vcenter" id="tabla">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Empleado</th>
                            <th>Monto de la venta</th>
                            <th>Factura</th>
                            <th>Tipo de venta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php print_r(Empresa::obtener_empleados()); ?>
                    </tbody>
                </table>
                <!-- END Orders Content -->
            </div>
            <!-- END Orders Block -->

            <!-- Products in Cart Block -->
            
            <!-- END Products in Cart Block -->
        </div>
    </div>
    <!-- END Customer Content -->
    

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
<?php include 'modal.php'; ?>
</div>


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>

<script type="text/javascript">
    var tabla = cargar_tabla2("tabla");//inicializar tabla
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

        $(document).on("click","#nueva_sucur", function(e){
            var empresa=$(this).attr("data-codigo");
            $("#empresa").val(empresa);
            $("#md_nueva_sucur").modal("show");
        });

        $(document).on("click","#btn_guardar_sucur", function(e){
            var valid = $("#fm_sucursal").valid();
            if(valid){
                var datos=$("#fm_sucursal").serialize();
                $.ajax({
                    url:'json_empresa.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success: function(json){
                        if(json[0]==1){
                            guardar_exito();
                            window.location.href="perfil_empresa.php";
                        }else{
                            guardar_error();
                        }
                    }
                });
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

        $(document).on("click","#subir_imagen", function(e){
            var codigo=$("#codiguito").val();
            insertar_imagen($("#file_1"),codigo);
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


    function cambiar_foto(){
        $("#md_cambiar_imagen").modal("show");
    }

    //funcion que validad que el archivo sea una imagen
    function validar_archivo(file){
            $("#img_file").attr("src","../../img/imagenes_subidas/image.svg");//31.gif
                //var ext = file.value.match(/\.(.+)$/)[1];
                 //Para navegadores antiguos
                 if (typeof FileReader !== "function") {
                    $("#img_file").attr("src",'../../img/imagenes_subidas/image.svg');
                    return;
                 }
                 var Lector;
                 var Archivos = file[0].files;
                 var archivo = file;
                 var archivo2 = file.val();
                 if (Archivos.length > 0) {

                    Lector = new FileReader();

                    Lector.onloadend = function(e) {
                        var origen, tipo, tamanio;
                        //Envia la imagen a la pantalla
                        origen = e.target; //objeto FileReader
                        //Prepara la información sobre la imagen
                        tipo = archivo2.substring(archivo2.lastIndexOf("."));
                        console.log(tipo);
                        tamanio = e.total / 1024;
                        console.log(tamanio);

                        //Si el tipo de archivo es válido lo muestra, 

                        //sino muestra un mensaje 

                        if (tipo !== ".jpeg" && tipo !== ".JPEG" && tipo !== ".jpg" && tipo !== ".JPG" && tipo !== ".png" && tipo !== ".PNG") {
                            $("#img_file").attr("src",'../../img/imagenes_subidas/photo.svg');
                            $("#error_formato1").removeClass('hidden');
                            //$("#error_tamanio"+n).hide();
                            //$("#error_formato"+n).show();
                            console.log("error_tipo");
                        }
                        else{
                            $("#img_file").attr("src",origen.result);
                            $("#error_formato1").addClass('hidden');
                        }


                   };
                    Lector.onerror = function(e) {
                    console.log(e)
                   }
                   Lector.readAsDataURL(Archivos[0]);
           }
           
        }

    //subir la imagen
    function insertar_imagen(archivo,id_prod){
        var file =archivo.files;
        var formData = new FormData();
        formData.append('formData', $("#form-producto"));
        var data = new FormData();
         //Append files infos
         jQuery.each(archivo[0].files, function(i, file) {
            data.append('file-'+i, file);
         });

         console.log("data",data);
         $.ajax({  
            url: "json_imagen.php?id="+id_prod,  
            type: "POST", 
            dataType: "json",  
            data: data,  
            cache: false,
            processData: false,  
            contentType: false, 
            context: this,
            success: function (json) {
                console.log(json);
                if(json.exito){  
                    iziToast.success({
                        title: 'Excelente',
                        message: 'Datos almacenados correctamente',
                        timeout: 3000,
                    });
                    timer=setInterval(function(){
                        location.reload();                        
                        clearTimeout(timer);
                    },2000);
                     NProgress.done();
                }
                if(json.error){
                    swal.close();
                    swal({
                      title: '¡Advertencia!',
                      html: $('<div>')
                      .addClass('some-class')
                      .text('No se logro insertar la imagen'),
                      animation: false,
                      allowEscapeKey:false,
                      allowOutsideClick:false,
                      customClass: 'animated tada',
                            //timer: 2000
                          }).then(function (result) {
                            //$("#md_cantidad").focus();
                            
                          });
                }

            }
        });
    }
</script>