<?php
/**
 * Archivo para peticiones AJAX de Vehiculos, Conductores y Propietarios (data sent by POST method)
 * @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
 */

/**
 * Desactivar el muestreo de errores y notices de PHP
 * para correcto funcionamiento de respuesta JSON a DataTables
 */
error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT);
ini_set("display_errors", "Off");
ini_set("display_startup_errors", "Off");

// Clases para el procesamiento de los datos
require "../../class/vehicle.class.php";
require "../../class/person.class.php";

// Definicion de variables provenientes del DOM para el manejo de operaciones
$type   = ( isset ( $_GET['type'] ) ) ? trim ( $_GET['type'] ) : null;     # Tipo de Objeto
$action = ( isset ( $_GET['action'] ) ) ? trim ( $_GET['action'] ) : null; # Accion a realizar

// Datos a procesar
switch ( $type ) {
  case 'vehicle':
    if ( $action == 'save' || $action == 'getById' || $action == 'delete' ) {
      $placa        = ( isset ( $_POST['placa'] ) ) ? trim( $_POST['placa'] ) : trim ( $_POST['vehicle_plate'] );
      $color        = $_POST['color'];
      $marca        = $_POST['marca'];
      $tipo_veh     = intval( $_POST['tipo_veh'] );
      $conductor    = intval( $_POST['conductor'] );
      $propietario  = intval( $_POST['propietario'] );
    }else{
      $placa  = array (
        "original"  => trim ( $_POST['oldPlaca'] ),
        "nueva"     => trim ( $_POST['uPlaca'] )
      );
      $color        = $_POST['uColor'];
      $marca        = $_POST['uMarca'];
      $tipo_veh     = intval( $_POST['uTipo_veh'] );
      $conductor    = intval( $_POST['uConductor'] );
      $propietario  = intval( $_POST['uPropietario'] );
    }
    $object = new Vehicle( $placa, $color, $marca, $tipo_veh, $conductor, $propietario );
    break;
  case 'person':
    if ( $action == 'save' || $action == 'getById' || $action == 'delete' ) {
      $tipo_pers    = intval( $_POST['tipo_persona']);
      $documento    = ( isset ( $_POST['documento'] ) ) ? intval( $_POST['documento'] ) : intval ( $_POST['person_document'] );
      $primer_nom   = $_POST['primer_nombre'];
      $segundo_nom  = $_POST['segundo_nombre'];
      $apellidos    = $_POST['apellidos'];
      $direccion    = $_POST['direccion'];
      $telefono     = intval( $_POST['telefono'] );
      $ciudad       = $_POST['ciudad'];
    }else{
      $tipo_pers = intval( $_POST['uTipo_persona']);
      $documento = array (
        "original" => intval ( $_POST['oldDocument'] ),
        "nuevo"    => intval ( $_POST['uDocumento'] )
      );
      $primer_nom   = $_POST['uPrimer_nombre'];
      $segundo_nom  = $_POST['uSegundo_nombre'];
      $apellidos    = $_POST['uApellidos'];
      $direccion    = $_POST['uDireccion'];
      $telefono     = intval( $_POST['uTelefono'] );
      $ciudad       = $_POST['uCiudad'];
    }
    $object = new Person( $tipo_pers, $documento, $primer_nom, $segundo_nom, $apellidos, $direccion, $telefono, $ciudad );
    break;
  default:
    $object = "No se ha indicado el tipo de datos a procesar";
}

// Acciones a realizar
if ( isset( $action ) ){
  switch ( $action ) {
    case 'getAll':
      $response = $object->getAll( $_POST["draw"], $_POST['start'], $_POST['length'], $_POST['search']['value'], $_POST['order'] );
      break;
    case 'save':
      $response = $object->save();
      break;
    case 'getById':
      $response = $object->getById();
      break;
    case 'update':
      $response = $object->update();
      break;
    case 'delete':
      $response = $object->delete();
      break;
  }
}

// Retorno de la respuesta
echo json_encode($response);
