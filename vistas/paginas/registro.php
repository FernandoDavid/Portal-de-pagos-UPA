<script>
    var st = 0;
</script>
<?php
date_default_timezone_set('America/Mexico_City');
$fechaActual = strtotime(date('y-m-d'));
$res = ModeloFormularios::mdlSelecReg("Cursos");
$progress = 0;
if (isset($rutas[1])) {
    $datos = array("idParticipante"=>intval($rutas[1]));
    $inscrito = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datos), $datos);
    if (isset($inscrito[0]["idParticipante"])) {
        if($inscrito[0]["rev1"] && $inscrito[0]["rev2"]){
            echo '
            <script>
                st = 3;
                stepAlert("Paso 4: Confirmación", "Revisa tu información..");
            </script>';
            $progress = 100;
        }else{
            echo '
            <script>
                st = 2;
                stepAlert("Paso 3: Comprobante de pago", "Adjunta tu comprobante de pago..");
            </script>';
            $progress = 200 / 3;
        }
    } else {
        $_SESSION["toast"] = "error/Usuario no registrado";
        echo '
        <script>
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
            window.location = "' . $dominio . '";
        </script>
        ';
    }
}
?>

<div class="cointer-fluid text-center bg-upa-main-dark text-white py-3">
    <h1>Cursos UPA</h1>
</div>
<div class="container my-4">
    <!-- Barra de progreso -->
    <div class="position-relative my-5 progress-step">
        <div class="progress" style="height: 1px;">
            <div class="progress-bar" role="progressbar" style="width: <?php echo intval($progress) ?>%;"
                aria-valuenow="<?php echo intval($progress) ?>" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <button id="step1" type="button"
            class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-circle">1</button>
        <button id="step2" type="button"
            class="position-absolute top-0 start-33 translate-middle btn btn-sm <?php if ($progress >= (100 / 3)) : ?>btn-primary<?php else : ?>btn-secondary<?php endif ?> rounded-circle">2</button>
        <button id="step3" type="button"
            class="position-absolute top-0 start-66 translate-middle btn btn-sm <?php if ($progress >= (100 * 2 / 3)) : ?>btn-primary<?php else : ?>btn-secondary<?php endif ?> rounded-circle">3</button>
        <button id="step4" type="button"
            class="position-absolute top-0 start-100 translate-middle btn btn-sm <?php if ($progress == 100) : ?>btn-primary<?php else : ?>btn-secondary<?php endif ?> rounded-circle">4</button>
    </div>

    <div class="text-center" id="loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Paso 1 (Carrousel con los cursos) -->

    <div class="visually-hidden-focusable container" id="card0">
        <div class="d-flex justify-content-evenly">
            <?php foreach ($res as $valor) : 
                // HAcer un query que cuente los registros de alumnos (idCurso) y si es menor al Cupo del curso, muestralo
                $alumnosInscritos=ModeloFormularios::mdlVerificarCupo($valor["idCurso"],1);
                
                $fechainicio = strtotime($valor['fec_inicio']);
                $fechafin = strtotime($valor['fec_fin']);
                
                if(($alumnosInscritos[0]<$valor['cupo']) && ($fechaActual>=$fechainicio && $fechaActual<$fechafin)){
                ?>
            <div id="<?php echo $valor["idCurso"] ?>" onclick="reg(this)" style="border-radius: 0.5rem" class="cursos
                overflow-hidden mb-3 shadow text light">
                <div class="curso-title text-white text-center bg-primary px-3 py-2">
                    <h4>
                        <?php echo $valor["curso"]?>
                    </h4>
                </div>
                <div class="curso-body px-3 py-2">
                    <h6>
                        <?php echo "Instructor: ".$valor["instructor"] ?>
                    </h6>
                    <p>
                        <?php echo $valor["desc"] ?>
                    </p>
                    <div class="row">
                        <div class="col-6">
                            <p><b>
                                    <?php echo "Precio: $".number_format($valor["precio"],2) ?>
                                </b></p>
                        </div>
                        <div class="col-6 text-end">
                            <p><b>
                                    <?php echo "Cupo: ".$alumnosInscritos[0]."/".$valor['cupo']?>
                                </b></p>
                        </div>
                    </div>

                </div>

            </div>
            <?php 
                }
            endforeach ?>
        </div>
    </div>

    <!-- Paso 2 (Formulario de registro de los aspirantes)-->
    <div class="visually-hidden-focusable" id="card1">
        <div class="card">
            <div class="card-body">
                <form method="POST" id="formRegistro1">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="titulo-curso fw-bolder text-center pb-2"></h4>
                            <input name="curso" id="curso" type="text" class="visually-hidden-focusable">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <!--Col izquierda-->
                        <div class="col-xl-8 col-lg-6 col-md-12">
                            <div class="col mb-2">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                            class="fas fa-user fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="Nombre completo" name="nombre"
                                        required>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                            class="fas fa-hashtag fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="CURP" name="curp" required>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                            class="fas fa-home fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="Domicilio" name="domicilio"
                                        required>
                                </div>
                            </div>
                            <div class="col mb-2">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                            class="fas fa-phone-alt fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="Número de teléfono"
                                        name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <!--Col derecha-->
                        <div class="col-xl-4 col-lg-6 col-md-12">
                            <div class="col-12 mb-2">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                            class="fas fa-envelope fa-lg icons"></i></i></span>
                                    <input type="text" class="form-control" placeholder="Correo" name="correo" required>
                                </div>
                            </div>
                            <div class="row mb-2 gx-0">
                                <div class="col-2">
                                    <div class="input-group-text input-group-text2">
                                        <i class="fas fa-venus-mars fa-lg icons"></i>
                                    </div>
                                </div>
                                <div class="col-4 pt-1">
                                    <input class="form-check-input ms-1" type="radio" value="H" id="hombreRadio"
                                        name="sexoRadio" onclick="document.getElementById('mujerRadio').checked = false"
                                        required>
                                    <label class="ms-2" for="">Hombre</label>
                                </div>
                                <div class="col-4  pt-1">
                                    <input class="form-check-input ms-1" type="radio" value="M" id="mujerRadio"
                                        name="sexoRadio"
                                        onclick="document.getElementById('hombreRadio').checked = false">
                                    <label class="ms-2" for="">Mujer</label>
                                </div>
                            </div>
                            <div class="row gx-0 mb-2">
                                <div class="col-2 ">
                                    <div class="input-group-text input-group-text2">
                                        <i class="fas fa-hand-holding-heart fa-lg icons"></i>
                                    </div>
                                </div>
                                <div class="col-4 pt-1">
                                    <input class="form-check-input ms-1" type="radio" value="soltero" id="casadoRadio"
                                        name="estadoRadio"
                                        onclick="document.getElementById('solteroRadio').checked = false" required>
                                    <label class="ms-2" for="">Soltero/a</label>
                                </div>
                                <div class="col-4 pt-1">
                                    <input class="form-check-input ms-1" type="radio" value="casado" id="solteroRadio"
                                        name="estadoRadio"
                                        onclick="document.getElementById('casadoRadio').checked = false">
                                    <label class="ms-2" for="">Casado/a</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="subs"
                                    id="checkBox-publicidad" checked>
                                <label class="form-check-label" for="flexCheckChecked">
                                    Deseo recibir notificaciones a mi correo sobre las noticias más recientes
                                    relacionadas al área de Cursos y diplomados de la UPA
                                </label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <h4>Facturación</h4>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                        class="fas fa-address-card fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="RFC" name="rfc" required>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                        class="fas fa-file-alt fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="CFDI" name="cfdi" required>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="obs" class="form-label">Observaciones</label>
                            <div class="input-group">
                                <!-- <span class="input-group-text"><i class="fas fa-sticky-note fa-lg icons"></i> </span> -->
                                <textarea class="form-control" aria-label="Observaciones" id="obs" name="obs"
                                    rows="3"></textarea>
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <?php
                    /*=====================================
                    INSTANCIA Y LLAMADO DE CLASE DE INGRESO
                    ======================================*/
                    $Form = new ControladorFormularios();
                    $Form->ctrRegistro($dominio);
                    ?>
                </form>
            </div>
        </div>
        <div class="row m-2">
            <div class="col-1">
                <button type="button" id="btnRegresar" class="btn btn-danger ">Regresar</button>
            </div>
        </div>
    </div>

    <!-- Paso 3 (Entrada del registro de pagos de los aspirantes) ARREGLAR CON RESPECTO AL FUNCIONAMIENTO PLATICADO CON EL CHARLY-->
    <div class="visually-hidden-focusable" id="card2">
        <div class="row">
            <div class="col-12">
                <div class="card p-4 mb-3 bg-dark text-light position-relative">
                    <?php 
                    $datos2 = array("idCurso"=>intval($inscrito[0]["idCurso"]));
                    $curso = ModeloFormularios::mdlSelecReg("cursos", array_keys($datos2), $datos2);
                    $datos3 = array("curp"=>$inscrito[0]["curp"]);
                    $alumno = ModeloFormularios::mdlSelecReg("alumnos",array_keys($datos3), $datos3);
                    ?>
                    <h4 class="text-uppercase fw-bolder text-center">
                        <?php echo $curso[0]["curso"] ?>
                    </h4>
                    <span
                        class="position-absolute badge rounded-pill bg-success <?php if($alumno[0]):?>text-decoration-line-through<?php endif ?>"
                        style="width: inherit !important; bottom: 1rem !important; right: 1rem !important; font-size: 1.25rem !important">
                        $
                        <?php echo number_format($curso[0]["precio"],2) ?>
                        <?php if(isset($alumno[0])):?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            $
                            <?php echo number_format($curso[0]["precio"]*(1-$curso[0]["descto"]/100),2) ?>
                        </span>
                        <?php endif ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="row align-items-stretch">
            <div class="col-sm-6 mb-3">
                <div class="card p-4 h-100">
                    <h4>
                        <?php echo $inscrito[0]["nombre"] ?>
                    </h4>
                    <hr>
                    <p><b>Correo: </b>
                        <?php echo $inscrito[0]["correo"] ?>
                    </p>
                    <p><b>Teléfono: </b>
                        <?php echo $inscrito[0]["telefono"] ?>
                    </p>
                    <p><b>Sexo: </b>
                        <?php echo ($inscrito[0]["sexo"] == "H") ? "Masculino" : "Femenino"; ?>
                    </p>
                    <p class="text-capitalize"><b>Estado Civil: </b>
                        <?php echo $inscrito[0]["est_civil"] ?>
                    </p>
                </div>
            </div>
            <div class="col-sm-6 mb-3">
                <div class="card p-4 h-100">
                    <?php if ($inscrito[0]["pago"] == null) : ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="">
                            <!-- <label for="comprobante" class="form-label">Comprobante de pago</label> -->
                            <div class="mb-3">
                                <label for="comprobante" class="form-label">Comprobante de pago</label>
                                <input class="form-control" name="comprobante" type="file" id="comprobante"
                                    data-max-file-size="3MB" data-max-files="1">
                            </div>
                            <!-- <div class="file-img mb-3">
                                    <input name="comprobante" id="comprobante" type="file" class="" data-max-file-size="3MB" data-max-files="1">
                                </div> -->
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <?php
                                /*=====================================
                                INSTANCIA Y LLAMADO DE CLASE DE INGRESO
                                ======================================*/
                                // $ctrComp = new ControladorFormularios();
                                $Form->ctrComprobante($inscrito[0]["idInscrito"], $inscrito[0]["idCurso"], $dominio);
                                ?>
                        </div>
                    </form>
                    <?php else : ?>
                    <h4 class="fw-bolder text-center">Comprobante</h4>
                    <img src="<?php echo $dominio . 'vistas/img/comprobantes/' . $inscrito[0][" idCurso"] . '/' .
                        $inscrito[0]["pago"] ?>" alt="
                    <?php echo $inscrito[0]["pago"] ?>" class="img-fluid">
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Paso 4 (Confirmación de información) -->
    <div class="visually-hidden-focusable text-center" id="card3">
        <h1 class="display-2">¡Enhorabuena!</h1>
        <hr>
        <?php
            $dia = explode('-',$curso[0]["fec_inicio"]);
            $hora = explode(':',$curso[0]["hora_inicio"]);
        ?>
        <p class="fw-bolder fs-3">Gracias,
            <?php echo $inscrito[0]["nombre"]; ?>, por inscribirte al curso "
            <?php echo $curso[0]["curso"] ?>"
        </p>
        <!-- <p>Recuerda que el curso inicia el <?php //echo strftime("%A, %d de %B del %Y a las %H:%M hrs.",mktime($hora[0],$hora[1],$hora[2],$dia[1],$dia[2],$dia[0])); ?></p> -->
        <p>Recuerda que el curso inicia el
            <?php echo $curso[0]["fec_inicio"] ?> a las
            <?php echo $curso[0]["hora_inicio"] ?> hrs. en
            <?php echo $curso[0]["lugar"] ?>.
        </p>
    </div>
</div>