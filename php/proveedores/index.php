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
include_once("../../Conexion/Proveedor.php");
$proveedores = Proveedor::obtener_proveedores();
if($proveedores[0] == 1)$datos = $proveedores[2];
?>

<!-- Page content -->
<div id="page-content">
    <div class="row">
      <div class="col-xs-12">
        <div class="block full">
          <div class="block-title">
            <ul class="nav-horizontal">
              <li class="active">
                <a href="#">Proveedores (<?=count($datos)?>)</a>
              </li>
              <li class="pull-right">
              <a href="registro_proveedor.php" class="btn btn-lg bg-white"><i class="fa pull-left" style="width: 20px;"><img src="../../img/icon_mas.svg" class="svg" alt=""></i> Agregar proveedor</a>
              </li>
            </ul>
          </div>
          <div class="">
            <table id="exampleTableSearch" class="table table-vcenter table-condensed table-bordered" >
              <thead>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>NRC</th>
                  <th>NIT</th>
                  <th>Giro</th>
                  <th>Dirección</th>
                  <th>Email</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>#</th>
                  <th>Nombre</th>
                  <th>Teléfono</th>
                  <th>NRC</th>
                  <th>NIT</th>
                  <th>Giro</th>
                  <th>Dirección</th>
                  <th>Email</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </tfoot>
              <tbody>
                <?php foreach ($datos as $key => $proveedor) { ?>
                  <tr>
                  <td><?php echo $key+1 ?></td>
                  <td><?php echo $proveedor['nombre'] ?></td>
                  <td><?php echo $proveedor['telefono'] ?></td>
                  <td><?php echo $proveedor['nrc'] ?></td>
                  <td><?php echo $proveedor['nit'] ?></td>
                  <td><?php echo $proveedor['giro'] ?></td>
                  <td><?php echo $proveedor['direccion'] ?></td>
                  <td><?php echo $proveedor['email'] ?></td>
                  <td>
                    <div class="btn-group">
                      <a class="btn btn-warning" onclick="<?php echo "editar(".$proveedor['id'].")" ?>" href="#"><i class="fa fa-edit"></i></a>
                      <a onclick="<?php echo "darbaja(".$proveedor['id'].",'tb_proveedor','proveedor')" ?>" class="btn btn-danger" href="#"><i class="fa fa-remove"></i></a>
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
<script src="proveedor.js"></script>

<script type="text/javascript">
  var table_procesos = cargar_tabla2("exampleTableSearch");   </script>