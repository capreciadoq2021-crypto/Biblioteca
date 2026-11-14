<?php // Campos del formulario de autor. Espera $data y $errors. ?>
<?php if ($errors) { ?>
    <div class="alert alert-danger text-start">
        <ul class="mb-0">
            <?php foreach ($errors as $error) { ?>
                <li><?php echo e($error) ?></li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>
<form method="post" class="text-start mx-auto" style="max-width: 30rem;">
    <div class="mb-3">
        <label for="first_name" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="first_name" name="first_name" maxlength="80" required value="<?php echo e($data['first_name']) ?>">
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Apellido</label>
        <input type="text" class="form-control" id="last_name" name="last_name" maxlength="80" required value="<?php echo e($data['last_name']) ?>">
    </div>
    <div class="mb-3">
        <label for="born_date" class="form-label">Fecha de nacimiento</label>
        <input type="date" class="form-control" id="born_date" name="born_date" value="<?php echo e($data['born_date']) ?>">
    </div>
    <div class="mb-3">
        <label for="pic_url" class="form-label">URL de la foto (opcional)</label>
        <input type="url" class="form-control" id="pic_url" name="pic_url" value="<?php echo e($data['pic_url']) ?>">
    </div>
    <button type="submit" class="btn btn-primary">Guardar</button>
    <a href="/Biblioteca/pages/author/" class="btn btn-outline-secondary">Cancelar</a>
</form>
