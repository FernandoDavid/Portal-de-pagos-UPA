<?php $dominio = fgets(fopen("dominio.txt", "r")); ?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--Styles CSS-->
    <link rel="stylesheet" href="<?php echo $dominio ?>vistas/css/styles.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <!-- Font awesome-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet"/>
    <title>Portal de pagos</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

    <?php
    // session_start();

    #ISSET: isset() Determina si una variable está definida y no es NULL
    if (isset($_GET["pagina"])) {

        $rutas = explode("/", $_GET["pagina"]);

        if (
            $rutas[0] == "adminCursos"
        ) {
            // switch ($rutas[0]) {
            //     case "Inicio":
            //     case "Capitulos":
            //         include "modulos/cabecera.php";
            //         break;
            // }
            include "paginas/" . $rutas[0] . ".php";
        } else {
            include "paginas/404.php";
        }
    } else {
        include "paginas/adminCursos.php";
    }

    ?>

    <!-- Optional JavaScript; choose one of the two! -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?php echo $dominio ?>vistas/js/script.js"></script>
</body>
</html>