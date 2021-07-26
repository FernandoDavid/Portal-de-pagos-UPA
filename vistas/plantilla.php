<?php 
// echo $_SERVER["HTTP_HOST"];
// echo $_SERVER["REQUEST_URI"];
$dominio = fgets(fopen("dominio.txt", "r")); 
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
        var dominio = "<?php echo $dominio ?>";
    </script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
    <!-- default icons used in the plugin are from Bootstrap 5.x icon library (which can be enabled by loading CSS below) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.min.css" crossorigin="anonymous">
    <!-- the fileinput plugin styling CSS file -->
    <link href="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- the main fileinput plugin script JS file -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/fileinput.min.js"></script>
    <!-- optionally if you need translation for your language then include the locale file as mentioned below (replace LANG.js with your language locale) -->
    <script src="https://cdn.jsdelivr.net/gh/kartik-v/bootstrap-fileinput@5.2.2/js/locales/es.js"></script>
    <title>Portal de pagos</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo $dominio ?>vistas/js/main.js"></script>
    <!--Styles CSS-->
    <link rel="stylesheet" href="<?php echo $dominio ?>vistas/css/styles.css">
</head>
<body>
<?php
session_start();

#ISSET: isset() Determina si una variable está definida y no es NULL
if (isset($_GET["pagina"])) {

    $rutas = explode("/", $_GET["pagina"]);

    if (
        $rutas[0] == "admin" ||
        $rutas[0] == "registro" || 
        $rutas[0] == "login" ||
        $rutas[0] == "salir"
    ) {
        include "modulos/mensajes.php";
        include "paginas/" . $rutas[0] . ".php";
        if($rutas[0] == "admin"){
            echo '<script>console.log("'.$campo.'");</script>';
            ($campo=="r2")? include "modulos/admin-admin.php" : include "modulos/posgrado-admin.php";
        }
    } else {
        include "paginas/404.php";
    }
} else {
    include "modulos/mensajes.php";
    include "paginas/registro.php";
}

?>

<!-- Own JavaScript -->
<script src="<?php echo $dominio ?>vistas/js/script.js"></script>
</body>

</html>