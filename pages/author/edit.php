<?php
include_once __DIR__ . '/../../commons/Utils.php';

$id_a = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
include_once __DIR__ . '/../../server/author/edit.php';

if (!$a) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar autor</title>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
    <?php include '../../commons/menu.php'; ?>
    <br><br>
    <div class="container text-center">
        <h1>Editar autor</h1>
        <br>
        <?php if (!$a) { ?>
            <div class="alert alert-warning">El autor no existe.</div>
            <a href="/Biblioteca/pages/author/">Volver al listado</a>
        <?php } else { ?>
            <?php include __DIR__ . '/_form.php'; ?>
        <?php } ?>
    </div>
</body>

</html>
