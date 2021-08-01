<?php
foreach ($res as $key => $dato) {
    if ($dato["r1"] && $dato["r2"]) {
        $datParticipante = ["idParticipante"=>$dato["idParticipante"]];
        $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datParticipante),$datParticipante);
        array_push($inscritos, $participante[0]);
    } else {
        $datParticipante = ["idParticipante"=>$dato["idParticipante"]];
        $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datParticipante),$datParticipante);
        array_push($pendientes, $participante[0]);
    }
}
// echo $campo;
// echo '<pre>';
// var_dump($inscritos);
// var_dump($pendientes);
// echo '</pre>';
// die;
?>
<!-- Barra de navegación -->
<header class="header" id="header">
    <div class="header_toggle">
        <i class='fas fa-bars' id="header-toggle"></i>
    </div>
    <div>
        <h5 class="me-auto my-auto">
            <?php echo $_SESSION["admin"]; ?>
        </h5>
    </div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div>
            <a href="#" class="nav_logo">
                <img src="<?php echo $dominio; ?>vistas/img/rsc/logo UPA.svg" class='nav_logo-icon'>
                <span class="nav_logo-name">CURSOS UPA</span>
            </a>
            <div class="nav_list">
                <a class="nav_link" id="link_pendientes">
                    <i class='fas fa-user-clock nav_icon'></i>
                    <span class="nav_name">Pendientes</span>
                </a>
                <a class="nav_link" id="link_inscritos">
                    <i class='fas fa-user-check nav_icon'></i>
                    <span class="nav_name">Inscritos</span>
                </a>
                <a class="nav_link" id="link_cursos">
                    <i class='fas fa-bookmark nav_icon'></i>
                    <span class="nav_name">Cursos</span>
                </a>
            </div>
        </div>
        <a href="<?php echo $dominio; ?>salir" class="nav_link">
            <i class='fas fa-sign-out-alt nav_icon'></i>
            <span class="nav_name">Cerrar sesión</span>
        </a>
    </nav>
</div>

<!--TABLAS-->

<div class="container-fluid mt-5 pt-4">
    <!-- ALUMNOS PENDIENTES-->
    <div id="pendientesTable" class="visually-hidden-focusable">
        <h1 class="text-center">Aspirantes pendientes</h1>
        <div class="table-responsive">
            <table class="table table-striped table-primary table-hover mb-4">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">CURP</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Pago</th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($pendientes as $key => $datos) {
                        $pagoDato = ["idParticipante"=>$datos["idParticipante"]];
                        $pagoPart = ModeloFormularios::mdlSelecReg("Pagos", array_keys($pagoDato),$pagoDato);
                        $datCurso = array("idCurso" => $datos["idCurso"]);
                        $curso = ModeloFormularios::mdlSelecReg("cursos", array_keys($datCurso), $datCurso);
                    ?>
                    <tr>
                        <td class="i-<?php echo $datos["idParticipante"] ?>">
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $datos['nombre']    ?>
                        </td>
                        <td>
                            <?php echo $datos['correo']    ?>
                        </td>
                        <td>
                            <?php echo $datos['curp']  ?>
                        </td>
                        <td class="c-<?php echo $datos["idCurso"] ?>">
                            <?php echo $curso[0]["curso"] ?>
                        </td>
                        <td>
                            <button type="submit" class="btn btn-<?php if (!$pagoPart[0]["comprobante"]) {echo 'secondary' ;} else
                                {echo 'primary' ;}?> btnComprobante position-relative">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <?php if ($pagoPart[0]["r2"]) : ?>
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle">
                                    <span class="visually-hidden"></span>
                                </span>
                                <?php endif ?>
                            </button>
                        </td>
                        <td><button type="submit" class="btn btn-warning btnEditarAlumno"
                                style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button>
                        </td>
                        <td><button type="button" class="btn btn-danger btnEliminarAlumno"
                                style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo '<script>$("#pendientesTable").removeClass("visually-hidden-focusable");$("#link_pendientes").addClass("active");</script>'; ?>

    <!-- ALUMNOS INSCRITOS -->
    <div id="inscritosTable" class="visually-hidden-focusable">
        <h1 class="text-center">Tabla inscritos</h1>
        <div class="table-responsive">
            <table class="table table-striped table-primary table-hover mb-4">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">CURP</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Pago</th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                </thead>
                <tbody>
                    <?php
                        foreach ($inscritos as $key => $datos) {
                            $datCurso = array("idCurso" => $datos["idCurso"]);
                            $curso = ModeloFormularios::mdlSelecReg("Cursos", array_keys($datCurso), $datCurso);
                        ?>
                    <tr>
                        <td class="i-<?php echo $datos["idParticipante"] ?>">
                            <?php echo $key + 1 ?>
                        </td>
                        <td>
                            <?php echo $datos['nombre']    ?>
                        </td>
                        <td>
                            <?php echo $datos['correo']    ?>
                        </td>
                        <td>
                            <?php echo $datos['curp']  ?>
                        </td>
                        <td class="c-<?php echo $datos["idCurso"] ?>">
                            <?php echo $curso[0]["curso"] ?>
                        </td>
                        <td><button type="button" class="btn btn-primary btnComprobante"><i
                                    class="fas fa-file-invoice-dollar"></i></button></td>
                        <td><button type="button" class="btn btn-warning btnEditarAlumno"
                                style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button>
                        </td>
                        <td><button type="button" class="btn btn-danger btnEliminarAlumno"
                                style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div>
            <form method="POST">
                <input type="submit" class="btn btn-primary bg-upa-secondary" name="subs" value="Alumnos subscritos">
                <?php
                    $File = new ControladorReportes();
                    $File->ctrSubscritos();
                    ?>
            </form>
        </div>
    </div>

    <!-- CURSOS-->
    <div id="cursosTable" class="visually-hidden-focusable">
        <h1 class="text-center">Tabla Cursos</h1>
        <div class="table-responsive">
            <table class="table table-striped table-primary table-hover mb-4">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Nombre del curso</th>
                    <th scope="col">Instructor</th>
                    <th scope="col">Registro del curso</th>
                    <th scope="col">Inicio del curso</th>
                    <th scope="col">Horario de clases</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Cupo</th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                </thead>
                <tbody>
                    <?php
                        $res = ModeloFormularios::mdlSelecReg("cursos");
                        foreach ($res as $key => $datos) {
                        $alumnosInscritos=ModeloFormularios::mdlVerificarCupo($datos["idCurso"]);
                    ?>
                    <tr>
                        <td class="c-<?php echo $datos["idCurso"] ?>">
                            <?php echo  $key + 1    ?>
                        </td>
                        <td>
                            <?php echo $datos['curso'] ?>
                        </td>
                        <td>
                            <?php echo $datos['instructor'] ?>
                        </td>
                        <td>
                            <?php echo "Del ".$datos['reg_inicio']." a ".$datos['reg_fin'] ?>
                        </td>
                        <td>
                            <?php echo "Del ".$datos['fec_inicio']." a ".$datos['fec_fin']  ?>
                        </td>
                        <td>
                            <?php echo "De ".$datos['hora_inicio']." a ".$datos['hora_fin']  ?>
                        </td>
                        <td>
                            <?php echo $datos['precio']  ?>
                        </td>
                        <td>
                            <?php echo $alumnosInscritos[0]."/".$datos['cupo']  ?>
                        </td>
                        <td><button type="button" class="btn btn-warning btnModificarCurso"
                                style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button>
                        </td>
                        <td><button type="button" class="btn btn-danger btnEliminarCurso" style="border-color: black"><i
                                    class="fas fa-trash-alt"></i></button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-primary bg-upa-secondary" data-bs-toggle="modal"
            data-bs-target="#modalAddCurso">Agregar curso</button>
    </div>

    <?php
        if (isset($_SESSION["vista"])) {
            switch ($_SESSION["vista"]) {
                case 1:
                    echo '<script>
                    $("#cursosTable").addClass("visually-hidden-focusable");
                    $("#inscritosTable").addClass("visually-hidden-focusable");
                    $("#pendientesTable").removeClass("visually-hidden-focusable");
                    $("#link_pendientes").addClass("active");
                    $("#link_inscritos").removeClass("active");
                    $("#link_cursos").removeClass("active");
                </script>';
                    break;
                case 2:
                    echo '<script>
                        $("#cursosTable").addClass("visually-hidden-focusable");
                        $("#inscritosTable").removeClass("visually-hidden-focusable");
                        $("#pendientesTable").addClass("visually-hidden-focusable");
                        $("#link_pendientes").removeClass("active");
                        $("#link_inscritos").addClass("active");
                        $("#link_cursos").removeClass("active");
                    </script>';
                    break;
                case 3:
                    echo '<script>
                        $("#cursosTable").removeClass("visually-hidden-focusable");
                        $("#inscritosTable").addClass("visually-hidden-focusable");
                        $("#pendientesTable").addClass("visually-hidden-focusable");
                        $("#link_pendientes").removeClass("active");
                        $("#link_inscritos").removeClass("active");
                        $("#link_cursos").addClass("active");
                    </script>';
                    break;
            }
            unset($_SESSION["vista"]);
        }
        ?>

    <!----------------------------------------------------MODALS------------------------------------------------------------------>

    <!--MODIFICAR ALUMNO -->
        <div class="modal fade" id="modalModificarAlumno" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel">Modificar datos del aspirante</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-2">
                                <div class="col-12">
                                <div class="input-group mb-3">
                                    <input type="text" id="idAlumno" name="idAlumno" hidden>
                                    <label class="input-group-text" for="inputGroupSelect01">Nombre del curso</label>
                                    <select class="form-select" id="idCurso" name="idCurso" required>
                                        <option selected value="">Elegir...</option>
                                        <?php
                                            $opcionescursos = ModeloFormularios::mdlSelecReg("Cursos");
                                            foreach ($opcionescursos as $key => $opcurso) {
                                            ?>
                                        <option value="<?php echo $opcurso["idCurso"] ?>">
                                            <?php echo $opcurso["curso"] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                </div>
                                <!--Col izquierda-->
                                <div class="col-xl-8 col-lg-6 col-md-12">
                                    <div class="col mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-user fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Nombre completo"
                                                name="nombre" required>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-hashtag fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="CURP" name="curp"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col mb-2">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-home fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Domicilio"
                                                name="direc" required>
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
                                            <input type="text" class="form-control" placeholder="Correo" name="correo"
                                                required>
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
                                                name="sexoRadio"
                                                onclick="document.getElementById('mujerRadio').checked = false"
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
                                            <input class="form-check-input ms-1" type="radio" value="soltero"
                                                id="solteroRadio" name="estadoRadio"
                                                onclick="document.getElementById('solteroRadio').checked = false"
                                                required>
                                            <label class="ms-2" for="">Soltero/a</label>
                                        </div>
                                        <div class="col-4 pt-1">
                                            <input class="form-check-input ms-1" type="radio" value="casado"
                                                id="casadoRadio" name="estadoRadio"
                                                onclick="document.getElementById('casadoRadio').checked = false">
                                            <label class="ms-2" for="">Casado/a</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn bg-upa-secondary text-white ">Modificar</button>
                            <?php
                                //añadir la modificación del alumno PHP
                                $Form = new ControladorFormularios();
                                $Form -> ctrModificarRegistroAlumno($campo);
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- ELIMINAR ALUMNO -->
    <div class="modal fade" id="modalEliminarAlumno" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Eliminar alumno</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="idAlumnoEliminar" name="alumnoEliminar" hidden>
                        ¿Estás seguro que deseas eliminar este alumno para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA
                        FORMA UNA VEZ BORRADO
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger ">Borrar alumno</button>
                        <?php
                            $Form->ctrEliminarRegistro("Participantes", "idParticipante", $campo,$dominio);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--AGREGAR CURSO-->
    <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="modalAddCurso" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Agregar un curso nuevo</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <!--Columna izq-->
                            <div class="col-xl-5 col-lg-11 col-md-12 ">
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <h5><b>Datos generales del curso</b></h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <input type="text" id="idCurso" hidden>
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-graduation-cap fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Nombre del curso"
                                                name="curso" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <input type="text" id="idCurso" hidden>
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-chalkboard-teacher fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Instructor"
                                                name="instructor" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <input type="text" id="idCurso" hidden>
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-school fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Lugar de impartición"
                                                name="aula" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <textarea class="form-control" placeholder="Objetivo" aria-label="Objetivo"
                                                name="objetivo" rows="7" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Columna enmedio-->
                            <div class="col-xl-5 col-lg-7 col-md-12 ">
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Inscripciones</b></h5>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12  mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2"
                                                id="addon-wrapping">Del</span>
                                            <input type="date" class="form-control" name="reg_inicio" id="reg_inicio"
                                                required>
                                            <span class="input-group-text input-group-text2"
                                                id="addon-wrapping">al</i></span>
                                            <input type="date" class="form-control" name="reg_fin" id="reg_fin"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Inicio y fin de curso</b></h5>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping">Del</span>
                                        <input type="date" class="form-control" name="fec_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping">al</i></span>
                                        <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Horario de entrenamiento</b></h5>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2 text-center"
                                            id="addon-wrapping">De</span>
                                        <input type="time" class="form-control" name="hora_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping">a</i></span>
                                        <input type="time" class="form-control" name="hora_fin" id="fec_fin" required>
                                    </div>
                                </div>

                            </div>
                            <!---Columna derecha-->
                            <div class="col-xl-2 col-lg-3 col-md-12 align-self-center">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 text-center">
                                        <h5><b>Texto sample</b></h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <input type="number" class="form-control" placeholder="Precio" name="precio"
                                                step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">

                                            <input type="number" class="form-control" placeholder="Descuento"
                                                name="desc" step="0" min="0" max="100" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="input-group">

                                            <input type="number" class="form-control" placeholder="Cupo" name="cupo"
                                                min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <h5><b>Texto sample</b></h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <select class="form-select" id="tipo" name="tipo" required>
                                                <option value="" selected>Tipo...</option>
                                                <option value="0">Diplomado</option>
                                                <option value="1">Curso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <select class="form-select" id="modalidad" name="modalidad" required>
                                                <option value="" selected>Modalidad...</option>
                                                <option value="0">Presencial</option>
                                                <option value="1">En línea</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="input-group">
                                            <select class="form-select" id="dia" name="dia" required>
                                                <option value="" selected>Días de clases...</option>
                                                <option value="lunes">Lunes</option>
                                                <option value="martes">Martes</option>
                                                <option value="miercoles">Miércoles</option>
                                                <option value="jueves">Jueves</option>
                                                <option value="viernes">Viernes</option>
                                                <option value="sabado">Sábados</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Parte inferior -->
                            <div class="col-12 text-center">
                                <h5><b>Temario</b></h5>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="input-group">
                                    <textarea class="form-control"
                                        placeholder="Ingresar los temas que serán impartidos por el/la instructor/a durante el curso"
                                        aria-label="Temario" name="temario"
                                        style="min-height: 200px; max-height: 200px;"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-12 gx-0 pe-2 mb-4">
                                    <h5 class="text-center"><b>Recursos</b></h5>
                                    <div class="input-group">
                                        <textarea class="form-control"
                                            placeholder="Ingresar las ligas de documentos, libros, software, etc., necesarios para el curso"
                                            aria-label="recursos" name="recursos"
                                            style="min-height: 200px; max-height: 200px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12 gx-0 ps-2 mb-4">
                                    <h5 class="text-center"><b>Materiales</b></h5>
                                    <div class="input-group">
                                        <textarea class="form-control"
                                            placeholder="Indicar todos los materiales necesarios para la realización de las prácticas del curso (cables, conectores, dispositivos, etc.)"
                                            aria-label="materias" name="materiales"
                                            style="min-height: 200px; max-height: 200px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <h5 class="text-center"><b>Flyer del curso</b></h5>
                                <input type="file" class=" file" name="flyer" id="flyer" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn text-white bg-upa-secondary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <?php
                            $Form->ctrRegistrarCurso();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!--MODIFICAR CURSO-->
    <form method="POST" enctype="multipart/form-data">
        <div class="modal fade" id="modalModificarCurso" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Modificar información del curso</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="idCursoModificar" id="idCursoModificar" hidden>
                        <div class="row justify-content-center">
                            <!--Columna izq-->
                            <div class="col-xl-5 col-lg-11 col-md-12 ">
                                <div class="row justify-content-center">
                                    <div class="col-12 text-center">
                                        <h5><b>Datos generales del curso</b></h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <!-- <input type="text" id="idCurso" hidden> -->
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-graduation-cap fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Nombre del curso"
                                                name="curso" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <input type="text" id="idCurso" hidden>
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-chalkboard-teacher fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Instructor"
                                                name="instructor" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <input type="text" id="idCurso" hidden>
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i
                                                    class="fas fa-school fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Aula y/o ubicación"
                                                name="aula" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <textarea class="form-control" placeholder="Objetivo" aria-label="Objetivo"
                                                name="objetivo" rows="7"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--Columna enmedio-->
                            <div class="col-xl-5 col-lg-7 col-md-12 ">
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Inscripciones</b></h5>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-12  mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2"
                                                id="addon-wrapping">Del</span>
                                            <input type="date" class="form-control" name="reg_inicio" id="reg_inicio"
                                                required>
                                            <span class="input-group-text input-group-text2"
                                                id="addon-wrapping">al</i></span>
                                            <input type="date" class="form-control" name="reg_fin" id="reg_fin"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Inicio y fin de clases</b></h5>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping">Del</span>
                                        <input type="date" class="form-control" name="fec_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping">al</i></span>
                                        <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Horario de clases</b></h5>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2 text-center"
                                            id="addon-wrapping">De</span>
                                        <input type="time" class="form-control" name="hora_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping">a</i></span>
                                        <input type="time" class="form-control" name="hora_fin" id="fec_fin" required>
                                    </div>
                                </div>
                            </div>
                            <!---Columna derecha-->
                            <div class="col-xl-2 col-lg-3 col-md-12 align-self-center">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 text-center">
                                        <h5><b>Texto sample</b></h5>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="input-group">

                                            <input type="number" class="form-control" placeholder="Precio" name="precio"
                                                step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">

                                            <input type="number" class="form-control" placeholder="Descuento"
                                                name="desc" step="0" min="0" max="100" required>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="input-group">

                                            <input type="number" class="form-control" placeholder="Cupo" name="cupo"
                                                min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <h5><b>Texto sample</b></h5>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <select class="form-select" id="tipo" name="tipo" required>
                                                <option selected>Tipo...</option>
                                                <option value="0">Diplomado</option>
                                                <option value="1">Curso</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <select class="form-select" id="modalidad" name="modalidad" required>
                                                <option selected>Modalidad...</option>
                                                <option value="0">Presencial</option>
                                                <option value="1">En línea</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-4">
                                        <div class="input-group">
                                            <select class="form-select" id="dia" name="dia" required>
                                                <option selected>Días de clases...</option>
                                                <option value="lunes">Lunes</option>
                                                <option value="martes">Martes</option>
                                                <option value="miercoles">Miércoles</option>
                                                <option value="jueves">Jueves</option>
                                                <option value="viernes">Viernes</option>
                                                <option value="sabado">Sábados</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <h5><b>Temario</b></h5>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="input-group">
                                    <textarea class="form-control"
                                        placeholder="Ingresar los temas que serán impartidos por el/la instructor/a durante el curso"
                                        aria-label="Temario" name="temario"
                                        style="min-height: 200px; max-height: 200px;"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-12 mb-4">
                                    <h5 class="text-center"><b>Recursos</b></h5>
                                    <div class="input-group">
                                        <textarea class="form-control"
                                            placeholder="Ingresar las ligas de documentos, libros, software, etc., necesarios para el curso"
                                            aria-label="recursos" name="recursos"
                                            style="min-height: 200px; max-height: 200px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-12 mb-4">
                                    <h5 class="text-center"><b>Materiales</b></h5>
                                    <div class="input-group">
                                        <textarea class="form-control"
                                            placeholder="Indicar todos los materiales necesarios para la realización de las prácticas del curso (cables, conectores, dispositivos, etc.)"
                                            aria-label="materias" name="materiales"
                                            style="min-height: 200px; max-height: 200px;"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mb-4">
                                <h5 class="text-center"><b>Flyer del curso</b></h5>
                                <input type="file" name="flyer" id="editFlyer">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn text-white bg-upa-secondary">Guardar</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <?php
                            $Form->ctrModificarCurso($dominio);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>

    

    <!-- ELIMINAR CURSO -->
    <div class="modal fade" id="modalEliminarCurso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Eliminar curso</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="idCursoEliminar" name="cursoEliminar" hidden>
                        ¿Estás seguro que deseas eliminar este curso para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA
                        FORMA UNA VEZ BORRADO
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Borrar curso</button>
                        <?php
                            $Form->ctrEliminarRegistro("Cursos", "idCurso", $campo,$ominio);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- REVISAR COMPROBANTE -->
    <div class="modal fade" id="modalRevisar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Revisión de comprobante de pago</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div id="info-inscrito" class="col-md-6">
                        <h4>Nombre completo</h4>
                        <hr>
                        <p>Dirección: ..</p>
                        <p>CURP: ..</p>
                        <p>RFC: ..</p>
                        <p>Teléfono: ..</p>
                        <p>Curso: ..</p>
                        <p>Sexo: ..</p>
                        <p>Estado civil: ..</p>
                        <p>Curso: ..</p>
                        <p>Revisión (Administración): ..</p>
                    </div>
                    <div class="col-md-6 text-center">
                        <h4>Comprobante</h4>
                        <img id="revCmprobante" src="" alt="" class="img-fluid" style="max-height: 23rem">
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="text" name="idRev" id="idRev" class="visually-hidden-focusable">
                        <input type="text" name="idRevCurso" id="idRevCurso" class="visually-hidden-focusable">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-danger" name="btnRev" value="Rechazar">
                        <input type="submit" class="btn btn-success" name="btnRev" value="Validar">
                        <?php
                        
                        $Form->ctrValidarComprobante($dominio, $revisor, $campo);
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo $dominio; ?>vistas/js/admin-cursos.js"></script>

</body>