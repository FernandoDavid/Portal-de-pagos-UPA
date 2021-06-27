<?php

class ControladorFormularios
{

    public static function ctrRegistro($dominio)
    {
        if (isset($_POST["curso"])) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["nombre"])) {
                $tabla = "Inscritos";

                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "telefono" => $_POST["telefono"],
                    "direc" => $_POST["domicilio"],
                    "correo" => $_POST["correo"],
                    "curp" => $_POST["curp"],
                    "rfc" => $_POST["rfc"],
                    "sexo" => $_POST["sexoRadio"],
                    "est_civil" => $_POST["estadoRadio"],
                    "idCurso" => $_POST["curso"]
                );
                $respuesta = ModeloFormularios::mdlCrearRegistro($tabla, array_keys($datos), $datos);
                if ($respuesta == "ok") {

                    $id = ModeloFormularios::mdlSeleccionarId($tabla, $datos);
                    if ($id) {
                        $correo = new ControladorCorreo();
                        $correo->ctrEnviarCorreo($dominio, $id["idInscrito"]);
                    } else {
                        echo '<script>
                            alert("Error al obtener id");
                        </script>';
                    }
                    $_SESSION["toast"] = "success/Registro exitoso, revisa tu correo";
                    echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    // alert("Registro guardado correctamente");
                    location.reload();
                    </script>';
                } else {
                    $_SESSION["toast"] = "error/Error al realizar registro";
                    echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    // alert("Error al realizar registro");
                    location.reload();
                    </script>';
                }
            } else {
                $_SESSION["toast"] = "error/Error al realizar registro";
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    // alert("Error al realizar registro");
                    location.reload();
                    </script>';
            }
        }
    }
}
