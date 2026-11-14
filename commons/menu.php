<?php
include_once __DIR__ . '/db.php';
include_once __DIR__ . '/Utils.php';

$menuStmt = $db->prepare('SELECT initcap(name) AS name FROM public.category WHERE state = :s ORDER BY name');
$menuStmt->bindValue(':s', true, PDO::PARAM_BOOL);
$menuStmt->execute();
$menuCategories = $menuStmt->fetchAll();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/Biblioteca/">BibTum</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="/Biblioteca/">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Biblioteca/pages/book/">Libros</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Categorías
                    </a>
                    <ul class="dropdown-menu">
                        <?php foreach ($menuCategories as $menuCategory) { ?>
                            <li>
                                <a class="dropdown-item" href="/Biblioteca/pages/collections.php?col=<?php echo e(urlencode($menuCategory['name'])) ?>">
                                    <?php echo e($menuCategory['name']) ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Administrador
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/Biblioteca/pages/author/">Autores</a></li>
                        <li><a class="dropdown-item" href="/Biblioteca/pages/book/">Libros</a></li>
                        <li><a class="dropdown-item disabled" aria-disabled="true">Préstamos</a></li>
                        <li><a class="dropdown-item disabled" aria-disabled="true">Socios</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
