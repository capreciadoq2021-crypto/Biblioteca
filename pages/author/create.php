<?php
include_once __DIR__ . '/../../commons/Utils.php';
include_once __DIR__ . '/../../server/author/create.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo autor</title>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
    <?php include '../../commons/menu.php'; ?>
    <br><br>
    <div class="container text-center">
        <h1>Nuevo autor</h1>
        <br>
        <?php include __DIR__ . '/_form.php'; ?>
    </div>
</body>

</html>
