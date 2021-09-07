    <?php
    foreach ($res as $key => $dato) {
        if ($dato["r2"]==0) {
            $datParticipante = ["idParticipante"=>$dato["idParticipante"]];
            $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datParticipante),$datParticipante);
            array_push($pendientes, $participante[0]);
        }
    }
    ?>

    <!-- <header class="header" id="header">
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
                <a id="link_pendientes" class="nav_link">
                    <i class='fas fa-user-clock'></i>
                    <span class="links_name">Pendientes</span>
                </a>
                <span class="tooltip">Pendientes</span>
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
                <i class='fas fa-sign-out-alt' id="log_out"></i>
            </li>
        </ul>
    </div>

    <div class="container-fluid pt-3">
        <!-- Tabla mostrar alumnos pendientes -->
        <div id="pendientesTable" class="mb-4">
            <div class="row mb-4 d-flex">
                <div class="col-sm-6 align-self-center">
                    <h1 class="text-left fs-2 fw-bolder ms-3 my-auto"><i class="fas fa-angle-double-right text-upa-primary me-2"></i>Aspirantes pendientes</h1>
                </div>
                <div class="col-sm-5 me-3 ms-auto">
                    <div class="input-group rounded-pill shadow-sm-2 bg-white p-1">
                        <input type="text" class="form-control rounded-pill border-0 me-1 search-input" onkeyup="search(this)" name="searchPendientesAdm" id="liveSearch" placeholder="Buscar" aria-label="Buscar" aria-describedby="basic-addon1">
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
                    </thead>
                    <tbody class="searchContainer" name="adminPendientes">
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
                                </button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!-- <div class="table-responsive">
                <table class="table table-striped table-success mb-4">
                    <thead>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>
                        <th scope="col">CURP</th>
                        <th scope="col">Curso</th>
                        <th scope="col">Pago</th>
                    </thead>
                    <tbody class="searchContainer" name="adminPendientes">
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
                                    <button type="submit" class="btn btn-<?php if (!$pagoPart[0]["comprobante"]) {echo 'secondary';} else {echo 'primary';}?>  btnComprobante position-relative" onclick="comprobante(this)">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </button>
                                    <button type="submit" class="btn p-1 <?php if ($pagoPart[0]["comprobante"]) {echo 'btn-primary' ;}?> btnComprobante position-relative" onclick="comprobante(this)">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> -->
            <button type="submit" class="btn btn-primary bg-upa-secondary btn-Report mt-4" data-bs-toggle="modal" data-bs-target="#modalIngresos">Reporte de ingresos</button>            
        </div>

        <!-- Modal generar reporte de ingresos -->
        <div class="modal fade" id="modalIngresos" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-upa-primary-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4">Reporte de ingresos</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
                        <div class="modal-body row">
                            <div class="col-2">
                                <div class="input-group-text input-group-text2">
                                    <i class="fas fa-file fa-lg icons"></i>
                                </div>
                            </div>
                            <div class="col-4 pt-2">
                                <input class="form-check-input ms-1" type="radio" value="Excel" id="excelReport"
                                    name="reportType"
                                    required
                                    checked>
                                <label class="ms-2" for="">Excel</label>
                            </div>
                            <div class="col-4 pt-2">
                                <input class="form-check-input ms-1" type="radio" value="PDF" id="pdfReport"
                                    name="reportType">
                                <label class="ms-2" for="">PDF</label>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="input-group">
                                    <span class="input-group-text input-group-text2 fw-bold" id="addon-wrapping">Del</span>
                                    <input type="date" class="form-control" name="fec_inicio" id="fec_inicio"
                                        required>
                                    <span class="input-group-text input-group-text2 fw-bold"
                                        id="addon-wrapping">al</i></span>
                                    <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn text-white btn-primary" name="btnIngresos" value="Generar" data-bs-dismiss="modal">
                            <?php
                                $File = new ControladorReportes();
                                $File->ctrIngresos();
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal revisar comprobante -->
        <div class="modal fade" id="modalRevisar" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-upa-primary-gradient">
                        <h2 class="modal-title text-white text-uppercase display-6 fs-4">Revisión de comprobante de pago</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="post">
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
                                            <div class="row">
                                                <div class="mx-auto col-md-7 col-sm-12 mt-4">
                                                    <label for="fec_r2" class="form-label fw-bold text-upa-main-dark">Fecha de revisión</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i class="far fa-calendar fa-lg icons"></i></span>
                                                        <input type="date" class="form-control" name="fec_r2" id="fec_r2" required>
                                                    </div>
                                                </div>
                                            </div>
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
                                        <div class="w-100 marco-comprobante p-3 mb-3 mt-2">
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
                            <input type="text" name="idRev" id="idRev" class="visually-hidden-focusable">
                            <input type="text" name="idRevCurso" id="idRevCurso" class="visually-hidden-focusable">
                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button> -->
                            <input type="submit" class="btn btn-danger me-3" name="btnRev" value="Rechazar">
                            <input type="submit" class="btn btn-primary" name="btnRev" value="Validar">
                            <?php
                            $Form = new ControladorFormularios();
                            $Form->ctrValidarComprobante($dominio, $revisor, $campo);
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <?php echo '<script>$("#pendientesTable").removeClass("visually-hidden-focusable");$("#link_pendientes").addClass("active");</script>'; ?>
    </div>

    <script src="<?php echo $dominio; ?>vistas/js/admin-cursos.js"></script>

</body>