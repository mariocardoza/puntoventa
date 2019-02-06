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
include_once("../../Conexion/Empleado.php");
$datos = null;
$result = Empleado::obtener_empleados();
//print_r($result);
if($result[0] == 1)$datos = $result[1];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row" style="background-color: #fff;">
      <div class="card">
        <div class="row centrado">
          <div class="col-xs-4 col-lg-4">
            <label for="" class="control-label">Buscar</label>
            <div class="input-group">
                <input type="search" class="form-control" id="busqueda" placeholder="Buscar">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
          </div>
          <div class="col-xs-4 col-lg-4">
            <label for="" class="control-label">Estado</label>
            <select name="" id="estados" class="select-chosen">
              <option value="">Todos</option>
              <option value="1">Activos</option>
              <option value="2">Inactivos</option>
            </select>
          </div>
          <div class="col-xs-4 col-lg-4">
            <div class="row">
              <div class="col-sm-2 col-lg-2"></div>
              <div class="col-sm-8 col-lg-8"><a href="javascript:void(0)" id="btn_nuevo" class="btn btn-mio btn-block">Nuevo empleado</a></div>
              <div class="col-sm-2 col-lg-2"></div>
          </div>
          </div>
        </div>
      </div>
      <div class="" id="aqui_busqueda">
      </div>
    </div>

    <div id="modal_edit"></div>
    <?php include 'modales.php'; ?>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>

<script type="text/javascript">
    var correo_g = "";
    var cod_ed = "";
    var nom_ed = "";
    var data_n = -1;
    var validar_cambios=val_email=val_tel= false;
    $("#titulo_nav").text("Empleados");
    $(function() {
      cargar_empleados();
        $(document).on("input","#busqueda", function(e){
          var esto=$(this).val();
          var estado=$("#estados").val();
          $.ajax({
            url:'../../Conexion/administracion/data_json.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'busqueda',esto,estado},
            success: function(json){
              console.log(json);
              if(json[2]){
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(json[2]);
              }else{
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(no_datos);
              }
          }
        });
      });

        $(document).on("change","#estados", function(e){
          var estado=$(this).val();
          $("#busqueda").val("");
          var esto="";
          $.ajax({
            url:'../../Conexion/administracion/data_json.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'busqueda',esto,estado},
            success: function(json){
              console.log(json);
              if(json[2]){
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(json[2]);
              }else{
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(no_datos);
              }
          }
        });
        });

        $(document).on("change","input:radio[name=es_usuario]:checked",function(e){
          var esto = $(this).val();
          if(esto=='si'){
            $("#leveles").show();
          }
          if(esto=='no'){
            $("#leveles").hide();
          }
        });


        $(document).on('input', '#n_email', function(event) {
            validar_cambios = false;
            $(".guarda1").addClass("hide");
            $(".valida1").removeClass("hide");
        });
        $(document).on("blur","#n_nit", function(e){
          e.preventDefault();
          var valor=$(this);
          if(valor.val() != ""){
            validar_nit(valor.val(),"tb_persona",valor);
          }
        });
        $(document).on("blur","#n_dui", function(e){
          e.preventDefault();
          var valor=$(this);
          if(valor.val() != ""){
            validar_dui(valor.val(),"tb_persona",valor);
          }
        });
        $(document).on('blur', '#n_email', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (correo_g != valor.val() && valor.val() != "") {
                $.ajax({
                    url: "../../Conexion/administracion/data_json.php",
                    dataType: "json",
                    data: { data_id: "val_email", email: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_email = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El E-mail ingresado ya fue registrado. Por favor ingrese uno diferente'),
                                animation: false,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                customClass: 'animated tada',
                                //timer: 2000
                            }).then(function(result) {
                                //$("#md_cantidad").focus();
                                valor.val("");
                                valor.focus();
                            });
                        } else {
                            val_email = true;
                            $(".valida1").trigger("click");
                        }
                    }
                });
            }
        });
        $(document).on('blur', '#n_telefono', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                $.ajax({
                    url: "../../Conexion/administracion/data_json.php",
                    dataType: "json",
                    data: { data_id: "val_tel", email: valor.val() },
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if (json[1]) {
                            val_tel = false;
                            swal({
                                title: '¡Advertencia!',
                                html: $('<div>')
                                    .addClass('some-class')
                                    .text('El teléfono ingresado ya fue registrado. Por favor ingrese uno diferente'),
                                animation: false,
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                customClass: 'animated tada',
                                //timer: 2000
                            }).then(function(result) {
                                //$("#md_cantidad").focus();
                                valor.val("");
                                valor.focus();
                            });
                        } else {
                            val_tel = true;
                            $(".valida1").trigger("click");
                        }
                    }
                });
            }
        });

        $(document).on("click", "#btn_nuevo", function (e) {
            $(".guarda1").addClass("hide");
            $(".valida1").removeClass("hide");
            $("#n_nombre").val("");
            $("#n_email").val("");
            $("#n_telefono").val("");
            $("#md_nuevo").modal({
                show: 'false'
            }); 
        });

        $(document).on("click","#cambiar_pass", function(e){
          $("#md_cambiar_pass").modal("show");
          var email=$(this).attr("data-email");
          var nombre=$(this).attr("data-nombre");
          $("#nombre_pass").text(nombre);
          $("#email_pass").val(email);
        });

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
              cambiar_pass();
            }
        });

        //boton para actualizar
        $(document).on("click",'#btn_actualizar', function(e){
          var valid = $("#fm_editar_empleado").valid();
          if(valid){
            var datos = $("#fm_editar_empleado").serialize();
            console.log(datos);
            $.ajax({
                url: "../../Conexion/administracion/data_json.php",
                dataType: "json",
                data: datos,
                method: "POST",
                success: function(json) {
                    console.log(json);
                    if(json[0]==1){
                        if ($("#file_1").val()!="") {
                                insertar_imagen($("#file_1"),json[3]);
                            }else{
                                guardar_exito();
                                var timer=setInterval(function(){
                                    $(".modal").modal('hide');
                                   cargar_empleados();
                                   $(".form-control").val("");
                                    clearTimeout(timer);
                                },3500);
                            }
                    }else{
                        swal.close();
                        guardar_error();
                    }
                }
            });
          } 
        });
        /*** boton guardar nuevo ****/
        $(document).on("click", "#btn_guardar", function(e) {
            console.log("guardar");
            var valid = $("#fm_nuevo_empleado").valid();
            if (valid) {
                var datos = $("#fm_nuevo_empleado").serialize();
                console.log(datos);
                console.log(valid);
                $('#md_nuevo').modal('toggle');
                swal({
                    title: '¡Cargando!',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    onOpen: function() {
                        swal.showLoading()
                    }
                });
                $.ajax({
                    url: "../../Conexion/administracion/data_json.php",
                    dataType: "json",
                    data: datos,
                    method: "POST",
                    success: function(json) {
                        console.log(json);
                        if(json[0]==1){
                            if ($("#file_1").val()!="") {
                                insertar_imagen($("#file_1"),json[1][0]);
                            }else{
                                guardar_exito();
                                var timer=setInterval(function(){
                                    $("#md_nuevo").modal('toggle');
                                   cargar_empleados();
                                   $(".form-control").val("");
                                    clearTimeout(timer);
                                },3500);
                            }
                        }else{
                            swal.close();
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
        $(document).on("change","#file_1", function(e){
          validar_archivo($(this));
        });

    });
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

    function insertar_imagen(archivo,id_prod){
        var file =archivo.files;
        var formData = new FormData();
        formData.append('formData', $("#fm_nuevo_empleado"));
        var data = new FormData();
         //Append files infos
         jQuery.each(archivo[0].files, function(i, file) {
            data.append('file-'+i, file);
         });

         console.log("data",data);
         $.ajax({  
            url: "../../Conexion/administracion/data_json_imagen.php?id="+id_prod,  
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
                    guardar_exito();
                    var timer=setInterval(function(){
                        $(".modal").modal('hide');
                       cargar_empleados();
                       $(".form-control").val("");
                        clearTimeout(timer);
                    },3500);
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

    // funcion para cargar modal de editar
    function editar(id){
      $.ajax({
        url: "../../Conexion/administracion/data_json.php",  
        type: 'GET',
        dataType: 'json',
        data: {id:id,data_id:'modal_editar'},
        success: function(json){
          console.log(id);
          $("#modal_edit").html(json[3]);
          $("#md_editar").modal('show'); // lanza el modal
        }
      });
    }

    function ver(id){
      $.ajax({
        url: "../../Conexion/administracion/data_json.php",  
        type: 'GET',
        dataType: 'json',
        data: {id:id,data_id:'modal_ver'},
        success: function(json){
          console.log(id);
          $("#modal_edit").html(json[2]);
          $("#md_ver_empleado").modal('show'); // lanza el modal
        }
      });
    }

    function cargar_empleados(){
      modal_cargando();
      $.ajax({
            url:'../../Conexion/administracion/data_json.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'busqueda',esto:''},
            success: function(json){
              console.log(json);
                if(json[2]){
                    $("#aqui_busqueda").empty();
                    $("#aqui_busqueda").html(json[2]);
                    swal.closeModal();
                }else{
                    $("#aqui_busqueda").empty();
                    $("#aqui_busqueda").html(no_datos);
                    swal.closeModal();
                }
            }
          });
    }

    function cambiar_pass(){
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
                    guardar_exito();
                    timer=setInterval(function(){
                        location.href="../home/destruir.php";                        
                        clearTimeout(timer);
                    },6000);
                     NProgress.done();
                }else{
                    swal.close();
                    guardar_error();

                }
            }
        });
    }
</script>