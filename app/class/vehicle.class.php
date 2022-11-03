<?php
/**
 * Archivo para las operaciones de la clase Vehiculo (select, insert, update and delete).
 * @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
 */
require_once "../../config/connection.php";
class Vehicle {
  public $placa;
  public $color;
  public $marca;
  public $tipo_vehiculo;
  public $conductor;
  public $propietario;

  /**
   * Metodo constructor de la clase
   * @param $placa String Placa del vehiculo
   * @param $color String Color del vehiculo
   * @param $marca String Marca del vehiculo
   * @param $tipo_vehiculo Int Tipo de vehiculo
   * @param $conductor Int Documento del conductor
   * @param $propietario Int Documento del propietario
   */
  function __construct( $placa, $color, $marca, $tipo_vehiculo, $conductor, $propietario ) {
    $this->placa          = $placa;
    $this->color          = $color;
    $this->marca          = $marca;
    $this->tipo_vehiculo  = $tipo_vehiculo;
    $this->conductor      = $conductor;
    $this->propietario    = $propietario;
  }

  /**
   * Obtiene todos los vehiculos registrados
   * @return array Datos del vehiculo
   */
  function getAll ($draw, $start, $length, $searchVal, $order) {
    // Instancia de conexion a BD
    $connect = new Connection();
    $conn    = $connect->connect();

    // Total datos a filtrar
    $sqlTotal = "SELECT PLACA FROM VEHICULOS";
    $resTotal = mysqli_query( $conn, $sqlTotal );
    $rcdTotal = mysqli_num_rows( $resTotal );

    // Concatenamiento de nombres
    $concat_nombre_conductor    = "(SELECT CONCAT(CEDULA, ' - ', COALESCE(PRIMER_NOMBRE, ''), ' ', COALESCE(SEGUNDO_NOMBRE, ''), ' ', COALESCE(APELLIDOS, '')) FROM PERSONAS WHERE CEDULA = v.CONDUCTOR)";
    $concat_nombre_propietario  = "(SELECT CONCAT(CEDULA, ' - ', COALESCE(PRIMER_NOMBRE, ''), ' ', COALESCE(SEGUNDO_NOMBRE, ''), ' ', COALESCE(APELLIDOS, '')) FROM PERSONAS WHERE CEDULA = v.PROPIETARIO)";

    // Query principal
    $sql = "SELECT v.PLACA, v.COLOR, v.MARCA, tv.NOMBRE AS TIPO, $concat_nombre_conductor AS CONDUCTOR, $concat_nombre_propietario AS PROPIETARIO FROM VEHICULOS v INNER JOIN TIPO_VEHICULOS tv ON v.ID_TIPO = tv.ID";

    // Input Buscar del DataTable
    if ( isset( $searchVal ) && ! empty( $searchVal ) ) {
      $sql .= " WHERE v.PLACA LIKE '%$searchVal%' OR v.COLOR LIKE '%$searchVal%' OR v.MARCA LIKE '%$searchVal%' OR $concat_nombre_conductor LIKE '%$searchVal%' OR $concat_nombre_propietario LIKE '%$searchVal%' OR tv.NOMBRE LIKE '%$searchVal%'";
    }

    // Order by del DataTable
    if ( isset( $order ) && ! empty( $order ) ) {
      $sql .= " ORDER BY " . $order[0]['column'] . " " . $order[0]['dir'] . " ";
    }else{
      $sql .= " ORDER BY v.PLACA ASC";
    }

    // Start y Limit del DataTable
    if ( isset( $start ) || isset( $length ) ) {
      $sql .= " LIMIT $start,$length";
    }

    $res            = mysqli_query( $conn, $sql );
    $data           = array();
    $filteredRows   = mysqli_num_rows( $res );
    $result         = mysqli_fetch_all( $res );

    // Organizar datos
    foreach ($result as $row) {
      $subArr = array();
      $subArr[] = $row[0];
      $subArr[] = $row[1];
      $subArr[] = $row[2];
      $subArr[] = $row[3];
      $subArr[] = $row[4];
      $subArr[] = $row[5];
      $subArr[] = '<button type="button" class="btn btn-info btn-sm" title="Actualizar veh&iacute;culo" onclick="getVehicleById(`'.$row[0].'`)" data-bs-toggle="modal" data-bs-target="#updateVehicle"><img src="../../../libs/bootstrap-v5.2.2/icons/pencil-square.svg" alt="Actualizar"/></button>
                        &nbsp;<button type="button" class="btn btn-danger btn-sm" title="Eliminar veh&iacute;culo" onclick="deleteVehicle(`'.$row[0].'`)"><img src="../../../libs/bootstrap-v5.2.2/icons/trash3-fill.svg" alt="Eliminar"/></button>';
      $data[]     = $subArr;
    }

    // Arreglo de retorno
    $response = array (
      "draw"              => $draw,
      "recordsTotal"      => $filteredRows,
      "recordsFiltered"   => $rcdTotal,
      "data"              => $data
    );
    return $response;
  }

  /**
   * Registra un nuevo vehiculo
   * @return int
   */
  function save () {
    $connect = new Connection();
    $conn    = $connect->connect();
    $sql    = "INSERT INTO VEHICULOS(PLACA, COLOR, MARCA, ID_TIPO, CONDUCTOR, PROPIETARIO, CREATED_AT)VALUES('$this->placa', '$this->color', '$this->marca', $this->tipo_vehiculo, $this->conductor, $this->propietario, NOW())";
    $response = (mysqli_query($conn, $sql)) ? 1 : $conn->error;
    return $response;
  }

  /**
   * Obtiene un vehiculo mediante la placa
   * @return array|false|string|string[]|null
   */
  function getById () {
    $connect = new Connection();
    $conn    = $connect->connect();
    $sql     = "SELECT PLACA, COLOR, MARCA, ID_TIPO, CONDUCTOR, PROPIETARIO FROM VEHICULOS WHERE PLACA = '" . $this->placa . "'";
    $res     = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
      $data = mysqli_fetch_assoc($res);
      return $data;
    }else{
      return "No se encontro un vehiculo con la placa: " . $this->placa;
    }
  }

  /**
   * Actualiza los datos de un vehiculo
   * @return int
   */
  function update () {
    $connect  = new Connection();
    $conn     = $connect->connect();
    $sql      = "UPDATE VEHICULOS SET PLACA = '".$this->placa['nueva']."', COLOR = '".$this->color."', MARCA = '".$this->marca."', ID_TIPO = $this->tipo_vehiculo, CONDUCTOR = $this->conductor, PROPIETARIO = $this->propietario, UPDATED_AT = NOW() WHERE PLACA = '" . $this->placa['original'] . "'";
    $response = (mysqli_query($conn, $sql)) ? 1 : $conn->error;
    return $response;
  }

  /**
   * Elimina un vehiculo
   * @return int
   */
  function delete () {
    $connect = new Connection();
    $conn    = $connect->connect();
    $sql     = "DELETE FROM VEHICULOS WHERE PLACA = '" . $this->placa . "'";
    $response = (mysqli_query($conn, $sql)) ? 1 : $conn->error;
    return $response;
  }
}
