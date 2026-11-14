<?php
include_once __DIR__ . '/../../commons/Utils.php';

$id_a = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
include_once __DIR__ . '/../../server/author/delete.php';

if (!$a) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar autor</title>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
    <?php include '../../commons/menu.php'; ?>
    <br><br>
    <div class="container text-center">
        <h1>Eliminar autor</h1>
        <br>
        <?php if (!$a) { ?>
            <div class="alert alert-warning">El autor no existe.</div>
            <a href="/Biblioteca/pages/author/">Volver al listado</a>
        <?php } elseif ($books) { ?>
            <div class="alert alert-warning">
                No se puede eliminar a <?php echo e($a['first_name'] . ' ' . $a['last_name']) ?>
                porque tiene <?php echo count($books) ?> libro(s) registrado(s).
            </div>
            <a href="/Biblioteca/pages/author/">Volver al listado</a>
        <?php } else { ?>
            <p>¿Seguro que quieres eliminar a <strong><?php echo e($a['first_name'] . ' ' . $a['last_name']) ?></strong>? Esta acción no se puede deshacer.</p>
            <form method="post">
                <button type="submit" class="btn btn-danger">Eliminar</button>
                <a href="/Biblioteca/pages/author/" class="btn btn-outline-secondary">Cancelar</a>
            </form>
        <?php } ?>
    </div>
</body>

</html>
