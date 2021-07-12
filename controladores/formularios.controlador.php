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
                        $msg = '<div>
                            <p>Ingresa al siguiente enlace para subir tu comprobante de pago: </p>
                            <a href="' . $dominio . 'registro/' . $id["idInscrito"] . '">' . $dominio . 'registro/' . $id["idInscrito"] . '</a>
                        </div>';
                        $subject = "Info. cursos";

                        $correo = new ControladorCorreo();
                        $correo->ctrEnviarCorreo($datos["correo"],$datos["nombre"],$subject, $msg);
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
    public static function ctrModificarRegistroAlumno($dominio,$campo)
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

                    if ($inscrito["idCurso"] != $datos["idCurso"]) {
                        $source = "vistas/img/comprobantes/" . $inscrito['idCurso'] . "/" . $inscrito['pago'];
                        $destination = "vistas/img/comprobantes/" . $datos['idCurso'] . "/" . $inscrito['pago'];
                        copy($source, $destination);
                        unlink($source);
                    }
                    // echo '<script>alert("'.$source.', '.$destination.'")</script>';
                    $_SESSION["toast"] = "success/Registro modificado exitosamente";
                    ($inscrito[$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
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
    public static function ctrEliminarRegistro($tabla, $item,$campo)
    {
        if (isset($_POST['alumnoEliminar']) || isset($_POST['cursoEliminar'])) {
            if ($tabla == "inscritos" || $tabla == "Inscritos") {
                $inscrito = ModeloFormularios::mdlSelecReg("Inscritos", "idInscrito", $_POST["alumnoEliminar"])[0];
                $val = $_POST["alumnoEliminar"];
                unlink("vistas/img/comprobantes/" . $inscrito['idCurso'] . '/' . $inscrito['pago']);
                ($inscrito[$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
            } else {
                $curso = ModeloFormularios::mdlSelecReg("cursos", "idCurso", $_POST["cursoEliminar"])[0];
                $val = $_POST["cursoEliminar"];
                rmdir("vistas/img/comprobantes/" . $curso['idCurso']);
                $_SESSION["vista"] = 3;
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

    public static function ctrSelectData($tabla, $item, $id)
    {
        return ModeloFormularios::mdlSelecReg($tabla, $item, $id);
    }

    ////////////////////////////ADMIN//////////////////////////////////
    public static function ctrIngreso()
    {
        if (isset($_POST["correoIngreso"]) && isset($_POST["pwdIngreso"])) {
            $res = ModeloFormularios::mdlSelecReg("admins", "correo", $_POST["correoIngreso"]);
            if (isset($res[0])) {
                if ($res[0]["pwd"] == $_POST["pwdIngreso"]) {
                    $_SESSION["admin"] = $res[0]["nombre"];
                    $_SESSION["toast"] = "success/Bienvenido(a) " . $_SESSION["admin"];
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        window.location = "admin-cursos";
                        </script>';
                } else {
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        Toast.fire({
                            icon: "error",
                            title: "Contraseña incorrecta"
                        });
                        </script>';
                }
            } else {
                echo '<script>
                if(window.history.replaceState){
                    window.history.replaceState(null,null,window.location.href);
                } 
                Toast.fire({
                    icon: "error",
                    title: "Correo incorrecto"
                });
                </script>';
            }
        }
    }

    public static function ctrValidarComprobante($dominio, $revisor,$campo)
    {
        if (isset($_POST["idRev"]) && isset($_POST["btnRev"]) && isset($_POST["idRevCurso"])) {
            $inscrito = ModeloFormularios::mdlSelecReg("Inscritos", "idInscrito", $_POST["idRev"]);
            if ($_POST["btnRev"] == "Validar") {
                // echo '<script>alert("2 if")</script>';
                // $revisor = ModeloFormularios::mdlSelecReg("admins", "nombre", $_SESSION["admin"]);
                $revisor[0]["depto"] == "Posgrado" ? $campo = "rev1" : $campo = "rev2";
                $res = ModeloFormularios::mdlRevisarComprobante($campo, $_POST["idRev"], $_POST["idRevCurso"]);
                if ($res == "ok") {
                    $msg = '<div>
                            <h3>Felicidades</h3>
                            <p>Tu comprobante de pago ha sido validado, ingresa al siguiente enlace para.. : </p>
                            <a href="' . $dominio . 'confirmacion/' . $_POST["idRev"] . '">' . $dominio . 'confirmacion/' . $_POST["idRev"] . '</a>
                        </div>';
                    $subject = "Info. cursos";
                    $correo = new ControladorCorreo();
                    $correo->ctrEnviarCorreo($inscrito[0]["correo"],$inscrito[0]["nombre"],$subject, $msg);
                    ($inscrito[$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
                    $_SESSION["toast"] = "success/Comprobante validado";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        window.location = "admin-cursos";
                        </script>';
                } else {
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        Toast.fire({
                            icon: "error",
                            title: "Error al validar comprobante"
                        });
                        </script>';
                }
            } else {
                $source = "vistas/img/comprobantes/" . $_POST["idRevCurso"] . "/" . $_POST["idRev"];
                unlink($source);
                $msg = '<div>
                            <h3>Lo sentimos</h3>
                            <p>Tu comprobante de pago ha sido rechazado, ingresa al siguiente enlace para.. : </p>
                            <a href="' . $dominio . 'registro/' . $_POST["idRev"] . '">' . $dominio . 'registro/' . $_POST["idRev"] . '</a>
                        </div>';
                $subject = "Info. cursos";
                $correo = new ControladorCorreo();
                $correo->ctrEnviarCorreo($inscrito[0]["correo"],$inscrito[0]["nombre"],$subject, $msg);
                $_SESSION["toast"] = "error/Comprobante rechazado";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        window.location = "admin-cursos";
                        </script>';
            }
        }
    }

    ////////////////////////////////////CURSOS////////////////////////////////////
    public static function ctrRegistrarCurso()
    {
        if (isset($_POST["nombreCurso"]) && !isset($_POST["idCursoModificar"])) {
            
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
                    $_SESSION["vista"] = 3;
                    $_SESSION["toast"] = "success/Curso creado exitosamente";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        window.location = "admin-cursos";
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
                    $_SESSION["vista"] = 3;
                    $_SESSION["toast"] = "success/Curso modificado exitosamente";
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
