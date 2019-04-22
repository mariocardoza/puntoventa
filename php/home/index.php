<?php 
    @session_start();
    include_once('../../Conexion/Empresa.php');
    include_once('../../Conexion/Caja.php');
    include_once('../../Conexion/Turno.php');
    $empresa=Empresa::datos_empresa();
    //echo $_SESSION['autentica']."STO TRAE"; exit();
    if(!isset($_SESSION['loggedin']) && $_SESSION['autentica'] != "simon"){
        if($_SESSION['autentica'] != "simon" )
        {
             header("Location: destruir.php");  
            exit(); 
        }else{
          
             header("Location: destruir.php");  
            exit(); 

        }
    }else{
        if(!$empresa){
            header("Location: ../empresa/registro_empresa.php");  
        }else{
            if($_SESSION[level]==2){
                header("Location: ../comandas/comandas.php");  
            }
        }
    }//prueba


?>

<?php 
    if($empresa[tipo_negocio]==1) {
        include '../../inc/config2.php';
    }else{
        if($empresa[tipo_negocio]==2 || $empresa[tipo_negocio]==3){
            include '../../inc/config2.php';
        }else{
            if($empresa[tipo_negocio]==4){
                include '../../inc/config.php';
            }else{
                header("Location: ../empresa/registro_empresa.php"); 
            }
        }
    }
?>
<?php include '../../inc/template_start.php'; ?>
<?php ($_SESSION['level']==2) ? include '../../inc/page_head.php' : include '../../inc/page_head2.php' ?> 
<?php
$datos=Empresa::totales();
$productos=Empresa::cuantos_productos();
$clientes=Empresa::cuantos_clientes();
$cajas = Caja::cajas_libres();
$miturno=Turno::obtener_mi_turno();
$_SESSION['turno'] = $miturno[0][codigo_oculto];
?>


<!-- Page content -->
<div id="page-content">
    <!-- Quick Stats -->
    <?php if($_SESSION[level]==0): 
        if($empresa[tipo_negocio]==4):
            include 'admin/index.php';
        else:

        endif;
     elseif ($_SESSION[level]==1): 
        require_once("turnos/modal.php");
        ?>
        <div class="row" style="background-color: #fff;">
            <?php if(!$miturno): ?>
              <div class="card">
                <div class="row centrado">
                  <div class="col-sm-4 col-lg-4">
                    <div class="row">
                      <div class="col-sm-2 col-lg-2"></div>
                      <div class="col-sm-8 col-lg-8"><a href="javascript:void(0)" id="modal_guardar" class="btn btn-mio btn-block">Iniciar Turno</a></div>
                      <div class="col-sm-2 col-lg-2"></div>
                  </div>
                  </div>
                </div>
              </div>
            <?php else: ?>
                <div class="card">
                <div class="row centrado">
                  <div class="col-sm-4 col-lg-4">
                    <div class="row">
                      <div class="col-sm-2 col-lg-2"></div>
                      <div class="col-sm-8 col-lg-8"><a href="javascript:void(0)" id="modal_cerrar_turno" class="btn btn-mio btn-block">Terminar Turno</a></div>
                      <div class="col-sm-2 col-lg-2"></div>
                  </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>
          <div class="" id="aqui_busqueda">
            <table class="table" id="tablita">
                <thead>
                    <th>N°</th>
                    <th>Caja</th>
                    <th>Tipo de transacción</th>
                    <th>Monto</th>
                    <th>Fecha y hora</th>
                </thead>
            </table>
          </div>
        </div>
    <?php endif; ?>
    <br><br><br>
    <!-- END Quick Stats -->

    <!-- eShop Overview Block -->
    
    <!-- END eShop Overview Block -->
    <div id="modal_aqui"></div>
</div>


<!-- END Page Content -->
<?php include '../../inc/page_footer.php'; ?>
<?php include '../../inc/template_scripts.php'; ?>
<script>
    $(function(){ 

    });
    $("#titulo_nav").text("Inicio");
    mis_movimientos();
    movimientos_dia();
    graficas();
    //grafica_mas_vendidos();
    //grafica_menos_vendidos();
    $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar_turno").modal("show");
    });

    $(document).on("click","#modal_cerrar_turno", function(e){
      var html='<button id="cerrar_swal" class="btn btn-default">Cancelar</button>'+
            '<button id="ver_turno" data-turno="<?php echo $_SESSION['turno']; ?>" class="btn btn-default">Ver resumen</button>'+
            '<button id="btn_terminar" class="btn btn-mio">Terminar turno</button>';
      swal({
          title: '¿Qué desea hacer',
          text: "",
          html: html,
          type: 'info',
          showCancelButton: false,
          showConfirmButton: false,
          allowEscapeKey: false,
          allowOutsideClick: false,
      });
    });

    $(document).on("click","#ver_turno",function(e){
        var turno=$(this).attr('data-turno');
        swal.closeModal();
        ver_resumen(turno);
    })

    $(document).on("click","#btn_marcar", function(e){
        e.preventDefault();
        var datos=$("#fm_turno").serialize();
        $.ajax({
            url:'json_home.php',
            type:'post',
            dataType:'json',
            data:datos,
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    guardar_exito();
                    window.location.href="index.php";
                }
            }
        });
    });

    $(document).on("click","#cerrar_swal", function(e){
        swal.closeModal();
    });

    $(document).on("click","#btn_terminar", function(e){
        e.preventDefault();
        $.ajax({
            url:'json_home.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'terminar_turno'},
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    guardar_exito();
                    window.location.href="index.php";
                }
            }
        });
    });

    function mis_movimientos(){
        $.ajax({
            url:'json_home.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'mis_movimientos'},
            success: function(json){
                console.log(json);
                if(json[2]){
                    $("#tablita").append(json[2]);
                }
                cargar_tabla2("tablita");
            }
        });
    }

    function movimientos_dia(){
        $.ajax({
            url:'json_home.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'movimientos_dia'},
            success: function(json){
                console.log(json);
                if(json[2]){
                    $("#lasdeldia").append(json[2]);
                }
                cargar_tabla2("lasdeldia");
            }
        });
    }

    function grafica_mas_vendidos(datos_grafica){
       if(datos_grafica.length > 0){
        Highcharts.chart('grafica1', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Productos más vendidos en el mes actual'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f} %</b><br>Cantidad:<b>{point.y}</b> Veces'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.y} Veces',
                    style: {
        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
    }
                }
                //showInLegend: true
            }
        },
        series: [{
            name: 'Porcentaje',
            colorByPoint: true,
            data: datos_grafica
            }]
        });
    }
                    
        
    }

    function graficas(){
        $.ajax({
            url:'json_home.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'ver_graficas'},
            success: function(json){
                console.log(json);
                datos_grafica_mas= [];
                var html_mas=''; 
                var html_menos=''; 
                datos_grafica_menos= []; 
                if(json[2].length > 0){
                    for(var i = 0, length1 = json[2].length; i < length1; i++){
                    datos_grafica_mas.push({name: json[2][i].n_producto, y: parseInt(json[2][i].cuantas)});
                        html_mas+='<tr>'+
                        '<td>'+(i+1)+'</td>'+
                        '<td>'+json[2][i].n_producto+'</td>'+
                        '<td>'+json[2][i].cuantas+'</td>'+
                        '</tr>';
                    }
                    $("#tabla_mas").append(html_mas);
                    //cargar_tabla2("tabla_mas");
                    grafica_mas_vendidos(datos_grafica_mas);
                }else{
                    //console.log("aqui");
                    datos_grafica_mas.push({name:'sin información',y:0});
                    grafica_mas_vendidos(datos_grafica_mas);
                    }
    
                if(json[3].length > 0){
                    for(var i = 0, length1 = json[3].length; i < length1; i++){
                    datos_grafica_menos.push({name: json[3][i].n_producto, y: parseInt(json[3][i].cuantas)});
                        html_menos+='<tr>'+
                            '<td>'+(i+1)+'</td>'+
                            '<td>'+json[3][i].n_producto+'</td>'+
                            '<td>'+json[3][i].cuantas+'</td>'+
                            '</tr>';
                    }
                    $("#tabla_menos").append(html_menos);
                    grafica_menos_vendidos(datos_grafica_menos);
                }else{
                    //console.log("aqui");
                    datos_grafica_menos.push({name:'sin información',y:0});
                    grafica_menos_vendidos(datos_grafica_menos);
                    }
                }
            });
    }

    function grafica_menos_vendidos(datos_grafica){
        if(datos_grafica.length > 0){
            Highcharts.chart('grafica2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Productos menos vendidos en el mes actual'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f} %</b><br>Cantidad:<b>{point.y}</b> Veces'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y} Veces',
                        style: {
            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
        }
                    }
                    //showInLegend: true
                }
            },
            series: [{
                name: 'Porcentaje',
                colorByPoint: true,
                data: datos_grafica
                }]
            });
        }
    }
        
    


    function ver_resumen(turno){
        $.ajax({
            url:'json_home.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'ver_resumen',turno},
            success: function(json){
                if(json[2]){
                    $("#modal_aqui").html(json[2]);
                    $("#md_ver_resumen").modal("show");
                }
                cargar_tabla3("tabla_resumen");
            }
        });
    }
</script>
<?php include '../../inc/template_end.php'; ?>