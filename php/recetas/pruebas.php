<?php 
    @session_start();
    //echo $_SESSION['autentica']." STO TRAE"; exit();
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
    
      
</style>
<?php include '../../inc/page_head.php'; 
include_once("../../Conexion/Conexion.php");
include_once("../../Conexion/Producto.php");
include_once("../../Conexion/Receta.php");
$recetas=Receta::traer_compuestos();

?>
<div id="page-content">    
  <div class="row">
    <div class="col-xs-12">
      <div class="block full">
        <form action="#" method="post" name="fm_sacar_compuesto" id="fm_sacar_compuesto" class="">
          <div class="row">
            <div class="col-xs-12">
              <div class="form-group">
                <select name="" id="lareceta" class="select-chosen">
                  <option selected value="">Seleccione..</option>
                  <?php foreach ($recetas as $receta): ?>
                    <option value="<?php echo $receta[codigo_oculto] ?>"><?php echo $receta[nombre] ?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-xs-12" id="poner_aqui">
              
            </div>
            <div class="col-xs-12">
              <div class="form-group">
                <center>
                  <button class="btn btn-mio" type="button" id="sacar_prueba">Aceptar</button>
                </center>
              </div>
            </div>
            <div id="script_aqui"></div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php //include 'modal.php'; ?>
</div>
<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<!-- Load and execute javascript code used only in this page -->
<!--script src="compuesto.js?cod=<?=$cod?>"></script-->
<script>

  var telementos=0;
  $("#titulo_nav").text("Pruebas");
  $(document).ready(function(e){
    $(document).on("change","#lareceta",function(e){
      var codigo = $(this).val();
      $.ajax({
        url:'json_compuesto.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'prueba',codigo},
        success: function(json){
          if(json[0]==1){
            $("#poner_aqui").empty();
            $("#poner_aqui").html(json[2]);
            $("#script_aqui").empty();//limpiar el div para imprimir el script que se genera en PHP
            $("#script_aqui").html(json[3]);//imprime el script
          }
        }
      });
    });
    
    //prueba para sacar todos los seleccionados
    $(document).on("click","#sacar_prueba",function(e){
      //alert(telementos);
      var losingredientes=new Array();//inicializo el array donde guardare todos los que obtenga
      //*** sacar todos los checkbox seleccionados ***//
      $("#fm_sacar_compuesto input[type=checkbox]:checked").each(function(index,element){
        //cada elemento seleccionado
        if(element){//si encuentra checkbox seleccionados los guarda en el array
          losingredientes.push({
            codigo:$(this).val(),
            lacanti:$(element).attr('data-canti')
          });
        }
      });
      //obtener todos los radiobutton
      $("#fm_sacar_compuesto input[type=radio]:checked").each(function(index,element){
        //cada elemento seleccionado
        if(element){//si encuentra radiobutton seleccionados los guarda en el array
          losingredientes.push({
            codigo:$(this).val(),
            lacanti:$(element).attr('data-canti')
          });
        }
      });
  
      if(losingredientes.length < telementos){
        alert("seleccione los elemtnos obligatorios")
      }else{
        alert("ya paso");
      }
      console.log(losingredientes);
    });
  });
</script> 
<?php include '../../inc/template_end.php'; ?>

