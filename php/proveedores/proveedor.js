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
        url:'json_proveedores.php',
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
      //var departamento=$("#depart").val();
      $.ajax({
        url:'json_proveedores.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'busqueda',esto},
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

	//validar nit
	 $(document).on('blur', '#nit', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                validar_nit(valor.val(),"tb_proveedor",valor);
            }
        });

      //validar email
     $(document).on('blur', '#email', function(event) {
            event.preventDefault();
            var valor = $(this);
            if (valor.val() != "") {
                validar_correo(valor.val(),"tb_proveedor",valor);
            }
        });
     //validar telefono 
     $(document).on("blur","#telefono", function(e){
        e.preventDefault();
        var valor=$(this);
        if(valor.val()!=""){
            validar_telefono(valor.val(),"tb_proveedor",valor);
        }
     });

     $(document).on("blur","#nrc", function(e){
        e.preventDefault();
        valor =$(this);
        if(valor.val()!=""){
            validar_nrc(valor.val(),"tb_proveedor",valor);
        }
     });



     //boton guardar
     $(document).on("click","#btn_guardar", function(e){
        var valid = $("#fm_proveedor").valid();
        if(valid){
            var datos=$("#fm_proveedor").serialize();
            $.ajax({
                url:'json_proveedores.php',
                type:'POST',
                dataType:'json',
                data:datos,
                success: function(json){
                    console.log(json);
                    if(json[0]==1){
                        guardar_exito("proveedores");
                    }else{
                        guardar_error();
                    }
                }
            });
        }
     });
});

function editar(id){
    $.ajax({
        url:'json_proveedores.php',
        type:'POST',
        dataType:'json',
        data:{data_id:'modal_editar',id:id},
        success: function(json){
            $("#modal_edit").html(json[3]);
            $("#md_editar").modal('show');
        }
    });
}