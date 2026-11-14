<?php
// Deja $l con el listado de libros.
include_once __DIR__ . '/../../commons/db.php';

$s = $db->prepare(
    "SELECT b.id, b.name_book, a.first_name || ' ' || a.last_name AS author
     FROM public.book b
     JOIN public.author a ON a.id = b.author_id
     ORDER BY b.id"
);
$s->execute();
$l = $s->fetchAll();
