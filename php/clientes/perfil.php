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
include_once("../../Conexion/Cliente.php");
$empresa = Empresa::datos_empresa();
?>

<!-- Page content -->
<div id="page-content">

    <!-- Customer Content -->
    <div class="row">
        <div class="col-lg-4">
            <!-- Customer Info Block -->
                <?php echo Cliente::construir_perfil($_GET['cliente']) ?>
            <!-- END Customer Info Block -->
        </div>
        <div class="col-lg-8">
            <!-- Orders Block -->

            
            <div class="block">
                <!-- Orders Title -->
                <div class="block-title">
                    <h2><i class="fa fa-user"></i> <strong>Compras</strong></h2>
                </div>
                <!-- END Orders Title -->

                <!-- Orders Content -->
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Cajero</th>
                            <th>Monto de la venta</th>
                            <th>Factura</th>
                            <th>Tipo de venta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php print_r(Cliente::obtener_compras()); ?>
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
<div id="aqui_modal"></div>
<?php //include 'modal.php'; ?>
</div>


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<?php include '../../inc/template_end.php'; ?>

<script type="text/javascript">
    var table_procesos = cargar_tabla2("exampleTableSearch"); //inicializar tabla
    $(function() {

    });
   function ver(id){
    $.ajax({
        url:'json_clientes.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'ver_venta',id:id},
        success:function(json){
            console.log(json);
            $("#aqui_modal").html(json[3]);
            $("#md_ver_venta").modal("show");
        }
    })
    //
   }

</script>