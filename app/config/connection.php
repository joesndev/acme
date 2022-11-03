<?php
/**
 * Archivo de conexion al servidor de base de datos
 * @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
 */
class Connection {

  public  $host;
  public  $user;
  public  $password;
  public  $database;
  public  $port;

  function __construct () {
    $connectionData = parse_ini_file( "config.ini" );
    $this->host     = $connectionData['host'];
    $this->user     = $connectionData['user'];
    $this->password = $connectionData['password'];
    $this->database = $connectionData['database'];
    $this->port     = $connectionData['port'];
  }

  function connect () {
    $connect = new mysqli( $this->host, $this->user, $this->password, $this->database, $this->port );
    if ( $connect->connect_errno ) {
      $response = "Fallo al conectar con MySQL: (".$connect->connect_error.")";
    }else{
      if ( mysqli_select_db( $connect, $this->database ) ) {
        $response = $connect;
      }else{
        $response = "No se pudo seleccionar la base de datos";
      }
    }
    return $response;
  }
}
