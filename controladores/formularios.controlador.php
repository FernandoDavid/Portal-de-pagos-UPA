<?php

class ControladorFormularios
{
    ////////////////////////////ALUMNOS//////////////////////////////////
    //Insertar registro alumnos
    public static function ctrRegistro($dominio)
    {
        if (isset($_POST["curso"])) {
            if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ 0-9]+$/', $_POST["nombre"])) {
                $_POST["telefono"] = str_replace(" ","",$_POST["telefono"]); 
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "telefono" => $_POST["telefono"],
                    "direc" => $_POST["domicilio"],
                    "correo" => $_POST["correo"],
                    "curp" => $_POST["curp"],
                    "sexo" => $_POST["sexoRadio"],
                    "est_civil" => $_POST["estadoRadio"],
                    // "subs" => ($_POST["subs"])? 1 : 0,
                    "idCurso" => $_POST["curso"]
                );

                if($_POST["subs"]){
                    $subscripcion = [
                        "nombre" => $_POST["nombre"],
                        "telefono" => $_POST["telefono"],
                        "correo" => $_POST["correo"],
                    ];
                    try{
                        $sub = ModeloFormularios::mdlCrearRegistro("Subscritos", array_keys($subscripcion), $subscripcion);
                    }catch(Exception $e){}
                }

                $respuesta = ModeloFormularios::mdlCrearRegistro("Participantes", array_keys($datos), $datos);
                if ($respuesta == "ok") {
                    $id = ModeloFormularios::mdlSelecReg("Participantes",array_keys($datos),$datos)[0];
                    $datosCurso = ["idCurso"=>$datos["idCurso"]];
                    $curso = ModeloFormularios::mdlSelecReg("Cursos",array_keys($datosCurso),$datosCurso);
                    if ($id) {
                        $datosAlumno = [
                            "curp" => $id["curp"]
                        ];
                        $alumno = ModeloFormularios::mdlSelecReg("Alumnos",array_keys($datosAlumno), $datosAlumno);
                        $descuento = 0;
                        if(isset($alumno[0])){
                            $descuento =  $curso[0]["desc"];
                        }
                        $datosPago = [
                            "idParticipante" => $id["idParticipante"],
                            "desc"=>$descuento,
                            "pago"=>$curso[0]["precio"]
                        ];
                        $res = ModeloFormularios::mdlCrearRegistro("Pagos",array_keys($datosPago),$datosPago);
                        if($res=="ok"){
                            if(isset($_POST["rfc"]) && $_POST["rfc"]!=""){
                                $datosFac = [
                                    "idParticipante" => $id["idParticipante"],
                                    "rfc" => $_POST["rfc"],
                                    "cfdi" => $_POST["cfdi"],
                                    "obs" => $_POST["obs"]
                                ];
                                $resRfc = ModeloFormularios::mdlCrearRegistro("Facturas", array_keys($datosFac), $datosFac);
                                if($resRfc != "ok"){
                                    echo '<script>
                                        alert("Error al crear registro de Factura");
                                    </script>';
                                }
                            }

                            // $doc = new ControladorReportes();
                            // $doc -> ctrRegistro($curso[0]['idCurso']);

                            //------ ENCRIPTACIÓN DE ID------//
                            $encrypt_method = "AES-256-CBC";
                            $secret_key = 'AA74CDCC2BBRT935136HH7B63C27';
                            $secret_iv = '5fgf5HJ5g27';
                            $key = hash('sha256', $secret_key);
                            $iv = substr(hash('sha256', $secret_iv), 0, 16);
                            $encryption = openssl_encrypt(strval($id["idParticipante"]), $encrypt_method, $key, 0, $iv);
                            $encryption = base64_encode($encryption);

                            $msg = '<div>
                                <p>Gracias por registrarte a través de nuestra plataforma.   </p>
                                <br>
                                <p>Para continuar con tu proceso de registro debes de hacer el depósito por la cantidad que se te indica en el siguiente link:</p>
                                <a href="' . $dominio . 'registro/' . $encryption . '">' . $dominio . 'registro/' . $encryption . '</a>
                                <br>
                                <p>
                                    Dentro de este mismo link deberás subir una captura o foto de tu comprobante de pago para pasar a la validación de tu lugar dentro del curso.
                                    <b>HASTA NO TENER VALIDADO TU COMPROBANTE NO SE TE DARÁ TU LUGAR DENTRO DEL CURSO</b>
                                </p>
                                <img src="cid:imagen" style="margin-left:auto;margin-right:auto;margin-top: 1rem;width: 35rem;" alt="Instrucciones de pago">
                            </div>';
                            $subject = "Regsitro a un curso UPA";
                            $correo = new ControladorCorreo();
                            $correo->ctrEnviarCorreo($datos["correo"],$datos["nombre"],$subject, $msg,$curso[0]['idCurso'],1);

                            $_SESSION["toast"] = "success/Registro exitoso, revisa tu correo";
                            echo '<script>
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null,window.location.href);
                                } 
                                location.reload();
                            </script>';
                        }else{
                            $_SESSION["toast"] = "error/Error al realizar registro de pago";
                            echo '<script>
                                if(window.history.replaceState){
                                    window.history.replaceState(null,null,window.location.href);
                                }
                                location.reload();
                            </script>';
                        }
                    } else {
                        echo '<script>
                            alert("Error al obtener id");
                        </script>';
                    }
                    // $_SESSION["toast"] = "success/Registro exitoso, revisa tu correo";
                    // echo '<script>
                    //     if(window.history.replaceState){
                    //         window.history.replaceState(null,null,window.location.href);
                    //     } 
                    //     location.reload();
                    // </script>';
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
                // echo '<script>alert("ctr");</script>';
                $datos = array(
                    "nombre" => $_POST["nombre"],
                    "telefono" => $_POST["telefono"],
                    "direc" => $_POST["direc"],
                    "correo" => $_POST["correo"],
                    "curp" => $_POST["curp"],
                    "sexo" => $_POST["sexoRadio"],
                    "est_civil" => $_POST["estadoRadio"],
                    "idCurso" => $_POST["idCurso"]
                );
                // echo "<script>console.log(".json_encode(var_export($datos, true)).");</script>";
                $id = array(
                    "idParticipante" => $_POST["idAlumno"]
                );
                $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($id), $id)[0];
                $respuesta = ModeloFormularios::mdlModificarRegistro("Participantes", array_keys($datos), $datos, $id);
                if ($respuesta == "ok") {
                    // echo "<script>console.log(".json_encode(var_export($respuesta, true)).");</script>";
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
                            title: "Error al modificar registro"
                        });
                    </script>';
                }
            }
        }
    }
    //Eliminar registro de alumnos
    public static function ctrEliminarRegistro($tabla, $item,$campo,$dominio)
    {
        if (isset($_POST['alumnoEliminar']) || isset($_POST['cursoEliminar'])) {
            if ($tabla == "participantes" || $tabla == "Participantes") {
                $id = array("idParticipante"=>$_POST["alumnoEliminar"]);
                $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($id), $id)[0];
                $val = $_POST["alumnoEliminar"];
                $comprobante = ModeloFormularios::mdlSelecReg("Pagos", array_keys($id), $id);
                $deletePago = ModeloFormularios::mdlBorrarRegistro("Pagos","idParticipante",$id);
                if($comprobante[0]['comprobante']!=null){
                    unlink($dominio."vistas/img/comprobantes/" . $participante['idCurso'] . '/' . $comprobante[0]['comprobante']);
                }
                ($comprobante[0][$campo]) ? $_SESSION["vista"] = 2 : $_SESSION["vista"] = 1;
            } else {
                $id = array("idCurso"=>$_POST["cursoEliminar"]);
                $curso = ModeloFormularios::mdlSelecReg("cursos", array_keys($id), $id)[0];
                $val = $_POST["cursoEliminar"];
                rmdir($dominio."vistas/img/comprobantes/" . $curso['idCurso']);
                unlink($dominio."vistas/img/flyers/".$curso["flyer"]);
                $_SESSION["vista"] = 1;
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
    public static function ctrComprobante($idParticipante, $idCurso, $dominio)
    {
        if (isset($_FILES["comprobante"])) {
            
            $ext = explode("/", $_FILES["comprobante"]["type"]);
            $carpeta = 'vistas/img/comprobantes/' . $idCurso;
            $datos = array(
                "comprobante" => basename($idParticipante . '.' . $ext[1])
            );
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }
            if (move_uploaded_file($_FILES["comprobante"]["tmp_name"], $carpeta . '/' . $datos["comprobante"])) {
                // echo '<script>alert("hi");</script>';
                $respuesta = ModeloFormularios::mdlModificarRegistro("Pagos",array_keys($datos), $datos,array("idParticipante"=>$idParticipante));
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
                $revisor[0]["depto"] == "Posgrado" ? $campo = "r1" : $campo = "r2";
                if($campo=="r1"){
                    date_default_timezone_set('America/Mexico_City');
                    $datos = array($campo=>"1","fec_".$campo=>date('y-m-d'));
                }else{
                    $datos = [$campo=>"1","fec_".$campo=>$_POST["fec_r2"]];
                }
                
                $res = ModeloFormularios::mdlModificarRegistro("Pagos",array_keys($datos), $datos,$id);
                if ($res == "ok") {
                    if($campo=="r1"){
                        $doc = new ControladorReportes();
                        // $doc = new ControladorReportes();
                        $doc -> ctrRegistro($_POST["idRevCurso"]);
                        $doc -> ctrInscrito($_POST["idRevCurso"]);

                        $msg = '<div>
                            <h3>Felicidades!</h3>
                            <p>Tu comprobante de pago ha sido validado. Revisa los archivos adjuntos para obtener mayor información sobre el curso al cual te registraste : </p>
                        </div>';
                        $subject = "Registro Exitoso";
                        $correo = new ControladorCorreo();
                        $correo->ctrEnviarCorreo($inscrito[0]["correo"],$inscrito[0]["nombre"],$subject, $msg,$_POST["idRevCurso"],0);
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
                $id = array("idParticipante"=>$_POST["idRev"]);
                $revisor[0]["depto"] == "Posgrado" ? $campo = "r1" : $campo = "r2";
                $comp = ModeloFormularios::mdlSelecReg("Pagos", array_keys($id), $id);
                $datos = ["comprobante"=>null];
                $res = ModeloFormularios::mdlModificarRegistro("Pagos",array_keys($datos), $datos,$id);
                $source = "vistas/img/comprobantes/" . $_POST["idRevCurso"] . "/" . $comp[0]["comprobante"];
                unlink($source);
                $msg = '<div>
                            <h3>Lo sentimos</h3>
                            <p>Tu comprobante de pago ha sido rechazado, ingresa al siguiente enlace para reenviar la captura de tu comprobante. Asegúrate que se vean claramente los datos del mismo en la fotografía que vayas a mandar. : </p>
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
                    // $datCurso = ["curso"=>$_POST["curso"]];
                    $id = ModeloFormularios::mdlSelecReg("Cursos", array_keys($datos), $datos);
                    $extFileFlyer = explode("/", $_FILES["flyer"]["type"]);
                    $extFileBanner = explode("/", $_FILES["banner"]["type"]);
                    // echo '<script>console.log("'.$id[0]["idCurso"].'.'.$extFile[1].'")</script>';
                    $datos = [
                        "flyer" => basename($id[0]["idCurso"].'.'.$extFileFlyer[1]),
                        "banner" => basename($id[0]["idCurso"].'.'.$extFileBanner[1])
                    ];
                    $flyer = ModeloFormularios::mdlModificarRegistro("Cursos", array_keys($datos), $datos,array("idCurso" => $id[0]["idCurso"]));
                    if($flyer == 'ok' && move_uploaded_file($_FILES["flyer"]["tmp_name"], 'vistas/img/flyers/' . $datos["flyer"]) && move_uploaded_file($_FILES["banner"]["tmp_name"], 'vistas/img/banners/' . $datos["banner"])){
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

    public static function ctrModificarCurso($dominio)
    {
        if (isset($_POST["idCursoModificar"])) {
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
                $data = array("idCurso" => $_POST["idCursoModificar"]);
                // $old = ModeloFormularios::mdlSelecReg("Cursos",array_keys($data),$data);
                $actualizar = ModeloFormularios::mdlModificarRegistro("Cursos", array_keys($datos), $datos, $data);
                if ($actualizar == "ok") {
                    if((isset($_FILES["flyer"]) && $_FILES["flyer"]["type"]!="") || (isset($_FILES["banner"]) && $_FILES["banner"]["type"]!="")){
                        $cursoEdit = ModeloFormularios::mdlSelecReg("Cursos", array_keys($data), $data); 
                        // unlink('vistas/img/flyers/'.$old[0]['flyer']);
                        $extFileFlyer = explode("/", $_FILES["flyer"]["type"]);
                        $extFileBanner = explode("/", $_FILES["banner"]["type"]);
                        $datos = [
                            "flyer" => (isset($_FILES["flyer"]) && $_FILES["flyer"]["type"]!="") ? basename($data["idCurso"].'.'.$extFileFlyer[1]) : $cursoEdit[0]["flyer"],
                            "banner" => (isset($_FILES["banner"]) && $_FILES["banner"]["type"]!="") ? basename($data["idCurso"].'.'.$extFileBanner[1]) : $cursoEdit[0]["banner"] 
                        ];
                        $flyer = ModeloFormularios::mdlModificarRegistro("Cursos", array_keys($datos), $datos,$data);

                        $st = false;
                        try{
                            move_uploaded_file($_FILES["flyer"]["tmp_name"], 'vistas/img/flyers/' . $datos["flyer"]);
                            $st = true;
                        }catch(Exception $e){}
                        try{
                            move_uploaded_file($_FILES["banner"]["tmp_name"], 'vistas/img/banners/' . $datos["banner"]);
                            $st = true;
                        }catch(Exception $er){}

                        if($st){
                            $_SESSION["vista"] = 3;
                            $_SESSION["toast"] = "success/Curso modificado exitosamente";
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
                                title: "Error al subir flyer"
                            });
                            </script>';
                        } 
                    }else{
                        $_SESSION["vista"] = 3;
                        $_SESSION["toast"] = "success/Curso modificado exitosamente";
                        echo '<script>
                            if(window.history.replaceState){
                                window.history.replaceState(null,null,window.location.href);
                            } 
                            location.reload();
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
}
