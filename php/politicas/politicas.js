$(document).ready(function(e){
    cargar_todas();

    $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar").modal("show");
    });
	//habilitar elemento de minimo de stock
	 $('input[name="tipo"]').change(function(e) {
        var tipo = $(this).val();
        if(tipo=="stock"){
        	$("#minimo_fm_group").show();
        	$("#minimo").removeAttr("disabled");
        }else{
        	$("#minimo_fm_group").hide();
        	$("#minimo").prop("disabled",true);
        }
    });
		//guardar politica
	 $(document).on("click","#btn_guardar", function(e){
            var valid=$("#fm_politicas").valid();
            if(valid){
                var datos=$("#fm_politicas").serialize();
                $.ajax({
                    url:'json_politicas.php',
                    type:'POST',
                    dataType:'json',
                    data:datos,
                    success:function(json){
                        if(json[0]==1){
                            guardar_exito("politicas");
                        }else{
                            guardar_error();
                        }
                    }
                });
            }
        });
});

function cargar_todas(){
    modal_cargando();
      $.ajax({
        url:'json_politicas.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda'},
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