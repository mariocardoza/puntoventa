$(document).ready(function(e){
	swal({
	    title: 'Consultando datos!',
	    text: 'Este diálogo se cerrará al cargar los datos.',
	    showConfirmButton: false,
	    onOpen: function () {
	    swal.showLoading()
	   }
  	});
  $.ajax({
        url:'json_servicios.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:''},
        success: function(json){
          console.log(json);
            var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
            if(json[2]){
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(json[2]);
                swal.closeModal();
            }else{
                $("#aqui_busqueda").empty();
                $("#aqui_busqueda").html(html);
                swal.closeModal();
            }
        }
      });

                 //buscar con funcion input
    $(document).on("input","#busqueda", function(e){
      var esto=$(this).val();
      $.ajax({
        url:'json_servicios.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron servicios</div>';
          if(json[2]){
            $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(json[2]);
        }else{
          $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(html);
        }
        }
      });
    });

    $(document).on("click","#modal_guardar", function(e){
    	$(".form-control").val("");
    	$("#id").val("");
    	//$("#data_id").val("");
    	$("#md_guardar").modal("show");
    });

    $(document).on("click","#btn_guardar_n", function(e){

    });


	$(document).on("click","#btn_agregar_producto",function(e){
		$("#md_agregar_producto").modal("show");
	});

	//validaciones
	$("#fm_servicios").validate({
		ignore: ":hidden:not(select)",
		rules:{
			nombre:"required",
			descripcion:"required",
			duracion:"required",
			precio:{
				required:true,
				min:1
			}
		},
            submitHandler: function(form) {
              //form.submit();
          	  guardar();
            }
	});
});

function guardar(){
	var datos=$("#fm_servicios").serialize();
	modal_cargando();
	$.ajax({
		url:'json_servicios.php',
		type:'POST',
		dataType:'json',
		data:datos,
		success: function(json){
			if(json[0]==1){
				guardar_exito("servicios");
			}else{
				swal.close();
				guardar_error();
			}
		}
	});
}