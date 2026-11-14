<?php
include_once __DIR__ . '/../commons/Utils.php';

$col = trim((string) ($_GET['col'] ?? ''));
include_once __DIR__ . '/../server/collections.php';

if (!$category) {
    http_response_code(404);
}
$utils = new Utils();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset='utf-8'>
    <title>BibTum - Colecciones</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../css/bootstrap.min.css'>
    <script src='../js/popper.min.js'></script>
    <script src='../js/bootstrap.min.js'></script>
</head>

<body>
    <?php include '../commons/menu.php' ?>
    <br><br>
    <div class="container text-center">
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10">
                <?php if (!$category) { ?>
                    <div class="alert alert-warning">La categoría no existe.</div>
                <?php } else { ?>
                    <h1>Colección <?php echo e($category['name']) ?></h1>
                    <br>
                    <?php if (!$l) { ?>
                        <p>Todavía no hay libros en esta categoría.</p>
                    <?php } else { ?>
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
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</body>

</html>
