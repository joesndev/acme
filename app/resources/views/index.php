<!--
    Vista principal ACME app
    @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
-->
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ACME - Inicio</title>
  <?php $path_app = "../../.."; include "$path_app/app/resources/views/layouts/html-header.php"; ?>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php"><b><cite>ACME</cite></b></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="vehicles/index.php">Veh&iacute;culos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="persons/index.php">Conductores y Propietarios</a>
        </li>
      </ul>
    </div>
  </div>
</nav><br><br>
<div class="container">
  <div class="card mb-3">
    <img src="<?php echo $path_app ?>/app/resources/img/oet.png" class="rounded mx-auto d-block" alt="Prueba tecnica - OET" style="width: 500px; height: 250px;">
    <div class="card-body">
      <h5 class="card-title"><b>Bienvenido a ACME</b>: Aplicaci&oacute;n web para la administraci&oacute;n de veh&iacute;culos, conductores y propietarios utilizados durante las operaciones diarias de Transporte ACME S.A.</h5>
      <br><br><p class="card-text">En la parte superior encontrar&aacute; la barra de navegaci&oacute;n, donde podr&aacute; acceder a los diferentes m&oacute;dulos del sistema.</p>
    </div>
  </div>
</div>
<?php include "$path_app/app/resources/views/layouts/html-footer.php"; ?>
</body>
</html>
