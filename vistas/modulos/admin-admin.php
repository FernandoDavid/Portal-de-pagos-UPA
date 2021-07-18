    <?php
    foreach ($res as $key => $dato) {
        if (!$dato["rev2"]) {
            array_push($pendientes, $dato);
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
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pendientes as $key => $datos) {
                            $datCurso = array("idCurso" => $datos["idCurso"]);
                            $curso = ModeloFormularios::mdlSelecReg("cursos", array_keys($datCurso), $datCurso);
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
                                    </button>
                                </td>
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
                            $Form = new ControladorFormularios();
                            $Form->ctrValidarComprobante($dominio, $revisor, $campo);
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php echo '<script>$("#pendientesTable").removeClass("visually-hidden-focusable");$("#link_pendientes").addClass("active");</script>'; ?>
    </div>

    <script src="<?php echo $dominio; ?>vistas/js/admin-cursos.js"></script>

</body>