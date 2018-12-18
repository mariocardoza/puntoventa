$(document).ready(function(e){
	//habilitar elemento de fecha de caducidad
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