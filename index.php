<?php

ob_start();
require_once "controladores/plantilla.controlador.php";

require_once "controladores/formularios.controlador.php";
require_once "modelos/formularios.modelo.php";

require_once "controladores/correo.controlador.php";
require_once "controladores/reportes.controlador.php";

require_once 'extensiones/vendor/autoload.php';

$plantilla = new ControladorPlantilla();
$plantilla -> ctrTraerPagina();
