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
    #submit{
          clear: both;
      }
      #barcodeTarget,
      #canvasTarget{
        margin-top: 20px;
      }  
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Mesa.php");
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Cliente.php");
include_once("../../Conexion/Opcion.php");
include_once("../../Conexion/Comanda.php");
$mesas=Mesa::obtener_mesas();
$productos=Producto::obtener_productos();
$naturales=Cliente::obtener_naturales();
$juridicos=Cliente::obtener_juridicos();
$clientes=Cliente::obtener_todos();
$categorias=Opcion::obtener_opciones();
$tipos=Comanda::tipos();
$comanda=$_GET['comanda'];

$sql_comanda="SELECT c.*,m.nombre as n_mesa, DATE_FORMAT(c.fecha,'%d/%m/%Y') as dia_comanda,DATE_FORMAT(fecha,'%H:%i:%s') as hora_comanda FROM tb_comanda as c LEFT JOIN tb_mesa as m ON m.codigo_oculto=c.mesa  WHERE c.codigo_oculto='$comanda'";
$comandoc=Conexion::getInstance()->getDb()->prepare($sql_comanda);
$comandoc->execute();
while ($row=$comandoc->fetch(PDO::FETCH_ASSOC)) {
  $comanda_a=$row;
}
$tipo="";
if($comanda_a[tipo]==1) { $tipo="Orden: Mesa"; }
if($comanda_a[tipo]==2) { $tipo="Orden: Llevar"; }
if($comanda_a[tipo]==3) { $tipo="Orden: Domicilio";}

$sql_dcomanda="SELECT
              notas,
              n_producto,
              precio_p,
              codigo_producto,
              descripcion,
              familia
            FROM
              (
                SELECT
                  dc.notas AS notas,
                  p.nombre AS n_producto,
                  ROUND(
                    (
                      (
                        (p.ganancia / 100) * p.precio_unitario
                      ) + p.precio_unitario
                    ),
                    2
                  ) AS precio_p,
                  p.codigo_oculto as codigo_producto,
                  p.descripcion as descripcion,
                  dc.familia as familia
                FROM
                  tb_producto AS p
                INNER JOIN tb_comanda_detalle AS dc ON dc.codigo_producto = p.codigo_oculto
                WHERE
                  dc.codigo_comanda = '$comanda'
                UNION ALL
                  SELECT
                    dc.notas AS notas,
                    r.nombre AS n_producto,
                    r.precio AS precio_p,
                    r.codigo_oculto as codigo_producto,
                    r.descripcion as descripcion,
                    dc.familia as familia
                  FROM
                    tb_receta AS r
                  INNER JOIN tb_comanda_detalle AS dc ON dc.codigo_producto = r.codigo_oculto
                  WHERE
                    dc.codigo_comanda = '$comanda'
              ) AS t";
$html="";
$total_php=0.0;
$comandov=Conexion::getInstance()->getDb()->prepare($sql_dcomanda);
$comandov->execute();
$html.='<div class="col-xs-12 col-lg-12">
          <ul class="list-group">';
while ($row=$comandov->fetch(PDO::FETCH_ASSOC)) {
  $html.='<li class="list-group-item" style="font-size: 18px;">1     '.$row[n_producto].'       $'.$row[precio_p].' <i id="anular_elemento" data-familia="'.$row[familia].'" class="fa fa-remove pull-right"></i><br>'.$row[descripcion].'</li>';
        $total_php=$total_php+$row[precio_p];
}
$html.='</ul>
        </div>';
//print_r($comanda_a);
?>

<div id="page-content" style="background-color: #F2F2F2;">
    <form action="#" method="post" name="fm_orden" id="fm_orden" class="form-horizontal">
      <div class="row">
        <div class="col-lg-12">
            <div class="row" style="background-color: #F2F2F2;">
                <div class="col-lg-12" style="background-color: #F2F2F2;">
                    <div class="block " id="selmesa" style="display: none;">
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="nombre">Tipo de orden</label>
                            <div class="col-md-9">
                               <select name="tipo_orden" id="tipo_orden" class="select-chosen">
                                   <option value="">Seleccione</option>
                                   <option value="1">Mesa</option>
                                   <option value="2">Llevar</option>
                                   <option value="3">Domicilio</option>
                               </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-lg-3 control-label">Mesa seleccionada</label>
                            <div class="col-lg-9">
                              <label for="" id="nombre_mesa"></label>
                            </div>
                        </div>    
                    </div> 
                    <div class="block " id="mesas" style="display: none;">
                        <label for="">Seleccione la mesa</label>
                        <div class="row">
                          <?php foreach ($mesas as $mesa): ?>
                              <div class="col-sm-6 col-lg-3">
                                <div class="widget">
                                    <div class="widget-simple <?php echo ($mesa[ocupado] == 0) ? 'themed-background-dark' : 'themed-background-dark-fire' ?>">
                                        <a data-codigo="<?php echo $mesa[codigo_oculto] ?>" data-nombre="<?php echo $mesa[nombre] ?>" href="#" id="<?php echo ($mesa[ocupado]==0)? 'libre' : 'ocupado' ?>" >
                                            <img src="../../img/placeholders/mesa.png" alt="avatar" class="widget-image img-circle pull-left">
                                        </a>
                                        <h4 class="widget-content">
                                            <a data-nombre="<?php echo $mesa[nombre] ?>" data-codigo="<?php echo $mesa[codigo_oculto] ?>" href="#" id="<?php echo ($mesa[ocupado]==0)? 'libre1' : 'ocupado1' ?>">
                                                <strong><?php echo $mesa[nombre] ?></strong>
                                            </a>
                                        </h4>
                                    </div>
                                </div>
                              </div> 
                          <?php endforeach ?>
                        </div>
                    </div>
                    <div class="block" id="orden" style="display: block;">
                      <div class="row">
                        <div class="widget">
                                    <div class="widget-simple themed-background-dark-fire">
                                      <div class="row">
                                        <div class="col-xs-2">
                                          <?php if($comanda_a[tipo]==1): ?>
                                          <img id="img_tipo" src="../../img/placeholders/mesa.png" alt="avatar" class="widget-image img-circle pull-left">
                                        <?php elseif ($comanda_a[tipo]==2): ?>
                                          <img id="img_tipo" src="../../img/placeholders/llevar.png" alt="avatar" class="widget-image img-circle pull-left">
                                        <?php else: ?>
                                            <img id="img_tipo" src="../../img/placeholders/domicilio.jpg" alt="avatar" class="widget-image img-circle pull-left">
                                          <?php endif; ?>
                                        </div>
                                        <div class="col-xs-8">
                                          <p style="color: #fff; font-size: 18px;" id="tipo_ordenes"><?php echo $tipo; ?></p>
                                            <?php if($comanda_a[tipo]==1): ?>
                                              <p style="color: #fff; font-size: 18px;" id="num_mesa"><?php echo $comanda_a[n_mesa]; ?>
                                              </p>
                                              <p style="color: #fff; font-size: 18px;" id="para_cuantos"><?php echo $comanda_a[numero_clientes]; ?> clientes</p>
                                              
                                            <?php elseif ($comanda_a[tipo]==2): ?>
                                              <p style="color: #fff; font-size: 18px;" id="nome_cliente"><?php echo $comanda_a[nombre_cliente]; ?></p>
                                            <?php elseif($comanda_a[tipo]==3): ?>
                                              <p style="color: #fff; font-size: 18px;" id="nome_cliente"><?php echo $comanda_a[nombre_cliente]; ?></p><p style="color: #fff; font-size: 18px;" id="direc_cliente">Dirección de entrega: <?php echo $comanda_a[direccion]; ?></p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-xs-2">
                                            <a id="editar_datos_comanda" href="javascript:void(0)" class="pull-right"><img src="../../img/iconos/editar.svg" width="35px" height="35px"></a>
                                        </div>
                                      </div>
                                    </div>
                                </div>
                                <input type="hidden" value="<?php echo $comanda_a[mesa] ?>" id="id_mesa">
                                <input type="hidden" value="<?php echo $comanda_a[numero_clientes] ?>" id="numero_clientes">
                                <input type="hidden" value="<?php echo $comanda_a[tipo] ?>" id="tipo_pedido">
                                <input type="hidden" value="<?php echo $comanda_a[total] ?>" id="total_comanda"> 
                                <input type="hidden" value="<?php echo $comanda_a[nombre_cliente] ?>" id="nom_cliente">
                                <input type="hidden" value="<?php echo $comanda_a[direccion] ?>" id="direccion">
                        <div class="col-xs-2 col-lg-2">
                          <h2>Categorías</h2>
                          <div class="row" style="height: 840px;overflow-y: auto;">
                            <?php foreach ($categorias as $categoria): ?>
                              <div class="col-xs-12 col-lg-12">
                                <div class="widget">
                                  <div class="widget-simple themed-background-dark-amethyst">
                                    <h4 class="widget-content">
                                        <a id="esto" data-tipo="<?php echo $categoria[codigo_oculto] ?>" href="javascript:void(0)" >
                                            <strong><?php echo $categoria[nombre] ?></strong>
                                        </a>
                                    </h4>
                                  </div>
                                </div>
                              </div>
                          <?php endforeach ?>
                          </div>
                        </div>
                        <div class="col-xs-4 col-lg-4">
                          <h2>Productos</h2>
                          <div class="row" id="aqui" style="height: 840px;overflow-y: auto;">
                            
                          </div>
                        </div>
                        <div class="col-xs-6 col-lg-6" style="height: 840px;overflow-y: auto;">
                          <h2>Comanda</h2>
                          <div class="row" id="">
                            <?php echo $html; ?>
                          </div>
                          <div class="row" id="comandi"></div>
                          <h2 class="pull-right" id="totalpone">Total: $0.00</h2>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="col-lg-12">
          <div class="form-group">
            <center>
              <button class="btn btn-mio" type="button" id="btn_editar_comanda">Aceptar</button>
              <a href="comandas.php" class="btn btn-default" >Cancelar</a>
            </center>
          </div>
        </div>
      </div>    
    </form>
    <!-- END Product Edit Content -->
<?php include 'modales.php'; ?>
</div>

<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>

<script>
var total_php=parseFloat("<?php echo $total_php; ?>");
var lacomanda="<?php echo $_GET[comanda] ?>";
var yidisus="<?php echo date("Yidisus") ?>";
</script>
<!-- Load and execute javascript code used only in this page -->
<script src="comandas.js?cod=<?php echo date("Yidisus") ?>"></script>    
<?php include '../../inc/template_end.php'; ?>

