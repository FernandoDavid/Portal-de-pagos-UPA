<div class="container-fluid mt-4">
    <!-- Tabla mostrar alumnos-->
    <h1 class="text-center">Tabla inscritos</h1>
    <table class="table table-striped table-success mb-4">
        <thead>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Correo</th>
            <th scope="col">Teléfono</th>
            <th scope="col">Dirección</th>
            <th scope="col">CURP</th>
            <th scope="col">RFC</th>
            <th scope="col">Sexo</th>
            <th scope="col">Estado civil</th>
            <th scope="col">Curso</th>
            <th scope="col">Pago</th>
            <th scope="col">Modificar</th>
            <th scope="col">Eliminar</th>
        </thead>
        <tbody>
            <?php
            $res = ModeloFormularios::mdlSelecReg("inscritos", null, null);
            foreach ($res as $key => $datos) {
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
                        <?php echo $datos['telefono']  ?>
                    </td>
                    <td>
                        <?php echo $datos['direc']  ?>
                    </td>
                    <td>
                        <?php echo $datos['curp']  ?>
                    </td>
                    <td>
                        <?php echo $datos['rfc']  ?>
                    </td>
                    <td>
                        <?php echo ($datos["sexo"] == "H") ? "Masculino" : "Femenino";  ?>
                    </td>
                    <td>
                        <?php echo $datos['est_civil']  ?>
                    </td>
                    <td class="c-<?php echo $datos["idCurso"] ?>">
                        <?php echo $curso[0]["curso"] ?>
                    </td>
                    <!-- Modal revisión de comprobante -->
                    <td><button type="submit" class="btn btn-primary btnComprobante"><i class="fas fa-file-invoice-dollar"></i></button></td>
                    <div class="modal fade" id="modalRevisar" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title">Revisión de comprobante de pago</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img id="revCmprobante" src="" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal modifcar datos del alumno-->
                    <td><button type="submit" class="btn btn-warning btnEditarAlumno" style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button></td>
                    <div class="modal fade" id="modalModificarAlumno" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLabel">Actualizar datos del alumno</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST">
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
                                    $modificar->ctrModificarRegistroAlumno($dominio);

                                    ?>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal eliminar alumno-->
                    <td><button type="button" class="btn btn-danger btnEliminarAlumno" style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
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
                                        $delete->ctrEliminarRegistro("inscritos", "idInscrito");
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Tabla Mostrar cursos-->
    <h1 class="text-center">Tabla Cursos</h1>
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
                        <?php echo  $datos['idCurso']    ?>
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
                    <!-- Modal modificar curso-->
                    <td><button type="button" class="btn btn-warning btnModificarCurso" style="color: black; border-color: black;"><i class="fas fa-pencil-alt"></i></button></td>
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
                                                            <input type="text" name="idCursoModificar" id="idCursoModificar" hidden >
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
                    <!--Modal elminar curso-->
                    <td><button type="button" class="btn btn-danger btnEliminarCurso" style="border-color: black"><i class="fas fa-trash-alt"></i></button></td>
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
                                        $del->ctrEliminarRegistro("cursos", "idCurso");
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Modal agregar curso-->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddCurso">Agregar curso</button>
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
</div>

<script>
    $(document).ready(function() {
        $(".btnEditarAlumno").on('click', function() {
            $('#modalModificarAlumno').modal('show');
            var $tr = $(this).closest('tr');

            var $datos = $tr.children('td').map(function() {
                return $(this)[0].innerText;
            }).get();
            console.log($datos);

            $('#idAlumno').val($tr.children('td')[0].className.split('-')[1]);
            $('#nombre').val($datos[1]);
            $('#correo').val($datos[2]);
            $('#telefono').val($datos[3]);
            $('#domicilio').val($datos[4]);
            $('#curp').val($datos[5]);
            $('#rfc').val($datos[6]);
            if ($datos[7] == "Masculino") {
                document.getElementById('hombreRadio').checked = true;
            } else {
                document.getElementById('mujerRadio').checked = true;
            }

            if ($datos[8] == "soltero") {
                document.getElementById('solteroRadio').checked = true;
            } else {
                document.getElementById('casadoRadio').checked = true;
            }
            $('#curso').val($tr.children('td')[9].className.split('-')[1]);
        });

        $(".btnEliminarAlumno").on('click', function() {
            $('#modalEliminarAlumno').modal('show');
            var $tr = $(this).closest('tr');

            $('#idAlumnoEliminar').val($tr.children('td')[0].className.split('-')[1]);

        });


        $(".btnModificarCurso").on('click', function() {
            $('#modalModificarCurso').modal('show');
            var $tr = $(this).closest('tr');


            var $datos = $tr.children('td').map(function() {
                return $(this)[0].innerText;
            }).get();

            $('#idCursoModificar').val($datos[0]);
            $('#nombreCurso').val($datos[1]);
            $('#descripcion').val($datos[2]);
            $('#instructor').val($datos[3]);
            $('#fec_inicio').val($datos[4]);
            $('#fec_fin').val($datos[5]);
            $('#hora_inicio').val($datos[6]);
            $('#hora_fin').val($datos[7]);
            $('#precio').val($datos[8]);
            $('#lugar').val($datos[9]);
            $('#cupo').val($datos[10]);
        });

        $(".btnEliminarCurso").on('click', function() {
            $('#modalEliminarCurso').modal('show');
            var $tr = $(this).closest('tr');

            $('#idCursoEliminar').val($tr.children('td')[0].className.split('-')[1]);
        });

        $(".btnComprobante").on('click', function() {
            $('#modalRevisar').modal('show');

            var tr = $(this).closest('tr');

            var datos = {
                "idInscrito": tr.children('td')[0].className.split('-')[1],
                "idCurso": tr.children('td')[9].className.split('-')[1]
            };
            console.log(datos);

            $.ajax({
                url: dominio + 'ajax/formularios.ajax.php',
                method: "POST",
                data: datos,
                dataType: "json",
                success: function(res) {
                    console.log(res);
                    $('#modalRevisar .modal-body img').attr({
                        "src": dominio + 'vistas/img/comprobantes/' + res["idCurso"] + '/' + res["pago"],
                        "alt": res["pago"]
                    });
                },
                error: function() {
                    alert("err");
                }
            });


        });
    });
</script>

</body>