var total=0.0;
var codigo="";
var producto="";
var imagen="";
var precio=0.0;
var cantidad=0;
var existencias=0;
var cliente="";
var tipo_factura=0;
$(document).ready(function(e){
  //traer_clientes();
  $("#titulo_nav").text("Venta");
  $("#cobrar").hide();
    $.ajax({
        url:'json_ventas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',departamento:'0'},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
          if(json[2]){
            $("#aqui_busqueda_venta").empty();
          $("#aqui_busqueda_venta").html(json[2]);
        }else{
          $("#aqui_busqueda_venta").empty();
          $("#aqui_busqueda_venta").html(html);
        }
        }
      });


    //boton para abrir modal de las mesas
    $(document).on("click","#selec_mesa",function(e){
        $("#md_seleccionar_mesa").modal("show");
    });

    //click en las mesas libres
    $(document).on("click","#libre,#libre1",function(e){
        var codigo=$(this).attr("data-codigo");
        var nombre=$(this).attr("data-nombre");
        $("#nombre_mesa").text(nombre);
        $("#md_seleccionar_mesa").modal("hide");
    });
    //click en las mesas ocupadas
    $(document).on("click","#ocupado,#ocupado1",function(e){
        swal(
          'Aviso!',
          'La mesa no esta disponible',
          'warning'
        );
    });

    //evento input
    $(document).on("input","#canti",function(e){
    	//var contador=1;
        var canti=($(this).val()=='') ? 0.00 : parseFloat($(this).val());
        var existencias=$(this).attr('data-existencia');
        var codigo=$(this).attr('data-codigo');
        if(canti>existencias){
            alert("sobrepasa el inventario")
            $("input[name='"+codigo+"']").val("");
        }else{
            //var canti=$(this).val();
            console.log(canti);
            var precio_aqui=parseFloat($(this).attr('data-precio'));
            var sub_aqui=canti*precio_aqui
            var sub_anterior=parseFloat($(this).attr('data-sub'));
            total=total-sub_anterior;
            total=total+sub_aqui;
                
                
            $("#total").text("$"+total.toFixed(2));
            $("#totalp").val(total.toFixed(2));
            $( "input[name='"+codigo+"']" ).attr('data-sub', sub_aqui);
            $( "input[name='"+codigo+"']" ).attr('data-cantidad', canti);
        }
           
    });

    //quitar de la tabla
    $(document).on("click","#btn_quitar", function(e){
        var codigo=$(this).attr('data-codigo');
        var div=$("."+codigo);
        var input=$(e.target).parents("tbody").find('tr:eq(1)').find('td:eq(2)').find('input');
        var subtotal=parseFloat(input.attr('data-sub'));
        total=total-subtotal;
        div.remove();
        $("#total").text("$"+total.toFixed(2));
        $("#totalp").val(total.toFixed(2));
    });

    //tipo de factura
    $(document).on("click","#btn_tipofactura", function(e){
      var total=$("#totalp").val();
      if(total>0){
        $("#md_tipofactura").modal("show");
      }else{
        swal(
        '¡Aviso!',
        'No se han agregado productos',
        'warning'
      )
      }
      
        //$("#md_tipofactura").modal("show");
    });

    //click en boton de seleccion de tipo factura
    $(document).on("click", "#btn_cobrar_antes", function(e){
        var tipo=$('input[name=tipo_factura]:checked').val();
        if(tipo==1){
            $("#md_tipofactura").modal("hide");
            $("#md_credito").modal("show");
            tipo_factura=1;
        }else{
            if(tipo==2){
              $("#md_tipofactura").modal("hide");
              $("#md_consumidor").modal("show");
              tipo_factura=2;
            }else{
              cliente="";
              traer_clientes(cliente);
              tipo_factura=3;
              $("#md_tipofactura").modal("hide");
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

    $(document).on("click","#btn_cerrar_formapago", function(e){
      $("#md_formapago").modal("hide");
      $("#md_tipofactura").modal("show");
      $("#efectivo_recibido").val("");
      $("#efectivo_vuelto").val("");
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

    //imprimir ticket
    $(document).on("click","#btn_imprimir_ticket", function(e){
        var factura=$("#tipo_fac").val();
        var efectivo=$("#efectivo_recibido").val();
        var cambio=$("#efectivo_vuelto").val();
        var total=$("#total_venta").val();
        var cliente_aqui=cliente;
        var cliente_debe=$("#cliente_debe").val();
        var descripcion_debe = $("#descripcion_debe").val();
        var tipo_pago=$("input:radio[name=tipo_pago]:checked").val();
        //console.log(datos);
        facturar(tipo_pago,factura,efectivo,cambio,total,cliente_aqui,cliente_debe,descripcion_debe);
        /*if(factura==1) {}
        if(factura==2) {consumidor(venta,efectivo,cambio,total);}
        else {ticket(venta,efectivo,cambio,total);}*/
    });

// prueba para imprimir ticket
    $(document).on("click","#elticket", function(e){
           $.ajax({
               url: 'ticket.php',
               type: 'POST',
               data: {datos:'20191716172600000026'},
               success: function(response){
                   if(response==1){
                       alert('Imprimiendo....');
                   }else{
                       alert('Error');
                   }
               }
           }); 
    });

    //reimprimir
    $(document).on("click", "#btn_imprimir2", function(e) {//EVENTO SE ACTIVA AL DAR CLICK EN IMPRIMIR DE LA MODAL
          $("#md_imprimir").modal('toggle');
          //var option = $("#t_doc :selected");
          //var correlativo = parseInt(option.data("correlativo")) + 1;
          //var datos = { data_id: "a_factura", id_orden: id_orden_g, t_doc: $("#t_doc").val(), correlativo: correlativo };
          //console.log(datos);
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
                window.location.href='registro_orden.php';
                  /*$.ajax({
                      url: "json/data_json.php",
                      dataType: "json",
                      data: datos,
                      method: "POST",
                      success: function(json) {
                          console.log(json);
                          if (json.exito) {
                              swal({
                                  type: "success",
                                  title: "!Exito!",
                                  text: '',
                                  timer: 1500,
                                  showConfirmButton: false
                              });
                              setTimeout(function() {
                                  window.location.href = "facturas.php?cod=" + cod;
                              }, 1400);
                          }
                          if (json.falla || json.error) {
                              swal({
                                  title: 'Advertencia',
                                  text: "No se Pudo Registrar en la Base de Datos",
                                  type: 'warning',
                                  showCancelButton: false,
                                  allowEscapeKey: false,
                                  allowOutsideClick: false,
                                  confirmButtonColor: '#d33',
                                  cancelButtonColor: '#d33',
                                  confirmButtonText: 'Aceptar'
                              }).then((result) => {
                                  //$('#md_nuevo_cliente').modal({show: 'false'});
                              })
                          }
                      }
                  });*/
              });
          /*setTimeout(function() {
              
          }, 500);*/
      });

    //guardar cliente natural
    $(document).on("click","#btn_guardar_natural", function(e){
        var nombre=$("#nombre_fac_final").val();
        var direccion=$("#direccion_fac_final").val();
        var tipo=1;
        $.ajax({
            url:'json_ventas.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'nuevo_cliente',nombre:nombre,direccion:direccion,tipo:tipo,nrc:'',nit:''},
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    cliente=json[3];
                    traer_clientes(json[3]);
                    $("#btn_cobrar").trigger("click");
                }
            }
        });
    });

    //guardar cliente juridico
    $(document).on("click","#btn_guardar_juridico", function(e){
        var nombre=$("#nombre_fac").val();
        var direccion=$("#direccion_fac").val();
        var nit=$("#nit_fac").val();
        var nrc=$("#nrc_fac").val();
        var tipo=2;
        $.ajax({
            url:'json_ventas.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'nuevo_cliente',nombre:nombre,direccion:direccion,tipo:tipo,nrc:nrc,nit:nit},
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    cliente=json[3];
                    traer_clientes(json[3]);
                    $("#btn_cobrar").trigger("click");
                }
            }
        });
    });

    //cobrar
    $(document).on("click","#btn_cobrar", function(e){
      if(tipo_factura==1){
        $("#md_consumidor").modal("hide");
        $("#md_credito").modal("hide");
        $("#md_formapago").modal("show");
        $("#tipo_fac").val(1);
        $("#total_venta").val(total);
        $("#fecha_pago").val("");
        $("#id_venta").val("");
        $("#efectivo_recibido").val("");
        $("#efectivo_vuelto").val("");
        $("#poner_total").text("Total de la Venta: $"+total);
      }
      if(tipo_factura==2){
        $("#md_consumidor").modal("hide");
        $("#md_credito").modal("hide");
        $("#md_formapago").modal("show");
        $("#tipo_fac").val(2);
        $("#total_venta").val(total);
        $("#id_venta").val("");
        $("#efectivo_recibido").val("");
        $("#efectivo_vuelto").val("");
        $("#fecha_pago").val("");
        $("#poner_total").text("Total de la Venta: $"+total);
        //consumidor(json[1]);
      }
      if(tipo_factura==3){
        $("#md_formapago").modal("show");
        $("#tipo_fac").val(3);
        $("#total_venta").val(total);
        $("#id_venta").val("");
        $("#efectivo_recibido").val("");
        $("#efectivo_vuelto").val("");
        $("#fecha_pago").val("");
        $("#poner_total").text("Total de la Venta: $"+total);
      }
    });

    //buscar clientes naturales
    $(document).on("input","#nombre_fac_final",function(e){
        var val = this.value;
        if($('#naturales option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();        
        }).length) {
            //send ajax request
            $.ajax({
                url:'json_ventas.php',
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
                url:'json_ventas.php',
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


    //agregar imagen a la tabla
    $(document).on("click","#agrega_img",function(e){
        codigo=$(this).attr("data-codigo");
        var existe=$(this).attr("data-existencia");
        var articulos = new Array();
       
        if($("#"+codigo).length){
            var canti=parseInt($("input[name="+codigo+"]").val());
            if(canti+1 < existe){
              $("input[name="+codigo+"]").val(canti+1);
                $("input[name="+codigo+"]").trigger("input");  
            } 
        }else{
            producto=$(this).attr("data-nombre");
            precio=parseFloat($(this).attr("data-precio"));
            existencias =parseInt($(this).attr('data-existencia'));
            imagen=$(this).attr('data-imagen');
            agregar(codigo,producto,precio,imagen,existencias);
        }
        
    });

    $(document).on("click","#agregar_a_tabla", function(e){
        cantidad=$("#cuantos").val();
        if(cantidad>0){
            if(cantidad>existencias){
                swal('Aviso','la cantidad supera las existencias','warning');
            }else{
                agregar(codigo,producto,precio,cantidad);
                $("#md_digitar_cantidad").modal("hide");
                $("#cuantos").val(1);
            }
        }else{
            swal('Aviso','Debe digitar la cantidad','warning');
        }
    });

    /// *** buscar segun departamento *** ///
    $(document).on("change","#depart", function(e){
      var iddepar=$(this).val();
      $("#busqueda").val("");
      $.ajax({
        url:'json_ventas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',departamento:iddepar},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
          if(json[2]){
            $("#aqui_busqueda_venta").empty();
          $("#aqui_busqueda").html(json[2]);
        }else{
          $("#aqui_busqueda_venta").empty();
          $("#aqui_busqueda_venta").html(no_datos);
          //swal.closeModal();
        }
        }
      });
    });

     //buscar con funcion input
    $(document).on("input","#busqueda", function(e){
      var esto=$(this).val();
      var departamento=$("#depart").val();
      $.ajax({
        url:'json_ventas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto,departamento},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
          if(json[2]){
            $("#aqui_busqueda_venta").empty();
          $("#aqui_busqueda_venta").html(json[2]);
        }else{
          $("#aqui_busqueda_venta").empty();
          $("#aqui_busqueda_venta").html(no_datos);
        }
        }
      });
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
});

function facturar(tipo_pago,factura,efectivo,cambio,total,cliente_aqui,cliente_debe,descripcion_debe){
      var venta = new Array();
        var total=total;
        var efectivo=efectivo;
        var tipo_pago=tipo_pago;
        var cambio = cambio;
        var tipo_factura=factura;
        var cliente_aqui=cliente_aqui;
        var cliente_debe=cliente_debe;
        var descripcion_debe=descripcion_debe;
        $(cuerpo).find("tr:eq(1)").find('td:eq(2)').find('input').each(function (index, element) {
          if(element){
            venta.push({
                  codigo: $(element).attr("data-codigo"),
                  precio: parseFloat($(element).attr("data-precio")),
                  cantidad :parseFloat($(element).attr("data-cantidad")),
                  subtotal : parseFloat($(element).attr("data-sub"))
            });
          }
        });

        console.log(venta);

        $.ajax({
            url:'json_ventas.php',
            type:'POST',
            dataType:'json',
            data:{venta:venta,total:total,tipo_factura:tipo_factura,cliente:cliente_aqui,cliente_debe:cliente_debe,descripcion_debe,descripcion_debe,efectivo:efectivo,cambio:cambio,tipo_pago:tipo_pago,data_id:'nueva_venta'},
            success: function(json){
                console.log(json);
                if(json[0]==1){
                    guardar_exito();
                    //ticket(json[1]);
                    if(json[2]=="1"){
                      credito(json[1]);
                    }
                    if(json[2]=="2"){
                      consumidor(json[1]);   
                    }
                    if(json[2]=="3"){
                        ticket(json[1],efectivo,cambio,total);
                    }
                }else{
                    guardar_error();
                }
            }
        });    
    }

//funcion que imprime ticket luego de la compra
function ticket(venta,efectivo,cambio,total){
    console.log("esto "+venta);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/ticketp.php?datos='+venta+'&efectivo='+efectivo+'&cambio='+cambio+'&total='+total+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/ticket.php?datos='+venta+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

//funcion que imprmer factura consumidor final
function consumidor(venta,efectivo,cambio,total){
    console.log("esto "+venta);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/final.php?datos='+venta+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/final.php?datos='+venta+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

function credito(venta,efectivo,cambio,total){
    console.log("esto "+venta);
    var h = $( window ).height();
    console.log(h);
    var iframe = '<div class="iframe-container"><iframe id="PDF_doc" src="../../lib/tcpdf/reportes/fiscal.php?datos='+venta+'" width="100%" height="'+(h-100)+'px"></iframe></div>'+
      '<div class="iframe-container"><iframe id="PDF_doc2" class="hide" src="../../lib/tcpdf/reportes/fiscal.php?datos='+venta+'" width="100%" height="100%"></iframe></div>';
    console.log(iframe);
    $("#md_imprimir .modal-body").empty().html(iframe);
    console.log(iframe);
    swal.close();
    $("#md_imprimir").modal({show: 'false'});
}

function traer_clientes(cliente){
  var select='<option value="">Cliente general</option>';
  $.ajax({
    url:'json_ventas.php',
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

//agregar los productos a la tabla
function agregar(codigo,producto,precio,imagen,existencias){
    var sub=parseFloat(precio);
        total+=sub;
        var alert=$("#alert");
        alert.remove();
        //$("#orden_tb").empty();
        $("#orden_tb").append(
            /*'<tr data-codigo='+codigo+' data-cantidad='+cantidad+'>'+
                '<td>'+producto+'</td>'+
                '<td>$'+precio+'</td>'+
                '<td>'+
                    '<div class="input-group">'+
                    '<span class="input-group-btn">'+
                    '<button type="button" id="minus" class="btn btn-primary" data-quantity="minus" data-field="'+codigo+'"><i class="fa fa-minus"></i></button>'+
                    '</span>'+
                    '<input type="number" data-sub="'+sub+'" class="form-control" data-codigo="'+codigo+'" data-precio="'+precio+'" name="'+codigo+'" id="canti" value="1" step="1" min="1" max="100" placeholder="" readonly="">'+
                    '<span class="input-group-btn">'+
                    '<button type="button" id="plus" class="btn btn-primary" data-quantity="plus" data-field="'+codigo+'"><i class="fa fa-plus"></i></button>'+
                    '</span>'+
                    '</div>'+
                '</td>'+
                '<!--td>'+cantidad+'</td-->'+
                '<td id="'+codigo+'">$ '+sub+'</td>'+
                '<td>'+
                    '<button class="btn btn-danger" id="btn_quitar"><i class="fa fa-remove"></i></button>'+
                '</td>'+
            '</tr>'*/
            '<div class="col-xs-12 col-sm-12 col-lg-12 '+codigo+'" id="listado-card">'+
                        '<div class="widget">'+
                          '<div class="widget-simple">'+
                            '<table width="100%">'+
                               ' <tbody id="cuerpo">'+
                                    '<tr id="'+codigo+'">'+
                                        '<td width="15%"></td>'+
                                        '<td width="15%" rowspan="3"><center><img src="../../img/productos/'+imagen+'" alt="avatar" class="widget-image img-circle"></center></td>'+
                                        '<td style="font-size: 18px;"><b>'+producto+'</b></td>'+
                                        '<td width="15%">'+
                                            '<span>'+
                                                '<center><button type="button" id="plus" class="btn btn-default btn-xs" data-quantity="plus" data-field="'+codigo+'"><i class="fa fa-plus"></i></button></center>'+
                                            '</span>'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td><a style="border-radius: 90px" class="btn btn-mio btn-lg" id="btn_quitar" data-codigo="'+codigo+'" href="javascript:void(0)"><i class="fa fa-times"></i></a></td>'+
                                        '<td style="font-size: 18px;">Precio: $'+precio+'</td>'+
                                        '<td align="center">'+
                                            '<input type="number" data-cantidad="1" data-sub="'+sub+'" class="form-control" data-codigo="'+codigo+'" data-precio="'+precio+'" data-existencia="'+existencias+'" name="'+codigo+'" id="canti" value="1" step="0.01" max="'+existencias+'" placeholder="" >'+
                                        '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td width="15%"></td>'+
                                        '<td></td>'+
                                        '<td>'+
                                            '<span>'+
                                                '<center><button type="button" id="minus" class="btn btn-default btn-xs" data-quantity="minus" data-field="'+codigo+'"><i class="fa fa-minus"></i></button></center>'+
                                            '</span>'+
                                        '</td>'+
                                    '</tr>'+
                                '</tbody>'+
                            '</table>'+
                          '</div>'+
                        '</div>'+
                    '</div>'
            );
        $("#total").text("$"+total.toFixed(2));
        $("#totalp").val(total.toFixed(2));
}


