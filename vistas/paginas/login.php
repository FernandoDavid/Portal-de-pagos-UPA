<div class="bg-light">
    <div class="position-absolute text-center w-100 start-50 top-50 translate-middle">
        <form method="POST" class="col-md-3 col-sm-7 row mx-auto">
            <div class="col-12 mb-4">
                <span><i class="fas fa-user" style="font-size: 5rem"></i></span>
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
                <button class="btn btn-primary" type="submit">Enviar</button>
                <?php
                /*=====================================
                INSTANCIA Y LLAMADO DE CLASE DE INGRESO
                ======================================*/
                $ingreso = new ControladorFormularios();
                $ingreso->ctrIngreso();
                ?>
            </div>
        </form>
    </div>
</div>
</body>