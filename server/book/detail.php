<?php
// Espera $id_b. Deja $b con el libro o false si no existe.
include_once __DIR__ . '/../../commons/db.php';

$b = false;
if ($id_b) {
    $s = $db->prepare(
        "SELECT b.*, a.first_name || ' ' || a.last_name AS author, initcap(c.name) AS category
         FROM public.book b
         JOIN public.author a ON a.id = b.author_id
         JOIN public.category c ON c.id = b.category_id
         WHERE b.id = :i"
    );
    $s->bindValue(':i', $id_b, PDO::PARAM_INT);
    $s->execute();
    $b = $s->fetch();
}
