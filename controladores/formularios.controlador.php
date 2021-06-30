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

    public static function ctrModificarRegistroAlumno(){
        if (isset($_POST["idAlumno"])) {
            if(preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["nombre"]))
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
                $respuesta = ModeloFormularios::mdlModificarRegistro($tabla, array_keys($datos), $datos, $_POST["idAlumno"]);
                if($respuesta){
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

    public static function ctrEliminarRegistro(){
        if (isset($_POST['idAlumnoEliminar'])) {
            $eliminar=ModeloFormularios::mdlBorrarRegistro("inscritos", "idInscrito", $_POST['idAlumnoEliminar']);
            echo '<script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            } 
            // alert("Error al realizar registro");
            location.reload();
            </script>';
        }
        else if(isset($_POST['idAlumnoEliminar'])){

        }
    }

    public static function ctrComprobante($idInscrito,$idCurso,$dominio){
        if(isset($_FILES["comprobante"])){
            $ext = explode("/",$_FILES["comprobante"]["type"]);
            $carpeta = 'vistas/img/comprobantes/'.$idCurso;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            if (move_uploaded_file($_FILES["comprobante"]["tmp_name"],$carpeta.'/'.basename($idInscrito.'.'.$ext[1]))){
                $_SESSION["toast"] = "success/Comprobante subido correctamente";
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    window.location = "'.$dominio.'";
                    </script>';
            }else{
                $_SESSION["toast"] = "error/Error al subir comprobante";
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    location.reload();
                    </script>';
            }
        }
    }
}
