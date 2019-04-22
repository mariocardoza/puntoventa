$(document).ready(function(e){
	cargar_paquetes();
	  //cargar el modal para guardar
	  $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar").modal("show");
    });

    //validar formulario
    $("#fm_paquete").validate({
    	ignore: ":hidden:not(select)",
    	rules: {
    		nombre:"required",
	    	precio:{
	          required:true,
	          number:true
	    	}
	    },
        submitHandler: function(form) {
          guardar();
        }
    });

    /// editar paquete ///
    $(document).on("click","#btn_editar", function(e){
      var valid=$("#fm_paquete").valid();
      if(valid){
        var datos=$("#fm_paquete").serialize();
        modal_cargando();
        $.ajax({
          url:'json_paquetes.php',
          type:'POST',
          dataType:'json',
          data:datos,
          success:function(json){
            if(json[0]==1){
              $("#fm_paquete").trigger("reset");
              guardar_exito();
              $(".modal").modal("hide");
              cargar_paquetes();
            }else{
              swal.closeModal();
              guardar_error();
            }
          }
        });
      }
    });

    /**** modal apra agregar productos al paquete ***/
    $(document).on("click","#agregar_productos",function(e){
      var codigo=$(this).attr("data-codigo");
      var nombre=$(this).attr("data-nombre");
      cargar_productos(codigo);
      $("#n_ver_paquete").text("Paquete: "+nombre);
      $("#elpaquete").val(codigo);
      $("#md_agregar_productos").modal("show");
    });

    /**** Agregar productos al paquete ****/
    $(document).on("click","#agregar_p",function(e){
      var codigo=$("#elproducto").val();
      var paquete = $("#elpaquete").val();
      $.ajax({
        url:'json_paquetes.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'guardarle_productos',paquete,codigo},
        success:function(json){
          console.log(json);
          if(json[0]==1){
            cargar_productos(paquete);
            guardar_exito();
          }else{
            guardar_error();
          }
        }
      });
    });

    /** Guardar los productos del paquete en la base **/
    $(document).on("click","#agregar_losproductos",function(e){
      var paquete = $("#elpaquete").val();
      var productos = new Array();
      $("#cuerpo2").find("tr").each(function(index,element){
        if(element){
          productos.push({
            codigo:$(element).attr("data-elcodigo")
          });
        }
      });
      console.log(paquete,productos);
      $.ajax({
        url:'json_paquetes.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'guardarle_productos',paquete,productos},
        success:function(json){
          console.log(json);
          if(json[0]==1){
            cargar_productos(paquete);
            guardar_exito();
          }else{
            guardar_error();
          }
        }
      });
    });

    /** quitar producto de la base **/
    $(document).on("click","#quita_base",function(e){
      var codigo = $(this).attr("data-codigo");
      var paquete = $(this).attr("data-paquete");
      swal({
       title: '¿Desea continuar?',
       text: "¡Se eliminara el producto!",
       type: 'warning',
       showCancelButton: true,
       cancelButtonText:"Cancelar",
       confirmButtonColor: 'red',
       cancelButtonColor: '#3085d6',
       confirmButtonText: '¡Si, continuar!'
       }).then(function () {
          $.ajax({
              url:'json_paquetes.php',
              type:'POST',
              dataType:'json',
              data:{codigo,paquete,data_id:'eliminar_item'},
              success: function(json){
                if(json[0]==1){
                  guardar_exito()
                  cargar_productos(paquete);
                }else{
                  guardar_error();
                }
              }
          });
       });
    });

      //buscar con funcion input
    $(document).on("input","#busqueda", function(e){
      var esto=$(this).val();
      $.ajax({
        url:'json_paquetes.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto},
        success: function(json){
          console.log(json);
          if(json[2]){
            $("#aqui_busqueda").empty();
            $("#aqui_busqueda").html(json[2]);
        }else{
          $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(no_datos);
        }
        }
      });
    });
});

function cargar_productos(codigo){
  $.ajax({
    url:'json_paquetes.php',
    type:'POST',
    dataType:'json',
    data:{data_id:'cargar_productos',codigo:codigo},
    success: function(json){
      console.log(json);
      $("#elproducto").empty();
      $("#elproducto").append(json[2]);
      $(".select-chosen").chosen({'width':"100%"});
      $("#elproducto").trigger("chosen:updated");
      $("#cuerpo").empty();
      $("#cuerpo").append(json[3]);
      $("#cuerpo2").empty();
    }
  });
}

function guardar(){
	modal_cargando();
  var datos=$("#fm_paquete").serialize();
  console.log(datos);
  $.ajax({
    url:'json_paquetes.php',
    type:'POST',
    dataType:'json',
    data:datos,
    success:function(json){
      if(json[0]==1){
          $("#fm_paquete").trigger("reset");
          guardar_exito();
          $(".modal").modal("hide");
          cargar_paquetes();
      }else{
        swal.close();
        guardar_error();
      }
    }
  });
}

function cargar_paquetes(){
	modal_cargando();
	$.ajax({
    url:'json_paquetes.php',
    type:'POST',
    dataType:'json',
    data:{data_id:'busqueda',esto:''},
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

function editar(id){
  $.ajax({
    url:'json_paquetes.php',
    type:'POST',
    dataType:'json',
    data:{data_id:'modal_editar',id:id},
    success: function(json){
    	if(json[0]==1){
        $("#modal_edit").html(json[2]);
        $('.select-chosen').chosen({width: "100%"});
        $("#md_editar").modal("show");
      }
    }
  });
}

function verpaquete(codigo){
  $.ajax({
    url:'json_paquetes.php',
    type:'POST',
    dataType:'json',
    data:{data_id:'modal_ver',codigo},
    success:function(json){
      if(json[0]==1){
        $("#modal_edit").html(json[2]);
        $("#md_ver").modal("show");
      }
    }
  });
}