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
include_once("../../Conexion/Servicio.php");
include_once("../../Conexion/Cliente.php");
$datos = null;
$servicios = Servicio::obtener_servicios();
$clientes = Cliente::obtener_todos();

//print_r($departamentos);
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
              <div class="col-sm-8 col-lg-8"><a href="javascript:void(0)" id="modal_guardar" class="btn btn-mio btn-block">Nueva reserva</a></div>
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
<!--script src="cliente.js?cod=<?php echo date("Yidisus") ?>"></script-->
<script type="text/javascript">
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla
    $("#titulo_nav").text("Reservas");
    $(document).ready(function(e){
      cargar_reservas();

    $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar").modal("show");
    });
                   //buscar con funcion input
    $(document).on("input","#busqueda", function(e){
      var esto=$(this).val();
      $.ajax({
        url:'json_reservas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
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

    $(document).on("click","#btn_editar",function(json){
      var valid=$("#fm_reserva").valid();
      if(valid){
        var datos=$("#fm_reserva").serialize();
        console.log(datos);
        modal_cargando();
        $.ajax({
          url:'json_reservas.php',
          type:'POST',
          dataType:'json',
          data:datos,
          success:function(json){
            if(json[0]==1){
              guardar_exito();
              $("#fm_reserva").trigger("reset");
              cargar_reservas();
              $(".modal").modal("hide");
            }else{
              swal.closeModal();
              guardar_error();
            }
          }
        });
      }
    });
    

    $("#fm_reserva").validate({
      ignore: ":hidden:not(select)",
      rules:{
        nombre:"required",
        precio:{
          required:true,
          number:true
        }
      },
        submitHandler: function(form) {
              //form.submit();
          guardar();
        }
      });      
    });

    function guardar(){
      modal_cargando();
      var datos=$("#fm_reserva").serialize();
      $.ajax({
        url:'json_reservas.php',
        type:'POST',
        dataType:'json',
        data:datos,
        success:function(json){
          if(json[0]==1){
              guardar_exito();
              $("#fm_reserva").trigger("reset");
              $("#md_guardar").modal("hide");
              console.log(json);
          }else{
              guardar_error();
              swal.closeModal();
          }
        }
      });
    }

    function editar(codigo){
      $.ajax({
        url:'json_reservas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_editar',codigo:codigo},
        success: function(json){
          if(json[0]==1){
            $("#modal_edit").html(json[2]);
            $("#md_editar").modal("show");
            $(".select-chosen").chosen({'width':'100%'});
          }
        }
      });
    }
    function cargar_reservas(){
      modal_cargando();
      $.ajax({
        url:'json_reservas.php',
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
</script>