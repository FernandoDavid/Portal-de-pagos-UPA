<?php

class ControladorFormularios
{
    ////////////////////////////ALUMNOS//////////////////////////////////
    //Insertar registro alumnos
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
                    location.reload();
                    </script>';
                }
            } else {
                $_SESSION["toast"] = "error/Error al realizar registro";
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    }
                    location.reload();
                    </script>';
            }
        }
    }
    //Modificar registro alumnos
    public static function ctrModificarRegistroAlumno($dominio)
    {
        if (isset($_POST["idAlumno"])) {
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
                $inscrito = ModeloFormularios::mdlSelecReg("Inscritos", "idInscrito", $_POST["idAlumno"])[0];
                $respuesta = ModeloFormularios::mdlModificarRegistro($tabla, array_keys($datos), $datos, $_POST["idAlumno"]);
                if ($respuesta == "ok") {
                    if (!file_exists("vistas/img/comprobantes/" . $datos["idCurso"])) {
                        mkdir("vistas/img/comprobantes/" . $datos["idCurso"], 0777, true);
                    }
                    $source = "vistas/img/comprobantes/" . $inscrito['idCurso'] . "/" . $inscrito['pago'];
                    $destination = "vistas/img/comprobantes/" . $datos['idCurso'] . "/" . $inscrito['pago'];
                    copy($source, $destination);
                    unlink($source);
                    // echo '<script>alert("'.$source.', '.$destination.'")</script>';
                    $_SESSION["toast"] = "success/Registro modificado exitosamente";
                    echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    }
                    location.reload();
                    </script>';
                } else {
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        Toast.fire({
                            icon: "error",
                            title: "Error al crear curso"
                        });
                        </script>';
                }
            }
        }
    }
    //Eliminar registro de alumnos
    public static function ctrEliminarRegistro($tabla, $item)
    {
        if (isset($_POST['alumnoEliminar']) || isset($_POST['cursoEliminar'])) {
            if ($tabla == "inscritos" || $tabla == "Inscritos") {
                $inscrito = ModeloFormularios::mdlSelecReg("Inscritos", "idInscrito", $_POST["alumnoEliminar"])[0];
                $val = $_POST["alumnoEliminar"];
                unlink("vistas/img/comprobantes/" . $inscrito['idCurso'] . '/' . $inscrito['pago']);
            } else {
                $curso = ModeloFormularios::mdlSelecReg("cursos", "idCurso", $_POST["cursoEliminar"])[0];
                $val = $_POST["cursoEliminar"];
                rmdir("vistas/img/comprobantes/" . $curso['idCurso']);
            }
            $eliminar = ModeloFormularios::mdlBorrarRegistro($tabla, $item, $val);
            if ($eliminar == "ok") {

                $_SESSION["toast"] = "success/Registro eliminado exitosamente";
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    location.reload();
                    </script>';
            } else {
                echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    Toast.fire({
                        icon: "error",
                        title: "Error al eliminar registro"
                    });
                    </script>';
            }
        }
    }
    //Registro comprobante
    public static function ctrComprobante($idInscrito, $idCurso, $dominio)
    {
        if (isset($_FILES["comprobante"])) {
            $ext = explode("/", $_FILES["comprobante"]["type"]);
            $carpeta = 'vistas/img/comprobantes/' . $idCurso;
            $name = basename($idInscrito . '.' . $ext[1]);
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            if (move_uploaded_file($_FILES["comprobante"]["tmp_name"], $carpeta . '/' . $name)) {
                $respuesta = ModeloFormularios::mdlComprobante("inscritos", $name, $idInscrito);
                if ($respuesta == "ok") {
                    $_SESSION["toast"] = "success/Comprobante subido correctamente";
                    echo '<script>
                    if(window.history.replaceState){
                        window.history.replaceState(null,null,window.location.href);
                    } 
                    window.location = "' . $dominio . '";
                    </script>';
                } else {
                    $_SESSION["toast"] = "error/Error al subir comprobante";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        location.reload();
                        </script>';
                }
            } else {
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

    public static function ctrSelecComprobante($inscrito, $curso)
    {
        return ModeloFormularios::mdlSelecComprobante("Inscritos", array("idInscrito" => $inscrito, "idCurso" => $curso));
    }

    ////////////////////////////////////CURSOS////////////////////////////////////
    public static function ctrRegistrarCurso()
    {
        if (isset($_POST["nombreCurso"]) && !isset($_POST["idCursoModificar"]) ) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["nombreCurso"])) {
                $tabla = "Cursos";
                $datos = array(
                    "curso" => $_POST["nombreCurso"],
                    "desc" => $_POST["desc"],
                    "instructor" => $_POST["instructor"],
                    "fec_inicio" => $_POST["fec_inicio"],
                    "fec_fin" => $_POST["fec_fin"],
                    "hora_inicio" => $_POST["hora_inicio"],
                    "hora_fin" => $_POST["hora_fin"],
                    "cupo" => $_POST["cupo"],
                    "status" => 1,
                    "precio" => $_POST["precio"],
                    "lugar" => $_POST["lugar"]
                );
                $insertar = ModeloFormularios::mdlRegistrarCurso($tabla, $datos);
                if ($insertar == "ok") {
                    $_SESSION["toast"] = "success/Curso creado exitosamente";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        location.reload();
                        </script>';
                } else {
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        Toast.fire({
                            icon: "error",
                            title: "Error al crear curso"
                        });
                        </script>';
                }
            }
        }
    }

    public static function ctrModificarCurso()
    {
        if (isset($_POST["idCursoModificar"])) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["nombreCurso"])) {
                $tabla = "Cursos";
                $datos = array(
                    "curso" => $_POST["nombreCurso"],
                    "desc" => $_POST["desc"],
                    "instructor" => $_POST["instructor"],
                    "fec_inicio" => $_POST["fec_inicio"],
                    "fec_fin" => $_POST["fec_fin"],
                    "hora_inicio" => $_POST["hora_inicio"],
                    "hora_fin" => $_POST["hora_fin"],
                    "cupo" => $_POST["cupo"],
                    "status" => 1,
                    "precio" => $_POST["precio"],
                    "lugar" => $_POST["lugar"]
                );
                
                $actualizar = ModeloFormularios::mdlModificarCurso($tabla, $datos, $_POST['idCursoModificar']);
                if ($actualizar == "ok") {
                    $_SESSION["toast"] = "success/Curso creado exitosamente";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        location.reload();
                        </script>';
                } else {
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        }
                        Toast.fire({
                            icon: "error",
                            title: "Error al crear curso"
                        });
                        </script>';
                }
            }
        }
    }

}
