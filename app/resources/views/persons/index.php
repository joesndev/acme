<!--
    Vista principal para modulo de Vehiculos - ACME app
    @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
-->
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ACME - Conductores & Propietarios</title>
  <?php $path_app = "../../../.."; include "$path_app/app/resources/views/layouts/html-header.php"; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php"><b><cite>ACME</cite></b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../vehicles/index.php">Veh&iacute;culos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Conductores y Propietarios</a>
        </li>
      </ul>
    </div>
  </div>
</nav><br><br>
<div class="container">
  <div class="card">
    <div class="card-header" style="text-align: center;">
      <b>Listado de Conductores & Propietarios&nbsp;<img style="width: 25px;" src="<?php echo $path_app ?>/app/libs/bootstrap-v5.2.2/icons/list-check.svg" alt="Personas"/></b>&nbsp;
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <button type='button' title='Almacenar un nuevo conductor o propietario' class='btn btn-light btn-lg' data-bs-toggle="modal" data-bs-target="#addPerson" onclick="cleanForm('savePerson');"><b>Nuevo conductor/propietario</b>&nbsp;<img style="width: 25px;" src="<?php echo $path_app ?>/app/libs/bootstrap-v5.2.2/icons/plus-square-fill.svg" alt="newPerson"/></button><br><br>
        <table class="cell-border hover display" id="personsTable" style="width: 100%;">
          <thead>
          <tr>
            <th>Tipo persona</th>
            <th>N&uacute;mero de c&eacute;dula</th>
            <th>Primer nombre</th>
            <th>Segundo nombre</th>
            <th>Apellidos</th>
            <th>Direcci&oacute;n</th>
            <th>Tel&eacute;fono</th>
            <th>Ciudad</th>
            <th>Acciones</th>
          </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal nueva persona -->
  <div class="modal fade" id="addPerson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="exampleModalLabel"><b><em>Registrar una persona</em></b></h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span style="font-size: 15px; color: red;"><b><u>Los campos con un asterisco son obligatorios.</u></b></span>
          <form id="formSavePerson" class="form-inline">
            <div class="form-group mx-sm-3 text-aligned">
              <div class="col-auto">
                <label for="tipo_persona" class="col-form-label">Seleccione el tipo de persona&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="tipo_persona" id="tipo_persona" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un tipo de la lista >></option>
                  <?php
                  require_once "$path_app/app/config/connection.php";
                  $connect = new Connection();
                  $conn    = $connect->connect();
                  $result2 = mysqli_query( $conn, "SELECT ID, NOMBRE FROM TIPO_PERSONAS" );
                  if ( $result2 ):
                    if ( mysqli_num_rows( $result2 ) > 0 ):
                      while ( $row = mysqli_fetch_assoc( $result2 ) ):
                        echo "<option value='".$row['ID']."'>". $row['NOMBRE'] . "</option>";
                      endwhile;
                    endif;
                  endif;
                  ?>
                </select>
              </div>
              <div class="col-auto">
                <label for="documento" class="col-form-label">N&uacute;mero de c&eacute;dula&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="documento" name="documento" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el n&uacute;mero de c&eacute;dula de la persona." onkeypress="return onlyNumbers(event)" maxlength="15">
              </div>
              <div class="col-auto">
                <label for="primer_nombre" class="col-form-label">Primer nombre&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="primer_nombre" name="primer_nombre" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el primer nombre de la persona.">
              </div>
              <div class="col-auto">
                <label for="segundo_nombre" class="col-form-label">Segundo nombre&nbsp;</label>
                <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el segundo nombre de la persona.">
              </div>
              <div class="col-auto">
                <label for="apellidos" class="col-form-label">Apellidos&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="apellidos" name="apellidos" class="form-control text-aligned" placeholder="Escribe aqu&iacute; los apellidos de la persona.">
              </div>
              <div class="col-auto">
                <label for="direccion" class="col-form-label">Direcci&oacute;n&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="direccion" name="direccion" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la direcci&oacute;n de la persona.">
              </div>
              <div class="col-auto">
                <label for="telefono" class="col-form-label">Tel&eacute;fono&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="telefono" name="telefono" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el n&uacute;mero de tel&eacute;fono de la persona." onkeypress="return onlyNumbers(event)" maxlength="10">
              </div>
              <div class="col-auto">
                <label for="ciudad" class="col-form-label">Ciudad&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="ciudad" name="ciudad" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la ciudad de la persona.">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer content-aligned">
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" class="btn btn-success" onclick="return savePerson();">Registrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal nueva persona -->
  <!-- Modal actualizar persona -->
  <div class="modal fade" id="updatePerson" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="exampleModalLabel"><b><em>Actualizar una persona</em></b>&nbsp;</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span style="font-size: 15px; color: red;"><b><u>Los campos con un asterisco son obligatorios.</u></b></span>
          <form id="formUpdatePerson" class="form-inline">
            <div class="form-group mx-sm-3 text-aligned">
              <div class="col-auto">
                <label for="uTipo_persona" class="col-form-label">Seleccione el tipo de persona&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="uTipo_persona" id="uTipo_persona" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un tipo de la lista >></option>
                  <?php
                    require_once "$path_app/app/config/connection.php";
                    $connect = new Connection();
                    $conn    = $connect->connect();
                    $result2 = mysqli_query( $conn, "SELECT ID, NOMBRE FROM TIPO_PERSONAS" );
                    if ( $result2 ):
                      if ( mysqli_num_rows( $result2 ) > 0 ):
                        while ( $row = mysqli_fetch_assoc( $result2 ) ):
                          echo "<option value='".$row['ID']."'>". $row['NOMBRE'] . "</option>";
                        endwhile;
                      endif;
                    endif;
                  ?>
                </select>
              </div>
              <div class="col-auto">
                <label for="uDocumento" class="col-form-label">N&uacute;mero de c&eacute;dula&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uDocumento" name="uDocumento" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el n&uacute;mero de c&eacute;dula de la persona." onkeypress="return onlyNumbers(event)" maxlength="15">
              </div>
              <div class="col-auto">
                <label for="uPrimer_nombre" class="col-form-label">Primer nombre&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uPrimer_nombre" name="uPrimer_nombre" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el primer nombre de la persona.">
              </div>
              <div class="col-auto">
                <label for="uSegundo_nombre" class="col-form-label">Segundo nombre&nbsp;</label>
                <input type="text" id="uSegundo_nombre" name="uSegundo_nombre" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el segundo nombre de la persona.">
              </div>
              <div class="col-auto">
                <label for="uApellidos" class="col-form-label">Apellidos&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uApellidos" name="uApellidos" class="form-control text-aligned" placeholder="Escribe aqu&iacute; los apellidos de la persona.">
              </div>
              <div class="col-auto">
                <label for="uDireccion" class="col-form-label">Direcci&oacute;n&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uDireccion" name="uDireccion" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la direcci&oacute;n de la persona.">
              </div>
              <div class="col-auto">
                <label for="uTelefono" class="col-form-label">Tel&eacute;fono&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uTelefono" name="uTelefono" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el n&uacute;mero de tel&eacute;fono de la persona." onkeypress="return onlyNumbers(event)" maxlength="10">
              </div>
              <div class="col-auto">
                <label for="uCiudad" class="col-form-label">Ciudad&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uCiudad" name="uCiudad" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la ciudad de la persona.">
              </div>
            </div>
            <input type="hidden" name="oldDocument" id="oldDocument" value="">
          </form>
        </div>
        <div class="modal-footer content-aligned">
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" class="btn btn-success" onclick="return updatePerson();">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal actualizar persona -->
</div>
<?php include "$path_app/app/resources/views/layouts/html-footer.php"; ?>
</body>
</html>
