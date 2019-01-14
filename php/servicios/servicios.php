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
include_once("../../Conexion/Empleado.php");
$datos = null;
$servicios = Servicio::obtener_servicios();
$empleados = Empleado::obtener_empleados();

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
              <div class="col-sm-8 col-lg-8"><a href="javascript:void(0)" id="modal_guardar" class="btn btn-mio btn-block">Nuevo servicio</a></div>
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
<script src="servicios.js?cod=<?php echo date("Yidisus") ?>"></script>
<script type="text/javascript">
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla

    $(document).ready(function(e){
      $(document).on("click","#btn_guardar", function(e){
        modal_cargando();
            var valid=$("#fm_servicios").valid();
            if(valid){
                var datos=$("#fm_servicios").serialize();
                $.ajax({
                    url:'json_servicios.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito();
                            $(".modal").modal("hide");
                            cargar();
                        }else{
                          swal.close();
                            guardar_error();
                        }
                    }
                });
            }
        });
    });

    $(document).ready(function(e){
      $(document).on("click","#btn_guardar_n", function(e){
        modal_cargando();
            var valid=$("#fm_servicios").valid();
            if(valid){
                var datos=$("#fm_servicios").serialize();
                $.ajax({
                    url:'json_servicios.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito();
                            $(".modal").modal("hide");
                            cargar();
                        }else{
                          swal.close();
                            guardar_error();
                        }
                    }
                });
            }
        });
    });

    function editar(id){
      $.ajax({
        url:'json_servicios.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_editar',id:id},
        success: function(json){
          $("#modal_edit").html(json[3]);
          $('.select-chosen').chosen({width: "100%"});
          $("#md_editar").modal("show");
        }
      });
    }

    function cargar(){
      $.ajax({
        url:'json_servicios.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:''},
        success: function(json){
          console.log(json);
            var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
            if(json[2]){
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(json[2]);
                swal.closeModal();
            }else{
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(html);
                swal.closeModal();
            }
        }
      });
    }
</script>