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
  <title>ACME - Veh&iacute;culos</title>
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
          <a class="nav-link active" href="index.php">Veh&iacute;culos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../persons/index.php">Conductores y Propietarios</a>
        </li>
      </ul>
    </div>
  </div>
</nav><br><br>
<div class="container">
  <div class="card">
    <div class="card-header" style="text-align: center;">
      <b>Listado de Veh&iacute;culos&nbsp;<img style="width: 25px;" src="<?php echo $path_app ?>/app/libs/bootstrap-v5.2.2/icons/list-check.svg" alt="Veh&iacute;culo"/></b>&nbsp;
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <button type='button' title='Almacenar un nuevo veh&iacute;culo' class='btn btn-light btn-lg' data-bs-toggle="modal" data-bs-target="#addVehicle" onclick="cleanForm('saveVehicle');"><b>Nuevo veh&iacute;culo</b>&nbsp;<img style="width: 25px;" src="<?php echo $path_app ?>/app/libs/bootstrap-v5.2.2/icons/plus-square-fill.svg" alt="newVehicle"/></button><br><br>
        <table class="cell-border hover display" id="vehiclesTable" style="width: 100%;">
          <thead>
            <tr>
              <th>Placa</th>
              <th>Color</th>
              <th>Marca</th>
              <th>Tipo de veh&iacute;culo</th>
              <th>Conductor</th>
              <th>Propietario</th>
              <th>Acciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
  <!-- Modal nuevo vehiculo -->
  <div class="modal fade" id="addVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="exampleModalLabel"><b><em>Registrar un veh&iacute;culo</em></b></h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span style="font-size: 15px; color: red;"><b><u>Los campos con un asterisco son obligatorios.</u></b></span>
          <form id="formSaveVehicle" class="form-inline">
            <div class="form-group mx-sm-3 text-aligned">
              <div class="col-auto">
                <label for="placa" class="col-form-label">Placa&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="placa" name="placa" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la placa del veh&iacute;culo.">
              </div>
              <div class="col-auto">
                <label for="color" class="col-form-label">Color&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="color" name="color" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el color del veh&iacute;culo.">
              </div>
              <div class="col-auto">
                <label for="marca" class="col-form-label">Marca&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="marca" name="marca" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la marca del veh&iacute;culo.">
              </div>
              <div class="col-auto">
                <label for="tipo_veh" class="col-form-label">Seleccione el tipo de veh&iacute;culo&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="tipo_veh" id="tipo_veh" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un tipo de la lista >></option>
                  <?php
                    require_once "$path_app/app/config/connection.php";
                    $connect = new Connection();
                    $conn    = $connect->connect();
                    $result2 = mysqli_query( $conn, "SELECT ID, NOMBRE FROM TIPO_VEHICULOS" );
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
                <label for="conductor" class="col-form-label">Seleccione el conductor&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="conductor" id="conductor" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un conductor de la lista >></option>
                  <?php
                    $result2 = mysqli_query( $conn, "SELECT CEDULA, CONCAT(COALESCE(PRIMER_NOMBRE, ''), ' ', COALESCE(SEGUNDO_NOMBRE, ''), ' ', COALESCE(APELLIDOS, '')) AS NOMBRE FROM PERSONAS WHERE TIPO_PERSONA = 1" );
                    if ( $result2 ):
                      if ( mysqli_num_rows( $result2 ) > 0 ):
                        while ( $row = mysqli_fetch_assoc( $result2 ) ):
                          echo "<option value='".$row['CEDULA']."'>". $row['NOMBRE'] . "</option>";
                        endwhile;
                      endif;
                    endif;
                  ?>
                </select>
              </div>
              <div class="col-auto">
                <label for="propietario" class="col-form-label">Seleccione el propietario&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="propietario" id="propietario" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un propietario de la lista >></option>
                  <?php
                    $result2 = mysqli_query( $conn, "SELECT CEDULA, CONCAT(COALESCE(PRIMER_NOMBRE, ''), ' ', COALESCE(SEGUNDO_NOMBRE, ''), ' ', COALESCE(APELLIDOS, '')) AS NOMBRE FROM PERSONAS WHERE TIPO_PERSONA = 2" );
                    if ( $result2 ):
                      if ( mysqli_num_rows( $result2 ) > 0 ):
                        while ( $row = mysqli_fetch_assoc( $result2 ) ):
                          echo "<option value='".$row['CEDULA']."'>". $row['NOMBRE'] . "</option>";
                        endwhile;
                      endif;
                    endif;
                  ?>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer content-aligned">
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" class="btn btn-success" onclick="return saveVehicle();">Registrar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal nuevo vehiculo -->
  <!-- Modal actualizar vehiculo -->
  <div class="modal fade" id="updateVehicle" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title fs-5" id="exampleModalLabel"><b><em>Actualizar un veh&iacute;culo</em></b></h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <span style="font-size: 15px; color: red;"><b><u>Los campos con un asterisco son obligatorios.</u></b></span>
          <form id="formUpdateVehicle" class="form-inline">
            <div class="form-group mx-sm-3 text-aligned">
              <div class="col-auto">
                <label for="uPlaca" class="col-form-label">Placa&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uPlaca" name="uPlaca" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la placa del veh&iacute;culo.">
              </div>
              <div class="col-auto">
                <label for="uColor" class="col-form-label">Color&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uColor" name="uColor" class="form-control text-aligned" placeholder="Escribe aqu&iacute; el color del veh&iacute;culo.">
              </div>
              <div class="col-auto">
                <label for="uMarca" class="col-form-label">Marca&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <input type="text" id="uMarca" name="uMarca" class="form-control text-aligned" placeholder="Escribe aqu&iacute; la marca del veh&iacute;culo.">
              </div>
              <div class="col-auto">
                <label for="uTipo_veh" class="col-form-label">Seleccione el tipo de veh&iacute;culo&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="uTipo_veh" id="uTipo_veh" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un tipo de la lista >></option>
                  <?php
                    $result2 = mysqli_query( $conn, "SELECT ID, NOMBRE FROM TIPO_VEHICULOS" );
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
                <label for="uConductor" class="col-form-label">Seleccione el conductor&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="uConductor" id="uConductor" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un conductor de la lista >></option>
                  <?php
                    $result2 = mysqli_query( $conn, "SELECT CEDULA, CONCAT(COALESCE(PRIMER_NOMBRE, ''), ' ', COALESCE(SEGUNDO_NOMBRE, ''), ' ', COALESCE(APELLIDOS, '')) AS NOMBRE FROM PERSONAS WHERE TIPO_PERSONA = 1" );
                    if ( $result2 ):
                      if ( mysqli_num_rows( $result2 ) > 0 ):
                        while ( $row = mysqli_fetch_assoc( $result2 ) ):
                          echo "<option value='".$row['CEDULA']."'>". $row['NOMBRE'] . "</option>";
                        endwhile;
                      endif;
                    endif;
                  ?>
                </select>
              </div>
              <div class="col-auto">
                <label for="uPropietario" class="col-form-label">Seleccione el propietario&nbsp;<span style="font-size: 20px; color: red;">*</span></label>
                <select name="uPropietario" id="uPropietario" class="form-select" style="width: 430px; text-align-last: center;">
                  <option value="0"><< Seleccione un propietario de la lista >></option>
                  <?php
                    $result2 = mysqli_query( $conn, "SELECT CEDULA, CONCAT(COALESCE(PRIMER_NOMBRE, ''), ' ', COALESCE(SEGUNDO_NOMBRE, ''), ' ', COALESCE(APELLIDOS, '')) AS NOMBRE FROM PERSONAS WHERE TIPO_PERSONA = 2" );
                    if ( $result2 ):
                      if ( mysqli_num_rows( $result2 ) > 0 ):
                        while ( $row = mysqli_fetch_assoc( $result2 ) ):
                          echo "<option value='".$row['CEDULA']."'>". $row['NOMBRE'] . "</option>";
                        endwhile;
                      endif;
                    endif;
                  ?>
                </select>
              </div>
            </div>
            <input type="hidden" name="oldPlaca" id="oldPlaca" value="">
          </form>
        </div>
        <div class="modal-footer content-aligned">
          <div class="d-grid gap-2 col-6 mx-auto">
            <button type="button" class="btn btn-success" onclick="return updateVehicle();">Actualizar</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end Modal actualizar vehiculo -->
</div>
<?php include "$path_app/app/resources/views/layouts/html-footer.php"; ?>
</body>
</html>
