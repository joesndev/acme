/**
 * Archivo Javascript para funciones del DOM
 * @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
 */

/**
 * Inicia carga de datos mediante DataTables y Ajax
 */
$(document).ready(function() {
    loadVehicles()
    loadPersons()
});

/**
 * Carga el listado de vehiculos mediante ajax y DataTable
 */
function loadVehicles () {
    var spanishLang = {
        "processing": "Procesando...",
        "lengthMenu": "Mostrar _MENU_ veh&iacute;culos",
        "zeroRecords": "No se encontraron veh&iacute;culos",
        "emptyTable": "Ning&uacute;n veh&iacute;culo disponible en esta tabla",
        "sInfo": "Mostrando veh&iacute;culos del _START_ al _END_ de un total de _TOTAL_ veh&iacute;culos",
        "infoEmpty": "Mostrando veh&iacute;culos del 0 al 0 de un total de 0 veh&iacute;culos",
        "infoFiltered": "(filtrado de un total de _MAX_ veh&iacute;culos)",
        "search": "Buscar: ",
        "infoThousands": ",",
        "loadingRecords": "Cargando...",
        "paginate": {
            "first": "Primero",
            "last": "&Uacute;ltimo",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
    $("#vehiclesTable").DataTable({
      dom: 'Bfrtip',
      buttons: [
        {
          extend:    'csv',
          text:      '<img src="../../img/excel.png" style="width: 35px;" />',
          titleAttr: 'Generar informe en formato CSV'
        }
      ],
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: '../../../resources/ajax/index.php?type=vehicle&action=getAll',
            type: 'POST'
        },
        "columnsDefs": [
            {
                "targets": [],
                "orderable": false,
            },
        ],
        "language": spanishLang,
        fixedHeader: {
          header: true,
          footer: true
        }
    });
}

/**
 * Valida la informacion de campos obligatorios antes de enviar datos al servidor
 * @param operation Operacion a ser evaluada (guardar o actualizar) datos
 * @returns {boolean} true en correcto | false en error
 */
function validateInfo ( operation ) {
    var response = true;
    var message  = "Campos <b>obligatorios</b>, por favor verifique:<br><br>";
    switch ( operation ) {
      case 'saveVehicle':
        var placa   = $("#placa").val();
        var color   = $("#color").val();
        var marca   = $("#marca").val();
        var tipo_v  = $('select[name=tipo_veh] option').filter(':selected').val();
        var conduc  = $('select[name=conductor] option').filter(':selected').val();
        var propie  = $('select[name=propietario] option').filter(':selected').val();
        break;
      case 'updateVehicle':
        var placa   = $("#uPlaca").val();
        var color   = $("#uColor").val();
        var marca   = $("#uMarca").val();
        var tipo_v  = $('select[name=uTipo_veh] option').filter(':selected').val();
        var conduc  = $('select[name=uConductor] option').filter(':selected').val();
        var propie  = $('select[name=uPropietario] option').filter(':selected').val();
        break;
      case 'savePerson':
        var tipo_p    = $('select[name=tipo_persona] option').filter(':selected').val();
        var documento = $("#documento").val();
        var p_nombre  = $("#primer_nombre").val();
        var apellidos = $("#apellidos").val();
        var direccion = $("#direccion").val();
        var telefono  = $("#telefono").val();
        var ciudad    = $("#ciudad").val();
        break;
      case 'updatePerson':
        var tipo_p    = $('select[name=uTipo_persona] option').filter(':selected').val();
        var documento = $("#uDocumento").val();
        var p_nombre  = $("#uPrimer_nombre").val();
        var apellidos = $("#uApellidos").val();
        var direccion = $("#uDireccion").val();
        var telefono  = $("#uTelefono").val();
        var ciudad    = $("#uCiudad").val();
        break;
    }

    // Validar campos obligatorio para registro o actualizacion de un vehiculo
    if ( operation == 'saveVehicle' || operation == 'updateVehicle' ) {
      if ( ! placa ) {
        response = false;
        message = message + "- Debe proporcionar la <b>placa</b> del veh&iacute;culo.<br>";
      }

      if ( ! color ) {
        response = false;
        message = message + "- Debe proporcionar el <b>color</b> del veh&iacute;culo.<br>";
      }

      if ( ! marca ) {
        response = false;
        message = message + "- Debe proporcionar la <b>marca</b> del veh&iacute;culo.<br>";
      }

      if ( tipo_v == 0 ) {
        response = false;
        message = message + "- Debe seleccionar el <b>tipo</b> de veh&iacute;culo.<br>";
      }

      if ( conduc == 0 ) {
        response = false;
        message = message + "- Debe seleccionar el <b>conductor</b> del veh&iacute;culo.<br>";
      }

      if ( propie == 0 ) {
        response = false;
        message = message + "- Debe seleccionar el <b>propietario</b> del veh&iacute;culo.<br>";
      }
    }else if ( operation == 'savePerson' || operation == 'updatePerson' ) { // Validar campos obligatorio para registro o actualizacion de una persona
      if ( tipo_p == 0 ) {
        response = false;
        message = message + "- Debe seleccionar el <b>tipo</b> de persona.<br>";
      }

      if ( !documento ) {
        response = false;
        message = message + "- Debe proporcionar el <b>n&uacute;mero de documento</b> de la persona.<br>";
      }

      if ( !p_nombre ) {
        response = false;
        message = message + "- Debe proporcionar el <b>primer nombre</b> de la persona.<br>";
      }

      if ( !apellidos ) {
        response = false;
        message = message + "- Debe proporcionar el/los <b>apellidos</b> de la persona.<br>";
      }

      if ( !direccion ) {
        response = false;
        message = message + "- Debe proporcionar la <b>direcci&oacute;n</b> de la persona.<br>";
      }

      if ( !telefono ) {
        response = false;
        message = message + "- Debe proporcionar el <b>tel&eacute;fono</b> de la persona.<br>";
      }

      if ( !ciudad ) {
        response = false;
        message = message + "- Debe proporcionar la <b>ciudad</b> de la persona.<br>";
      }
    }

    // Alerta en caso de que no se haya diligenciado un campo obligatorio
    if (!response) {
        Swal.fire({
            title: 'Ocurri&oacute; un error',
            icon: 'error',
            html: message,
            showCloseButton: true,
            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: 'Ok!'
        })
    }else{
        return response;
    }
}

/**
 * Envia mediante ajax los datos del nuevo vehiculo a registrar
 */
function saveVehicle () {
    if (validateInfo('saveVehicle')) {
        $.ajax({
            type: "POST",
            url: "../../../resources/ajax/index.php?type=vehicle&action=save",
            dataType: "JSON",
            data: $("#formSaveVehicle").serialize(),
            success: function( response ) {
                if ( response == 1 ) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '¡Veh\u00EDculo registrado!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        $("#vehiclesTable").DataTable().ajax.reload();
                        $('#addVehicle').modal('hide');
                    });
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ocurrio un error en el servidor (' + response + ')',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        });
    }
}

/**
 * Obtiene un unico registro de vehiculo para su posterior actualizacion
 * @param vehiclePlate Placa identificadora del vehiculo
 */
function getVehicleById ( vehiclePlate ) {
    cleanForm('updateVehicle');
    $.ajax({
        type: "POST",
        url: "../../../resources/ajax/index.php?type=vehicle&action=getById",
        dataType: "JSON",
        data: 'vehicle_plate='+vehiclePlate,
        success: function( data ) {
            $("#oldPlaca").val(vehiclePlate);
            $("#uPlaca").val(data.PLACA);
            $("#uColor").val(data.COLOR);
            $("#uMarca").val(data.MARCA);
            $("#uTipo_veh").val(data.ID_TIPO);
            $("#uConductor").val(data.CONDUCTOR);
            $("#uPropietario").val(data.PROPIETARIO);
        }
    });
}

/**
 * Envia mediante ajax los datos de un vehiculo a actualizar
 */
function updateVehicle () {
    if (validateInfo('updateVehicle')) {
        $.ajax({
            type: "POST",
            url: "../../../resources/ajax/index.php?type=vehicle&action=update",
            dataType: "JSON",
            data: $("#formUpdateVehicle").serialize(),
            success: function( response ) {
                if ( response == 1 ) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '¡Veh\u00EDculo actualizado!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        $("#vehiclesTable").DataTable().ajax.reload();
                        $('#updateVehicle').modal('hide');
                    });
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Ocurrio un error en el servidor (' + response + ')',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        });
    }
}

/**
 * Metodo de evento que solo permite digitar numeros al momento de digitar en un input tipo number
 * @param evt Evento de digitacion
 * @returns {boolean}
 */
function onlyNumbers ( evt ) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

/**
 * Limpia los campos de los formularios para su diligenciamiento
 * @param operation Operacion para la cual se realiza el proceso (guardar o actualizar)
 */
function cleanForm ( operation ) {
  switch ( operation ) {
    case 'saveVehicle':
      $("#placa").val("");
      $("#color").val("");
      $("#marca").val("");
      $('div.col-auto select').val("0");
      break;
    case 'updateVehicle':
      $("#uPlaca").val("");
      $("#uColor").val("");
      $("#uMarca").val("");
      $('div.col-auto select').val("0");
      break;
    case 'savePerson':
      $('div.col-auto select').val("0");
      $("#documento").val("");
      $("#primer_nombre").val("");
      $("#segundo_nombre").val("");
      $("#apellidos").val("");
      $("#direccion").val("");
      $("#telefono").val("");
      $("#ciudad").val("");
      break;
    case 'updatePerson':
      $('div.col-auto select').val("0");
      $("#uDocumento").val("");
      $("#uPrimer_nombre").val("");
      $("#uSegundo_nombre").val("");
      $("#uApellidos").val("");
      $("#uDireccion").val("");
      $("#uTelefono").val("");
      $("#uCiudad").val("");
      break;
  }
}

/**
 * Envia placa del vehiculo a ser eliminado mediante ajax
 * @param vehiclePlate Placa identificadora del vehiculo
 */
function deleteVehicle ( vehiclePlate ) {
    Swal.fire({
        title: '¿Est\u00E1 seguro?',
        text: "No puede revertir esta acci\u00F3n",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, eliminar!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "../../../resources/ajax/index.php?type=vehicle&action=delete",
                dataType: "JSON",
                data: 'vehicle_plate='+vehiclePlate,
                success: function(response) {
                    if (response == 1) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: '¡Veh\u00EDculo eliminado!',
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            $("#vehiclesTable").DataTable().ajax.reload();
                        });
                    }else{
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: 'Ocurrio un error en el servidor (' + response + ')',
                            showConfirmButton: false,
                            timer: 2000
                        })
                    }
                }
            });
        }
    })
}

/**
 * Carga el listado de personas mediante ajax y DataTable
 */
function loadPersons () {
  var spanishLang = {
    "processing": "Procesando...",
    "lengthMenu": "Mostrar _MENU_ personas",
    "zeroRecords": "No se encontraron personas",
    "emptyTable": "Ninguna persona disponible en esta tabla",
    "sInfo": "Mostrando personas del _START_ al _END_ de un total de _TOTAL_ personas",
    "infoEmpty": "Mostrando personas del 0 al 0 de un total de 0 personas",
    "infoFiltered": "(filtrado de un total de _MAX_ personas)",
    "search": "Buscar: ",
    "infoThousands": ",",
    "loadingRecords": "Cargando...",
    "paginate": {
      "first": "Primero",
      "last": "&Uacute;ltimo",
      "next": "Siguiente",
      "previous": "Anterior"
    },
    "aria": {
      "sortAscending": ": Activar para ordenar la columna de manera ascendente",
      "sortDescending": ": Activar para ordenar la columna de manera descendente"
    }
  }
  $("#personsTable").DataTable({
    "processing": true,
    "serverSide": true,
    "order": [],
    "ajax": {
      url: '../../../resources/ajax/index.php?type=person&action=getAll',
      type: 'POST'
    },
    "columnsDefs": [
      {
        "targets": [],
        "orderable": false,
      },
    ],
    "language": spanishLang,
    fixedHeader: {
      header: true,
      footer: true
    }
  });
}

/**
 * Envia mediante ajax los datos de la nueva persona a registrar
 */
function savePerson () {
  if (validateInfo('savePerson')) {
    $.ajax({
      type: "POST",
      url: "../../../resources/ajax/index.php?type=person&action=save",
      dataType: "JSON",
      data: $("#formSavePerson").serialize(),
      success: function( response ) {
        if ( response == 1 ) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: '¡Persona registrada!',
            showConfirmButton: false,
            timer: 2000
          }).then(() => {
            $("#personsTable").DataTable().ajax.reload();
            $('#addPerson').modal('hide');
          });
        }else{
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Ocurrio un error en el servidor (' + response + ')',
            showConfirmButton: false,
            timer: 2000
          })
        }
      }
    });
  }
}

/**
 * Obtiene un unico registro de persona para su posterior actualizacion
 * @param personDocument Cedula identificadora de la persona
 */
function getPersonById ( personDocument ) {
  cleanForm('updatePerson');
  $.ajax({
    type: "POST",
    url: "../../../resources/ajax/index.php?type=person&action=getById",
    dataType: "JSON",
    data: 'person_document='+personDocument,
    success: function( data ) {
      $("#oldDocument").val(personDocument);
      $("#uTipo_persona").val(data.TIPO_PERSONA);
      $("#uDocumento").val(data.DOCUMENTO);
      $("#uPrimer_nombre").val(data.PRIMER_NOMBRE);
      $("#uSegundo_nombre").val(data.SEGUNDO_NOMBRE);
      $("#uApellidos").val(data.APELLIDOS);
      $("#uDireccion").val(data.DIRECCION);
      $("#uTelefono").val(data.TELEFONO);
      $("#uCiudad").val(data.CIUDAD);
    }
  });
}

/**
 * Envia mediante ajax los datos de una persona a actualizar
 */
function updatePerson () {
  if (validateInfo('updatePerson')) {
    $.ajax({
      type: "POST",
      url: "../../../resources/ajax/index.php?type=person&action=update",
      dataType: "JSON",
      data: $("#formUpdatePerson").serialize(),
      success: function( response ) {
        if ( response == 1 ) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: '¡Persona actualizada!',
            showConfirmButton: false,
            timer: 2000
          }).then(() => {
            $("#personsTable").DataTable().ajax.reload();
            $('#updatePerson').modal('hide');
          });
        }else{
          Swal.fire({
            position: 'center',
            icon: 'error',
            title: 'Ocurrio un error en el servidor (' + response + ')',
            showConfirmButton: false,
            timer: 2000
          })
        }
      }
    });
  }
}

/**
 * Envia cedula de la persona para que sea eliminada mediante ajax
 * @param personDocument Placa identificadora del vehiculo
 */
function deletePerson ( personDocument ) {
  Swal.fire({
    title: '¿Est\u00E1 seguro?',
    text: "No puede revertir esta acci\u00F3n",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Si, eliminar!'
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        type: "POST",
        url: "../../../resources/ajax/index.php?type=person&action=delete",
        dataType: "JSON",
        data: 'person_document='+personDocument,
        success: function( response ) {
          if (response == 1) {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: '¡Persona eliminada!',
              showConfirmButton: false,
              timer: 2000
            }).then(() => {
              $("#personsTable").DataTable().ajax.reload();
            });
          }else{
            Swal.fire({
              position: 'center',
              icon: 'error',
              title: 'Ocurrio un error en el servidor (' + response + ')',
              showConfirmButton: false,
              timer: 2000
            })
          }
        }
      });
    }
  })
}
