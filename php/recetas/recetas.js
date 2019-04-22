var table_procesos = cargar_tabla2("productos_table"); //inicializar tabla
var receta="";
$(document).ready(function(e){
  /// *** funcion para cargar modal *** ///
  $(document).on("click","#md_detalle", function(e){
    $("#md_agregar_productos").modal("show");
  });

  $(document).on("click","#agregar", function(e){
    var cate=$("#cate").val();
    var tipo=$("input[name='tipo']:checked"). val()
    if(tipo==1) var te="Obligatorio";
    else var te= "Opcional";
    var cantidad=$("#canti").val();

    $(cuerpo).append(
      '<tr>'+
        '<td>'+cate+'</td>'+
        '<td>'+te+'</td>'+
        '<td>'+cantidad+'</td>'+
      '<tr>'
      );
  });

  /// ****** agregar producto a la receta **** ///
    $(document).on("click","#btn_agregar", function(e){
      var producto=$("#producto").val() || 0;
      var n_producto = $("#producto option:selected").text();
      var cantidad=$("#cantidad").val() || 0;
      var medida=$("#producto option:selected").attr("data-unidad");
      var existe = $("#producto option:selected");
       var f = new Fraction(cantidad); 
      var fraccion= f.numerator + '/' + f.denominator;
      //console.log(existe);
      if(producto && cantidad){
        $(cuerpo).append(
          '<tr data-codigo="'+producto+'" data-cantidad="'+cantidad+'">'+
            '<td>'+n_producto+'</td>'+
            '<td>'+fraccion+' '+medida+'</td>'+
            '<td><button type="button" class="btn btn-mio btn-xs" id="quita"><i class="fa fa-times"></i></button></td>'+
          '</tr>'
          );
     
        //var cate=$("#categoria").val();
        //$("#categoria").trigger("change");
        //console.log(productos_array)
        $(existe).css("display", "none");
        $("#cantidad").val("");
        $("#producto").val("").trigger('chosen:updated');
      }else{
        swal('aviso',
          'Seleccione un producto y digite la cantidad',
          'warning');
      }
    });

    $(document).on("click","#quita", function(e){
      var tr=$(e.target).parents("tr");
      quitar_mostrar($(tr).attr("data-codigo"));
      tr.remove();
    });

    //cargar modal de registrar nuevo
    $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar").modal("show");
    });

  
	//habilitar elemento de fecha de caducidad
	

   $(document).on("click","#btn_guardar", function(e){
      var valid=$("#form_receta").valid();
      if(valid){
        var nombre=$("#nombre").val();
        var descripcion = $("#descripcion").val();
        var precio = $("#precio").val();
        var tipo = $("#tipo").val();
        modal_cargando();
          $.ajax({
            url:'json_recetas.php',
            type:'POST',
            dataType:'json',
            data:{data_id:'nueva_receta',nombre,descripcion,precio,tipo},
            success: function(json){
              console.log(json);
              console.log(json[2][3])
              receta=json[2][3];
              if(json[0]==1){
                if ($("#file_1").val()!="") {
                      insertar_imagen($("#file_1"),json[2][3]);
                  }else{
                      var html='<button class="btn btn-primary" data-codigo="'+json[2][3]+'" id="btn_receta" data-toggle="tooltip" data-original-title="Guardar"><i class="fa fa-save"></i> Guardar receta</button> ' +
                          '<button class="btn btn-default btn-pure" id="btn_cerrar_swal" data-toggle="tooltip" data-original-title="Cancelar"><i class="fa fa-times"></i> Cancelar</button>';
                       swal({
                          title: '¿Que desea hacer a continuación?',
                          text: "",
                          html: html,
                          type: 'info',
                          showCancelButton: false,
                          showConfirmButton: false,
                          allowEscapeKey: false,
                          allowOutsideClick: false,
                      });
                  }
                guardar_exito();
                
              }else{
                swal.close();
                guardar_error();
              }
            }
          });
      }
   });

	 //eventos para la imagen
	$(document).on("click", "#img_file", function (e) {
        $("#file_1").click();
    });
    $(document).on("click", "#btn_subir_img", function (e) {
        $("#file_1").click();
    });
    $("#file_1").change(function(event) {
        validar_archivo($(this));
    });

    $(document).on("click","#btn_receta", function(e){
      var codigo = $(this).attr("data-codigo");
      window.location.href="ingredientes.php?receta="+codigo;
    });

    $(document).on("click","#btn_cerrar_swal", function(e){
      window.location.href="recetas.php";
    });

    $(document).on("click","#btn_guardar_ingredientes", function(e){
      var ingredientes = new Array();
      var receta = $("#cod_receta").val();
        $(cuerpo).find("tr").each(function (index, element) {
          if(element){
            ingredientes.push({
              codigo: $(element).attr("data-codigo"),
              cantidad :$(element).attr("data-cantidad")
            });
          }
        });

        $.ajax({
          url:'json_recetas.php',
          type: 'POST',
          dataType:'json',
          data:{data_id:'guardar_ingredientes',ingredientes,receta},
          success: function(response){
            console.log(response);
            if(response[0]=1){
              guardar_exito();
              window.location.href="recetas.php";
            }else{
              guardar_error();
            }
          }
        });
    });

    ///abrir modal de ver producto

    $(document).on("click","#btn_editar", function(e){
      //modal_cargando();
        var valid=$("#form-producto").valid();
        datos=$("#form-producto").serialize();
        if(valid){
          
          $.ajax({
            url:'json_recetas.php',
            type:'POST',
            dataType:'json',
            data: datos,
            success: function(json){
              console.log(json);
              if(json[0]=="1"){
                 guardar_exito();
                  cargar();
                  //alert("aqui");
                $(".modal").modal("hide");
               $(".form-control").val("");
              }else{
                guardar_error();
              }
            }
          });
        }
    });

    $(document).on("click","#subir_imagen", function(e){
      var codigo=$("#codiguito").val();
      insertar_imagen($("#file_1"),codigo);
    });

    //cambiar imagen
    $(document).on("click","#cambiar_imagen", function(e){
        $("#md_cambiar_imagen").modal("show");
        var codigo=$(this).data('codigo');
        $("#codiguito").val(codigo);
    });

});

///guardar en la base de datos
function guardar(){
	var datos = $("#form-productog").serialize();
  //var equivalencia = $("#medida").attr("data-equivalencia");
	console.log(datos);
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url:'json_recetas.php',
		data:datos,
		success: function(json){
      console.log(json);
			if(json[0]==1){
        if ($("#file_1").val()!="") {
          insertar_imagen($("#file_1"),json[1]);
        }else{
          iziToast.success({
            title: 'Excelente',
            message: 'Datos almacenados correctamente',
            timeout: 3000,
          });
          var timer=setInterval(function(){
            //$("#md_nuevo").modal('toggle');
            //window.location.href="productos.php";
            clearTimeout(timer);
          },3500);
        }
      }if(json[0]==-1){
        swal.close();
        iziToast.error({
          title: 'Error',
          message: 'Hubo un problema al procesar la solicitud, intentelo nuevamente',
          timeout: 3000,
        });
      }
		}
	});
}

//funcion que validad que el archivo sea una imagen
function validar_archivo(file){
        $("#img_file").attr("src","../../img/imagenes_subidas/image.svg");//31.gif
            //var ext = file.value.match(/\.(.+)$/)[1];
             //Para navegadores antiguos
             if (typeof FileReader !== "function") {
                $("#img_file").attr("src",'../../img/imagenes_subidas/image.svg');
                return;
             }
             var Lector;
             var Archivos = file[0].files;
             var archivo = file;
             var archivo2 = file.val();
             if (Archivos.length > 0) {

                Lector = new FileReader();

                Lector.onloadend = function(e) {
                    var origen, tipo, tamanio;
                    //Envia la imagen a la pantalla
                    origen = e.target; //objeto FileReader
                    //Prepara la información sobre la imagen
                    tipo = archivo2.substring(archivo2.lastIndexOf("."));
                    console.log(tipo);
                    tamanio = e.total / 1024;
                    console.log(tamanio);

                    //Si el tipo de archivo es válido lo muestra, 

                    //sino muestra un mensaje 

                    if (tipo !== ".jpeg" && tipo !== ".JPEG" && tipo !== ".jpg" && tipo !== ".JPG" && tipo !== ".png" && tipo !== ".PNG") {
                        $("#img_file").attr("src",'../../img/imagenes_subidas/photo.svg');
                        $("#error_formato1").removeClass('hidden');
                        //$("#error_tamanio"+n).hide();
                        //$("#error_formato"+n).show();
                        console.log("error_tipo");
                    }
                    else{
                        $("#img_file").attr("src",origen.result);
                        $("#error_formato1").addClass('hidden');
                    }


               };
                Lector.onerror = function(e) {
                console.log(e)
               }
               Lector.readAsDataURL(Archivos[0]);
       }
       
    }

    //subir la imagen
function insertar_imagen(archivo,id_prod){
  var file =archivo.files;
  var formData = new FormData();
  formData.append('formData', $("#form_receta"));
  var data = new FormData();
   //Append files infos
   jQuery.each(archivo[0].files, function(i, file) {
      data.append('file-'+i, file);
   });

   console.log("data",data);
     $.ajax({  
        url: "json_imagen.php?id="+id_prod,  
        type: "POST", 
        dataType: "json",  
        data: data,  
        cache: false,
        processData: false,  
        contentType: false, 
        context: this,
        success: function (json) {
            console.log(json);
            if(json.exito){  
              var html='<button class="btn btn-primary" data-codigo="'+receta+'" id="btn_receta" data-toggle="tooltip" data-original-title="Guardar"><i class="fa fa-save"></i> Guardar receta</button> ' +
                          '<button class="btn btn-default btn-pure" id="btn_cerrar_swal" data-toggle="tooltip" data-original-title="Cancelar"><i class="fa fa-times"></i> Cancelar</button>';
              swal({
                title: '¿Que desea hacer a continuación?',
                text: "",
                html: html,
                type: 'info',
                showCancelButton: false,
                showConfirmButton: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
              });
            }
            if(json.error){
                swal.close();
                swal({
                  title: '¡Advertencia!',
                  html: $('<div>')
                  .addClass('some-class')
                  .text('No se logro insertar la imagen'),
                  animation: false,
                  allowEscapeKey:false,
                  allowOutsideClick:false,
                  customClass: 'animated tada',
                        //timer: 2000
                      }).then(function (result) {
                        //$("#md_cantidad").focus();
                        
                      });
            }

        }
    });
}

function quitar_mostrar (ID) {
    $("#producto option").each(function (index, element) {
      if($(element).attr("value") == ID ){
        $(element).css("display", "block");
      }
    });
    $("#producto").trigger('chosen:updated');
  }
    