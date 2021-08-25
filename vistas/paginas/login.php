<div class="d-flex" style="height: 100vh">
    <div class="text-center m-auto w-100 row">
        <form method="POST" id="form-login" class="col-lg-4 col-md-5 col-sm-7 row mx-auto">
            <div class="card border-0 shadow bg-upa-primary-gradient p-4">
                <div class="card-body">
                    <div class="col-12 mb-4">
                        <span class="mx-auto rounded-circle overflow-hidden d-flex p-0 pt-2" style="width: 100px;height:100px">
                            <i class="fas fa-user m-auto text-white" style="font-size: 6rem"></i>
                        </span>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-envelope fa-lg icons"></i></span>
                            <input type="text" class="form-control" placeholder="Correo" name="correoIngreso" required pattern="[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])">
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <span class="input-group-text input-group-text2" id="addon-wrapping"><i class="fas fa-key fa-lg icons"></i></span>
                            <input type="password" class="form-control" placeholder="Contraseña" name="pwdIngreso" required>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary mt-3" type="submit">Ingresar</button>
                        <?php
                        /*=====================================
                        INSTANCIA Y LLAMADO DE CLASE DE INGRESO
                        ======================================*/
                        $ingreso = new ControladorFormularios();
                        $ingreso->ctrIngreso();
                        ?>
                    </div>
                </div> 
            </div>
        </form>
    </div>
</div>
</body>