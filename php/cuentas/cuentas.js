$(document).ready(function(e){
	cargar_todos();

	$(document).on("change","#turnos", function(e){
		var turno=$(this).val();
		$("#busqueda").val();
		$.ajax({
        url:'json_cuentas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',turno:turno},
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
	});
});
function cargar_todos(){
        $.ajax({
        url:'json_cuentas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',turno:''},
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