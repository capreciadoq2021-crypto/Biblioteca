<?php
// Espera $id_a. Deja $a (autor o false), $data y $errors.
// Si el formulario llega por POST y es válido, actualiza el autor y redirige.
include_once __DIR__ . '/detail.php';
include_once __DIR__ . '/form.php';

$data = $a ? [
    'first_name' => $a['first_name'],
    'last_name' => $a['last_name'],
    'born_date' => (string) $a['born_date'],
    'pic_url' => (string) $a['pic_url'],
] : [];
$errors = [];

if ($a && $_SERVER['REQUEST_METHOD'] === 'POST') {
    [$data, $errors] = authorFromPost();
    if (!$errors) {
        $s = $db->prepare(
            'UPDATE public.author
             SET first_name = :fn, last_name = :ln, born_date = :bd, pic_url = :pu
             WHERE id = :i'
        );
        bindAuthor($s, $data);
        $s->bindValue(':i', $id_a, PDO::PARAM_INT);
        $s->execute();
        header('Location: /Biblioteca/pages/author/detail.php?id=' . $id_a);
        exit;
    }
}
