    <?php
    foreach ($res as $key => $dato) {
        if (!$dato["r2"]) {
            $datParticipante = ["idParticipante"=>$dato["idParticipante"]];
            $participante = ModeloFormularios::mdlSelecReg("Participantes", array_keys($datParticipante),$datParticipante);
            array_push($pendientes, $participante[0]);
        }
    }
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
                </div>
            </div>
            <a href="<?php echo $dominio; ?>salir" class="nav_link">
                <i class='fas fa-sign-out-alt nav_icon'></i>
                <span class="nav_name">Cerrar sesión</span>
            </a>
        </nav>
    </div>

    <div class="container-fluid mt-5 pt-3">
        <!-- Tabla mostrar alumnos pendientes -->
        <div id="pendientesTable" class="visually-hidden-focusable mb-4">
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

            <div class="table-responsive px-3">
                <table class="table own-table-hover mb-4 align-middle">
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
            <button type="submit" class="btn btn-primary bg-upa-secondary btn-Report" data-bs-toggle="modal" data-bs-target="#modalIngresos">Reporte de ingresos</button>            
        </div>

        <!-- Modal generar reporte de ingresos -->
        <div class="modal fade" id="modalIngresos" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Reporte de ingresos</h2>
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
                                    <span class="input-group-text input-group-text2" id="addon-wrapping">Del</span>
                                    <input type="date" class="form-control" name="fec_inicio" id="fec_inicio"
                                        required>
                                    <span class="input-group-text input-group-text2"
                                        id="addon-wrapping">al</i></span>
                                    <input type="date" class="form-control" name="fec_fin" id="fec_fin" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn text-white bg-upa-secondary" name="btnIngresos" value="Generar" data-bs-dismiss="modal">
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
                    <div class="modal-header">
                        <h2 class="modal-title">Revisión de comprobante de pago</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST">
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
                                <div class="rev-date">
                                    <input type="date" class="form-control revDate" name="revDate" placeholder="Fecha de revisión" required>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <h4>Comprobante</h4>
                                <img id="revCmprobante" src="" alt="" class="img-fluid" style="max-height: 23rem">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="text" name="idRev" id="idRev" class="visually-hidden-focusable">
                            <input type="text" name="idRevCurso" id="idRevCurso" class="visually-hidden-focusable">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-danger" name="btnRev" value="Rechazar">
                            <input type="submit" class="btn btn-success" name="btnRev" value="Validar">
                            <?php
                            $Form = new ControladorFormularios();
                            $Form->ctrValidarComprobante($dominio, $revisor, $campo);
                            ?>
                        </div>
                    </form>
                </div>
            </div>
            <div>
        </div>

        <?php echo '<script>$("#pendientesTable").removeClass("visually-hidden-focusable");$("#link_pendientes").addClass("active");</script>'; ?>
    </div>

    <script src="<?php echo $dominio; ?>vistas/js/admin-cursos.js"></script>

</body>