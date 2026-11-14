<?php
include_once __DIR__ . '/../../commons/Utils.php';
include_once __DIR__ . '/../../server/author/index.php';

$utils = new Utils();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autores</title>
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
                <h1>Listado de autores</h1>
                <br>
                <div class="text-end">
                    <a href="/Biblioteca/pages/author/create.php" class="btn btn-primary">Nuevo autor</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Nacimiento</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($l as $a) { ?>
                            <tr>
                                <td><?php echo e($a['id']) ?></td>
                                <td><?php echo e($a['first_name']) ?></td>
                                <td><?php echo e($a['last_name']) ?></td>
                                <td><?php echo e($a['born_date']) ?></td>
                                <td><?php $utils->getCRUDOptions('/Biblioteca/pages/author/', $a['id']) ?></td>
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
