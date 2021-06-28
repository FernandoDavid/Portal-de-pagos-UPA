<?php $dominio = fgets(fopen("dominio.txt", "r")); ?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

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
    <!-- Filepond stylesheet -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css" rel="stylesheet" />
    <title>Portal de pagos</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?php echo $dominio ?>vistas/js/main.js"></script>
    <!--Styles CSS-->
    <link rel="stylesheet" href="<?php echo $dominio ?>vistas/css/styles.css">
</head>

<?php
session_start();

#ISSET: isset() Determina si una variable está definida y no es NULL
if (isset($_GET["pagina"])) {

    $rutas = explode("/", $_GET["pagina"]);

    if (
        $rutas[0] == "admin-cursos" ||
        $rutas[0] == "registro"
    ) {
        // switch ($rutas[0]) {
        //     case "":
        //     case "Registro":
        //         include "modulos/cabecera.php";
        //         break;
        // }
        include "paginas/" . $rutas[0] . ".php";
    } else {
        include "paginas/404.php";
    }
} else {
    include "paginas/registro.php";
}

?>

<!-- Own JavaScript -->
<script src="<?php echo $dominio ?>vistas/js/script.js"></script>
</body>

</html>