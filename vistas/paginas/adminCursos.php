<body>
    <div class="container mt-4" >
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
                    
                    $res=ModeloFormularios::mdlSelecReg("inscritos",null,null);

                    foreach($res as $key=> $datos){
                ?>
                <tr>
                    <th><?php echo $datos['nombre']    ?></td>
                    <td><?php echo $datos['correo']    ?></td>
                    <td><?php echo $datos['telefono']  ?></td>
                    <td><?php echo $datos['direc']  ?></td>
                    <td><?php echo $datos['curp']  ?></td>
                    <td><?php echo $datos['rfc']  ?></td>
                    <td><?php echo $datos['sexo']  ?></td>
                    <td><?php echo $datos['est_civil']  ?></td>
                    <td><?php echo $datos['idCurso']  ?></td>
                    <td><a href="formModificarProducto.php?idInscrito=<?php echo $datos['idInscrito'] ?>"><button  type="button" class="btn btn-warning" style="color: white; border-color: black;" >Modificar</button></a></td>
                    <td><a href="borrarProducto.php?idInscrito=<?php echo $datos['idInscrito'] ?>"><button type="button" class="btn btn-danger"  style="border-color: black">Eliminar</button></a></td>
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
                    <th><?php echo $datos['titulo']    ?></td>
                    <td><?php echo $datos['desc']    ?></td>
                    <td><?php echo $datos['impartidor']  ?></td>
                    <td><?php echo $datos['fec_inicio']  ?></td>
                    <td><?php echo $datos['fec_fin']  ?></td>
                    <td><?php echo $datos['hora_inicio']  ?></td>
                    <td><?php echo $datos['hora_fin']  ?></td>
                    <td><?php echo $datos['precio']  ?></td>
                    <td><?php echo $datos['lugar']  ?></td>
                    <td><a href="formModificarProducto.php?idCurso=<?php echo $datos['idCurso'] ?>"><button  type="button" class="btn btn-warning" style="color: white; border-color: black;" >Modificar</button></a></td>
                    <td><a href="borrarProducto.php?IdCurso=<?php echo $datos['idCurso'] ?>"><button type="button" class="btn btn-danger"  style="border-color: black">Eliminar</button></a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
        <!-- Formulario registrar cursos-->
        <div class="card">
            <div class="card-body">
                <h1 class="text-center">Formulario registro cursos</h1>
                <form method="POST">
                    
                    <div class="row mb-3">
                        <div class="col-xl-7 col-lg-12">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                        <input type="text" class="form-control" placeholder="Nombre del curso" name="nombre" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                        <input type="text" class="form-control" placeholder="Instructor" name="nombre" required>
                                    </div> 
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                        <input type="text" class="form-control" placeholder="Lugar" name="nombre" required>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text">Descripción</span>
                                        <textarea class="form-control" aria-label="Descripción"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-12">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                        <input type="text" class="form-control" placeholder="Precio" name="nombre" required>
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
                                        <input type="date" class="form-control" placeholder="Instructor" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                        <input type="date" class="form-control" placeholder="Instructor" name="nombre" required>
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
                                        <input type="date" class="form-control" placeholder="Instructor" name="nombre" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-user fa-lg icons"></i></span>
                                        <input type="date" class="form-control" placeholder="Instructor" name="nombre" required>
                                    </div>
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
                        $ingreso->ctrRegistro();
                    ?>
                </form>
            </div>
        </div>

    </div>

</body>