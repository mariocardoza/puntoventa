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
include_once("../../Conexion/Mesa.php");
$datos = null;
$mesas = Mesa::obtener_mesas();

//print_r($departamentos);

// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
  <div class="row" style="background-color: #fff;">
      <div class="card">
        <div class="row centrado">
          <div class="row">
            <div class="col-xs-2 col-lg-2"></div>
            <div class="col-xs-8 col-lg-8"><h1>Control de productos</h1></div>
            <div class="col-xs-2 col-lg-2"></div>
          </div>
        </div>
      </div>
      <div class="block" id="">
        <div class="block-title">
          <h3>Aviso de productos próximos a vencer</h3>
        </div>
       <table class="table" id="tablita1">
          <thead>
            <th>N°</th>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Lote</th>
            <th>Fecha de vencimiento</th>
            <th>Días restantes</th>
          </thead>
          <tbody id="tabla1"></tbody>      
        </table>
      </div>
      <div class="block">
        <div class="block-title">
          <h3>Aviso de productos con poco stock</h3>
        </div>
        <table class="table" id="tablita2">
          <thead>
            <th>N°</th>
            <th>Producto</th>
            <th>Tipo</th>
            <th>Stock actual</th>
            <th>Proveedor</th>
            <th>Acciones</th>
          </thead>
          <tbody id="tabla2"></tbody>      
        </table>
      </div>
      
    </div>
    <div id="modal_edit"></div>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>
<!--script src="cliente.js?cod=<?php echo date("Yidisus") ?>"></script-->
<script type="text/javascript">
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla

    $(document).ready(function(e){
      //cargar_mesas();
      $("#titulo_nav").text("Avisos");
     cargar_notificaciones();

    });

    function cargar_notificaciones(){
      modal_cargando();
      $.ajax({
        url:'json_notificaciones.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda'},
        success: function(json){
          console.log(json);
            if(json[2]){
                $("#tabla1").empty();
                $("#tabla1").html(json[2]);
                swal.closeModal();
                cargar_tabla2("tablita1");
            }else{
                $("#tabla1").empty();
                $("#tabla1").html(no_datos);
                swal.closeModal();
            }
            if(json[3]){
                $("#tabla2").empty();
                $("#tabla2").html(json[3]);
                cargar_tabla2("tablita2");
                swal.closeModal();
            }else{
                $("#tabla2").empty();
                $("#tabla2").html(no_datos);
                swal.closeModal();
            }
        }
      });
    }
</script>