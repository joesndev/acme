<?php
/**
 * Archivo para las operaciones de la clase Persona (select, insert, update and delete).
 * @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
 */
require_once "../../config/connection.php";
class Person {
  public $tipo_persona;
  public $documento;
  public $primer_nombre;
  public $segundo_nombre;
  public $apellidos;
  public $direccion;
  public $telefono;
  public $ciudad;

  /**
   * Metodo constructor de la clase
   * @param $tipo_persona
   * @param $documento
   * @param $primer_nombre
   * @param $segundo_nombre
   * @param $apellidos
   * @param $direccion
   * @param $telefono
   * @param $ciudad
   */
  function __construct( $tipo_persona, $documento, $primer_nombre, $segundo_nombre, $apellidos, $direccion, $telefono, $ciudad ) {
    $this->tipo_persona   = $tipo_persona;
    $this->documento      = $documento;
    $this->primer_nombre  = $primer_nombre;
    $this->segundo_nombre = $segundo_nombre;
    $this->apellidos      = $apellidos;
    $this->direccion      = $direccion;
    $this->telefono       = $telefono;
    $this->ciudad         = $ciudad;
  }

  /**
   * Obtiene todas las personas registradas
   * @return array Datos de las personas
   */
  function getAll ($draw, $start, $length, $searchVal, $order) {
    // Instancia de conexion a BD
    $connect = new Connection();
    $conn    = $connect->connect();

    // Total datos a filtrar
    $sqlTotal = "SELECT CEDULA FROM PERSONAS";
    $resTotal = mysqli_query( $conn, $sqlTotal );
    $rcdTotal = mysqli_num_rows( $resTotal );

    // Query principal
    $sql = "SELECT tp.NOMBRE AS TIPO_PERSONA, p.CEDULA, p.PRIMER_NOMBRE, COALESCE(p.SEGUNDO_NOMBRE, '') AS SEGUNDO_NOMBRE, p.APELLIDOS, p.DIRECCION, p.TELEFONO, p.CIUDAD FROM PERSONAS p INNER JOIN TIPO_PERSONAS tp ON p.TIPO_PERSONA = tp.ID";

    // Input Buscar del DataTable
    if ( isset( $searchVal ) && ! empty( $searchVal ) ) {
      $sql .= " WHERE tp.NOMBRE LIKE '%$searchVal%' OR p.CEDULA LIKE '%$searchVal%' OR p.PRIMER_NOMBRE LIKE '%$searchVal%' OR COALESCE(p.SEGUNDO_NOMBRE, '') LIKE '%$searchVal%' OR p.APELLIDOS LIKE '%$searchVal%' OR p.DIRECCION LIKE '%$searchVal%' OR p.TELEFONO LIKE '%$searchVal%' OR p.CIUDAD LIKE '%$searchVal%'";
    }

    // Order by del DataTable
    if ( isset( $order ) && ! empty( $order ) ) {
      $sql .= " ORDER BY " . $order[0]['column'] . " " . $order[0]['dir'] . " ";
    }else{
      $sql .= " ORDER BY p.CEDULA ASC";
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
      $subArr[] = $row[6];
      $subArr[] = $row[7];
      $subArr[] = '<button type="button" class="btn btn-info btn-sm" title="Actualizar persona" onclick="getPersonById(`'.$row[1].'`)" data-bs-toggle="modal" data-bs-target="#updatePerson"><img src="../../../libs/bootstrap-v5.2.2/icons/pencil-square.svg" alt="Actualizar"/></button>
                        &nbsp;<button type="button" class="btn btn-danger btn-sm" title="Eliminar persona" onclick="deletePerson(`'.$row[1].'`)"><img src="../../../libs/bootstrap-v5.2.2/icons/trash3-fill.svg" alt="Eliminar"/></button>';
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
   * Registra una nueva persona
   * @return int
   */
  function save () {
    $connect = new Connection();
    $conn    = $connect->connect();
    $sql    = "INSERT INTO PERSONAS(CEDULA, TIPO_PERSONA, PRIMER_NOMBRE, SEGUNDO_NOMBRE, APELLIDOS, DIRECCION, TELEFONO, CIUDAD, CREATED_AT)VALUES($this->documento, $this->tipo_persona, '$this->primer_nombre', '$this->segundo_nombre', '$this->apellidos', '$this->direccion', $this->telefono, '$this->ciudad', NOW())";
    $response = (mysqli_query($conn, $sql)) ? 1 : $conn->error;
    return $response;
  }

  /**
   * Obtiene una persona mediante el numero de cedula
   * @return array|false|string|string[]|null
   */
  function getById () {
    $connect = new Connection();
    $conn    = $connect->connect();
    $sql     = "SELECT TIPO_PERSONA, CEDULA AS DOCUMENTO, PRIMER_NOMBRE, SEGUNDO_NOMBRE, APELLIDOS, DIRECCION, TELEFONO, CIUDAD FROM PERSONAS WHERE CEDULA = $this->documento";
    $res     = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
      $data = mysqli_fetch_assoc($res);
      return $data;
    }else{
      return "No se encontro una persona con la cedula: " . $this->documento;
    }
  }

  /**
   * Actualiza los datos de una persona
   * @return int
   */
  function update () {
    $connect  = new Connection();
    $conn     = $connect->connect();
    $sql      = "UPDATE PERSONAS SET CEDULA = '".$this->documento['nuevo']."', TIPO_PERSONA = $this->tipo_persona, PRIMER_NOMBRE = '$this->primer_nombre', SEGUNDO_NOMBRE = '$this->segundo_nombre', APELLIDOS = '$this->apellidos', DIRECCION = '$this->direccion', TELEFONO = $this->telefono, CIUDAD = '$this->ciudad', UPDATED_AT = NOW() WHERE CEDULA = '" . $this->documento['original'] . "'";
    $response = (mysqli_query($conn, $sql)) ? 1 : $conn->error;
    return $response;
  }

  /**
   * Elimina una persona
   * @return int
   */
  function delete () {
    $connect = new Connection();
    $conn    = $connect->connect();
    $sql     = "DELETE FROM PERSONAS WHERE CEDULA = $this->documento";
    $response = (mysqli_query($conn, $sql)) ? 1 : $conn->error;
    return $response;
  }
}
