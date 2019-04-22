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
include_once("../../Conexion/Categoria.php");
$datos = null;
$categorias = Categoria::obtener_categorias();
include_once("../../Conexion/Departamento.php");
$departamentos=Departamento::obtener_departamentos();
//print_r($departamentos);
if($categorias[0] == 1)$datos = $categorias[2];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row" style="background-color: #fff;">
      <div class="card">
        <div class="row centrado">
          <div class="col-xs-4 col-lg-4">
            <label for="">Digite para buscar</label>
            <div class="input-group">
                <input type="search" class="form-control" id="busqueda" placeholder="Buscar">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
            </div>
          </div>
          <div class="col-xs-4 col-lg-4">
            <label for="">Buscar por tipo</label>
            <select name="" id="tipos" class="select-chosen">
              <option value="">Todos</option>
              <option value="1">Crédito fiscal</option>
              <option value="2">Consumidor final</option>
              <option value="3">Ticket</option>
            </select>
          </div>
          <div class="col-xs-4 col-lg-4">
            <label for="">Buscar por mes</label>
            <select name="" id="mes" class="select-chosen">
              <option value="">Todos</option>
              <option value="01">Enero</option>
              <option value="02">Febrero</option>
              <option value="03">Marzo</option>
              <option value="04">Abril</option>
              <option value="05">Mayo</option>
              <option value="06">Junio</option>
              <option value="07">Julio</option>
              <option value="08">Agosto</option>
              <option value="09">Septiembre</option>
              <option value="10">Octubre</option>
              <option value="11">Noviembre</option>
              <option value="12">Diciembre</option>
            </select>
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
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla

    $(document).ready(function(e){
      //modal_cargando();
      cargar();
  
      //buscar con funcion input
      $(document).on("input","#busqueda", function(e){
        var esto=$(this).val();

        $.ajax({
          url:'json_ventas.php',
          type:'POST',
          dataType:'json',
          data:{data_id:'busqueda',esto,tipo:'',mes:''},
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

      // prueba para imprimir ticket
    $(document).on("click","#elticket", function(e){
      var venta=$(this).attr("data-venta");
           $.ajax({
               url: 'ticket.php',
               type: 'POST',
               data: {datos:venta},
               success: function(response){
                   if(response==1){
                       alert('Imprimiendo....');
                   }else{
                       alert('Error');
                   }
               }
           }); 
    });

        $(document).on("change","#tipos", function(e){
          $("#busqueda").val("");
          var tipo=$(this).val();
          var mes = $("#mes").val();
            $.ajax({
            url:'json_ventas.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'busqueda',esto:'',tipo:tipo,mes:mes},
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
        })

        $(document).on("change","#mes", function(e){
          $("#busqueda").val("");
          var tipo=$("#tipos").val();
          var mes = $(this).val();
            $.ajax({
            url:'json_ventas.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'busqueda',esto:'',tipo:tipo,mes:mes},
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
        })
      });

    function ver(id){
      $.ajax({
        url:'json_ventas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'ver_venta',id:id},
        success: function(json){
          $("#modal_edit").html(json[3]);
          $("#md_ver_venta").modal("show");
        }
      });
    }

    function cargar(){
      $.ajax({
        url:'json_ventas.php',
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