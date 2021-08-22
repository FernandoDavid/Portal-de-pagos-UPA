<script>
    var st = 0;
</script>
<?php
date_default_timezone_set('America/Mexico_City');
$fechaActual = strtotime(date('y-m-d'));
$res = ModeloFormularios::mdlSelecReg("Cursos");
$progress = 0;
if (isset($rutas[1])) {

    // $ciphering = "AES-128-CTR";
    // $iv_length = openssl_cipher_iv_length($ciphering);
    // $options = 0;
    // $decryption_iv = '1234567891011121';
    // $decryption_key = "Burritos21";
    // $decryption = openssl_decrypt($rutas[1], $ciphering,$decryption_key, $options, $decryption_iv);

    // $datos = array("idParticipante"=>intval($decryption));
    $datos = array("idParticipante"=>intval($rutas[1]));
    $inscrito = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datos), $datos);
    $pagoParticipante = ModeloFormularios::mdlSelecReg("Pagos", array_keys($datos), $datos);
    if (isset($inscrito[0]["idParticipante"])) {
        if($pagoParticipante[0]["r1"] && $pagoParticipante[0]["r2"]){
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

<div class="text-center bg-upa-main-dark text-white overflow-hidden position-relative" id="header-cursos">
    <div class="cover"></div>
    <h1 class="w-100 display-5 text-uppercase position-absolute top-50 start-50 translate-middle">Cursos UPA</h1>
    <!-- <img src="<?php echo $dominio?>vistas/img/rsc/cover.jpg" alt="Educación continua" class=""> -->
</div>
<!-- Barra de progreso -->
<div id="steps" class="px-5 shadow" style="padding-top: 2.3rem; padding-bottom: 2.3rem">
    <div class="position-relative progress-step">
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
</div>
<div class="container-fluid py-5">
    <!-- <hr> -->
    <div class="text-center" id="loader">
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
    </div>

    <!-- Paso 1 (Carrousel con los cursos) -->
    <div class="container animate__animated px-0" id="card0">
        <div class="d-flex justify-content-evenly flex-wrap align-content-around">
            <?php foreach ($res as $valor) : 
                $alumnosInscritos=ModeloFormularios::mdlVerificarCupo($valor["idCurso"]);
                $fechainicio = strtotime($valor['reg_inicio']);
                $fechafin = strtotime($valor['reg_fin']);
                if(($alumnosInscritos[0]<$valor['cupo']) && ($fechaActual>=$fechainicio && $fechaActual<=$fechafin)){
                    $razonCupo = floatval($alumnosInscritos[0])*floatval($valor['cupo'])/100;
            ?>
            <div id="<?php echo $valor["idCurso"] ?>" style="border-radius: 0.5rem" class="cursos bg-white overflow-hidden shadow mb-5">
                <div class="curso-banner position-relative text-white text-center bg-primary" style="background-image: url('<?php echo $dominio?>vistas/img/banners/<?php echo $valor["banner"]?>')">
                    <!-- <img src="" alt="" class="img-fluid"> -->
                    <span class="position-absolute bottom-0 m-2 end-0 fs-5 badge rounded-pill">
                        <?php echo "$ ".number_format($valor["precio"],2) ?>
                    </span>
                </div>
                <div class="curso-body p-3">
                    <h4 class="fw-bolder curso-title">
                        <?php echo $valor["curso"]?>
                    </h4>
                    <p class="text-dark float-end ps-2 fw-normal fst-italic" style="font-size: 0.8rem;line-height:0.9rem;">
                        <?php echo $valor["reg_inicio"] ?> - <?php echo $valor["reg_fin"] ?>
                    </p>
                    <hr>
                    <h6 class="text-dark d-inline-flex">
                        <i class="fas fa-graduation-cap pe-2 my-auto"></i> <?php echo $valor["instructor"] ?>
                    </h6>
                    <p class="text-upa-gray text-truncate">
                        <?php echo $valor["objetivo"] ?>
                    </p>
                    <div class="d-flex">
                        <button class="btn bg-upa-secondary text-white fw-bold" onclick='reg(this,"<?php echo $valor[9]?>")'>Ver más</button>
                        <div class="ms-auto d-flex">
                            <span class="badge my-auto rounded-pill fs-6 <?php if($razonCupo>=80): ?>bg-danger text-white<?php else: ?>bg-upa-gray-light text-upa-gray-dark<?php endif;?>">
                                <i class="fas fa-users"></i> <b> <?php echo $alumnosInscritos[0]."/".$valor['cupo']?></b>
                            </span>
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
    <div class="container animate__animated" id="card1">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 rounded-3 shadow overflow-hidden">
                    <div class="card-body p-0 row gx-0" id="data-curso">
                        <div class="col-xl-7 col-lg-6 col-md-12 p-4 h-auto">
                            <h3 class="text-center text-uppercase fw-bold text-dark">¡Inscríbete al curso!</h3>
                            <h5 class="text-center text-secondary text-upa-primary text-capitalize fw-bold">Curso title</h5>
                            <hr>
                            <p class="fw-lighter">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium perferendis sed corporis officia non deserunt porro ex incidunt fugit repellat voluptatum, ea dolore, quod, a eveniet magni ipsa saepe nobis.</p>
                            <div class="row mb-3">
                                <div class="col-sm-6 d-flex align-self-center curso-feature mb-3">
                                    <span class="bg-upa-secondary-lighter p-2 d-flex"><i class="fas fa-users m-auto fs-4"></i></span>
                                    <div class="my-auto ms-3">
                                        <h6 class="fw-bold mb-0">Modalidad</h6>
                                        <h6 class="fw-lighter text-secondary mb-0">Presencial</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6 d-flex align-self-center curso-feature mb-3">
                                    <span class="bg-upa-secondary-lighter p-2 d-flex"><i class="far fa-building m-auto fs-4"></i></span>
                                    <div class="my-auto ms-3">
                                        <h6 class="fw-bold mb-0">Ubicación</h6>
                                        <h6 class="fw-lighter text-secondary mb-0">Edificio 4, aula 404</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6 d-flex align-self-center curso-feature mb-3">
                                    <span class="bg-upa-secondary-lighter p-2 d-flex"><i class="far fa-calendar-alt m-auto fs-4"></i></span>
                                    <div class="my-auto ms-3">
                                        <h6 class="fw-bold mb-0">Sábados</h6>
                                        <h6 class="fw-lighter text-secondary mb-0">16-08-2021 - 24-09-2021</h6>
                                    </div>
                                </div>
                                <div class="col-sm-6 d-flex align-self-center curso-feature mb-3">
                                    <span class="bg-upa-secondary-lighter p-2 d-flex"><i class="far fa-clock m-auto fs-4"></i></span>
                                    <div class="my-auto ms-3">
                                        <h6 class="fw-bold mb-0">Horario</h6>
                                        <h6 class="fw-lighter text-secondary mb-0">08:00 - 12:00</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex flex-wrap justify-content-evenly text-center precios">
                                <div class="col-lg-4 col-6">
                                    <span class="p-3 mx-auto d-flex position-relative"><i class="fas fa-user fs-1 position-absolute top-50 start-50 translate-middle text-upa-main"></i></span>
                                    <div class="d-flex text-center justify-content-center align-items-center">
                                        <p class="mb-0 fs-6 text-secondary fw-bold me-1">$</p>
                                        <h5 class="fw-bold mb-0 fs-3 text-upa-primary">12,000</h5>
                                    </div>
                                    <p class="text-secondary">Público general</p>
                                </div>
                                <div class="col-lg-4 col-6">
                                <span class="p-3 mx-auto d-flex position-relative"><i class="fas fa-user-graduate fs-1 position-absolute top-50 start-50 translate-middle text-upa-main"></i></span>
                                    <div class="d-flex text-center justify-content-center align-items-center">
                                        <p class="mb-0 fs-6 text-secondary fw-bold me-1">$</p>
                                        <h5 class="fw-bold mb-0 fs-3 text-upa-primary">10,000</h5>
                                    </div>
                                    <p class="text-secondary">Estudiantes y egresados</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-12 p-5 bg-upa-secondary-gradient" style="display: grid" id="temario-curso">
                            <div class="align-self-center">
                                <h3 class="text-center text-white text-uppercase fw-bold mb-4">Temario</h3>
                                <!-- <hr> -->
                                <ul class="list-group">
                                    <li>
                                        <div class="col-12 d-flex">
                                            <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">I</h1></span>
                                            <div class="my-auto ms-3">
                                                <h6 class="fw-bold mb-0 text-uppercase">Unidad I</h6>
                                                <h6 class="fw-lighter text-white mb-0">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-12 d-flex">
                                            <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">II</h1></span>
                                            <div class="my-auto ms-3">
                                                <h6 class="fw-bold mb-0 text-uppercase">Unidad II</h6>
                                                <h6 class="fw-lighter text-white mb-0">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-12 d-flex">
                                            <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">III</h1></span>
                                            <div class="my-auto ms-3">
                                                <h6 class="fw-bold mb-0 text-uppercase">Unidad III</h6>
                                                <h6 class="fw-lighter text-white mb-0">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-12 d-flex">
                                            <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">IV</h1></span>
                                            <div class="my-auto ms-3">
                                                <h6 class="fw-bold mb-0 text-uppercase">Unidad IV</h6>
                                                <h6 class="fw-lighter text-white mb-0">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-12 d-flex">
                                            <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">V</h1></span>
                                            <div class="my-auto ms-3">
                                                <h6 class="fw-bold mb-0 text-uppercase">Unidad V</h6>
                                                <h6 class="fw-lighter text-white mb-0">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</h6>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="col-12 d-flex">
                                            <span class="rounded-circle align-self-center text-white p-2 d-flex"><h1 class="m-auto fs-4 fw-bold">VI</h1></span>
                                            <div class="my-auto ms-3">
                                                <h6 class="fw-bold mb-0 text-uppercase">Unidad VI</h6>
                                                <h6 class="fw-lighter text-white mb-0">Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum</h6>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-0 rounded-3 shadow">
                    <div class="card-body p-4">
                        <form method="POST" id="formRegistro1">
                            <div class="row">
                                <div class="col-12">
                                    <h4 class="titulo-curso fw-bolder text-center pb-2 text-uppercase display-6" style="font-size: 2rem">Registro</h4>
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
                                                required >
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-hashtag fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="CURP" name="curp" required
                                            pattern="[A-Z]{1}[AEIOU]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}">
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
                                                name="telefono" required pattern="(\+?( |-|\.)?\d{1,2}( |-|\.)?)?(\(?\d{3}\)?|\d{3})( |-|\.)?(\d{3}( |-|\.)?\d{4})">
                                        </div>
                                    </div>
                                </div>
                                <!--Col derecha-->
                                <div class="col-xl-4 col-lg-6 col-md-12">
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-envelope fa-lg icons"></i></i></span>
                                            <input type="text" class="form-control" placeholder="Correo" name="correo" required
                                            pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])">
                                        </div>
                                    </div>
                                    <div class="row mb-2 gx-0">
                                        <div class="col-2">
                                            <div class="input-group-text input-group-text2">
                                                <i class="fas fa-venus-mars fa-lg icons"></i>
                                            </div>
                                        </div>
                                        <div class="col-4 align-self-center">
                                            <input class="form-check-input ms-1" type="radio" value="H" id="hombreRadio"
                                                name="sexoRadio" onclick="document.getElementById('mujerRadio').checked = false"
                                                required>
                                            <label class="ms-2" for="">Hombre</label>
                                        </div>
                                        <div class="col-4  align-self-center">
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
                                        <div class="col-4 align-self-center">
                                            <input class="form-check-input ms-1" type="radio" value="soltero" id="casadoRadio"
                                                name="estadoRadio"
                                                onclick="document.getElementById('solteroRadio').checked = false" required>
                                            <label class="ms-2" for="">Soltero/a</label>
                                        </div>
                                        <div class="col-4 align-self-center">
                                            <input class="form-check-input ms-1" type="radio" value="casado" id="solteroRadio"
                                                name="estadoRadio"
                                                onclick="document.getElementById('casadoRadio').checked = false">
                                            <label class="ms-2" for="">Casado/a</label>
                                        </div>
                                    </div>
                                    <div class="row gx-0 mb-2 ">
                                        <div class="col-12 ms-2 mt-2 ">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="checkfactura" onclick="mostrarFactura()">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Quiero generar mi factura de registro</label>
                                            </div>
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
                            <div class="row" id="facturacion-form">
                                <div class="col-12 mb-3">
                                    <h4 class="text-uppercase fw-bold">Facturación</h4>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                class="fas fa-address-card fa-lg icons"></i></span>
                                        <input type="text" class="form-control" placeholder="RFC" name="rfc" id="rfc"
                                        pattern="^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})$" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                class="fas fa-file-alt fa-lg icons"></i></span>
                                        <select name="cfdi" id="cfdi" required>
                                            <option value="" selected>CFDI</option>
                                            <option value="1">Gastos en general</option>
                                        </select>
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
                            <div class="row justify-content-between">
                                <div class="col-3" style="margin: 0 auto !important;">
                                    <button type="submit" class="btn btn-primary w-100">Registrar</button>
                                </div>
                            </div>
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
            </div>
        </div>
        <div class="">
            <button type="button" id="btnRegresar" class="btn btn-danger mt-3">Regresar</button>
        </div>
    </div>

    <?php if(isset($rutas[1])): ?>
    <!-- Paso 3 (Entrada del registro de pagos de los aspirantes) ARREGLAR CON RESPECTO AL FUNCIONAMIENTO PLATICADO CON EL CHARLY-->
    <div class="" id="card2">
        <div class="row">
            <div class="col-12">
                <div class="card p-4 mb-3 bg-dark text-light position-relative">
                    <?php 
                    $datos2 = array("idCurso"=>intval($inscrito[0]["idCurso"]));
                    $curso = ModeloFormularios::mdlSelecReg("Cursos", array_keys($datos2), $datos2);
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
                            <?php echo number_format($curso[0]["precio"]*(1-$curso[0]["desc"]/100),2) ?>
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
                    <?php if ($pagoParticipante[0]["comprobante"] == null) : ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="">
                            <!-- <label for="comprobante" class="form-label">Comprobante de pago</label> -->
                            <div class="mb-3">
                                <label for="comprobante" class="form-label">Comprobante de pago</label>
                                <input type="file" name="comprobante" id="editFlyer" id="comprobante"
                                    data-max-file-size="3MB" data-max-files="1">
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
                                $Form->ctrComprobante($inscrito[0]["idParticipante"], $inscrito[0]["idCurso"], $dominio);
                                ?>
                        </div>
                    </form>
                    <?php else : ?>
                    <h4 class="fw-bolder text-center">Comprobante</h4>
                    <img src="<?php echo $dominio . 'vistas/img/comprobantes/' . $inscrito[0]["idCurso"] . '/' .
                        $pagoParticipante[0]["comprobante"] ?>" alt="
                    <?php echo $pagoParticipante[0]["comprobante"] ?>" class="img-fluid">
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Paso 4 (Confirmación de información) -->
    <div class=" text-center" id="card3">
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
    <?php endif; ?>
</div>

<footer class="bg-dark sticky-bottom py-3 text-center" style="color: rgba(248,249,250,0.5)">
    Made with <i class="fas fa-heart"></i> by Ferando Arévalo & Carlos Martínez
</footer>