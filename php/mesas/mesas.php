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
          <div class="col-sm-3 col-lg-3">
              <div class="row">
                <div class="col-sm-2 col-lg-2"></div>
                <div class="col-sm-8 col-lg-8"><a id="modal_guardar" href="javascript:void(0)" class="btn btn-mio btn-block">Nueva mesa</a></div>
                <div class="col-sm-2 col-lg-2"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="" id="aqui_busqueda" style="height: 700px;">
       
      </div>
      
    </div>
    <div id="modal_edit"></div>
    <div class="modal fade depa" id="md_guardar" aria-hidden="true"
      aria-labelledby="exampleModalTitle" role="dialog" tabindex="-1" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                  <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Registrar mesa</h4>
            </div>
            <div class="modal-body">
                    <form action="#" method="post" name="fm_mesas" id="fm_mesas" class="form-horizontal">
            
                        <div class="form-group">
                            <label class="control-label" for="nombre">Nombre</label>
                                <input type="hidden" name="data_id" value="nueva_mesa">  
                                <input type="hidden" name="codigo_oculto" value="<?php echo date("Yidisus") ?>">
                                <input required type="text" id="nombre" name="nombre" class="form-control" placeholder="Digite el nombre del departamento">
                        </div>
                        <div class="form-group">
                            <center>
                                <button type="button" id="btn_guardar" class="btn btn-sm btn-mio">Guardar</button>
                                <button type="button" data-dismiss="modal" class="btn btn-sm btn-defaul"> Cerrar</button>
                            </center>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>
<!--script src="cliente.js?cod=<?php echo date("Yidisus") ?>"></script-->
<script type="text/javascript">
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla

    $(document).ready(function(e){
      cargar_mesas();
      
      $("#titulo_nav").text("Mesas");
      $(document).on("click","#btn_guardar", function(e){
            var valid=$("#fm_mesas").valid();
            if(valid){
              modal_cargando();
                var datos=$("#fm_mesas").serialize();
                $.ajax({
                    url:'json_mesas.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito();
                            cargar_mesas();
                            $(".modal").modal("hide");
                            $("#data_id").val("");
                            $("#id").val("");
                            $("#codigo_oculto").val("");
                            $("#nombre").val("");
                        }else{
                          swal.close();
                            guardar_error();
                        }
                    }
                });
            }
        });

      $(document).on("click","#modal_guardar", function(e){
        $("#md_guardar").modal("show");
      });
    });

    function editar(id){
      $.ajax({
        url:'json_mesas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_editar',id:id},
        success: function(json){
          $("#modal_edit").html(json[2]);
          $("#md_editar").modal("show");
        }
      });
    }

    function cargar_mesas(){
      modal_cargando();
      $.ajax({
        url:'json_mesas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda'},
        success: function(json){
          console.log(json);
            if(json[2]){
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(json[2]);
                $(".draggable" ).draggable({
                  addClasses: false
                });
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