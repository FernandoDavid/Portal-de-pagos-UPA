<?php

class ControladorFormularios
{
    ////////////////////////////ALUMNOS//////////////////////////////////
    //Insertar registro alumnos
    public static function ctrRegistro($dominio)
    {
        if (isset($_POST["curso"])) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["nombre"])) {
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "telefono" => $_POST["telefono"],
                    "direc" => $_POST["domicilio"],
                    "correo" => $_POST["correo"],
                    "curp" => $_POST["curp"],
                    "sexo" => $_POST["sexoRadio"],
                    "est_civil" => $_POST["estadoRadio"],
                    "subs" => ($_POST["subs"])? 1 : 0,
                    "idCurso" => $_POST["curso"]
                );
                $respuesta = ModeloFormularios::mdlCrearRegistro("Participantes", array_keys($datos), $datos);
                if ($respuesta == "ok") {
                    $id = ModeloFormularios::mdlSelecReg("Participantes",array_keys($datos),$datos)[0];
                    if ($id) {
                        $msg = '<div>
                            <p>Ingresa al siguiente enlace para subir tu comprobante de pago: </p>
                            <a href="' . $dominio . 'registro/' . $id["idParticipante"] . '">' . $dominio . 'registro/' . $id["idParticipante"] . '</a>
                            <br>
                            <img src="cid:imagen" style="margin-left:auto;margin-right:auto;margin-top: 1rem;width: 35rem;" alt="Instrucciones de pago">
                        </div>';
                        $subject = "Info. cursos";
                        $correo = new ControladorCorreo();
                        $correo->ctrEnviarCorreo($datos["correo"],$datos["nombre"],$subject, $msg,$dominio,1);
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
    public static function ctrModificarRegistroAlumno($campo)
    {
        if (isset($_POST["idAlumno"])) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["nombre"])) {
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
                $id = array(
                    "idParticipante" => $_POST["idAlumno"]
                );
                $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($id), $id)[0];
                $respuesta = ModeloFormularios::mdlModificarRegistro("Participantes", array_keys($datos), $datos, $id);
                if ($respuesta == "ok") {
                    if (!file_exists("vistas/img/comprobantes/" . $datos["idCurso"])) {
                        mkdir("vistas/img/comprobantes/" . $datos["idCurso"], 0777, true);
                    }
                    if ($participante["idCurso"] != $datos["idCurso"]) {
                        $source = "vistas/img/comprobantes/" . $participante['idCurso'] . "/" . $participante['pago'];
                        $destination = "vistas/img/comprobantes/" . $datos['idCurso'] . "/" . $participante['pago'];
                        copy($source, $destination);
                        unlink($source);
                    }
                    $_SESSION["toast"] = "success/Registro modificado exitosamente";
                    ($participante[$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
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
            if ($tabla == "participantes" || $tabla == "Participantes") {
                $id = array("idAspirante"=>$_POST["alumnoEliminar"]);
                $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($id), $id)[0];
                $val = $_POST["alumnoEliminar"];
                unlink("vistas/img/comprobantes/" . $participante['idCurso'] . '/' . $participante['pago']);
                ($participante[$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
            } else {
                $id = array("idCurso"=>$_POST["cursoEliminar"]);
                $curso = ModeloFormularios::mdlSelecReg("cursos", array_keys($id), $id)[0];
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
    //Registro de comprobante (subida de archivp)
    public static function ctrComprobante($idAspirante, $idCurso, $dominio)
    {
        if (isset($_FILES["comprobante"])) {
            $ext = explode("/", $_FILES["comprobante"]["type"]);
            $carpeta = 'vistas/img/comprobantes/' . $idCurso;
            $datos = array(
                "pago" => basename($idAspirante . '.' . $ext[1])
            );
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            if (move_uploaded_file($_FILES["comprobante"]["tmp_name"], $carpeta . '/' . $datos["pago"])) {
                $respuesta = ModeloFormularios::mdlModificarRegistro("Participantes",array_keys($datos), $datos,array("idParticipante"=>$idAspirante));
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

    ////////////////////////////ADMIN/////////////////////////////////
    public static function ctrIngreso()
    {
        if (isset($_POST["correoIngreso"]) && isset($_POST["pwdIngreso"])) {
            $datos = array("correo"=>$_POST["correoIngreso"]);
            $res = ModeloFormularios::mdlSelecReg("Admins", array_keys($datos), $datos);
            if (isset($res[0])) {
                if ($res[0]["pwd"] == $_POST["pwdIngreso"]) {
                    $_SESSION["admin"] = $res[0]["nombre"];
                    $_SESSION["toast"] = "success/Bienvenido(a) " . $_SESSION["admin"];
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        window.location = "admin";
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
            $id = array("idParticipante"=>$_POST["idRev"]);
            $inscrito = ModeloFormularios::mdlSelecReg("Participantes", array_keys($id), $id);
            if ($_POST["btnRev"] == "Validar") {
                $revisor[0]["depto"] == "Posgrado" ? $campo = "rev1" : $campo = "rev2";
                $datos = array($campo=>"1");
                $res = ModeloFormularios::mdlModificarRegistro("Participantes",array_keys($datos), $datos,$id);
                if ($res == "ok") {
                    if($campo=="rev1"){
                        $msg = '<div>
                            <h3>Felicidades</h3>
                            <p>Tu comprobante de pago ha sido validado, ingresa al siguiente enlace para.. : </p>
                            <a href="' . $dominio . 'registro/' . $_POST["idRev"] . '">' . $dominio . 'registro/' . $_POST["idRev"] . '</a>
                        </div>';
                        $subject = "Info. cursos";
                        $correo = new ControladorCorreo();
                        $correo->ctrEnviarCorreo($inscrito[0]["correo"],$inscrito[0]["nombre"],$subject, $msg,$dominio,0);
                    }
                    ($inscrito[$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
                    $_SESSION["toast"] = "success/Comprobante validado";
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
                            <br>
                            <img src="cid:imagen" style="margin-left:auto;margin-right:auto;margin-top: 1rem;width: 35rem;" alt="Instrucciones de pago">
                        </div>';
                $subject = "Info. cursos";
                $correo = new ControladorCorreo();
                $correo->ctrEnviarCorreo($inscrito[0]["correo"],$inscrito[0]["nombre"],$subject, $msg,$dominio,1);
                $_SESSION["toast"] = "error/Comprobante rechazado";
                    echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        location.reload();
                    </script>';
            }
        }
    }

    //////////////////////////////CURSOS//////////////////////////////
    public static function ctrRegistrarCurso()
    {
        if (isset($_POST["curso"]) && !isset($_POST["idCursoModificar"])) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["curso"])) {
                $datos = array(
                    "curso" => $_POST["curso"],
                    "objetivo" => $_POST["objetivo"],
                    "tipo" => ($_POST["tipo"])? 1 : 0,
                    "instructor" => $_POST["instructor"],
                    "aula" => $_POST["aula"],
                    "modalidad" => ($_POST["modalidad"])? 1 : 0,
                    "temario" => ($_POST["temario"].'|||'.$_POST["recursos"].'|||'.$_POST["materiales"]),
                    "reg_inicio" => $_POST["reg_inicio"],
                    "reg_fin" => $_POST["reg_fin"],
                    "fec_inicio" => $_POST["fec_inicio"],
                    "fec_fin" => $_POST["fec_fin"],
                    "dia" => $_POST["dia"],
                    "hora_inicio" => $_POST["hora_inicio"],
                    "hora_fin" => $_POST["hora_fin"],
                    "cupo" => $_POST["cupo"],
                    "precio" => $_POST["precio"],
                    "desc" => $_POST["desc"]
                );

                // echo "<script>console.log(".json_encode(var_export($datos, true)).");</script>";

                $insertar = ModeloFormularios::mdlCrearRegistro("Cursos", array_keys($datos), $datos);
                if ($insertar == "ok") {
                    $id = ModeloFormularios::mdlSelecReg("Cursos", array_keys($datos), $datos);
                    $extFile = explode("/", $_FILES["flyer"]["type"]);
                    // echo '<script>console.log("'.$id[0]["idCurso"].'.'.$extFile[1].'")</script>';
                    $datos = [
                        "flyer" => basename($id[0]['idCurso'].'.'.$extFile[1])
                    ];
                    $flyer = ModeloFormularios::mdlModificarRegistro("Cursos", array_keys($datos), $datos,array("idCurso" => $id[0]['idCurso']));
                    if($flyer == 'ok' && move_uploaded_file($_FILES["flyer"]["tmp_name"], 'vistas/img/flyers/' . $datos["flyer"])){
                        $_SESSION["vista"] = 3;
                        $_SESSION["toast"] = "success/Curso creado exitosamente";
                        echo '<script>
                            if(window.history.replaceState){
                                window.history.replaceState(null,null,window.location.href);
                            } 
                            location.reload();
                            </script>';
                    }else{
                        echo '<script>
                        if(window.history.replaceState){
                            window.history.replaceState(null,null,window.location.href);
                        } 
                        Toast.fire({
                            icon: "error",
                            title: "Error al subir flyer de curso"
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
                $datos = array(
                    "curso" => $_POST["curso"],
                    "objetivo" => $_POST["objetivo"],
                    "tipo" => $_POST["tipo"],
                    "instructor" => $_POST["instructor"],
                    "aula" => $_POST["aula"],
                    "modalidad" => $_POST["modalidad"],
                    "temario" => $_POST["temario"],
                    "reg_inicio" => $_POST["inicio"],
                    "reg_fin" => $_POST["reg_fin"],
                    "fec_inicio" => $_POST["fec_inicio"],
                    "fec_fin" => $_POST["fec_fin"],
                    "dia" => $_POST["dia"],
                    "hora_inicio" => $_POST["hora_inicio"],
                    "hora_fin" => $_POST["hora_fin"],
                    "cupo" => $_POST["cupo"],
                    "precio" => $_POST["precio"],
                    "desc" => $_POST["desc"]
                );
                $actualizar = ModeloFormularios::mdlModificarRegistro("Cursos", array_keys($datos), $datos, array("idCurso" => $_POST["idCursoModificar"]));
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
