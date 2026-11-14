<?php
include_once __DIR__ . '/../../commons/Utils.php';

$id_a = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
include_once __DIR__ . '/../../server/author/detail.php';

if (!$a) {
    http_response_code(404);
}
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
                <h1>Detalles del autor</h1>
                <br>
                <?php if (!$a) { ?>
                    <div class="alert alert-warning">El autor no existe.</div>
                <?php } else { ?>
                    <div class="card mx-auto" style="width: 18rem;">
                        <img src="<?php echo e(imageUrl($a['pic_url'])) ?>" class="card-img-top" alt="Foto de <?php echo e($a['first_name'] . ' ' . $a['last_name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo e($a['first_name'] . ' ' . $a['last_name']) ?></h5>
                            <p class="card-text"><?php echo e($a['born_date']) ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <?php if (!$books) { ?>
                                <li class="list-group-item">Sin libros registrados</li>
                            <?php } ?>
                            <?php foreach ($books as $book) { ?>
                                <li class="list-group-item">
                                    <a href="/Biblioteca/pages/book/detail.php?id=<?php echo e($book['id']) ?>"><?php echo e($book['name_book']) ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="card-body">
                            <a href="/Biblioteca/pages/author/edit.php?id=<?php echo e($a['id']) ?>" class="card-link">Editar</a>
                            <a href="/Biblioteca/pages/author/delete.php?id=<?php echo e($a['id']) ?>" class="card-link">Eliminar</a>
                        </div>
                    </div>
                <?php } ?>
                <br>
                <a href="/Biblioteca/pages/author/">Volver al listado</a>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</body>

</html>
