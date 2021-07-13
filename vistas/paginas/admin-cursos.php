<?php
if (!isset($_SESSION["admin"])) {
    echo '<script>
    if(window.history.replaceState){
        window.history.replaceState(null,null,window.location.href);
    } 
    window.location = "admin";
    </script>';
}

$res = ModeloFormularios::mdlSelecReg("inscritos", null, null);
$inscritos = array();
$pendientes = array();

$revisor = ModeloFormularios::mdlSelecReg("admins", "nombre", $_SESSION["admin"]);
$revisor[0]["depto"] == "Posgrado" ? $campo = 10 : $campo = 11;
echo '<script> var campo=' . $campo . '</script>';

?>

<header class="header" id="header">
    <div class="header_toggle">
        <i class='fas fa-bars' id="header-toggle"></i>
    </div>
    <div>
        <h5 class="me-auto my-auto"><?php echo $_SESSION["admin"]; ?></h5>
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
                <?php if($revisor[0]["depto"]=="Posgrado"):?>
                <a class="nav_link" id="link_inscritos">
                    <i class='fas fa-user-check nav_icon'></i>
                    <span class="nav_name">Inscritos</span>
                </a>
                <a class="nav_link" id="link_cursos">
                    <i class='fas fa-bookmark nav_icon'></i>
                    <span class="nav_name">Cursos</span>
                </a>
                <?php endif ?>
            </div>
        </div>
        <a href="<?php echo $dominio; ?>salir" class="nav_link">
            <i class='fas fa-sign-out-alt nav_icon'></i>
            <span class="nav_name">Cerrar sesión</span>
        </a>
    </nav>
</div>

<?php
foreach ($res as $key => $dato) {
    if ($dato["rev1"] && $dato["rev2"]) {
        array_push($inscritos, $dato);
    } else {
        array_push($pendientes, $dato);
    }
}
?>

<div class="container-fluid mt-5 pt-4">
    <!-- Tabla mostrar alumnos pendientes -->
    <div id="pendientesTable" class="visually-hidden-focusable">
        <h1 class="text-center">Tabla pendientes</h1>
        <div class="table-responsive">
            <table class="table table-striped table-success mb-4">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Correo</th>
                    <th scope="col">CURP</th>
                    <th scope="col">Curso</th>
                    <th scope="col">Pago</th>
                    <?php if($revisor[0]["depto"]=="Posgrado"):?>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                    <?php endif ?>
                </thead>
                <tbody>
                    <?php
                    foreach ($pendientes as $key => $datos) {
                        $curso = ModeloFormularios::mdlSelecReg("cursos", "idCurso", $datos["idCurso"]);
                    ?>
                        <tr>
                            <td class="i-<?php echo $datos["idInscrito"] ?>">
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
                                <button type="submit" class="btn btn-<?php if (!$datos["pago"]) {echo 'secondary';} else {echo 'primary';}?> btnComprobante position-relative">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    <?php if($datos["rev2"]): ?>
                                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger rounded-circle">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                    <?php endif ?>
                                </button>
                            </td>
                            <?php if($revisor[0]["depto"]=="Posgrado"):?>
                            <td><button type="submit" class="btn btn-warning btnEditarAlumno" style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button></td>
                            <td><button type="button" class="btn btn-danger btnEliminarAlumno" style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
                            <?php endif?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal revisar comprobante -->
    <div class="modal fade" id="modalRevisar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Revisión de comprobante de pago</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div id="info-inscrito" class="col-md-6">
                        <h4>Fullname</h4>
                        <hr>
                        <p>Dirección: ..</p>
                        <p>CURP: ..</p>
                        <p>RFC: ..</p>
                        <p>Teléfono: ..</p>
                        <p>Curso: ..</p>
                        <p>Sexo: ..</p>
                        <p>Estado civil: ..</p>
                        <p>Curso: ..</p>
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
                        $validar = new ControladorFormularios();
                        $validar->ctrValidarComprobante($dominio, $revisor, $campo);
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php echo '<script>$("#pendientesTable").removeClass("visually-hidden-focusable");$("#link_pendientes").addClass("active");</script>'; ?>
    <?php if($revisor[0]["depto"]=="Posgrado"):?>

    <!-- Tabla mostrar alumnos inscritos -->
    <div id="inscritosTable" class="visually-hidden-focusable">
        <h1 class="text-center">Tabla inscritos</h1>
        <div class="table-responsive">
            <table class="table table-striped table-success mb-4">
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
                        $curso = ModeloFormularios::mdlSelecReg("cursos", "idCurso", $datos["idCurso"]);
                    ?>
                        <tr>
                            <td class="i-<?php echo $datos["idInscrito"] ?>">
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
                            <td><button type="button" class="btn btn-primary btnComprobante"><i class="fas fa-file-invoice-dollar"></i></button></td>
                            <td><button type="button" class="btn btn-warning btnEditarAlumno" style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button></td>
                            <td><button type="button" class="btn btn-danger btnEliminarAlumno" style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabla Mostrar cursos-->
    <div id="cursosTable" class="visually-hidden-focusable">
        <h1 class="text-center">Tabla Cursos</h1>
        <div class="table-responsive">
            <table class="table table-striped table-success mb-4">
                <thead>
                    <th scope="col">#</th>
                    <th scope="col">Nombre del curso</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">Instructor</th>
                    <th scope="col">Fecha de inicio</th>
                    <th scope="col">Fecha de fin</th>
                    <th scope="col">Hora de inicio</th>
                    <th scope="col">Hora de fin</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Lugar</th>
                    <th scope="col">Cupo</th>
                    <th scope="col">Modificar</th>
                    <th scope="col">Eliminar</th>
                </thead>
                <tbody>
                    <?php

                    $res = ModeloFormularios::mdlSelecReg("cursos", null, null);
                    foreach ($res as $key => $datos) {
                    ?>
                        <tr>
                            <td class="c-<?php echo $datos["idCurso"] ?>">
                                <?php echo  $key + 1    ?>
                            </td>
                            <td>
                                <?php echo $datos['curso']    ?>
                            </td>
                            <td>
                                <?php echo $datos['desc']    ?>
                            </td>
                            <td>
                                <?php echo $datos['instructor']  ?>
                            </td>
                            <td>
                                <?php echo $datos['fec_inicio']  ?>
                            </td>
                            <td>
                                <?php echo $datos['fec_fin']  ?>
                            </td>
                            <td>
                                <?php echo $datos['hora_inicio']  ?>
                            </td>
                            <td>
                                <?php echo $datos['hora_fin']  ?>
                            </td>
                            <td>
                                <?php echo $datos['precio']  ?>
                            </td>
                            <td>
                                <?php echo $datos['lugar']  ?>
                            </td>
                            <td>
                                <?php echo $datos['cupo']  ?>
                            </td>
                            <td><button type="button" class="btn btn-warning btnModificarCurso" style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button></td>

                            <td><button type="button" class="btn btn-danger btnEliminarCurso" style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCurso">Agregar curso</button>
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

    <!-- MODALS -->
    <!-- Modificar alumno -->
    <div class="modal fade" id="modalModificarAlumno" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Actualizar datos del alumno</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <input type="text" id="idAlumno" name="idAlumno" hidden>
                                    <label class="input-group-text" for="inputGroupSelect01">Nombre del curso</label>
                                    <select class="form-select" id="curso" name="curso" required>
                                        <option selected value="">Elegir...</option>
                                        <?php
                                        $opcionescursos = ModeloFormularios::mdlSelecReg("cursos", null, null);
                                        foreach ($opcionescursos as $key => $opcurso) {
                                        ?>
                                            <option value="<?php echo $opcurso["idCurso"] ?>"><?php echo $opcurso["curso"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xl-8 col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                    <input type="text" value="" class="form-control" placeholder="Nombre completo" id="nombre" name="nombre" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 break-lg">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-phone-alt fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="Número de teléfono" id="telefono" name="telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xl-8 col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-home fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="Domicilio" id="domicilio" name="domicilio" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-12 break-lg">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-envelope fa-lg icons"></i></i></span>
                                    <input type="text" class="form-control" placeholder="Correo" id="correo" name="correo" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-xl-8 col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-hashtag fa-lg icons"></i></span>
                                    <input type="text" class="form-control" placeholder="CURP" id="curp" name="curp" required>
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
                                    <input type="text" class="form-control" placeholder="RFC" id="rfc" name="rfc" required>
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
                                        <input class="form-check-input ms-1" type="radio" value="soltero" id="solteroRadio" name="estadoRadio" onclick="document.getElementById('casadoRadio').checked = false" required>
                                        <label class="ms-2" for="">Soltero/a</label>
                                    </div>
                                    <div class="col-4 pt-2">
                                        <input class="form-check-input ms-1" type="radio" value="casado" id="casadoRadio" name="estadoRadio" onclick="document.getElementById('solteroRadio').checked = false">
                                        <label class="ms-2" for="">Casado/a</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar datos</button>
                        <?php
                        $modificar = new ControladorFormularios();
                        $modificar->ctrModificarRegistroAlumno($dominio, $campo);

                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Eliminar alumno -->
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
                        ¿Estás seguro que deseas eliminar este alumno para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA FORMA UNA VEZ BORRADO
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary " data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger ">Borrar alumno</button>
                        <?php
                        $delete = new ControladorFormularios();
                        $delete->ctrEliminarRegistro("inscritos", "idInscrito", $campo);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal agregar curso-->
    <form method="POST">
        <div class="modal fade" id="modalAddCurso" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Agregar curso</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <input type="text" id="idCurso" hidden>
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="text" class="form-control" placeholder="Nombre del curso" name="nombreCurso" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="text" class="form-control" placeholder="Instructor" name="instructor" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="text" class="form-control" placeholder="Lugar" name="lugar" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <span class="input-group-text">Descripción</span>
                                                    <textarea class="form-control" aria-label="Descripción" name="desc"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="number" class="form-control" placeholder="Precio" name="precio" step="0.01" min="0" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="number" class="form-control" placeholder="Cupo" name="cupo" min="0" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <h5 class="text-center">Fechas de curso</h5>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="date" class="form-control" name="fec_inicio" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="date" class="form-control" name="fec_fin" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row ">
                                            <h5 class="text-center">Horas del curso</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="time" class="form-control" name="hora_inicio" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group">
                                                    <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                                    <input type="time" class="form-control" name="hora_fin" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar curso</button>
                        <?php
                        $insert = new ControladorFormularios();
                        $insert->ctrRegistrarCurso();

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal eliminar curso -->
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
                        ¿Estás seguro que deseas eliminar este curso para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA FORMA UNA VEZ BORRADO
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Borrar curso</button>
                        <?php
                        $del = new ControladorFormularios();
                        $del->ctrEliminarRegistro("cursos", "idCurso", $campo);
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar curso -->
    <div class="modal fade" id="modalModificarCurso" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLabel">Actualizar datos del curso</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-xl-6 col-lg-12">
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <input type="text" name="idCursoModificar" id="idCursoModificar" hidden>
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Nombre del curso" name="nombreCurso" id="nombreCurso" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Instructor" id="instructor" name="instructor" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="text" class="form-control" placeholder="Lugar" id="lugar" name="lugar" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-group">
                                            <span class="input-group-text">Descripción</span>
                                            <textarea class="form-control" aria-label="Descripción" id="descripcion" name="desc"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="number" class="form-control" placeholder="Precio" id=precio name="precio" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="number" class="form-control" placeholder="Cupo" id="cupo" name="cupo" min="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <h5 class="text-center">Fechas de curso</h5>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="date" class="form-control" id="fec_inicio" name="fec_inicio" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="date" class="form-control" id="fec_fin" name="fec_fin" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row ">
                                    <h5 class="text-center">Horas del curso</h5>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="time" class="form-control" id="hora_inicio" name="hora_inicio" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                            <input type="time" class="form-control" id="hora_fin" name="hora_fin" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Actualizar datos</button>
                        <?php

                        $modificarCurso = new ControladorFormularios();
                        $modificarCurso->ctrModificarCurso();


                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php endif ?>
</div>

<script>
    $(document).ready(function() {

        $('body').addClass('admin-body').attr("id", "body-pd");

        $(".btnEditarAlumno").on('click', function() {
            $('#modalModificarAlumno').modal('show');
            let tr = $(this).closest('tr');

            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: 'POST',
                crossDomain: true,
                data: {
                    "tablaFD": "inscritos",
                    "itemFD": "idInscrito",
                    "idFD": tr.children('td')[0].className.split('-')[1]
                },
                dataType: "json",
                async: true,
                success: function(res) {
                    // console.log(res);
                    let inputs = $('#modalModificarAlumno').find('input');
                    // console.log(inputs);
                    $(inputs[0]).val(tr.children('td')[0].className.split('-')[1]);
                    $(inputs[1]).val(res["nombre"]);
                    $(inputs[2]).val(res["telefono"]);
                    $(inputs[3]).val(res["direc"]);
                    $(inputs[4]).val(res["correo"]);
                    (res["sexo"] == "H") ? inputs[6].checked = true: inputs[7].checked = true;
                    $(inputs[5]).val(res["curp"]);
                    $(inputs[8]).val(res["rfc"]);
                    (res["est_civil"] == "soltero") ? inputs[9].checked = true: inputs[10].checked = true;
                    $($('#modalModificarAlumno').find('select')[0]).val(res["idCurso"]);
                },
                error: function(err) {
                    console.log(err);
                }
            });

            // var $datos = $tr.children('td').map(function() {
            //     return $(this)[0].innerText;
            // }).get();
            // console.log($datos);


            // $('#idAlumno').val($tr.children('td')[0].className.split('-')[1]);
            // $('#nombre').val($datos[1]);
            // $('#correo').val($datos[2]);
            // $('#telefono').val($datos[3]);
            // $('#domicilio').val($datos[4]);
            // $('#curp').val($datos[5]);
            // $('#rfc').val($datos[6]);
            // if ($datos[7] == "Masculino") {
            //     document.getElementById('hombreRadio').checked = true;
            // } else {
            //     document.getElementById('mujerRadio').checked = true;
            // }

            // if ($datos[8] == "soltero") {
            //     document.getElementById('solteroRadio').checked = true;
            // } else {
            //     document.getElementById('casadoRadio').checked = true;
            // }
            // $('#curso').val($tr.children('td')[9].className.split('-')[1]);
        });

        $(".btnEliminarAlumno").on('click', function() {
            $('#modalEliminarAlumno').modal('show');
            var $tr = $(this).closest('tr');

            $('#idAlumnoEliminar').val($tr.children('td')[0].className.split('-')[1]);

        });


        $(".btnModificarCurso").on('click', function() {
            $('#modalModificarCurso').modal('show');
            let tr = $(this).closest('tr');

            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: 'POST',
                data: {
                    "tablaFD": "cursos",
                    "itemFD": "idCurso",
                    "idFD": tr.children('td')[0].className.split('-')[1]
                },
                dataType: "json",
                async: true,
                success: function(res) {
                    // console.log(res);
                    let inputs = $('#modalModificarCurso').find('input');
                    // console.log(inputs);
                    console.log(tr.children('td')[0].className.split('-')[1]);
                    $(inputs[0]).val(tr.children('td')[0].className.split('-')[1]);
                    console.log(tr.children('td')[0].className.split('-')[1]);
                    $(inputs[1]).val(res["curso"]);
                    $(inputs[2]).val(res["instructor"]);
                    $(inputs[3]).val(res["lugar"]);
                    $('#modalModificarCurso').find('textarea').val(res["desc"]);
                    $(inputs[4]).val(res["precio"]);
                    $(inputs[5]).val(res["cupo"]);
                    $(inputs[6]).val(res["fec_inicio"]);
                    $(inputs[7]).val(res["fec_fin"]);
                    $(inputs[8]).val(res["hora_inicio"]);
                    $(inputs[9]).val(res["hora_fin"]);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $(".btnEliminarCurso").on('click', function() {
            $('#modalEliminarCurso').modal('show');
            var $tr = $(this).closest('tr');

            $('#idCursoEliminar').val($tr.children('td')[0].className.split('-')[1]);
        });

        $(".btnComprobante").on('click', function() {
            $('#modalRevisar').modal('show');

            var tr = $(this).closest('tr');
            // console.log(tr.children());
            // console.log(fillData("inscritos","idInscrito",tr.children('td')[0].className.split('-')[1]));

            let datos = {
                "idInscrito": tr.children('td')[0].className.split('-')[1],
                "idCurso": tr.children('td')[4].className.split('-')[1]
            }
            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: "POST",
                data: datos,
                dataType: "json",
                success: function(res) {
                    if (res["pago"]) {
                        $('#modalRevisar .modal-body img').attr({
                            "src": dominio + 'vistas/img/comprobantes/' + res["idCurso"] + '/' + res["pago"],
                            "alt": res["pago"]
                        });
                    } else {
                        $('#modalRevisar .modal-body img').attr({
                            "src": "",
                            "alt": ""
                        });
                    }

                    $('#idRev').val(datos["idInscrito"]);
                    $('#idRevCurso').val(res["idCurso"]);
                    if (res[campo]) {
                        $($('#modalRevisar .modal-footer')[0]).addClass("visually-hidden-focusable");
                    } else {
                        $($('#modalRevisar .modal-footer')[0]).removeClass("visually-hidden-focusable");
                    }
                },
                error: function() {
                    alert("err");
                }
            });

            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: 'POST',
                data: {
                    "tablaFD": "inscritos",
                    "itemFD": "idInscrito",
                    "idFD": tr.children('td')[0].className.split('-')[1]
                },
                dataType: "json",
                async: true,
                success: function(res) {
                    // console.log(res);
                    // console.log($('#info-inscrito').children());
                    let labels = $('#info-inscrito').children();
                    // console.log(labels);
                    $(labels[0]).text(res["nombre"]);
                    $(labels[2]).html('<b>Correo: </b>' + res["correo"]);
                    $(labels[3]).html('<b>Teléfono: </b>' + res["telefono"]);
                    $(labels[4]).html('<b>Dirección: </b>' + res["direc"]);
                    $(labels[5]).html('<b>CURP: </b>' + res["curp"]);
                    $(labels[6]).html('<b>RFC: </b>' + res["rfc"]);
                    $(labels[7]).html('<b>Sexo: </b>' + ((res["sexo"] == "H") ? "Masculino" : "Femenino"));
                    $(labels[8]).html('<b>Estado civil: </b>' + res["est_civil"]);
                    $(labels[9]).html('<b>Curso: </b>' + tr.children('td')[4].innerText);
                },
                error: function(err) {
                    console.log(err);
                }
            });

        });

        // LATERAL NAVBAR
        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId);

            // Validate that all variables exist
            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener('click', () => {
                    // show navbar
                    nav.classList.toggle('show_nav');
                    // change icon
                    toggle.classList.toggle('fa-times');
                    // add padding to body
                    bodypd.classList.toggle('body-pd');
                    // add padding to header
                    headerpd.classList.toggle('body-pd');
                });
            }
        }

        showNavbar('header-toggle', 'nav-bar', 'body-pd', 'header');

        /*===== LINK ACTIVE =====*/
        const linkColor = document.querySelectorAll('.nav_link');

        function colorLink() {
            if (linkColor) {
                linkColor.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            }
        }
        linkColor.forEach(l => l.addEventListener('click', colorLink));

        $('#link_inscritos').on('click', () => {
            $('#inscritosTable').removeClass('visually-hidden-focusable');
            $('#cursosTable').addClass('visually-hidden-focusable');
            $('#pendientesTable').addClass('visually-hidden-focusable');
        });
        $('#link_cursos').on('click', () => {
            $('#cursosTable').removeClass('visually-hidden-focusable');
            $('#inscritosTable').addClass('visually-hidden-focusable');
            $('#pendientesTable').addClass('visually-hidden-focusable');
        });
        $('#link_pendientes').on('click', () => {
            $('#cursosTable').addClass('visually-hidden-focusable');
            $('#inscritosTable').addClass('visually-hidden-focusable');
            $('#pendientesTable').removeClass('visually-hidden-focusable');
        });
    });
</script>

</body>