<?php
// Espera $col (nombre de la categoría). Deja $category (o false) y $l (libros).
include_once __DIR__ . '/../commons/db.php';

$s = $db->prepare(
    'SELECT id, initcap(name) AS name FROM public.category
     WHERE lower(name) = lower(:n) AND state = TRUE'
);
$s->bindValue(':n', $col, PDO::PARAM_STR);
$s->execute();
$category = $s->fetch();

$l = [];
if ($category) {
    $s = $db->prepare(
        "SELECT b.id, b.name_book, a.first_name || ' ' || a.last_name AS author
         FROM public.book b
         JOIN public.author a ON a.id = b.author_id
         WHERE b.category_id = :c
         ORDER BY b.name_book"
    );
    $s->bindValue(':c', $category['id'], PDO::PARAM_INT);
    $s->execute();
    $l = $s->fetchAll();
}
