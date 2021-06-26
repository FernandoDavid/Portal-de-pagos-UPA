<body>
    <div class="cointer-fluid text-center bg-primary text-white py-3">
        <h1>Formulario Inscripciones</h1>
    </div>
    <div class="container my-4">
        <!-- Barra de progreso -->
        <div class="position-relative my-5">
            <div class="progress" style="height: 1px;">
                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <button id="step1" type="button" class="position-absolute top-0 start-0 translate-middle btn btn-sm btn-primary rounded-pill" style="width: 2rem; height:2rem;">1</button>
            <button id="step2" type="button" class="position-absolute top-0 start-50 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">2</button>
            <button id="step3" type="button" class="position-absolute top-0 start-100 translate-middle btn btn-sm btn-secondary rounded-pill" style="width: 2rem; height:2rem;">3</button>
        </div>
        
        <!-- Paso 1 (Carrousel con los cursos) -->


        <!-- Paso 2 (Formulario de registro de los aspirantes)-->
        
        
        
        <div class="card">
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupSelect01">Nombre del curso</label>
                                <select class="form-select" id="curso" name="curso" required>
                                    <option selected value="">Elegir...</option>
                                    <?php 
                                        $res=ModeloFormularios::mdlSelecReg("cursos";
                                        foreach($res as $key=>$valor){
                                    ?>
                                    <option value="<?php echo $valor["idCurso"] ?>"><?php echo $valor["titulo"] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
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

        <!-- Paso 3 (Entrada del registro de pagos de los aspirantes) ARREGLAR CON RESPECTO AL FUNCIONAMIENTO PLATICADO CON EL CHARLY-->

    </div>