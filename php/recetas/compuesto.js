$(document).ready(function(e){
traer_subcategorias();
	$(document).on("change","#lacate",function(e){
		var id=$(this).val();
		traer_subcategorias(id);
	});

	$(document).on("click","#btn_obtener",function(e){
		var lasopciones=$("#laopcion").val();
		var nombre = $("#nombre").val();
		var descripcion = $("#descripcion").val();
		var limite = $("#limite").val();
		$.ajax({
			url:'json_compuesto.php',
			type:'POST',
			dataType:'json',
			data:{data_id:'guardar_componente',lasopciones,nombre,descripcion,limite},
			success:function(json){
				if(json[0]==1){
					guardar_exito();
				}else{
					guardar_error();
				}
			}
		});
	});
});

function traer_subcategorias(){
	$.ajax({
		url:'json_compuesto.php',
		type:'POST',
		dataType:'json',
		data:{data_id:'traer_subcategorias'},
		success:function(json){
			//console.log(json);
			if(json[0]==1){
				$("#laopcion").empty();
				$("#laopcion").append(json[2]);
				$("#laopcion").trigger("chosen:updated");
				$("#laopcion").chosen({'width':'100%'});
			}
		}
	});
}