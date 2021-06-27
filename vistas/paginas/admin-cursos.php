<body>
    <div class="container-fluid mt-4">
        <!-- Tabla mostrar alumnos-->
        <h1 class="text-center">Tabla inscritos</h1>
        <table class="table table-striped table-success mb-4">
            <thead>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Dirección</th>
                <th scope="col">CURP</th>
                <th scope="col">RFC</th>
                <th scope="col">Sexo</th>
                <th scope="col">Estado civil</th>
                <th scope="col">Curso</th>
                <th scope="col">Modificar</th>
                <th scope="col">Eliminar</th>
            </thead>
            <tbody>
                <?php 
                    $res=ModeloFormularios::mdlSelecReg("inscritos");
                    foreach($res as $key=> $datos){
                ?>
                <tr>
                    <th>
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
                        <?php echo $datos['sexo']  ?>
                    </td>
                    <td>
                        <?php echo $datos['est_civil']  ?>
                    </td>
                    <td>
                        <?php echo $datos['idCurso']  ?>
                    </td>
                    <!-- Modal modifcar datos del alumno-->
                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalModificarAlumno" style="color: black; border-color: black;">Modificar</button></td>
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
                                                    <label class="input-group-text" for="inputGroupSelect01">Nombre del curso</label>
                                                    <select class="form-select" id="curso" name="curso" required>
                                                        <option selected value="">Elegir...</option>
                                                        <?php   
                                                            $res=ModeloFormularios::mdlSelecReg("cursos");
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-warning">Actualizar datos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal eliminar alumno-->
                    <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarAlumno" style="border-color: black">Eliminar</button></td>
                    <div class="modal fade" id="modalEliminarAlumno" tabindex="-1"  aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLabel">Eliminar alumno</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro que deseas eliminar este alumno para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA FORMA UNA VEZ BORRADO
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger">Borrar alumno</button>
                                </div>
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
                <th scope="col">Nombre del curso</th>
                <th scope="col">Descripción</th>
                <th scope="col">Instructor</th>
                <th scope="col">Fecha de inicio</th>
                <th scope="col">Fecha de fin</th>
                <th scope="col">Hora de inicio</th>
                <th scope="col">Hora de fin</th>
                <th scope="col">Costo</th>
                <th scope="col">Lugar</th>
                <th scope="col">Modificar</th>
                <th scope="col">Eliminar</th>
            </thead>
            <tbody>
                <?php 
                    
                    $res=ModeloFormularios::mdlSelecReg("cursos",null,null);

                    foreach($res as $key=> $datos){
                ?>
                <tr>
                    <th>
                        <?php echo $datos['titulo']    ?>
                        </td>
                    <td>
                        <?php echo $datos['desc']    ?>
                    </td>
                    <td>
                        <?php echo $datos['impartidor']  ?>
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
                    <td><button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalModificarCurso" style="color: black; border-color: black;">Modificar</button></td>
                    <div class="modal fade" id="modalModificarCurso" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLabel">Actualizar datos del curso</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    
                                    



                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-warning">Actualizar datos</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarCurso" style="border-color: black">Eliminar</button></td>
                    <div class="modal fade" id="modalEliminarCurso" tabindex="-1"  aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="modal-title" id="exampleModalLabel">Eliminar curso</h2>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro que deseas eliminar este curso para siempre? NO SE PODRÁ RECUPERAR DE NINGUNA FORMA UNA VEZ BORRADO
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger">Borrar curso</button>
                                </div>
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
                                        <div class="col-xl-7 col-lg-12">
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="text" class="form-control"
                                                            placeholder="Nombre del curso" name="nombre" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="text" class="form-control" placeholder="Instructor"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="text" class="form-control" placeholder="Lugar"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text">Descripción</span>
                                                        <textarea class="form-control"
                                                            aria-label="Descripción"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-5 col-lg-12">
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="text" class="form-control" placeholder="Precio"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <h5 class="text-center">Fechas de curso</h5>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="date" class="form-control" placeholder="Instructor"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="date" class="form-control" placeholder="Instructor"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <h5 class="text-center">Horas del curso</h5>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="time" class="form-control" placeholder="Instructor"
                                                            name="nombre" required>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text input-group-text2"
                                                            id="addon-wrapping"><i
                                                                class="fas fa-user fa-lg icons"></i></span>
                                                        <input type="time" class="form-control" placeholder="Instructor"
                                                            name="nombre" required>
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
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>

</body>