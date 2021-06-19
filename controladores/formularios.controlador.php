<?php

class ControladorFormularios
{
    
    public static function ctrRegistro()
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
                $respuesta = ModeloFormularios::mdlCrearRegistro($tabla,array_keys($datos),$datos);
                if ($respuesta == "ok") {
                    echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    alert("Registro guardado correctamente");
                    location.reload();
                    </script>';
                } else {
                    echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    alert("Error al realizar registro");
                    </script>';
                }
            } else {
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    alert("Error al realizar registro");
                    </script>';
            }
        }
    }

}
