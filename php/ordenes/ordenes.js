var total=0.0;
var codigo="";
var producto="";
var imagen="";
var precio=0.0;
var cantidad=0;
var existencias=0;
$(document).ready(function(e){
    $(document).on("click","#btn_guardar", function(e){
            var valid=$("#fm_orden").valid();
            if(valid){
                var datos=$("#fm_orden").serialize();
                $.ajax({
                    url:'json_ordenes.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito("ordenes");
                        }else{
                            guardar_error();
                        }
                    }
                });
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
        var canti=$(this).val();
        var precio_aqui=parseFloat($(this).attr('data-precio'));
        if(canti==1){
        	alert("es uno");
        }else{
        	var canti_aqui=parseInt($(this).attr('data-cantidad'));
	        
	        var codigo=$(this).attr('data-codigo');
	        var sub_anterior=parseFloat($(this).attr('data-sub'));
	        if(canti>canti_aqui){
	        	var contador=canti;
	        	var sub=sub_anterior+precio_aqui;
	        	total+=precio_aqui;
	        }else{
	        	var contador=canti;
	        	contador--;
	        	var sub=sub_anterior-precio_aqui;
	        	total-=precio_aqui;
	        }
	        
	        
	        $("#total").text("$"+total.toFixed(2));
	        $( "input[name='"+codigo+"']" ).attr('data-sub', sub);
	        $( "input[name='"+codigo+"']" ).attr('data-cantidad', contador);
        }

        
    });

    //quitar de la tabla
    $(document).on("click","#btn_quitar", function(e){
        var codigo=$(this).attr('data-codigo');
        var input=$(e.target).parents("tbody").find('tr:eq(1)').find('td:eq(2)').find('input');
        var subtotal=parseFloat(input.attr('data-sub'));
        /*var fila=$(this).parents('tr').find('td:eq(3)').text();
        var res=fila.split(" ");
        var totalFila=parseFloat(res[1]);
        total=total-totalFila;
        tr.remove();
        $("#total").text("$"+total);*/
    });

    //cobrar
    $(document).on("click","#btn_cobrar", function(e){
        var venta = new Array();
        $(cuerpo).find("tr:eq(1)").find('td:eq(2)').find('input').each(function (index, element) {
          if(element){
            venta.push({
                  codigo: $(element).attr("data-codigo"),
                  cantidad :parseInt($(element).attr("data-cantidad")),
                  subtotal : parseFloat($(element).attr("data-sub"))
              });
          }
      });

        console.log(venta);

        $.ajax({
            url:'json_ventas.php',
            type:'POST',
            dataType:'json',
            data:{venta:venta,data_id:'nueva_venta'},
            success: function(json){
                console.log(json);
            }
        });
    });


    //agregar imagen a la tabla
    $(document).on("click","#agrega_img",function(e){
        //$("#md_digitar_cantidad").modal("show");
        codigo=$(this).attr("data-codigo");
        producto=$(this).attr("data-nombre");
        precio=$(this).attr("data-precio");
        existencias =$(this).attr('data-existencia');
        imagen=$(this).attr('data-imagen');
        agregar(codigo,producto,precio,imagen);
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

    $(document).on("click","#ordenar", function(e){

    });
});

function agregar(codigo,producto,precio,imagen){
    var sub=parseFloat(precio);
        total+=sub;
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
            '<div class="col-xs-12 col-sm-12 col-lg-12 elementos" id="listado-card">'+
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
                                            '<input type="number" data-cantidad="1" data-sub="'+sub+'" class="form-control" data-codigo="'+codigo+'" data-precio="'+precio+'" name="'+codigo+'" id="canti" value="1" step="1" min="1" max="100" placeholder="" readonly="">'+
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
}


