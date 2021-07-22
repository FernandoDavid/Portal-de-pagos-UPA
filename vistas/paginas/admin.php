<?php
if (!isset($_SESSION["admin"])) {
    echo '<script>
    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    } 
    window.location = "login";
    </script>';
}

$res = ModeloFormularios::mdlSelecReg("Participantes");
$inscritos = array();
$pendientes = array();

$datosAdmin = array("nombre" => $_SESSION["admin"]);
$revisor = ModeloFormularios::mdlSelecReg("admins", array_keys($datosAdmin), $datosAdmin);
$revisor[0]["depto"] == "Posgrado" ? $campo = 10 : $campo = 11;
echo '<script> var campo=' . $campo . '</script>';
?>