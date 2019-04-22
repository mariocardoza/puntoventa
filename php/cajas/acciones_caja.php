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
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Cliente.php");
$naturales=Cliente::obtener_naturales();
$juridicos=Cliente::obtener_juridicos();
?>

<!-- Page content -->
<div id="page-content">
    <div class="row" style="background-color: #fff;">
      <div class="card">
        <div class="row centrado">
          <div class="col-xs-3 col-lg-3">
            <div class="input-group">
              <input type="search" class="form-control" id="busqueda" placeholder="Buscar">
              <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
          </div>
          <div class="col-xs-6 col-lg-6">
            <div class="row">
              <div class="col-xs-2 col-lg-2"></div>
              <div class="col-xs-8 col-lg-8"><a id="modal_guardar" href="javascript:void(0)" class="btn btn-mio btn-block">Registrar apertura o cierre de caja</a></div>
              <div class="col-xs-2 col-lg-2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="">
        <table class="table" id="tabla1">
          <thead>
            <th>Fecha</th>
            <th>Caja</th>
            <th>Monto de apertura</th>
            <th>Descripción</th>
            <th>Acciones</th>
          </thead>
          <tbody id=""></tbody>      
        </table>    
      </div>
      
    </div>
    <!-- END Quick Stats -->

    
    <!-- END All Products Block -->
    <div id="aqui_modal"></div>
    <?php include("modales.php") ?>
</div>

<!-- modales -->


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<!-- Load and execute javascript code used only in this page -->
<script src="../../js/pages/ecomProducts.js"></script>
<script>
  $(document).ready(function(e){
    $("#titulo_nav").text("Cajas registradoras");
    //cargar_movimientos();
    $(document).on("click","#modal_guardar", function(e){
      e.preventDefault();
      $("#md_guardar").modal("show");
    });

    $(document).on("click","#btn_guardar",function(e){
      var valid = $("#fm_caja").valid();
      if(valid){
        modal_cargando();
        var datos = $("#fm_caja").serialize();
        $.ajax({
          url:'json_cajas.php',
          type:'POST',
          dataType:'json',
          data:datos,
          success:function(json){
            console.log(json);
            if(json[0]==1){
              guardar_exito();
              $("#fm_caja").trigger("reset");
              $(".modal").modal("hide");
              swal.closeModal();
              cargar_movimientos();
            }else{
              guardar_error();
              swal.closeModal();
            }
          }
        });
      }
    });
  });

  function cargar_movimientos(){
    modal_cargando();
    $.ajax({
      url:'json_cajas.php',
      type:'POST',
      dataType:'json',
      data:{data_id:'cargar_movimientos'},
      success: function(json){
        if(json[2]){
          $("#cuerpo").empty();
          $("#tabla1").append(json[2]);
          cargar_tabla2("tabla1");
          swal.closeModal();
        }else{
          cargar_tabla2("tabla1");
          swal.closeModal();
        }
      }
    });
  }
</script>
<?php include '../../inc/template_end.php'; ?>

