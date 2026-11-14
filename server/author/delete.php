<?php
// Espera $id_a. Deja $a (autor o false), $books y $errors.
// Solo elimina cuando la confirmación llega por POST; luego redirige.
include_once __DIR__ . '/detail.php';

$errors = [];

if ($a && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($books) {
        $errors[] = 'No se puede eliminar un autor que tiene libros registrados.';
    } else {
        $s = $db->prepare('DELETE FROM public.author WHERE id = :i');
        $s->bindValue(':i', $id_a, PDO::PARAM_INT);
        $s->execute();
        header('Location: /Biblioteca/pages/author/');
        exit;
    }
}
