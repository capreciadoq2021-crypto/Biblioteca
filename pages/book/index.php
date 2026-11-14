<?php
include_once __DIR__ . '/../../commons/Utils.php';
include_once __DIR__ . '/../../server/book/index.php';

$utils = new Utils();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros</title>
    <script src="../../js/popper.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
</head>

<body>
    <?php include '../../commons/menu.php'; ?>
    <br><br>
    <div class="container text-center">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <h1>Listado de libros</h1>
                <br>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($l as $b) { ?>
                            <tr>
                                <td><?php echo e($b['id']) ?></td>
                                <td><?php echo e($b['name_book']) ?></td>
                                <td><?php echo e($b['author']) ?></td>
                                <td><?php $utils->getCRUDOptions('/Biblioteca/pages/book/', $b['id'], ['detail']) ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</body>

</html>
