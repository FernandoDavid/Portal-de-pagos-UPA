<body>
    <script>
        var st = 0;
    </script>
    <?php
    if (isset($_SESSION["toast"])) {
        $toast = explode("/", $_SESSION["toast"]);
        echo '
        <script>
            Toast.fire({
                icon: "' . $toast[0] . '",
                title: "' . $toast[1] . '"
            }).then(function(){
                stepAlert("Paso 1: Elección", "Selecciona tu curso..");
            });
        </script>';
        unset($_SESSION["toast"]);
    }

    $res = ModeloFormularios::mdlSelecReg("cursos", null, null);
    $progress = 0;
    if (isset($rutas[1])) {
        $inscrito = ModeloFormularios::mdlSelecReg("inscritos", "idInscrito", intval($rutas[1]));
        if (isset($inscrito[0]["idInscrito"])) {
            echo '
            <script>
                st = 2;
                stepAlert("Paso 3: Comprobante de pago","Adjunta tu comprobante de pago..");
            </script>
        ';
            $progress = 200 / 3;
        } else {
            $_SESSION["toast"] = "error/Usuario no registrado";
            echo '
            <script>
            if(window.history.replaceState){
                window.history.replaceState(null,null,window.location.href);
            } 
            window.location = "' . $dominio . '";
            </script>
            ';
        }
    }
    ?>

    <div class="cointer-fluid text-center bg-primary text-white py-3">
        <h1>Cursos UPA</h1>
    </div>
    <div class="container my-4">
        <!-- Barra de progreso -->
        <div class="position-relative my-5 progress-step">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: <?php echo intval($progress) ?>%;" aria-valuenow="<?php echo intval($progress) ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <button id="step1" type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-circle">1</button>
            <button id="step2" type="button" class="position-absolute top-0 start-33 translate-middle btn btn-sm <?php if ($progress >= (100 / 3)) : ?>btn-primary<?php else : ?>btn-secondary<?php endif ?> rounded-circle">2</button>
            <button id="step3" type="button" class="position-absolute top-0 start-66 translate-middle btn btn-sm <?php if ($progress >= (100 * 2 / 3)) : ?>btn-primary<?php else : ?>btn-secondary<?php endif ?> rounded-circle">3</button>
            <button id="step4" type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm <?php if ($progress == 100) : ?>btn-primary<?php else : ?>btn-secondary<?php endif ?> rounded-circle">4</button>
        </div>

        <div class="text-center" id="loader">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>

        <!-- Paso 1 (Carrousel con los cursos) -->

        <div class="card visually-hidden-focusable" id="card0">
            <div class="d-flex justify-content-evenly border-0">
                <?php foreach ($res as $valor) : ?>
                    <div id="<?php echo $valor["idCurso"] ?>" onclick="reg(this)" class="cursos bg-primary px-3 py-4 text light text-center">
                        <h4><?php echo $valor["titulo"] ?></h4>
                    </div>
                <?php endforeach ?>
            </div>
        </div>


        <!-- Paso 2 (Formulario de registro de los aspirantes)-->

        <div class="card visually-hidden-focusable" id="card1">
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="titulo-curso"></h4>
                            <input name="curso" id="curso" type="text" class="visually-hidden-focusable">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-xl-8 col-lg-12">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="Nombre completo" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 break-lg">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-phone-alt fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="Número de teléfono" name="telefono" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-8 col-lg-12">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-home fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="Domicilio" name="domicilio" required>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 break-lg">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-envelope fa-lg icons"></i></i></span>
                                <input type="text" class="form-control" placeholder="Correo" name="correo" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-8 col-lg-12">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-hashtag fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="CURP" name="curp" required>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 break-lg">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div class="input-group-text">
                                        <p style="margin-bottom: 0 !important; margin:0 auto;">Sexo</p>
                                    </div>
                                </div>
                                <div class="col-4 pt-2">
                                    <input class="form-check-input ms-1" type="radio" value="H" id="hombreRadio" name="sexoRadio" onclick="document.getElementById('mujerRadio').checked = false" required>
                                    <label class="ms-2" for="">Hombre</label>
                                </div>
                                <div class="col-4 pt-2">
                                    <input class="form-check-input ms-1" type="radio" value="M" id="mujerRadio" name="sexoRadio" onclick="document.getElementById('hombreRadio').checked = false">
                                    <label class="ms-2" for="">Mujer</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-8 col-lg-12">
                            <div class="input-group">
                                <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-address-card fa-lg icons"></i></span>
                                <input type="text" class="form-control" placeholder="RFC" name="rfc" required>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 break-lg">
                            <div class="row">
                                <div class="col-4 text-center">
                                    <div class="input-group-text">
                                        <p style="margin-bottom: 0 !important; margin:0 auto;">Estado civil</p>
                                    </div>
                                </div>
                                <div class="col-4 pt-2">
                                    <input class="form-check-input ms-1" type="radio" value="soltero" id="casadoRadio" name="estadoRadio" onclick="document.getElementById('solteroRadio').checked = false" required>
                                    <label class="ms-2" for="">Soltero/a</label>
                                </div>
                                <div class="col-4 pt-2">
                                    <input class="form-check-input ms-1" type="radio" value="casado" id="solteroRadio" name="estadoRadio" onclick="document.getElementById('casadoRadio').checked = false">
                                    <label class="ms-2" for="">Casado/a</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    <?php
                    /*=====================================
                    INSTANCIA Y LLAMADO DE CLASE DE INGRESO
                    ======================================*/
                    $ingreso = new ControladorFormularios();
                    $ingreso->ctrRegistro($dominio);
                    ?>
                </form>
            </div>
        </div>

        <!-- Paso 2 (Entrada del registro de pagos de los aspirantes) ARREGLAR CON RESPECTO AL FUNCIONAMIENTO PLATICADO CON EL CHARLY-->

        <div class="visually-hidden-focusable" id="card2">
            <div class="row">
                <div class="col-sm-4 mb-3">
                    <div class="card p-4">
                        <h4>Name</h4>
                        <hr>
                        <p><b>Correo: </b>...</p>
                        <p><b>Teléfono: </b>...</p>
                        <p><b>Sexo: </b>...</p>
                        <p><b>Estado Civil: </b>...</p>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="card p-4 mb-3 bg-dark text-light position-relative" style="height: 45% !important">
                        <h4 class="text-uppercase">Título curso</h4>
                        <span class="position-absolute badge rounded-pill bg-success" style="width: inherit !important; bottom: 1rem !important; right: 1rem !important">Price</span>
                    </div>
                    <div class="card p-4" style="height: 44.5% !important">
                        <form method="POST" class="row">
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Comprobante de pago</label>
                                <input type="file" class="my-pond" data-max-file-size="3MB" data-max-files="1" name="comprobante" id="comprobante">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- include FilePond library -->
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <!-- include FilePond plugins -->
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>

    <!-- include FilePond jQuery adapter -->
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>

    <script>
    $(document).ready(function(){
    
        // First register any plugins
        $.fn.filepond.registerPlugin(FilePondPluginImagePreview);

        // Turn input element into a pond
        $('.my-pond').filepond();

        // Set allowMultiple property to true
        $('.my-pond').filepond('allowMultiple', false);
    
        // Listen for addfile event
        $('.my-pond').on('FilePond:addfile', function(e) {
            console.log('file added event', e);
        });
        $('.filepond--credits').addClass("visually-hidden");
    });
    </script>