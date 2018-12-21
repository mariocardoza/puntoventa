<?php
/**
 * template_scripts.php
 *
 * Author: pixelcave
 *
 * All vital JS scripts are included here
 *
 */
?>

<!-- jQuery, Bootstrap.js, jQuery plugins and Custom JS code -->
<script src="../../js/vendor/jquery.min.js"></script>
<script src="../../js/vendor/bootstrap.min.js"></script>
<script src="../../js/plugins.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="../../js/app.js"></script>

<script type="text/javascript" src="../../js/izitoast/iziToast.min.js?v=130c"></script>
<script type="text/javascript" src="../../datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../datepicker/locales/bootstrap-datepicker.es.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script src="../../js/jquery.validate.js"></script>
<script src="../../js/vendor/bootstrap-select/bootstrap-select.min.js"></script>

<!--script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script-->
  <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>

  <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

  <script src="../../js/sweetalert2.all.min.js"></script>

  <script src="../../js/mask/jquery.inputmask.bundle.js" type="text/javascript"></script>
  <script src="../../js/moment.min.js" type="text/javascript"></script>
  <script src="../../js/plus-minus-input.js" type="text/javascript"></script>

<style type="text/css" media="screen">
  header .dropdown-menu.dropdown-custom > li {
      font-size: 11px !important;
  }
</style>

<script type="text/javascript">
  var val_tel=false;
  var EXITO="Excelente";
  var EXITO_MENSAJE="Datos almacenados correctamente";
  var EXITO_ACTUALIZAR="Datos Actualizados";
  var ERROR="Error";
  var ERROR_MENSAJE="Hubo un problema al procesar la solicitud, intentelo nuevamente";
  var ERROR_CORREO="Al parecer el correo ingresado ya existe";
  var ELIMINAR="Eliminado";
  var ELIMINAR_MENSAJE="La información han sido borrada de la base de datos";
  var UsuarioCrea = '<?php echo $_SESSION['codigo'];?>';
  $(function(){
    $('.telefono').inputmask("9999-9999", { "clearIncomplete": true });
    $(".nacimiento").datepicker({
    isRTL: false,
    format: 'dd/mm/yyyy',
    autoclose:true,
    language: 'es',
    endDate: '-18y',
});
    $('.dui').inputmask("99999999-9", { "clearIncomplete": true });
    $('.nit').inputmask("9999-999999-999-9", { "clearIncomplete": true });
    $(".select_piker2").selectpicker();
    $('[data-toggle="tooltip"]').tooltip();
    jQuery.extend(jQuery.validator.messages, {
      required: "Este campo es obligatorio.",
      remote: "Por favor, rellena este campo.",
      email: "Por favor, escribe una dirección de correo válida",
      url: "Por favor, escribe una URL válida.",
      date: "Por favor, escribe una fecha válida.",
      dateISO: "Por favor, escribe una fecha (ISO) válida.",
      number: "Por favor, escribe un número entero válido.",
      digits: "Por favor, escribe sólo dígitos.",
      creditcard: "Por favor, escribe un número de tarjeta válido.",
      equalTo: "Por favor, escribe el mismo valor de nuevo.",
      accept: "Por favor, escribe un valor con una extensión aceptada.",
      maxlength: jQuery.validator.format("Por favor, no escribas más de {0} caracteres."),
      minlength: jQuery.validator.format("Por favor, digita al menos {0} caracteres."),
      rangelength: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
      range: jQuery.validator.format("Por favor, escribe un valor entre {0} y {1}."),
      max: jQuery.validator.format("Por favor, escribe un valor menor o igual a {0}."),
      min: jQuery.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
    });

    ///quantity plus
    $(document).on("click","#plus",function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        var max = parseInt($('input[name='+fieldName+']').attr("max"));
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
            $('input[name='+fieldName+']').val(currentVal + 1);
            if(max <= currentVal)$('input[name='+fieldName+']').val(max);
            $('input[name='+fieldName+']').trigger("input");
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
            $('input[name='+fieldName+']').trigger("input");
        }
    });

    //quuantity minus
    $(document).on("click","#minus",function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseInt($('input[name='+fieldName+']').val());
        var min = parseInt($('input[name='+fieldName+']').attr("min"));
        // If it isn't undefined or its greater than 0
        if(min >= currentVal ){
             $('input[name='+fieldName+']').val(min);
             $('input[name='+fieldName+']').trigger("input");
         }
        else if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(currentVal - 1);
            $('input[name='+fieldName+']').trigger("input");
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
            $('input[name='+fieldName+']').trigger("input");
        }
    });
  });
  function cargar_tabla(elem){
    App.datatables();
    $("#"+elem).DataTable({
      responsive: true,
      "language":{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar: ",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "fnDrawCallback": function( oSettings ) {
         $('[rel="tooltip"]').tooltip();
         //$('.tooltip').tooltip();
      },
      columnDefs: [
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: -1 }
      ],
      dom: 'Bfrtip',
        buttons: [
            {
                text: 'Descargar Excel',
                action: function ( e, dt, node, config ) {
                    descargar_logs();
                }
            }

        ]
    });

    $("[rel='tooltip']").tooltip();
  }

  function cargar_tabla3(elem){
    App.datatables();
    $("#"+elem).DataTable({
      responsive: true,
      "language":{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar: ",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "fnDrawCallback": function( oSettings ) {
         $('[rel="tooltip"]').tooltip();
         //$('.tooltip').tooltip();
      },
      columnDefs: [
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: -1 }
      ]
        
    });

    $("[rel='tooltip']").tooltip();
  }

  function cargar_tabla2(elem){
    App.datatables();
    return $("#"+elem).DataTable({
      responsive: true,
      //"lengthMenu": [[5, 10, 25, -1], [5, 10, 25, "Todos"]],
      "language":{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "bInfo": false,
       columnDefs: [
          { responsivePriority: 1, targets: 0 },
          { responsivePriority: 2, targets: -1 }
      ]
    });
  }
  function cargar_tabla3(elem){
    App.datatables();
    $("#"+elem).DataTable({
      responsive: true,
      "language":{
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      },
      "bInfo": false
    });
  }

  // funcion eliminar usuario
    function darbaja(id,tabla,nombre){
      swal({
       title: '¿Desea continuar?',
       text: "¡Se deshabilitará "+nombre+"!",
       type: 'warning',
       showCancelButton: true,
       cancelButtonText:"Cancelar",
       confirmButtonColor: 'red',
       cancelButtonColor: '#3085d6',
       confirmButtonText: '¡Si, continuar!'
   }).then(function () {
    $.ajax({
      url:'../json/json_generico.php',
      type:'POST',
      dataType:'json',
      data:{data_id:'dar_baja',id:id,tabla:tabla},
      success: function(json){
        if(json[0]==1){
              iziToast.success({
                  title: ELIMINAR,
                  message: ELIMINAR_MENSAJE,
                  timeout: 3000,
              });
              var timer=setInterval(function(){
                  location.reload();
                  clearTimeout(timer);
              },3500);
          }else
            iziToast.error({
                title: ERROR,
                message: ERROR_MENSAJE,
                timeout: 3000,
            });
       }
      });
   });
}

//funcion para validar nit
function validar_nit(nit,tabla,valor){
  $.ajax({
    url: "../json/json_generico.php",
    dataType: "json",
    data: { data_id: "val_nit", nit: nit,tabla:tabla },
    method: "POST",
    success: function(json) {
        console.log(json);
        if (json[1]) {
            val_nrc = false;
            swal({
                title: '¡Advertencia!',
                html: $('<div>')
                    .addClass('some-class')
                    .text('El NIT ingresado ya fue registrado. Por favor ingrese uno diferente'),
                animation: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                customClass: 'animated tada',
                //timer: 2000
            }).then(function(result) {
                //$("#md_cantidad").focus();
                valor.val("");
                valor.focus();
            });
        } else {
            val_email = true;
            $(".valida1").trigger("click");
        }

    }
});
}

function modal_cargando(){
  swal({
    title: 'Cargando!',
    text: 'Este diálogo se cerrará al completar la operación.',
    allowOutsideClick: false,
    allowEscapeKey: false,
    showConfirmButton: false,
    onOpen: function () {
      swal.showLoading()
    }
  });
}

function validar_correo(email,tabla,valor){
  $.ajax({
    url: "../json/json_generico.php",
    dataType: "json",
    data: { data_id: "val_email", email: email,tabla:tabla},
    method: "POST",
    success: function(json) {
        console.log(json);
        if (json[1]) {
            val_email = false;
            swal({
                title: '¡Advertencia!',
                html: $('<div>')
                    .addClass('some-class')
                    .text('El E-mail ingresado ya fue registrado. Por favor ingrese uno diferente'),
                animation: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                customClass: 'animated tada',
                //timer: 2000
            }).then(function(result) {
                //$("#md_cantidad").focus();
                valor.val("");
                valor.focus();
            });
        } else {
            val_email = true;
            $(".valida1").trigger("click");
        }

    }
});
}

function validar_telefono(telefono,tabla,valor){
  $.ajax({
    url: "../json/json_generico.php",
    dataType: "json",
    data: { data_id: "val_tel", telefono: telefono,tabla:tabla },
    method: "POST",
    success: function(json) {
        console.log(json);
        if (json[1]) {
            val_tel = false;
            swal({
                title: '¡Advertencia!',
                html: $('<div>')
                    .addClass('some-class')
                    .text('El teléfono ingresado ya fue registrado. Por favor ingrese uno diferente'),
                animation: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                customClass: 'animated tada',
                //timer: 2000
            }).then(function(result) {
                //$("#md_cantidad").focus();
                valor.val("");
                valor.focus();
            });
        } else {
            val_tel = true;
            $(".validar").trigger("click");
        }

    }
});
}

function validar_nrc(nrc,tabla,valor){
  $.ajax({
    url: "../json/json_generico.php",
    dataType: "json",
    data: { data_id: "val_nrc", nrc: nrc,tabla:tabla },
    method: "POST",
    success: function(json) {
        console.log(json);
        if (json[1]) {
            val_nrc = false;
            swal({
                title: '¡Advertencia!',
                html: $('<div>')
                    .addClass('some-class')
                    .text('El NRC ingresado ya fue registrado. Por favor ingrese uno diferente'),
                animation: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                customClass: 'animated tada',
                //timer: 2000
            }).then(function(result) {
                //$("#md_cantidad").focus();
                valor.val("");
                valor.focus();
            });
        } else {
            val_email = true;
            $(".valida1").trigger("click");
        }

    }
});
}

function validar_dui(dui,tabla,valor){
  $.ajax({
    url: "../json/json_generico.php",
    dataType: "json",
    data: { data_id: "val_dui", dui: dui,tabla:tabla },
    method: "POST",
    success: function(json) {
        console.log(json);
        if (json[1]) {
            val_nrc = false;
            swal({
                title: '¡Advertencia!',
                html: $('<div>')
                    .addClass('some-class')
                    .text('El DUI ingresado ya fue registrado. Por favor ingrese uno diferente'),
                animation: false,
                allowEscapeKey: false,
                allowOutsideClick: false,
                customClass: 'animated tada',
                //timer: 2000
            }).then(function(result) {
                //$("#md_cantidad").focus();
                valor.val("");
                valor.focus();
            });
        } else {
            val_email = true;
            $(".valida1").trigger("click");
        }

    }
});
}

function guardar_exito(redireccion){
  iziToast.success({
    title: EXITO,
    message: EXITO_MENSAJE,
    timeout: 3000,
  });
  var timer=setInterval(function(){
  location.href = redireccion+".php"
  clearTimeout(timer);
  },3500);
}
function guardar_error(){
  swal.close();
      iziToast.error({
        title: ERROR,
        message: ERROR_MENSAJE,
        timeout: 3000,
      });
}
  jQuery('img.svg').each(function(){
  var $img = jQuery(this);
  var imgID = $img.attr('id');
  var imgClass = $img.attr('class');
  var imgURL = $img.attr('src');

  jQuery.get(imgURL, function(data) {
      // Get the SVG tag, ignore the rest
      var $svg = jQuery(data).find('svg');

      // Add replaced image's ID to the new SVG
      if(typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
      }
      // Add replaced image's classes to the new SVG
      if(typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', imgClass+' replaced-svg');
      }

      // Remove any invalid XML tags as per http://validator.w3.org
      $svg = $svg.removeAttr('xmlns:a');

      // Replace image with new SVG
      $img.replaceWith($svg);

  }, 'xml');

});
</script>