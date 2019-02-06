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
include_once("../../Conexion/Departamento.php");
$datos = null;
$departamentos = Departamento::obtener_departamentos();

//print_r($departamentos);
if($departamentos[0] == 1)$datos = $departamentos[1];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row" style="background-color: #fff;">
      <div class="card">
        <div class="row centrado">
          <div class="col-sm-4 col-lg-4">
            <div class="input-group">
                <input type="search" class="form-control" id="busqueda" placeholder="Buscar">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
          </div>
          <div class="col-sm-4 col-lg-4">
            <div class="row">
              <div class="col-sm-2 col-lg-2"></div>
              <div class="col-sm-8 col-lg-8"><a href="registro_receta.php" id="modal_guardar" class="btn btn-mio btn-block">Nueva receta</a></div>
              <div class="col-sm-2 col-lg-2"></div>
          </div>
          </div>
        </div>
      </div>
      <div class="" id="aqui_busqueda">
      </div>
    </div>
    <div id="modal_edit"></div>
    <?php include 'modal.php'; ?>

</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>
<!--script src="cliente.js?cod=<?php echo date("Yidisus") ?>"></script-->
<script type="text/javascript">
    $("#titulo_nav").text("Recetas");
    $(document).ready(function(e){
      cargar_recetas();

    $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar").modal("show");
    });

    //eventos para la imagen
  $(document).on("click", "#img_file", function (e) {
        $("#file_1").click();
    });
    $(document).on("click", "#btn_subir_img", function (e) {
        $("#file_1").click();
    });
    $(document).on("change","#file_1",function(event) {
      console.log("llega");
        validar_archivo($(this));
    });
                   //buscar con funcion input
    $(document).on("input","#busqueda", function(e){
      var esto=$(this).val();
      $.ajax({
        url:'json_recetas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto},
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

      ///guardar 
      $(document).on("click","#btn_guardar", function(e){
            var valid=$("#form_receta").valid();
            if(valid){
                modal_cargando();
                var datos=$("#form_receta").serialize();
                $.ajax({
                    url:'json_recetas.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                          if ($("#file_1").val()!="") {
                            insertar_imagen($("#file_1"),json[2][2]);
                          }else{
                            guardar_exito();
                            $(".modal").modal("hide");
                            $(".form-control").val("");
                            cargar_recetas();
                            console.log(json);
                          }  
                        }else{
                            guardar_error();
                        }
                    }
                });
            }
        });
    });

    function editar(id){
      $.ajax({
        url:'json_recetas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_editar',id:id},
        success: function(json){
          $("#modal_edit").html(json[2]);
          $(".select-chosen").chosen({'width':'100%'});
          $("#md_editar").modal("show");
        }
      });
    }
    function ver(id){
      $.ajax({
        url:'json_recetas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_ver',id:id},
        success: function(json){
          console.log(json);
          $("#modal_edit").html(json[2]);
          $("#md_ver_receta").modal("show");
        }
      });
    }
    function cargar_recetas(){
      modal_cargando();
      $.ajax({
            url:'json_recetas.php',
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
  formData.append('formData', $("#form_receta"));
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
              guardar_exito();
              $(".modal").modal("hide");
              $(".form-control").val("");
              cargar_recetas();
              console.log(json);
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