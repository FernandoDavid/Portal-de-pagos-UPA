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
?>
<!-- Barra de navegación -->
<!-- <header class="header" id="header">
    <div class="header_toggle">
        <i class='fas fa-bars' id="header-toggle"></i>
    </div>
    <div class="w-100 d-flex">
        <h5 class="ms-auto my-auto">
            <?php echo $_SESSION["admin"]; ?>
        </h5>
        <div class="rounded-circle ms-1 p-2"><i class="fas fa-user"></i></div>
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
</div> -->

<div class="sidebar">
    <div class="logo-details">
        <i class="upa-btn"><img src="<?php echo $dominio; ?>vistas/img/rsc/logo UPA.svg"></i>
        <!-- <i class='fas fa-home'></i> -->
        <span class="logo_name ms-3">Cursos UPA</span>
    </div>
    <!-- <div class="logo-details">
        <i class='bx bxl-c-plus-plus icon'></i>
        <div class="logo_name">Cursos UPA</div>
        <i class='bx bx-menu' id="btn"></i>
    </div> -->
    <ul class="nav-list p-0">
        <li>
            <a id="link_pendientes" class="nav_link" >
                <i class='fas fa-user-clock'></i>
                <span class="links_name">Pendientes</span>
            </a>
            <span class="tooltip">Pendientes</span>
        </li>
        <li>
            <a id="link_inscritos" class="nav_link">
                <i class='fas fa-user-check'></i>
                <span class="links_name">Inscritos</span>
            </a>
            <span class="tooltip">Inscritos</span>
        </li>
        <li>
            <a id="link_cursos" class="nav_link">
                <i class='fas fa-bookmark'></i>
                <span class="links_name">Cursos</span>
            </a>
            <span class="tooltip">Cursos</span>
        </li>
        <li class="profile">
            <div class="profile-details">
                <i class="fas fa-user"></i>
                <!-- <img src="profile.jpg" alt="profileImg"> -->
                <div class="name_job">
                    <div class="name fw-bold text-capitalize"><?php echo $_SESSION["admin"]; ?></div>
                    <div class="job text-capitalize"><?php echo $revisor[0]["depto"]; ?></div>
                </div>
            </div>
            <i class='fas fa-sign-out-alt' id="log_out" data-bs-toggle="tooltip" data-bs-placement="right" title="Cerrar sesión"></i>
        </li>
    </ul>
</div>

<!--TABLAS-->

<div class="container-fluid pt-4 body-adm">
    <!-- ALUMNOS PENDIENTES-->
    <div id="pendientesTable" class="visually-hidden-focusable">
        <div class="row mb-4 d-flex">
            <div class="col-sm-6 align-self-center">
                <h1 class="text-left fs-2 fw-bolder ms-3 my-auto"><i class="fas fa-angle-double-right text-upa-primary me-2"></i>Aspirantes pendientes</h1>
            </div>
            <div class="col-sm-5 me-3 ms-auto">
                <div class="input-group rounded-pill shadow-sm-2 bg-white p-1">
                    <input type="text" class="form-control rounded-pill border-0 me-1 search-input" onkeyup="search(this)" name="searchPendientesPos" id="liveSearch" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1">
                    <span class="input-group-text bg-dark rounded-circle p-1 text-white bounded-0 border-1 border-dark" style="width:36px">
                        <i class="fas fa-search mx-auto"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive px-3 mb-4">
            <table class="table own-table-hover mb-0 align-middle">
                <thead class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">CURP</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Pago</th>
                    <th scope="col">Opciones</th>
                </thead>
                <tbody class="searchContainer" name="posPendientes">
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
                            <?php echo $datos['nombre'] ?>
                        </td>
                        <td>
                            <?php echo $datos['correo'] ?>
                        </td>
                        <td>
                            <?php echo $datos['curp'] ?>
                        </td>
                        <td class="c-<?php echo $datos["idCurso"] ?>">
                            <?php echo $curso[0]["curso"] ?>
                        </td>
                        <td>
                            <button type="submit" class="btn p-1 <?php if ($pagoPart[0]["comprobante"]) {echo 'btn-primary' ;}?> btnComprobante position-relative" onclick="comprobante(this)">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <?php if ($pagoPart[0]["r2"]=="1") : ?>
                                <span
                                    class="position-absolute mt-1 top-0 start-100 translate-middle p-2 bg-danger rounded-circle">
                                </span>
                                <?php endif ?>
                            </button>
                        </td>
                        <td>
                            <button type="submit" class="btn p-1 btnEditarAlumno" onclick="editarParticipante(this)"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar aspirante">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn p-1 btnEliminarAlumno" onclick="eliminarParticipante(this)"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar aspirante">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php echo '<script>$("#pendientesTable").removeClass("visually-hidden-focusable");$("#link_pendientes").addClass("active");</script>'; ?>

    <!-- ALUMNOS INSCRITOS -->
    <div id="inscritosTable" class="visually-hidden-focusable">
        <div class="row mb-4 d-flex">
            <div class="col-sm-6 align-self-center">
                <h1 class="text-left fs-2 fw-bolder ms-3 my-auto"><i class="fas fa-angle-double-right text-upa-primary me-2"></i>Inscritos</h1>
            </div>
            <div class="col-sm-5 me-3 ms-auto">
                <div class="input-group rounded-pill shadow-sm-2 bg-white p-1">
                    <input type="text" class="form-control rounded-pill border-0 me-1 search-input" onkeyup="search(this)" name="searchInscritosPos" id="liveSearch" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1">
                    <span class="input-group-text bg-dark rounded-circle p-1 text-white bounded-0 border-1 border-dark" style="width:36px">
                        <i class="fas fa-search mx-auto"></i>
                    </span>
                </div>
            </div>
        </div>

        <div class="table-responsive px-3 mb-4">
            <table class="table own-table-hover mb-0">
                <thead class="table-dark">
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">CURP</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Pago</th>
                    <th scope="col">Opciones</th>
                </thead>
                <tbody class="searchContainer" name="posInscritos">
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
                        <td>
                            <button type="button" class="btn p-1 btn-primary btnComprobante" onclick="comprobante(this)">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn p-1 btnEditarAlumno" onclick="editarParticipante(this)"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar aspirante">
                                <i class="fas fa-pencil-alt"></i>
                            </button>
                            <button type="button" class="btn p-1 btnEliminarAlumno" onclick="eliminarParticipante(this)"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar aspirante">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
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
        <div class="col-sm-6 align-self-center mb-4">
            <h1 class="text-left fs-2 fw-bolder ms-3 my-auto"><i class="fas fa-angle-double-right text-upa-primary me-2"></i>Cursos</h1>
        </div>
        <div class="d-flex justify-content-evenly flex-wrap align-content-around">
            <?php 
                $res = ModeloFormularios::mdlSelecReg("Cursos");
                foreach ($res as $key => $datos):
                    $alumnosInscritos = ModeloFormularios::mdlVerificarCupo($datos["idCurso"]);
                    $razonCupo = floatval($alumnosInscritos[0])*floatval($datos['cupo'])/100;
            ?>
            <div id="c-<?php echo $datos["idCurso"] ?>" style="border-radius: 0.5rem" class="cursos overflow-hidden shadow mb-4">
            <div class="curso-banner position-relative text-white text-center bg-primary" style="background-image: url('<?php echo $dominio?>vistas/img/banners/<?php echo $datos["banner"]?>')">
                    <!-- <img src="<?php echo $dominio?>vistas/img/banners/<?php echo $datos["banner"]?>" alt="" class="img-fluid"> -->
                    <span class="position-absolute bottom-0 m-2 end-0 fs-5 badge rounded-pill">
                        <?php echo "$ ".number_format($datos["precio"],2) ?>
                    </span>
                </div>
                <div class="curso-body p-3">
                    <h4 class="fw-bolder curso-title">
                        <?php echo $datos["curso"]?>
                    </h4>
                    <p class="text-dark float-end ps-2 fw-normal fst-italic" style="font-size: 0.8rem;line-height:0.9rem;">
                        <?php echo $datos["reg_inicio"] ?> - <?php echo $datos["reg_fin"] ?>
                    </p>
                    <hr>
                    <h6 class="text-dark d-inline-flex">
                        <i class="fas fa-graduation-cap pe-2 my-auto"></i> <?php echo $datos["instructor"] ?>
                    </h6>
                    <p class="text-upa-gray text-truncate">
                        <?php echo $datos["objetivo"] ?>
                    </p>
                    <div class="d-flex">
                        <button class="btn bg-upa-secondary text-white fw-bold"  data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-cog"></i></button>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item btnModificarCurso" data-bs-toggle="modal">Editar curso</a></li>
                            <li><a class="dropdown-item btnEliminarCurso" data-bs-toggle="modal">Eliminar curso</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <form id="fc-<?php echo $datos["idCurso"]?>" method="post">
                                <input type="hidden" name="idCurso" value="<?php echo $datos["idCurso"]?>">
                                <?php 
                                //$File = new ControladorReportes();
                                $File->ctrParticipantes();
                                ?>
                            </form>
                            <li><a href="javacript:{}" onclick="document.getElementById(`fc-<?php echo $datos['idCurso']?>`).submit()" class="dropdown-item" data-bs-toggle="modal">Lista de participantes</a></li>
                        </ul>
                        <div class="ms-auto d-flex">
                            <span class="badge my-auto rounded-pill fs-6 <?php if($razonCupo>=80): ?>bg-danger text-white<?php else: ?>bg-upa-gray-light text-upa-gray-dark<?php endif;?>">
                                <i class="fas fa-users"></i> <b> <?php echo $alumnosInscritos[0]."/".$datos['cupo']?></b>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            ?>
        </div>
        <button type="button" class="btn btn-primary bg-upa-secondary" data-bs-toggle="modal" data-bs-target="#modalAddCurso">
            Agregar curso
        </button>
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
                    <div class="modal-header bg-upa-primary-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4" id="exampleModalLabel">Modificar aspirante</h2>
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
                                    <div class="col-4 align-self-center">
                                        <input class="form-check-input ms-1" type="radio" value="H" id="hombreRadio"
                                            name="sexoRadio"
                                            onclick="document.getElementById('mujerRadio').checked = false"
                                            required>
                                        <label class="ms-2" for="">Hombre</label>
                                    </div>
                                    <div class="col-4 align-self-center">
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
                                        <input class="form-check-input ms-1" type="radio" value="soltero"
                                            id="solteroRadio" name="estadoRadio"
                                            onclick="document.getElementById('casadoRadio').checked = false"
                                            required>
                                        <label class="ms-2" for="">Soltero/a</label>
                                    </div>
                                    <div class="col-4 align-self-center">
                                        <input class="form-check-input ms-1" type="radio" value="casado"
                                            id="casadoRadio" name="estadoRadio"
                                            onclick="document.getElementById('solteroRadio').checked = false">
                                        <label class="ms-2" for="">Casado/a</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Modificar</button>
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
                    <div class="modal-header bg-upa-danger-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4" id="exampleModalLabel">Eliminar alumno</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="idAlumnoEliminar" name="alumnoEliminar" hidden>
                        ¿Estás seguro que deseas eliminar este alumno para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA
                        FORMA UNA VEZ BORRADO
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
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
                    <div class="modal-header bg-upa-primary-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4">Nuevo curso</h2>
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
                                                id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">Del</i></span>
                                            <input type="date" class="form-control" name="reg_inicio" id="reg_inicio"
                                                required>
                                            <span class="input-group-text input-group-text2"
                                                id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">al</i></span>
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
                                        <span class="input-group-text input-group-text2" id="addon-wrapping">
                                            <i class="fst-normal fw-bold mx-auto">Del</i>
                                        </span>
                                        <input type="date" class="form-control" name="fec_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">al</i></span>
                                        <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Horario de entrenamiento</b></h5>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">De</i></span>
                                        <input type="time" class="form-control" name="hora_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">a</i></span>
                                        <input type="time" class="form-control" name="hora_fin" id="fec_fin" required>
                                    </div>
                                </div>

                            </div>
                            <!---Columna derecha-->
                            <div class="col-xl-2 col-lg-3 col-md-12 align-self-center">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 text-center">
                                        <h5><b>Detalles</b></h5>
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
                                        <h5><b>Clases</b></h5>
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
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <h5 class="text-center"><b>Flyer del curso</b></h5>
                                    <input type="file" class="" name="flyer" id="flyer" required>
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-center"><b>Banner del curso</b></h5>
                                    <input type="file" class="" name="banner" id="banner" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn text-white btn-primary">Guardar</button>
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
                    <div class="modal-header bg-upa-primary-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4">Modificar curso</h2>
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
                                                id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">Del</i></span>
                                            <input type="date" class="form-control" name="reg_inicio" id="reg_inicio"
                                                required>
                                            <span class="input-group-text input-group-text2"
                                                id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">al</i></span>
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
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">Del</i></span>
                                        <input type="date" class="form-control" name="fec_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">al</i></span>
                                        <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                                    </div>
                                </div>
                                <div class="col-12 mb-1">
                                    <h5 class="text-center"><b>Horario de clases</b></h5>
                                </div>
                                <div class="col-12 mb-4">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2 text-center"
                                            id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">De</i></span>
                                        <input type="time" class="form-control" name="hora_inicio" id="fec_inicio"
                                            required>
                                        <span class="input-group-text input-group-text2"
                                            id="addon-wrapping"><i class="fst-normal fw-bold mx-auto">a</i></span>
                                        <input type="time" class="form-control" name="hora_fin" id="fec_fin" required>
                                    </div>
                                </div>
                            </div>
                            <!---Columna derecha-->
                            <div class="col-xl-2 col-lg-3 col-md-12 align-self-center">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-12 text-center">
                                        <h5><b>Detalles</b></h5>
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
                                        <h5><b>Clases</b></h5>
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
                            <div class="row mb-4">
                                <div class="col-lg-6">
                                    <h5 class="text-center"><b>Flyer del curso</b></h5>
                                    <input type="file" name="flyer" id="editFlyer">
                                </div>
                                <div class="col-lg-6">
                                    <h5 class="text-center"><b>Banner del curso</b></h5>
                                    <input type="file" name="banner" id="editBanner">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn text-white btn-primary">Guardar</button>
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
                    <div class="modal-header bg-upa-danger-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4" id="exampleModalLabel">Eliminar curso</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="idCursoEliminar" name="cursoEliminar" hidden>
                        ¿Estás seguro que deseas eliminar este curso para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA
                        FORMA UNA VEZ BORRADO
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Borrar curso</button>
                        <?php
                            $Form->ctrEliminarRegistro("Cursos", "idCurso", $campo,$dominio);
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
                <div class="modal-header bg-upa-primary-gradient">
                    <h2 class="modal-title text-white text-uppercase display-6 fs-4">Revisión de comprobante de pago</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row gx-0">
                    <div class="col-xl-5 col-lg-6 col-md-12 mb-3 d-grid">
                        <div class="card my-auto border-0 user-card">
                            <div class="card-body my-auto">
                                <span class="mx-auto rounded-circle overflow-hidden d-flex p-0 pt-2">
                                    <i class="fas fa-user m-auto"></i>
                                </span>
                                <div class="text-center mt-3">
                                    <h5 class="fw-bold"></h5>
                                    <p class="fs-6 text-secondary fw-light mb-0" id="participante-name"></p>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6 col-md-12 text-center d-grid">
                        <div id="comprobante-revisar" class="card my-auto border-0">
                            <div class="card-body">
                                <h5 class="text-center text-upa-main-dark text-uppercase fw-bold mb-3">Monto a pagar</h5>
                                <div class="d-flex text-center justify-content-center align-items-center">
                                    <p class="mb-0 fs-6 text-upa-main-lighter fw-bold me-1">$</p>
                                    <h5 class="fw-bold mb-0 fs-3 text-upa-primary" id="precio"></h5>
                                </div>
                                <!-- <hr> -->
                                <div class="w-100 marco-comprobante p-3 mb-3 mt-2 position-relative">
                                    <!-- <span class="position-absolute top-0 start-100 translate-middle me-5 p-2 bg-danger border border-light rounded-circle" style="width:42px !important; height: 42px !important">
                                        <i class="fas fa-exclamation-triangle text-white fs-6"></i>
                                    </span> -->
                                    <img src="" alt="" class="img-fluid">
                                    <div class="row gx-0 pre-comprobante">
                                        <h6 class="fs-2 m-auto text-white fw-bolder">Sin comprobante</h6>
                                    </div>
                                </div>
                                <div id="rechazo" class="row">
                                    <div class="col-sm-6 text-danger fs-6"></div>
                                    <div class="col-sm-6 text-danger fs-6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form method="POST">
                        <input type="text" name="idRev" id="idRev" class="visually-hidden-focusable">
                        <input type="text" name="idRevCurso" id="idRevCurso" class="visually-hidden-focusable">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> -->
                        <input type="submit" class="btn btn-danger me-3" name="btnRev" value="Rechazar">
                        <input type="submit" class="btn btn-primary" name="btnRev" value="Validar">
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