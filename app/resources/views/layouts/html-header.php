<?php
/**
 * Archivo para importar estilos y funciones Javascript (se incluye en etiqueta <head>)
 * @author: Johann Esneider Chavez <johannesneider.dev@gmail.com>
 */
echo "
    <!-- Favicon -->
    <link rel='shortcut icon' href='$path_app/app/resources/img/favicon.png' type='image/x-icon'>
    <!-- Bootstrap -->
    <link href='$path_app/app/libs/bootstrap-v5.2.2/css/bootstrap.min.css' rel='stylesheet' crossorigin='anonymous'>
    <script src='$path_app/app/libs/bootstrap-v5.2.2/js/bootstrap.bundle.min.js' crossorigin='anonymous'></script>
    <!-- Google Font -->
    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Quicksand:wght@300&display=swap' rel='stylesheet'>
    <!-- Main styles -->
    <link href='$path_app/app/resources/css/style.css' rel='stylesheet'>
    <!-- jQuery -->
    <script src='$path_app/app/libs/jQuery-3.6.0/jquery-3.6.0.js'></script>
    <!-- Main functions -->
    <script src='$path_app/app/resources/js/functions.js'></script>
    <!-- Sweetalert -->
    <link href='$path_app/app/libs/sweetalert/dist/sweetalert2.css' rel='stylesheet'>
    <script src='$path_app/app/libs/sweetalert/dist/sweetalert2.js'></script>
    <!-- DataTables -->
    <link rel='stylesheet' type='text/css' href='$path_app/app/libs/DataTables/datatables.min.css'/>
    <script type='text/javascript' src='$path_app/app/libs/DataTables/datatables.min.js'></script>
";
