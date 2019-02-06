var total=0.0;
var codigo="";
var producto="";
var imagen="";
var precio=0.0;
var cantidad=0;
var existencias=0;
var cliente="";
var tipo_factura=0;
var nota_guarda="";
var cobrar_propina="";
var obj_comanda = new Object();
$(document).ready(function(e){
  total=total+total_php;
  $("#totalpone").text("Total: $"+total.toFixed(2));
  $("#total_comanda").val(total.toFixed(2));
  cargar_todos();
  //traer_clientes();
  $("#titulo_nav").text("Comandas");
  
  //boton para abrir modal de las mesas
    $(document).on("click","#selec_mesa",function(e){
        $("#md_seleccionar_mesa").modal("show");
    });

    //click en las mesas libres
    $(document).on("click","#libre,#libre1",function(e){
        var codigo=$(this).attr("data-codigo");
        var nombre=$(this).attr("data-nombre");
        $("#cod_mesa").val(codigo);
        $("#nume_mesa").text(nombre);
        $("#selmesa").show();
        $("#md_cuantos_mesa").modal("show");
        //$("#mesas").hide();
    });

    //evento que al hacer click sobre la categoria cargue los productos
    $(document).on("click","#esto", function(e){
    	var tipo=$(this).attr("data-tipo");
    	$.ajax({
        url:'json_comandas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'buscar_productos',tipo:tipo},
        success: function(json){
          console.log(json);
          if(json[1]){
          	$("#aqui").empty();
           $("#aqui").html(json[2]);
          }else{
           
          }
        
        //swal.closeModal();
        }
      });
    });

    //agregar nota
    $(document).on("click","#nota", function(e){
      
      var fila = $(this).attr('data-fila');
      $("#lafila").val(fila);
      nota_guarda=$("input[name='"+fila+"']").attr("data-nota");
      $("#notita").val("");
      $("#md_add_nota").modal("show");
    });

    //seleccionar clientes por mesa
    $(document).on("click","#btn_clientes", function(e){
      var cuantos=$("#cuantos").val();
      var codigo_mesa=$("#cod_mesa").val();
      $("#id_mesa").val(codigo_mesa);
      $("#numero_clientes").val(cuantos);
      $("#para_cuantos").text("Clientes: "+cuantos);
      $("#num_mesa").text($("#nume_mesa").text());
      $("#tipo_ordenes").text("Tipo orden: Mesas");
      $("#mesas").hide();
      $("#selmesa").hide();
      $("#orden").show();
      $("#md_cuantos_mesa").modal("hide");
    });

    //ejecutar comanda
    $(document).on("click","#comandar", function(e){
        guardar_comanda();
    });

    //editar la comanda
    $(document).on("click","#btn_editar_comanda", function(e){
      var id_mesa = $("#id_mesa").val() || 0;
        var numero_clientes = $("#numero_clientes").val() || 0;
        var tipo_pedido = $("#tipo_pedido").val() || 0;
        var cliente = $("#nom_cliente").val();
        var comanda=new Array();
        var total=$("#total_comanda").val() || 0;
        var nombre_cliente=$("#nom_cliente").val();
        var direccion = $("#direccion").val();
        
          $("#comandi").find('input').each(function (index, element) {
            if(element){
              comanda.push({
                    codigo: $(element).attr("data-codigo"),
                    nota: $(element).attr("data-nota"),
             });
            }
          });

        if(total && tipo_pedido ){
          $.ajax({
            url:'json_comandas.php?cod='+yidisus,
            type:'POST',
            dataType: 'json',
            data:{data_id:'actualizar_comanda',codigo_oculto:lacomanda,id_mesa,numero_clientes,tipo_pedido,comanda,total,nombre_cliente,direccion},
            success: function(json){
              console.log(json);
              if(comanda.length > 0){
                ticket(lacomanda);
              }
              guardar_exito();
            }
          });
        }else{
          swal('aviso',
            'No ha seleccionado nada',
            'warning');
        }
        
    });

    $(document).on("click","#add_nota", function(e){
      var lafila=$("#lafila").val();
      var nota=$("#notita").val();
      nota_guarda=nota_guarda+","+" "+nota;
      $( "input[name='"+lafila+"']" ).attr('data-nota',nota_guarda);
      $("#"+lafila).append(
        '<div>'+nota+'</div>'
        );
      $("#notita").val("");
      $("#md_add_nota").modal("hide");
    });

    $(document).on("click","#producto_add", function(e){
      var codigo = $(this).attr("data-id");
      //contar();
      //console.log(conta);
      var x = Math.floor((Math.random() * 10000000000) + 1);
    /*if($("#"+codigo).length){
      var canti=parseInt($("#"+codigo).attr("data-cantidad"));
      var precio = parseFloat($(this).attr("data-precio"));
      canti=canti+1;
      var sub=precio*canti;
      $("#"+codigo).attr('data-cantidad', canti);
      $("#"+codigo).attr('data-precio', sub);
      $("#"+codigo).find("th:eq(0)").text(canti);
      $("#"+codigo).find("th:eq(2)").text("$"+sub.toFixed(2));
    }else{*/
      var cantidad = parseInt($(this).attr("data-cantidad"));
      var nombre = $(this).attr("data-nombre");
      var precio = parseFloat($(this).attr("data-precio"));
      total=total+precio;
      $("#totalpone").text("Total: $"+total.toFixed(2));
      $("#total_comanda").val(total.toFixed(2));
      agregar_a_comanda(x,nombre,codigo,cantidad,precio);
    });
    //click en las mesas ocupadas
    $(document).on("click","#ocupado,#ocupado1",function(e){
        swal(
          'Aviso!',
          'La mesa no esta disponible',
          'warning'
        );
    });

  //evento para primer select
    $(document).on("change","#tipo_orden", function(e){
      var tipo=$(this).val();
      if(tipo==1){
        $("#mesas").show();
        $("#orden").hide();
        $("#tipo_pedido").val(1);
        $("#domicilios").hide();
        $("#img_tipo").attr("src","../../img/placeholders/mesa.png");
      }if (tipo==2) {
        $("#mesas").hide();
        $("#md_nombre_cliente").modal("show");
        $("#tipo_pedido").val(2);
        $("#tipo_ordenes").text("Tipo orden: Llevar");
        $("#orden").show();
        $("#domicilios").hide();
        $("#direcc").val("");
        $("#img_tipo").attr("src","../../img/placeholders/llevar.png");
      }if(tipo==3){
        $("#md_nombre_cliente").modal("show");
        $("#tipo_pedido").val(3);
        $("#mesas").hide();
        $("#orden").show();
        $("#domicilios").show();
        $("#tipo_ordenes").text("Tipo orden: Domicilio");
        $("#img_tipo").attr("src","../../img/placeholders/domicilio.jpg");
      }
    })

  //quitar de la tabla
    $(document).on("click","#btn_quitar", function(e){
        var fila=$(this).attr('data-fila');
        var input=$( "input[name='"+fila+"']" );
        var precio=parseFloat(input.attr('data-precio'));
        //alert(precio);
        input.remove();
        $("#"+fila).remove();
        total=total-precio;
        $("#totalpone").text("Total: $"+total.toFixed(2));
        $("#total_comanda").val(total.toFixed(2));
    });

    //click en boton de seleccion de tipo factura
    $(document).on("click", "#btn_cobrar_antes", function(e){
        var tipo=$('input[name=tipo_factura]:checked').val();
        if(tipo==1){
            $("#md_tipofactura").modal("hide");
            $("#md_propina").modal("show");
            //$("#md_credito").modal("show");
            tipo_factura=1;
        }else{
            if(tipo==2){
              $("#md_tipofactura").modal("hide");
              $("#md_propina").modal("show");
              //$("#md_consumidor").modal("show");
              tipo_factura=2;
            }else{
              //cliente="";
              //traer_clientes(cliente);
              tipo_factura=3;
              $("#md_tipofactura").modal("hide");
              $("#md_propina").modal("show");
              //$("#btn_cobrar").trigger("click");
            }
        }
    });

    $(document).on("click","#btn_cobrar_antes_p", function(e){
      var propina=$('input[name=propina]:checked').val();
      if(propina==1){
        cobrar_propina="si";
      }if(propina==2){
        cobrar_propina="no";
      }
        if(tipo_factura==1){
            //$("#md_tipofactura").modal("hide");
            $("#md_propina").modal("hide");
            $("#md_credito").modal("show");
            //tipo_factura=1;
        }else{
            if(tipo_factura==2){
              //$("#md_tipofactura").modal("hide");
              $("#md_propina").modal("hide");
              $("#md_consumidor").modal("show");
              //tipo_factura=2;
            }if(tipo_factura==3){
              cliente="";
              traer_clientes(cliente);
              tipo_factura=3;
              //$("#md_tipofactura").modal("hide");
              $("#md_propina").modal("hide");
              $("#btn_cobrar").trigger("click");
            }
        }
    });

    $(document).on("click","#btn_cerrar_fiscal,#btn_cerrar_consumidor", function(e){
      $("#md_consumidor").modal("hide");
      $("#md_credito").modal("hide");
      $("#md_tipofactura").modal("show");
      $("#nombre_fac_final").val("");
      $("#direccion_fac_final").val("");
      $("#nombre_fac").val("");
      $("#direccion_fac").val("");
      $("#nit_fac").val("");
      $("#nrc_fac").val("");
    });

    //buscar clientes naturales
    $(document).on("input","#nombre_fac_final",function(e){
        var val = this.value;
        if($('#naturales option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();        
        }).length) {
            //send ajax request
            $.ajax({
                url:'json_comandas.php',
                type:'POST',
                dataType:'json',
                data:{data_id:'buscar_natural',dato:val},
                success: function(json){
                    console.log(json);
                    $('.acepta').css('display', 'block');
                    $('.guarda').css('display', 'none');
                    cliente=(json[1][0].codigo_oculto);
                    $("#direccion_fac_final").val(json[1][0].direccion);
                }
            });
            //alert(this.value);
        }
        //alert("ninguno");
        $("#direccion_fac_final").val("");
        cliente="";
        $('.acepta').css('display', 'none');
        $('.guarda').css('display', 'block');
    });

    //buscar clientes juridicos
    $(document).on("input","#nombre_fac",function(e){
        var val = this.value;
        if($('#juridicos option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();        
        }).length) {
            //send ajax request
            $.ajax({
                url:'json_comandas.php',
                type:'POST',
                dataType:'json',
                data:{data_id:'buscar_natural',dato:val},
                success: function(json){
                    console.log(json);
                    $('.acepta2').css('display', 'block');
                    $('.guarda2').css('display', 'none');
                    cliente=(json[1][0].codigo_oculto);
                    $("#nit_fac").val(json[1][0].nit);
                    $("#nrc_fac").val(json[1][0].nrc);
                    $("#direccion_fac").val(json[1][0].direccion);
                }
            });
            //alert(this.value);
        }
        //alert("ninguno");
        $("#direccion_fac").val("");
        cliente="";
        $("#nit_fac").val("");
        $("#nrc_fac").val("");
        $('.acepta2').css('display', 'none');
        $('.guarda2').css('display', 'block');
    });

    //cobrar
    $(document).on("click","#btn_cobrar", function(e){
      var total_aqui=total;
      $("#total_real").val(total);
      if(tipo_factura==1){
        $("#md_consumidor").modal("hide");
        $("#md_credito").modal("hide");
        $("#md_formapago").modal("show");
        $("#tipo_fac").val(1);
        var propina=0.0;
        //console.log(cobrar_propina);
        $("#poner_totala").text("Total de la venta: $"+total_aqui.toFixed(2));
        if(cobrar_propina=="si"){
          propina=total_aqui*0.10;
          total_aqui=total_aqui+propina;
          $("#propi").val(propina.toFixed(2));
          $("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
          $("#poner_total").text("Total: $"+total_aqui.toFixed(2));
          $("#total_venta").val(total_aqui);
        }else{
          $("#propi").val(0);
          $("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
          $("#poner_total").text("Total: $"+total_aqui.toFixed(2));
          $("#total_venta").val(total_aqui);
        }
        //$("#total_venta").val(total);
        $("#fecha_pago").val("");
        //$("#id_venta").val("");
        $("#efectivo_recibido").val("");
        $("#efectivo_vuelto").val("");
        //$("#poner_total").text("Total de la Venta: $"+total);
      }
      if(tipo_factura==2){
        $("#md_consumidor").modal("hide");
        $("#md_credito").modal("hide");
        $("#md_formapago").modal("show");
        $("#tipo_fac").val(2);
        var propina=0.0;
        //console.log(cobrar_propina);
        $("#poner_totala").text("Total de la venta: $"+total_aqui.toFixed(2));
        if(cobrar_propina=="si"){
          propina=total_aqui*0.10;
          total_aqui=total_aqui+propina;
          $("#propi").val(propina.toFixed(2));
          $("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
          $("#poner_total").text("Total: $"+total_aqui.toFixed(2));
          $("#total_venta").val(total_aqui.toFixed(2));
        }else{
          $("#propi").val(0);
          $("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
          $("#poner_total").text("Total: $"+total_aqui.toFixed(2));
          $("#total_venta").val(total_aqui.toFixed(2));
        }
        //$("#total_venta").val(total);
        //$("#id_venta").val("");
        $("#efectivo_recibido").val("");
        $("#efectivo_vuelto").val("");
        $("#fecha_pago").val("");
        //$("#poner_total").text("Total de la Venta: $"+total);
        //consumidor(json[1]);
      }
      if(tipo_factura==3){
        $("#md_formapago").modal("show");
        $("#tipo_fac").val(3);
        var propina=0.0;
        //console.log(cobrar_propina);
        $("#poner_totala").text("Total de la venta: $"+total_aqui.toFixed(2));
        if(cobrar_propina=="si"){
          propina=total_aqui*0.10;
          total_aqui=total_aqui+propina;
          $("#propi").val(propina.toFixed(2));
          $("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
          $("#poner_total").text("Total: $"+total_aqui.toFixed(2));
          $("#total_venta").val(total_aqui);
        }else{
          $("#propi").val(0);
          $("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
          $("#poner_total").text("Total: $"+total_aqui.toFixed(2));
          $("#total_venta").val(total_aqui);
        }
        //$("#id_venta").val();
        $("#efectivo_recibido").val("");
        $("#efectivo_vuelto").val("");
        $("#fecha_pago").val("");
        //$("#poner_total").text("Total de la Venta: $"+total);
      }
    });

    ///acciones segun el tipo de pago
    $(document).on("change","input[type=radio][name=tipo_pago]",function(e){
      var esto=$(this).val();
      if(esto==1){
        $("#credit").css("display","none");
        $("#efec").css("display","block");
        $("#efectivo_recibido").removeAttr("disabled","disabled");
        $("#cliente_debe").attr("disabled",true);
        $("#fecha_pago").attr("disabled",true);
        $("#descripcion_debe").attr("disabled",true);
      }if(esto==2){
        $("#efec").css("display","none");
        $("#credit").css("display","block"); 
        $("#efectivo_recibido").attr("disabled",true);
        $("#cliente_debe").removeAttr("disabled","disabled");
        $("#fecha_pago").removeAttr("disabled","disabled");
        $("#descripcion_debe").removeAttr("disabled","disabled");
        traer_clientes(cliente);
        //console.log(cliente);
      }if(esto==3){
        $("#efec").css("display","none");
        $("#credit").css("display","none");
        $("#efectivo_recibido").attr("disabled",true);
        $("#cliente_debe").attr("disabled",true);
        $("#fecha_pago").attr("disabled",true);
        $("#descripcion_debe").attr("disabled",true);
      }
    });

    //calculo del vuelto o cambio
    $(document).on("input","#efectivo_recibido", function(e){
        var total=parseFloat($("#total_venta").val());
        var efectivo = parseFloat($(this).val());
        console.log(total);
        console.log(efectivo);
        var vuelto=0.0;
        vuelto=efectivo-total;
        $("#efectivo_vuelto").val(vuelto.toFixed(2));
    });

    $(document).on("click","#btn_cerrar_formapago", function(e){
      $("#md_formapago").modal("hide");
      $("#md_tipofactura").modal("show");
      $("#efectivo_recibido").val("");
      $("#efectivo_vuelto").val("");
      cobrar_propina="";
    });

    $(document).on("click", "#btn_imprimir2", function(e) {//EVENTO SE ACTIVA AL DAR CLICK EN IMPRIMIR DE LA MODAL
          $("#md_imprimir").modal('toggle');
          
          swal({
                  title: '¿Se imprimió correctamente?',
                  //text: "Si",
                  type: 'info',
                  showCancelButton: true,
                  allowEscapeKey: false,
                  allowOutsideClick: false,
                  cancelButtonText: "Cancelar",
                  confirmButtonColor: '#aad178',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: '¡Si, continuar!'
              }).then(function() {
                window.location.href='comandas.php';
              });
                  
      });

    $(document).on("click","#ir_a_cobrar", function(e){
      var codigo=$(this).attr("data-codigo");
      var total_a=parseFloat($(this).attr("data-total"));
      var mesa=$(this).attr("data-mesa");
      total=parseFloat(total_a);
      $("#id_venta").val(codigo);
      $("#mesita").val(mesa);
      swal.closeModal();
      $("#md_tipofactura").modal("show");
    });

    $(document).on("click","#btn_imprimir_ticket", function(e){
        var factura=$("#tipo_fac").val();
        var efectivo=$("#efectivo_recibido").val();
        var cambio=$("#efectivo_vuelto").val();
        var total=$("#total_real").val();
        var cliente_aqui=cliente;
        var cliente_debe=$("#cliente_debe").val();
        var descripcion_debe = $("#descripcion_debe").val();
        var forma_pago=$("input:radio[name=tipo_pago]:checked").val();
        var comanda=$("#id_venta").val();
        var propina = $("#propi").val();
        var mesa=$("#mesita").val();
        $.ajax({
            url:'json_comandas.php',
            type:'POST',
            dataType:'json',
            data:{propina,comanda,total,tipo_factura,cliente_aqui,cliente_debe,descripcion_debe,efectivo,cambio,forma_pago,mesa,data_id:'cobrar'},
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    guardar_exito();
                    $(".modal").modal("hide");
                    //ticket(json[1]);
                    if(tipo_factura==1){
                      credito(comanda);
                    }
                    if(tipo_factura==2){
                      consumidor(comanda);   
                    }
                    if(tipo_factura==3){
                        ticket2(comanda);
                    }
                }else{
                    guardar_error();
                }
            }
        });
        //console.log(datos);
        //facturar(tipo_pago,factura,efectivo,cambio,total,cliente_aqui,cliente_debe,descripcion_debe,comanda,propina);
        /*if(factura==1) {}
        if(factura==2) {consumidor(venta,efectivo,cambio,total);}
        else {ticket(venta,efectivo,cambio,total);}*/
    });

    //cerrar modal de pregunta
    $(document).on("click","#cancelar_cobrar", function(e){
      swal.closeModal();
    });

    $(document).on("click","#btn_elcliente", function(e){
      var nombre=$("#elnombre").val() || 0;
      var direccion=$("#direcc").val();
      if(nombre != 0){
        $("#tipo_ordenes").text("Llevar");
        $("#nom_cliente").val(nombre);
        $("#nome_cliente").text("Cliente: "+nombre);
        $("#direccion").val(direccion);
        $("#md_nombre_cliente").modal("hide");
        $("#img_tipo").attr("src","../../img/placeholders/llevar.png");
        $("#num_mesa").text("");
        $("#para_cuantos").text("");
        
        $("#numero_clientes").val("");
        $("#nom_cliente").val(nombre);
        $("#direccion").val(direccion);
        $("#direc_cliente").text("Direccion de entrega: "+direccion);
      }else{
        swal('Aviso','Debe digitar el nombre del cliente','warning');
      }
    });

    $(document).on("click","#editar_datos_comanda", function(e){
      $("#md_cambiar_comanda").modal("show");
    });

    $(document).on("change","input[type=radio][name=quecambiar]", function(e){
      var esto=$(this).val();
      if(esto==1){
        $("#diveltipo").show();
        $("#lapregunta").hide();
      }
      if(esto==2){

      }
    });

    $(document).on("change","input[type=radio][name=eltipodeorden]", function(e){
      var esto=$(this).val();
      if(esto==1){
        alert("mesa");
      }else{
        if(esto==2){
          $("#md_cambiar_comanda").modal("hide");
          $("#md_nombre_cliente").modal("show");
          $("#direccion").val("");
          $("#tipo_pedido").val(2);
        }else{
          if(esto==3){
            $("#md_cambiar_comanda").modal("hide");
            $("#md_nombre_cliente").modal("show");
            $("#domicilios").show();
            $("#tipo_pedido").val(3);
          }
        }
      }
    });
    
  });

//facturar
function facturar(tipo_pago,factura,efectivo,cambio,total,cliente_aqui,cliente_debe,descripcion_debe,comanda,propina){
        var total=total;
        var efectivo=efectivo;
        var tipo_pago=tipo_pago;
        var cambio = cambio;
        var tipo_factura=factura;
        var cliente_aqui=cliente_aqui;
        var cliente_debe=cliente_debe;
        var descripcion_debe=descripcion_debe;
        var comanda=comanda;
        var propina=propina;
        //var mesa=mesa;
        $.ajax({
            url:'json_comandas.php',
            type:'POST',
            dataType:'json',
            data:{propina,comanda,total:total,tipo_factura:tipo_factura,cliente:cliente_aqui,cliente_debe:cliente_debe,descripcion_debe,descripcion_debe,efectivo:efectivo,cambio:cambio,tipo_pago:tipo_pago,data_id:'cobrar'},
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    guardar_exito();
                    //ticket(json[1]);
                    if(tipo_factura==1){
                      credito(comanda);
                    }
                    if(tipo_factura==2){
                      consumidor(comanda);   
                    }
                    if(tipo_factura==3){
                        ticket(comanda,efectivo,cambio,total);
                    }
                }else{
                    guardar_error();
                }
            }
        });    
    }

//setInterval(guardar_comanda, 3000);
function traer_clientes(cliente){
  var select='<option value="">Cliente general</option>';
  $.ajax({
    url:'json_comandas.php',
    type: 'POST',
    dataType: 'json',
    data:{data_id:'traer_clientes'},
    success: function(json){
      $.each(json[1], function( index, value ) {
        if(cliente == value.codigo_oculto){
          select+='<option selected value="'+value.codigo_oculto+'">'+value.nombre+'</option>';
        }else{
          select+='<option value="'+value.codigo_oculto+'">'+value.nombre+'</option>';
        }
      });
      //console.log(select);
      $("#cliente_debe").empty();
      $("#cliente_debe").append(select);
      $("#cliente_debe").trigger("chosen:updated");
    }
  });
}

 function vercomanda(){
  console.log(obj_comanda);
 }
 function contar(){
  conta=conta+1;
 }
//cargar
    function cargar_todos(){
        $.ajax({
          url:'json_comandas.php',
          type:'POST',
          dataType:'json',
          data:{data_id:'busqueda',esto:'',tipo:'0'},
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

    function agregar_a_comanda(x,nombre,codigo,cantidad,precio){
      $("#comandi").append(
        '<input type="hidden" name="'+x+'" data-precio="'+precio+'" data-nota="" data-nombre="'+nombre+'" data-codigo="'+codigo+'">'+
        /*'<thead data-codigo="'+codigo+'" data-precio="'+precio+'" data-cantidad="'+cantidad+'" id="'+x+'">'+
          '<th rowspan="2">'+cantidad+'</th>'+
          '<th>'+nombre+'</th>'+
          '<th>$'+precio+'</th>'+
          '<th><button type="button" class="btn btn-success btn-xs" id="nota" data-fila="'+x+'">nota</button></th>'+
        '</thead>'*/
        '<div class="col-xs-12 col-lg-12" id="'+x+'">'+
          '<div><h3>'+cantidad+'    '+nombre+'    $'+precio+'  <button type="button" class="btn btn-success" id="nota" data-fila="'+x+'">nota</button><button type="button" class="btn btn-danger" id="btn_quitar" data-fila="'+x+'">Quitar</button></h3></div>'+
        '</div>'
        );
    }

    function guardar_comanda(){
        var id_mesa = $("#id_mesa").val() || 0;
        var numero_clientes = $("#numero_clientes").val() || 0;
        var tipo_pedido = $("#tipo_pedido").val() || 0;
        var cliente = $("#nom_cliente").val();
        var comanda=new Array();
        var total=$("#total_comanda").val() || 0;
        
            $("#comandi").find('input').each(function (index, element) {
            if(element){
              comanda.push({
                    codigo: $(element).attr("data-codigo"),
                    nota: $(element).attr("data-nota"),
             });
            }
          });
          console.log(comanda.length);
        if(total && tipo_pedido && (comanda.length > 0)){
          $.ajax({
            url:'json_comandas.php',
            type:'POST',
            dataType: 'json',
            data:{data_id:'nueva_comanda',id_mesa,numero_clientes,tipo_pedido,comanda,total},
            success: function(json){
              console.log(json);
              ticket(json[2][3]);
              guardar_exito();
            }
          });
        }else{
          swal('aviso',
            'No ha seleccionado nada',
            'warning');
        }
        
        
    }

    function actualizar_comanda(){
        
        
    }

  function ticket(comanda){
    console.log("esto "+comanda);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/comanda.php?datos='+comanda+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/comanda.php?datos='+comanda+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

function ticket2(comanda){
    console.log("esto "+comanda);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/ticketc.php?datos='+comanda+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/ticketc.php?datos='+comanda+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

//funcion que imprmer factura consumidor final
function consumidor(comanda){
    console.log("esto "+comanda);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/finalc.php?datos='+comanda+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/finalc.php?datos='+comanda+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

function credito(comanda){
    console.log("esto "+comanda);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/fiscalc.php?datos='+comanda+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/fiscalc.php?datos='+comanda+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

function ver(id){
  alert(id);
}

function cobrar(id,total_a,mesa){
  var html='<button id="cancelar_cobrar" class="btn btn-default">Cerrar</button>'+
           '<button data-codigo="'+id+'" class="btn btn-info">Imprimir precuenta</button>'+
           '<button id="ir_a_cobrar" data-mesa="'+mesa+'" data-codigo="'+id+'" data-total="'+total_a+'" class="btn btn-mio">Cobrar</button>';
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

  total=parseFloat(total_a);
  //console.log(total);
  //var totals=total;
  //var propina=total*0.10;
  //var totalp=0.0;
  //totalp=totals+propina;
  //$("#poner_totala").text("Total de la venta: $"+totals.toFixed(2));
  //$("#poner_propina").text("Propina sugerida: $"+propina.toFixed(2));
  //$("#poner_total").text("Total: $"+totalp.toFixed(2));
  //$("#md_tipofactura").modal("show");
}

function ver(id){
  $.ajax({
    url:'json_comandas.php',
    type:'POST',
    dataType:'json',
    data:{data_id:'ver_comanda',id:id},
    success: function(json){
      $("#aqui_modal").html(json[3]);
      $("#md_ver_comanda").modal("show");
    }
  });
}

function anular(codigo){
  swal({
       title: '¿Desea continuar?',
       text: "¡Se anulará la comanda!",
       type: 'warning',
       showCancelButton: true,
       cancelButtonText:"Cancelar",
       confirmButtonColor: 'red',
       cancelButtonColor: '#3085d6',
       confirmButtonText: '¡Si, continuar!'
   }).then(function () {
      swal({
         title: '¿Está realmente seguro?',
         text: "¡Se acción eliminará permanentemente la comanda y no podrá acceder a ella nuevamente!",
         type: 'warning',
         showCancelButton: true,
         cancelButtonText:"Cancelar",
         confirmButtonColor: 'red',
         cancelButtonColor: '#3085d6',
         confirmButtonText: '¡Si, continuar!'
      }).then(function () {
        $.ajax({
          url:'json_comandas.php',
          type:'POST',
          dataType:'json',
          data:{codigo,data_id:'anular'},
          success: function(json){
            if(json[0]==1){
              iziToast.success({
                  title: ELIMINAR,
                  message: ELIMINAR_MENSAJE,
                  timeout: 3000,
              });
              var timer=setInterval(function(){
                  cargar_todos();
                  clearTimeout(timer);
              },3500);
            }else{
              iziToast.error({
                title: ERROR,
                message: ERROR_MENSAJE,
                timeout: 3000,
            });
            }
          }
        });
      });
   });
}


