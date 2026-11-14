<?php
include_once __DIR__ . '/../../commons/Utils.php';

$id_b = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
include_once __DIR__ . '/../../server/book/detail.php';

if (!$b) {
    http_response_code(404);
}
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
                <h1>Detalles del libro</h1>
                <br>
                <?php if (!$b) { ?>
                    <div class="alert alert-warning">El libro no existe.</div>
                <?php } else { ?>
                    <div class="card mx-auto" style="width: 18rem;">
                        <img src="<?php echo e(imageUrl($b['img_book'])) ?>" class="card-img-top" alt="Portada de <?php echo e($b['name_book']) ?>">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo e($b['name_book']) ?></h2>
                            <h5>
                                <a href="/Biblioteca/pages/author/detail.php?id=<?php echo e($b['author_id']) ?>"><?php echo e($b['author']) ?></a>
                            </h5>
                            <p class="card-text"><?php echo e($b['description']) ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Fecha de lanzamiento: <?php echo e($b['date_lan']) ?></li>
                            <li class="list-group-item">Categoría: <?php echo e($b['category']) ?></li>
                            <li class="list-group-item">Editorial: <?php echo e($b['editorial']) ?></li>
                            <li class="list-group-item">Reseña: <?php echo e($b['rese']) ?></li>
                        </ul>
                    </div>
                <?php } ?>
                <br>
                <a href="/Biblioteca/pages/book/">Volver al listado</a>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</body>

</html>
