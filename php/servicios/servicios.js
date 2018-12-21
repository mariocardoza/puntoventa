$(document).ready(function(e){
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