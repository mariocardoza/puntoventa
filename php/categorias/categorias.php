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

//print_r($departamentos);
if($categorias[0] == 1)$datos = $categorias[2];
// else print_r($result);
?>

<!-- Page content -->
<div id="page-content">
    <div class="row">
      <div class="col-xs-12">
        <div class="block full">
          <div class="block-title">
            <ul class="nav-horizontal">
              <li class="active">
                <a href="#">Categorias (<?=count($datos)?>)</a>
              </li>
              <li class="pull-right">
              <a href="registro_categoria.php" class="btn btn-lg bg-white"><i class="fa pull-left" style="width: 20px;"><img src="../../img/icon_mas.svg" class="svg" alt=""></i> Agregar categoría</a>
              </li>
            </ul>
          </div>
          <div class="">
            <table id="exampleTableSearch" class="table table-vcenter table-condensed table-bordered" >
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Departamento</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Descripción</th>
                  <th>Departamento</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($datos as $key => $categoria) { ?>
                  <tr>
                  <td><?php echo $key+1 ?></td>
                  <td><?php echo $categoria[nombre] ?></td>
                  <td><?php echo $categoria[descripcion] ?></td>
                  <td><?php echo $categoria[departamento] ?></td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-warning" onclick="<?php echo "editar(".$categoria['id'].")" ?>" href="#"><i class="fa fa-edit"></i></a>
                      <!--a id="btn_editar" data-id="<?php echo $persona[id] ?>" class="btn btn-warning" href="#"><i class="fa fa-edit"></i></a-->
                      <a onclick="<?php echo "darbaja(".$categoria['id'].",'tb_categoria','la categoria')" ?>"  class="btn btn-danger" href="#"><i class="fa fa-remove"></i></a>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
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
      $(document).on("click","#btn_guardar", function(e){
            var valid=$("#fm_categoria").valid();
            if(valid){
                var datos=$("#fm_categoria").serialize();
                $.ajax({
                    url:'json_categorias.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito("categorias");
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
        url:'json_categorias.php',
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
</script>