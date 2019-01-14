$(document).ready(function(e){
	$("#tipo_tel").selectpicker();
	$(document).on("click","#btn_agregar_telefono", function(e){
		$("#md_agregar_telefono").modal("show");
	});

		//validar nit
	 $(document).on('blur', '#nit', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                validar_nit(valor.val(),"tb_negocio",valor);
            }
        });

      //validar email
     $(document).on('blur', '#email', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                validar_correo(valor.val(),"tb_negocio",valor);
            }
        });
     //validar telefono 
     $(document).on("input","#tel", function(e){
     	$(".validar").show();
        	$("#btn_agre_tel").hide();
     });

     $(document).on("click",".validar", function(e){
        e.preventDefault();
        var tel =$("#tel");
        //var valor=$(this);
        if(tel.val()!="" && !val_tel){
            var ver= validar_telefono(tel.val(),"tb_telefono_negocio",tel);
        }
        else{
        	$(".validar").hide();
        	$("#btn_agre_tel").show();
        }
     });

     //quitar telefono
     $(document).on("click","#quita", function(e){
     	var tr= $(e.target).parents("tr");
     	tr.remove();
     });

     //edita telefono
     $(document).on("click","#edita", function(e){
     	var tr= $(e.target).parents("tr");
     	var tipo=$(this).parents('tr').find('td:eq(0)').text();
     	var numero=$(this).parents('tr').find('td:eq(1)').text();
     	$("#tel").val(numero);
     	$("#tipo_tel").val(tipo);
     	$("#tipo_tel").selectpicker('refresh');
     	$("#md_agregar_telefono").modal("show");
     	tr.remove();
     });

     $(document).on("blur","#nrc", function(e){
        e.preventDefault();
        valor =$(this);
        if(valor.val()!=""){
            //validar_nrc(valor.val(),"dGJfbmVnb2Npbw==",valor); encriptada
            validar_nrc(valor.val(),"tb_negocio",valor); 
        }
     });

	$(document).on("click","#btn_agre_tel", function(e){
		var tipo=$("#tipo_tel").val() || 0;
		var numero=$("#tel").val() || 0;
		if(tipo && numero){
        	var html='<tr>'+
						'<input type="hidden" readonly name="telefono[]" class="form-control" value="'+numero+'">'+
	                    '<input type="hidden" readonly name="tipo[]" class="form-control" value="'+tipo+'">'+
                    '<td>'+tipo+'</td>'+
                    '<td>'+numero+'</td>'+
                    '<td>'+
                    	'<button type="button" class="btn btn-warning btn-xs" id="edita"><i class="fa fa-edit"></i></button>'+  
                    	'<button type="button" class="btn btn-danger btn-xs" id="quita"><i class="fa fa-remove"></i></button>'+  
                    '</td></tr>';
		$("#tels_aqui").append(html);
		$("#tel").val("");
		$("#tipo_tel").selectpicker('refresh');
		}else{
			iziToast.error({
	          title: 'Error',
	          message: 'Debe seleccionar un tipo y digitar el teléfono',
	          timeout: 3000,
        	});
		}
		
	});

	//validar 
	$("form[name='fm_negocio']").validate({
            ignore: ":hidden:not(select)",
            rules: {
            	tipo_empresa:{
            		required:true,
            	},
                nombre: {
                	required:true,
                	minlength:3
                },
                direccion:"required",
                nrc:"required",
               	email:{
               		required:true,
               		email:true
               	},
               	nit:{
               		required:true,
               		minlength: 10
               	}
            },

            submitHandler: function(form) {
              //form.submit();
              guardar();
            }
        });
});

function guardar(){
	var datos=$("#fm_negocio").serialize();
	console.log(datos);
	$.ajax({
		url:'json_empresa.php',
		type:'POST',
		dataType:'json',
		data:datos,
		success: function(json){
			if(json[0]==1){
				guardar_exito();
                console.log(json);
                window.location.href="perfil_empresa.php";
			}else{
				guardar_error();

			}

		}
	});
}