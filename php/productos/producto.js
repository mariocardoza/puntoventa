var table_procesos = cargar_tabla2("productos_table"); //inicializar tabla
$(document).ready(function(e){
  /// *** funcion para cargar todos los productos *** ///
  swal({
    title: 'Consultando datos!',
    text: 'Este diálogo se cerrará al cargar los datos.',
    showConfirmButton: false,
    onOpen: function () {
    swal.showLoading()
   }
  });
  cargar();

  /// ****** Fin cargar todos los productos **** ///

  /// *** buscar segun departamento *** ///
    $(document).on("change","#depart", function(e){
      var iddepar=$(this).val();
      $("#busqueda").val("");
      var estado = $("#estados").val();
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',departamento:iddepar,estado:estado},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
          if(json[2]){
            $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(json[2]);
        }else{
          $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(html);
          //swal.closeModal();
        }
        }
      });
    });

    //cargar modal de registrar nuevo
    $(document).on("click","#modal_guardar", function(e){
      $("#md_guardar").modal("show");
    });

    /// *** buscar segun estado *** ///
    $(document).on("change","#estados", function(e){
      var iddepar=$("#depart").val();
      var estado=$(this).val();
      $("#busqueda").val("");
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',departamento:iddepar,estado:estado},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
          if(json[2]){
            $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(json[2]);
        }else{
          $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(html);
          //swal.closeModal();
        }
        }
      });
    });

    //funcionar seleccion un departamento y actualizar select categoria
    $(document).on("change","#departamento", function(e){
      var id=$(this).val();
      obtener_categorias(id);
    });
    //funcionar seleccion un categoria y actualizar select subcategoria
    $(document).on("change","#categoria", function(e){
      var id=$(this).val();
      obtener_subcategorias(id);
    });
	//habilitar elemento de fecha de caducidad
	 $('#perecedero').change(function() {
        if( $(this).is(':checked') ){
        // Hacer algo si el checkbox ha sido seleccionado
        $("#venci").show();
        $("#vencimiento").removeAttr("disabled");
        $("#lotito").show();
        $("#lote").removeAttr("disabled");
    } else {
        // Hacer algo si el checkbox ha sido deseleccionado
        $("#venci").hide();
        $("#vencimiento").prop("disabled", true);
        $("#lotito").hide();
        $("#lote").prop("disabled",true);
    }
    });

   $(document).on("click","#btn_guardar", function(e){
      var valid=$("#form-producto").valid();
      if(valid){
        var datos=$("#form-producto").serialize();
        modal_cargando();
        $.ajax({
          url:'json_productos.php',
          type:'POST',
          dataType:'json',
          data:datos,
          success: function(json){
            if(json[0]==1){
              guardar_exito();
                  cargar();
                  //alert("aqui");
                $(".modal").modal("hide");
               //$(".form-control").val("");
            }else{
              swal.chose();
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

    //codigo para generar el sku
    $(document).on("click","#generar_sku", function(e){
    	$.ajax({
    		type: 'GET',
    		url:'generar_bc.php',
    		dataType: 'json',
    		data:{},
    		success: function(json){
    			console.log(json)
    		}
    	});
    });

    ///abrir modal de ver producto



    $("form[name='form-producto']").validate({
            ignore: ":hidden:not(select)",
            rules: {
                nombre: "required",
               	departamento: "required",
               	descripcion: "required",
               	categoria: "required",
               	subcategoria: "required",
               	cantidad: "required",
               	//precio: "required",
                precio: {
                  required: true
                },
               	proveedor: "required",
               	vencimiento: "required",
                lote: "required",
                ganancia:"required",
                vencimiento:"required"
            },
            
            messages: {
                nombre: "Complete este campo por favor",
                departamento: "Seleccione un departamento" ,
                categoria: "Seleccione una categoria",
                descripcion: "Digite la descripción",
                precio: {
                  required: "Digite el precio"
                },
                cantidad: "Digite la cantidad",
                subcategoria: "Seleccione una subcategoria",
                proveedor: "Seleccione un proveedor",
               vencimiento: "Seleccione la fecha de vencimiento",
               lote:"Digite el n° de lote",
               ganancia:"Digite el porcentaje de ganacia",
            },
            submitHandler: function(form) {
              //form.submit();
              guardar();
            }
        });

    $(document).on("click","#btn_editar", function(e){
      //modal_cargando();
        var valid=$("#form-producto").valid();
        datos=$("#form-producto").serialize();
        if(valid){
          
          $.ajax({
            url:'json_productos.php',
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

    //buscar con funcion input
    $(document).on("input","#busqueda", function(e){
      var esto=$(this).val();
      var departamento=$("#depart").val();
      var estado=$("#estados").val();
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto,departamento,estado:estado},
        success: function(json){
          console.log(json);
          var html='<div class="col-sm-6 col-lg-6">No se encontraron productos</div>';
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

    //asignar más mercadería
    $(document).on("click","#asignar_mas", function(e){
      var id=$(this).attr("data-id");
      var nombre=$(this).attr("data-nombre");
      $("#md_titulo").text(nombre);
      $("#id_producto").val(id);
      $("#md_agregar_mercaderia").modal('show');
    });

    //agregar más mercadería
    $(document).on("click","#agregar_existencia", function(e){
      var id=$("#id_producto").val();
      var cantidad=$("#canti").val();
      var precio = $("#precio").val();
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{id,cantidad,precio,data_id:'agregar_existencia'},
        success: function(json){
          console.log(json);
        }
      });
    });
});
//ver información de un producto
function verproducto(id){
  //$("#md_ver_producto").modal('show');
  //alert(id);
  $.ajax({
    url:'json_productos.php',
    type:'GET',
    dataType:'json',
    data:{id:id,data_id:'ver_producto'},
    success: function(json){
      console.log(json);
      $("#aqui_modal").html(json[3]);//imprime el modal 
      $("#md_ver_producto").modal('show'); // lanza el modal
    }
  });
}
///guardar en la base de datos
function guardar(){
	var datos = $("#form-producto").serialize();
  //var equivalencia = $("#medida").attr("data-equivalencia");
	console.log(datos);
	$.ajax({
		type: 'POST',
		dataType: 'json',
		url:'json_productos.php',
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
        formData.append('formData', $("#form-producto"));
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
                    iziToast.success({
                        title: 'Excelente',
                        message: 'Datos almacenados correctamente',
                        timeout: 3000,
                    });
                    timer=setInterval(function(){
                        location.reload();                        
                        clearTimeout(timer);
                    },2000);
                     NProgress.done();
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

    function editar(id){
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_editar',id:id},
        success:function(json){
          console.log(json);
          $("#aqui_modal").html(json[3]);
          $('.select-chosen').chosen({width: "100%"});
          $("#md_editar").modal("show");
          /*$("#departamento").trigger('change');
          $("#departamento").trigger('chosen:updated');
          $("#categoria").trigger('change');
          $("#categoria").trigger('chosen:updated');*/
        }
      });
    }

    function cargar(){
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto:'',departamento:'0',estado:'1'},
        success: function(json){
          console.log(json);
          $("#aqui_busqueda").empty();
          $("#aqui_busqueda").html(json[2]);
          swal.closeModal();
        }
      });
    }

    function obtener_categorias(id){
      var html="<option></option>";
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'categoria',id:id},
        success:function(json){
          $.each(json[1],function(index,value){
            console.log(value);
            html+="<option value="+value.id+">"+value.nombre+"</option>";
          });
          $("#categoria").html(html);
          $("#categoria").trigger("chosen:updated");
        }

      });
    }
    function obtener_subcategorias(id){
      var html="<option></option>";
      $.ajax({
        url:'json_productos.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'subcategoria',id:id},
        success:function(json){
          $.each(json[1],function(index,value){
            console.log(value);
            html+="<option value="+value.id+">"+value.nombre+"</option>";
          });
          $("#subcategoria").html(html);
          $("#subcategoria").trigger("chosen:updated");
        }

      });
    }

    