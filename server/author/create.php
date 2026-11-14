<?php
// Deja $data y $errors. Si el formulario llega por POST y es válido, crea el autor y redirige.
include_once __DIR__ . '/../../commons/db.php';
include_once __DIR__ . '/form.php';

$data = ['first_name' => '', 'last_name' => '', 'born_date' => '', 'pic_url' => ''];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$data, $errors] = authorFromPost();
    if (!$errors) {
        $s = $db->prepare(
            'INSERT INTO public.author (first_name, last_name, born_date, pic_url)
             VALUES (:fn, :ln, :bd, :pu)'
        );
        bindAuthor($s, $data);
        $s->execute();
        header('Location: /Biblioteca/pages/author/');
        exit;
    }
}
