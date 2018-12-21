var total=0.0;
var codigo="";
var producto="";
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
        var canti=$(this).val();
        var precio=$(this).attr('data-precio');
        var codigo=$(this).attr('data-codigo');
        var sub_anterior=$(this).attr('data-sub');
        var sub=canti*precio;
        total=total-sub_anterior;
        total=total+sub;
        $("#total").text("$"+total);
        $("#"+codigo).text("$"+sub);
    });

    //quitar de la tabla
    $(document).on("click","#btn_quitar", function(e){
        var tr = $(e.target).parents("tr");
        var fila=$(this).parents('tr').find('td:eq(3)').text();
        var res=fila.split(" ");
        var totalFila=parseFloat(res[1]);
        total=total-totalFila;
        tr.remove();
        $("#total").text("$"+total);
    });


    //agregar imagen a la tabla
    $(document).on("click","#agrega_img,#agrega_img1",function(e){
        $("#md_digitar_cantidad").modal("show");
        codigo=$(this).attr("data-codigo");
        producto=$(this).attr("data-nombre");
        precio=$(this).attr("data-precio");
        existencias =$(this).attr('data-existencia');
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

function agregar(codigo,producto,precio,cantidad){
    var sub=precio*cantidad;
        total+=sub;
        $("#orden_tb").append(
            '<tr data-codigo='+codigo+' data-cantidad='+cantidad+'>'+
                '<td>'+producto+'</td>'+
                '<td>$'+precio+'</td>'+
                '<!--td>'+
                    '<div class="input-group">'+
                    '<span class="input-group-btn">'+
                    '<button type="button" id="minus" class="btn btn-primary" data-quantity="minus" data-field="'+codigo+'"><i class="fa fa-minus"></i></button>'+
                    '</span>'+
                    '<input type="number" data-sub="'+sub+'" class="form-control" data-codigo="'+codigo+'" data-precio="'+precio+'" name="'+codigo+'" id="canti" value="1" step="1" min="1" max="100" placeholder="" readonly="">'+
                    '<span class="input-group-btn">'+
                    '<button type="button" id="plus" class="btn btn-primary" data-quantity="plus" data-field="'+codigo+'"><i class="fa fa-plus"></i></button>'+
                    '</span>'+
                    '</div>'+
                '</td-->'+
                '<td>'+cantidad+'</td>'+
                '<td id="'+codigo+'">$ '+sub+'</td>'+
                '<td>'+
                    '<button class="btn btn-danger" id="btn_quitar"><i class="fa fa-remove"></i></button>'+
                '</td>'+
            '</tr>'
            );
        $("#total").text("$"+total);
}


