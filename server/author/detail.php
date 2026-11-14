<?php
// Espera $id_a. Deja $a con el autor (o false si no existe) y $books con sus libros.
include_once __DIR__ . '/../../commons/db.php';

$a = false;
$books = [];
if ($id_a) {
    $s = $db->prepare('SELECT * FROM public.author WHERE id = :i');
    $s->bindValue(':i', $id_a, PDO::PARAM_INT);
    $s->execute();
    $a = $s->fetch();

    if ($a) {
        $s = $db->prepare('SELECT id, name_book FROM public.book WHERE author_id = :i ORDER BY name_book');
        $s->bindValue(':i', $id_a, PDO::PARAM_INT);
        $s->execute();
        $books = $s->fetchAll();
    }
}
